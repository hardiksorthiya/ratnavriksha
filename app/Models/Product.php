<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'stone_id',
        'featured_type',
        'featured_path',
        'shape_id',
        'color_id',
        'clarity_id',
        'cut_id',
        'row_weight',
        'polish_weight',
        'length',
        'width',
        'table_percent',
        'total_depth',
        'ratio',
        'remarks',
        'short_description',
        'long_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
    ];

    public function shape(): BelongsTo
    {
        return $this->belongsTo(Shape::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function clarity(): BelongsTo
    {
        return $this->belongsTo(Clarity::class);
    }

    public function cut(): BelongsTo
    {
        return $this->belongsTo(Cut::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(ProductMedia::class)->orderBy('sort_order');
    }
}
