<?php 

namespace App\Contracts;

use App\Models\Order;

interface OrderStatusManagerContract {
    public function __construct(Order $order);
    public function init_order() : String;
    public function is_ended() : bool;
    public function end_order() : String;
}