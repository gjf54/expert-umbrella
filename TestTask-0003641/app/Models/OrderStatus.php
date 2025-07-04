<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $table = 'order_statuses';

    protected $fillable = [
        'id',
        'order_id',
        'status',
    ];


    public function order() {
        return $this->belongsTo(Order::class);
    }
}
