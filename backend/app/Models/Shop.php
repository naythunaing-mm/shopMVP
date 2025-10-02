<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    protected $fillable = [
        "name",
        "description",
        "profile_pic",
        "social_links",
        "street",
        "unit",
        "address",
        "postal_code",
        "phone",
        "user_id"
    ];

    // Note: keep social_links as a plain string to avoid htmlspecialchars issues in forms

    // Relationship to User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Get all the products that the shop has
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    // ✅ Add this for orders
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
