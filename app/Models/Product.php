<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class, 'product_category');
    }

    public function wishlists()
    {
        return $this->belongsToMany(Wishlist::class, 'product_wishlist', 'product_id', 'wishlist_id');
    }
}
