<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enquiry extends Model
{
    protected $fillable = [
        'product_id',
        'product_name',
        'name',
        'email',
        'subject',
        'quantity',
        'phone',
        'comment',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function isContact(): bool
    {
        return $this->product_name === 'Contact Page' && $this->product_id === null;
    }

    public function scopeContact($query)
    {
        return $query->whereNull('product_id')->where('product_name', 'Contact Page');
    }

    public function scopeProduct($query)
    {
        return $query->whereNotNull('product_id');
    }
}
