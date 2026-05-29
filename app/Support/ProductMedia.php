<?php

namespace App\Support;

use App\Models\Product;

class ProductMedia
{
    public static function placeholderSrc(): string
    {
        return asset('images/logo_white.png');
    }

    public static function hasFeatured(Product $product): bool
    {
        return filled($product->featured_path);
    }

    public static function placeholderGalleryItem(string $key = 'placeholder'): array
    {
        return [
            'key' => $key,
            'type' => 'image',
            'path' => 'images/logo_white.png',
            'src' => self::placeholderSrc(),
            'is_placeholder' => true,
        ];
    }

    public static function srcFromStoragePath(string $path): string
    {
        $storagePath = '/storage/'.ltrim(str_replace('\\', '/', $path), '/');

        return rtrim(request()->getBaseUrl(), '/').$storagePath;
    }
}
