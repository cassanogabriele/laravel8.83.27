<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $fillable = ['product_id', 'user_id', 'product_name', 'product_price', 'product_image', 'qty', 'shipping_cost', 'total_without_shipping', 'total_with_shipping'];
   
    public function client()
    {
        return $this->belongsTo(Client::class, 'user_id', 'id');
    }
}
