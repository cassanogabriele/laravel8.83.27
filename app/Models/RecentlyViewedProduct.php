<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentlyViewedProduct extends Model
{
    use HasFactory;

    protected $table = 'recently_viewed_products';

    protected $fillable = [
        'user_id',
        'product_name',
        'product_price',
        'product_image',
        'shipping_cost',
        'qty',
        'product_description',
        'product_category',
        'status',
    ];
}