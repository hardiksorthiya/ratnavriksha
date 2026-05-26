<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'meta_title',
        'label',
        'heading',
        'description',
        'bg_image',
        'status',
    ];

    public function bgImageUrl(): string
    {
        if ($this->bg_image) {
            return rtrim(request()->getBaseUrl(), '/').'/storage/'.ltrim($this->bg_image, '/');
        }

        return asset('images/pages/breadcrumb-bg.png');
    }

    public function headingHtml(): string
    {
        return nl2br(e($this->heading ?? ''));
    }
}
