<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'orders_products';

    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'amount',
    ];


    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }


    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }


    public function cost() : float {
        return $this->amount * Product::find($this->product_id)->price; 
    }
}
