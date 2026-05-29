<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Support\ProductMedia;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(string $slug): View
    {
        $product = Product::with(['shape', 'color', 'clarity', 'cut', 'media'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $galleryItems = collect();

        if (ProductMedia::hasFeatured($product)) {
            $galleryItems->push($this->galleryItem('featured', $product->featured_type, $product->featured_path));
        } else {
            $galleryItems->push(ProductMedia::placeholderGalleryItem());
        }

        foreach ($product->media as $media) {
            $galleryItems->push($this->galleryItem('media-'.$media->id, $media->type, $media->path));
        }

        return view('frontend.pages.product.show', compact('product', 'galleryItems'));
    }

    private function galleryItem(string $key, string $type, string $path): array
    {
        return [
            'key' => $key,
            'type' => $type,
            'path' => $path,
            'src' => ProductMedia::srcFromStoragePath($path),
            'is_placeholder' => false,
        ];
    }
}
