<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clarity;
use App\Models\Color;
use App\Models\Cut;
use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\Shape;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['shape', 'color', 'clarity', 'cut'])->latest()->get();

        return view('backend.pages.products.index', compact('products'));
    }

    public function create()
    {
        return view('backend.pages.products.create_edit', array_merge($this->formData(), ['product' => null]));
    }

    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);

        $product = Product::create($this->prepareProductData($request, $validated));

        $this->handleFeaturedUpload($request, $product);
        $this->handleGalleryUpload($request, $product);

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function edit(string $id)
    {
        $product = Product::with('media')->findOrFail($id);

        return view('backend.pages.products.create_edit', array_merge($this->formData(), compact('product')));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::with('media')->findOrFail($id);

        $validated = $this->validateProduct($request, $product->id);

        $product->update($this->prepareProductData($request, $validated, $product));

        if ($request->boolean('remove_featured')) {
            $this->deleteStoredFile($product->featured_path);
            $product->update(['featured_type' => null, 'featured_path' => null]);
        }

        $this->handleFeaturedUpload($request, $product);
        $this->handleGalleryRemovals($request, $product);
        $this->handleGalleryUpload($request, $product);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(string $id)
    {
        $product = Product::with('media')->findOrFail($id);

        $this->deleteStoredFile($product->featured_path);

        foreach ($product->media as $media) {
            $this->deleteStoredFile($media->path);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }

    private function formData(): array
    {
        return [
            'shapes' => Shape::orderBy('name')->get(),
            'colors' => Color::orderBy('name')->get(),
            'clarities' => Clarity::orderBy('name')->get(),
            'cuts' => Cut::orderBy('name')->get(),
        ];
    }

    private function validateProduct(Request $request, ?int $productId = null): array
    {
        $slugRule = 'nullable|string|max:255|unique:products,slug';
        if ($productId) {
            $slugRule .= ','.$productId;
        }

        return $request->validate([
            'name' => 'nullable|string|max:255',
            'slug' => $slugRule,
            'stone_id' => 'nullable|string|max:255',
            'featured_media' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,mp4,webm,mov|max:20480',
            'gallery' => 'nullable|array',
            'gallery.*' => 'file|mimes:jpeg,png,jpg,gif,webp,mp4,webm,mov|max:20480',
            'remove_featured' => 'nullable|boolean',
            'remove_gallery' => 'nullable|array',
            'remove_gallery.*' => 'integer|exists:product_media,id',
            'shape_id' => 'nullable|exists:shapes,id',
            'color_id' => 'nullable|exists:colors,id',
            'clarity_id' => 'nullable|exists:clarities,id',
            'cut_id' => 'nullable|exists:cuts,id',
            'row_weight' => 'nullable|string|max:255',
            'polish_weight' => 'nullable|string|max:255',
            'length' => 'nullable|string|max:255',
            'width' => 'nullable|string|max:255',
            'table_percent' => 'nullable|string|max:255',
            'total_depth' => 'nullable|string|max:255',
            'ratio' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ]);
    }

    private function prepareProductData(Request $request, array $validated, ?Product $product = null): array
    {
        $fields = [
            'name', 'stone_id', 'shape_id', 'color_id', 'clarity_id', 'cut_id',
            'row_weight', 'polish_weight', 'length', 'width', 'table_percent',
            'total_depth', 'ratio', 'remarks', 'short_description', 'long_description',
            'meta_title', 'meta_description', 'meta_keywords', 'status',
        ];

        $data = [];

        foreach ($fields as $field) {
            $data[$field] = $validated[$field] ?? null;
        }

        $data['slug'] = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name'] ?? ($product?->name ?? 'product-'.time()));

        if (empty($data['status'])) {
            $data['status'] = 'active';
        }

        return $data;
    }

    private function handleFeaturedUpload(Request $request, Product $product): void
    {
        if (! $request->hasFile('featured_media')) {
            return;
        }

        $file = $request->file('featured_media');
        $type = str_starts_with($file->getMimeType(), 'video/') ? 'video' : 'image';

        $this->deleteStoredFile($product->featured_path);

        $product->update([
            'featured_type' => $type,
            'featured_path' => $file->store('products/featured', 'public'),
        ]);
    }

    private function handleGalleryUpload(Request $request, Product $product): void
    {
        if (! $request->hasFile('gallery')) {
            return;
        }

        $sortOrder = $product->media()->max('sort_order') ?? 0;

        foreach ($request->file('gallery') as $file) {
            $sortOrder++;
            $type = str_starts_with($file->getMimeType(), 'video/') ? 'video' : 'image';

            ProductMedia::create([
                'product_id' => $product->id,
                'type' => $type,
                'path' => $file->store('products/gallery', 'public'),
                'sort_order' => $sortOrder,
            ]);
        }
    }

    private function handleGalleryRemovals(Request $request, Product $product): void
    {
        $removeIds = $request->input('remove_gallery', []);

        if (empty($removeIds)) {
            return;
        }

        $mediaItems = ProductMedia::where('product_id', $product->id)->whereIn('id', $removeIds)->get();

        foreach ($mediaItems as $media) {
            $this->deleteStoredFile($media->path);
            $media->delete();
        }
    }

    private function deleteStoredFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
