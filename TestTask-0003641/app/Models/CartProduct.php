<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;

    protected $table = 'cart_products';

    protected $fillable = [
        'id',
        'cart_id',
        'product_id',
        'amount',
    ];


    public function product() {
        return $this->belongsTo(Product::class);
    }


    public function cost() {
        return $this->amount * $this->product->price;
    }
}
