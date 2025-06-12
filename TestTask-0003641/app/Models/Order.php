<?php

namespace App\Models;

use App\Modules\OrderStatusManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'id',
        'customer',
        'comment',
    ];


    public function products() {
        return $this->hasMany(OrderProduct::class);
    }


    public function cost() {
        $orderProducts = $this->products;
        $total = 0;

        foreach ($orderProducts as $orderProduct) {
            $total += $orderProduct->cost();
        }

        return $total;
    }


    public function history() {
        return $this->hasMany(OrderStatus::class);
    }


    public function status() {
        return $this->history->last()->status;
    }
}
