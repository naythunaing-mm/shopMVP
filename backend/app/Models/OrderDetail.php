<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'quantity',
        'price',
        'total'
    ];

    // Relationship: each OrderDetail belongs to one Order
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Relationship: each OrderDetail belongs to one Product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
