<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCartCollection extends Model
{
    use HasFactory;

    protected $table = 'products_in_cart';

    protected $fillable = [
        'id',
        'cart_id',
        'product_id',
        'amount',
    ];

    public function cart(){
        return $this->belongsTo(ShoppingCart::class, 'cart_id', 'id');
    }
}
