<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderList extends Model
{
    use HasFactory;

    protected $table = 'orders_list';

    protected $fillable = [
        'id',
        'product_id',
        'amount',
        'list_id',
    ];

    public function parent_note(){
        return $this->belongsTo(Order::class, 'list_id', 'id');
    }
}
