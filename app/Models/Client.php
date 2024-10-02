<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';

    // Relation One-to-Many avec le modèle Cart
    public function carts()
    {
        return $this->hasMany(Cart::class, 'user_id', 'id');
    }
}
