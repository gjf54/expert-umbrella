<?php

/*
|---------------------------------------------------------------
| Вспомогательный класс для обработки изменения статусов заказа
|---------------------------------------------------------------
*/

namespace App\Modules;

use App\Contracts\OrderStatusManagerContract;
use App\Models\Order;
use App\Models\OrderStatus;


class OrderStatusManager implements OrderStatusManagerContract  {

    protected $statuses = [
        'init_status' => 'Создан',
        'end_status' => 'Выполнен',
    ];

    public $order;


    public function __construct(Order $order) {
        $this->order = $order;
    }

    
    public function init_order() : String {

        OrderStatus::create([
            'order_id' => $this->order->id,
            'status' => $this->statuses['init_status'],
        ]);

        return $this->statuses['init_status'];
    }


    public function end_order() : String {
        OrderStatus::create([
            'order_id' => $this->order->id,
            'status' => $this->statuses['end_status'],
        ]);

        return $this->statuses['end_status'];
    }


    public function is_ended() : bool {
        return ($this->order->history->last()->status == $this->statuses['end_status']);
    }
    
}