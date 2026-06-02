<?php

namespace App\Support;

use App\Models\Category;
use Illuminate\Support\Collection;

class JewelleryCategory
{
    public static function ids(): Collection
    {
        return Category::query()
            ->where(function ($query) {
                $query->whereRaw('LOWER(TRIM(name)) = ?', ['jewellery'])
                    ->orWhereRaw('LOWER(TRIM(name)) = ?', ['jewelry']);
            })
            ->pluck('id');
    }

    public static function scopeProducts($query)
    {
        $ids = self::ids();

        if ($ids->isEmpty()) {
            return $query->whereRaw('1 = 0');
        }

        return $query->whereHas('categories', function ($categoryQuery) use ($ids) {
            $categoryQuery->whereIn('categories.id', $ids);
        });
    }
}
