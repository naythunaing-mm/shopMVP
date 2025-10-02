<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'discount',
        'pics',
        'video',
        'types',
        'colors',
        'stock',
        'category_id',
        'shop_id',
        'status',
        'is_featured',
    ];

    protected $casts = [
        // Remove array casts to prevent form display issues
        // 'pics' => 'array',
        // 'types' => 'array', 
        // 'colors' => 'array',
        'is_featured' => 'boolean',
    ];

    // Scope to get only active products
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope to get products with stock
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    // Scope to get featured products
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // a category that the current product belongs to
    public function category():BelongsTo{
        return $this->belongsTo(Category::class, 'category_id');
    }

    // a shop that the current product belongs to
    public function shop():BelongsTo{
        return $this->belongsTo(Shop::class, 'shop_id');
    }

}
