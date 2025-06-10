<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use HasFactory;

    protected $table = 'shopping_carts';

    protected $fillable = [
        'id',
        'user_id',
    ];

    public function products_collection() {
        return $this->hasMany(ShoppingCartCollection::class, 'cart_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
