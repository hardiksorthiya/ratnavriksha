<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'button_text',
        'button_link',
        'main_image',
        'desktop_image',
        'mobile_image',
        'status',
    ];

    public function scopeActive($query)
    {
        return $query->where(function ($query) {
            $query->where('status', 'active')
                ->orWhereNull('status');
        });
    }

    public function storageUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return asset('storage/'.$path);
    }
}
