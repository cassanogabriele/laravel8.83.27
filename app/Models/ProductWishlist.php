<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductWishlist extends Model
{
    protected $table = 'product_wishlist';

    protected $fillable = ['product_id', 'wishlist_id', 'created_at', 'updated_at'];

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
