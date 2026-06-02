<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Clarity;
use App\Models\Color;
use App\Models\Cut;
use App\Models\Page;
use App\Models\Product;
use App\Models\Shape;
use App\Support\ProductMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class DiamondController extends Controller
{
    public function index(Request $request): View
    {
        $shapeIds = collect(Arr::wrap($request->query('shape_ids', $request->query('shape_id'))))
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();
        $colorIds = collect(Arr::wrap($request->query('color_ids', $request->query('color_id'))))
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();
        $cutIds = collect(Arr::wrap($request->query('cut_ids', $request->query('cut_id'))))
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();
        $clarityIds = collect(Arr::wrap($request->query('clarity_ids', $request->query('clarity_id'))))
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();
        $categoryIds = collect(Arr::wrap($request->query('category_ids', $request->query('category_id'))))
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        $shapes = Shape::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
        $shapes->transform(function (Shape $shape) {
            $shape->list_image_src = $this->resolveShapeImageSrc($shape);
            return $shape;
        });

        $productsQuery = Product::query()
            ->where('status', 'active')
            ->with(['shape', 'color', 'clarity', 'cut', 'categories', 'media']);

        if ($shapeIds->isNotEmpty()) {
            $productsQuery->whereIn('shape_id', $shapeIds);
        }
        if ($colorIds->isNotEmpty()) {
            $productsQuery->whereIn('color_id', $colorIds);
        }
        if ($cutIds->isNotEmpty()) {
            $productsQuery->whereIn('cut_id', $cutIds);
        }
        if ($clarityIds->isNotEmpty()) {
            $productsQuery->whereIn('clarity_id', $clarityIds);
        }
        if ($categoryIds->isNotEmpty()) {
            $productsQuery->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            });
        }

        // Build card media (image/video) from featured first, then media fallback.
        $products = $productsQuery->latest()->paginate(12)->withQueryString();
        $products->getCollection()->transform(function (Product $product) {
            $media = $this->resolveListMedia($product);
            $product->list_media_src = $media['src'];
            $product->list_media_type = $media['type'];
            return $product;
        });

        return view('frontend.pages.product-catalog', [
            'page' => Page::where('slug', 'diamonds')->where('status', 'active')->firstOrFail(),
            'products' => $products,
            'shapes' => $shapes,
            'colors' => Color::query()->orderBy('name')->get(),
            'cuts' => Cut::query()->orderBy('name')->get(),
            'clarities' => Clarity::query()->orderBy('name')->get(),
            'categories' => Category::query()
                ->whereHas('products', fn ($query) => $query->where('status', 'active'))
                ->orderBy('name')
                ->get(),
            'activeShapeIds' => $shapeIds->all(),
            'activeColorIds' => $colorIds->all(),
            'activeCutIds' => $cutIds->all(),
            'activeClarityIds' => $clarityIds->all(),
            'activeCategoryIds' => $categoryIds->all(),
            'filterRoute' => 'diamonds',
            'hideCategoryFilter' => false,
            'hideSidebar' => false,
            'catalogLabel' => 'diamonds',
            'defaultListTitle' => 'All Diamonds',
        ]);
    }

    private function resolveListMedia(Product $product): array
    {
        if (ProductMedia::hasFeatured($product)) {
            return [
                'src' => ProductMedia::srcFromStoragePath($product->featured_path),
                'type' => $product->featured_type === 'video' ? 'video' : 'image',
            ];
        }

        return [
            'src' => ProductMedia::placeholderSrc(),
            'type' => 'image',
        ];
    }

    private function srcFromStoragePath(string $path): string
    {
        // Convert windows-style slashes to a clean storage URL.
        $storagePath = '/storage/' . ltrim(str_replace('\\', '/', $path), '/');

        return rtrim(request()->getBaseUrl(), '/') . $storagePath;
    }

    private function resolveShapeImageSrc(Shape $shape): ?string
    {
        if (empty($shape->image)) {
            return asset('images/home/shapes/round.png');
        }

        $normalized = ltrim(str_replace('\\', '/', $shape->image), '/');

        // If admin stored a storage path, use storage URL.
        if (str_starts_with($normalized, 'shapes/') || str_contains($normalized, '/')) {
            return $this->srcFromStoragePath($normalized);
        }

        // Otherwise treat it as public image path fallback.
        return asset('images/home/shapes/' . $normalized);
    }
}

