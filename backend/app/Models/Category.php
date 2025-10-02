<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = [
        'name',
        'shop_id'
    ];

    public function shop():BelongsTo{
        return $this->belongsTo(Shop::class);
    }
}
