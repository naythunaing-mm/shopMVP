<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Shop;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'shop_id',
        'order_number',
        'total_amount',
        'status',
        'payment_status',
        'shipping_address',
        'billing_address',
        'payment_method',
        'shipping_method'
    ];

    // Relationship: each Order belongs to one Shop
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    // Relationship: each Order belongs to one User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: each Order has many OrderDetails
    public function items()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Generate unique order number
    public static function generateOrderNumber()
    {
        $prefix = 'ORD-';
        $unique = false;
        $orderNumber = '';

        while (!$unique) {
            $orderNumber = $prefix . mt_rand(100000, 999999);
            $exists = self::where('order_number', $orderNumber)->exists();
            if (!$exists) {
                $unique = true;
            }
        }

        return $orderNumber;
    }
}
