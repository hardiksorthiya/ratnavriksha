<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
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

        if ($product->featured_path) {
            $galleryItems->push($this->galleryItem('featured', $product->featured_type, $product->featured_path));
        }

        foreach ($product->media as $media) {
            $galleryItems->push($this->galleryItem('media-'.$media->id, $media->type, $media->path));
        }

        return view('frontend.pages.product.show', compact('product', 'galleryItems'));
    }

    private function galleryItem(string $key, string $type, string $path): array
    {
        $storagePath = '/storage/'.ltrim(str_replace('\\', '/', $path), '/');

        return [
            'key' => $key,
            'type' => $type,
            'path' => $path,
            'src' => rtrim(request()->getBaseUrl(), '/').$storagePath,
        ];
    }
}
