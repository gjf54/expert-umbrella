<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'id',
        'user_id',
    ];

    public function order_products() {
        return $this->hasMany(OrderList::class, 'list_id', 'id');
    }
}
