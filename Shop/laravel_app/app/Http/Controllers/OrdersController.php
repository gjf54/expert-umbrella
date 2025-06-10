<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function view_all_orders() {
        $user = auth()->user();
        return view('orders.orders_view', [
            'orders' => $user->orders,
        ]);
    }

    public function view_order($id) {
        $order = Order::where(['id' => $id])->first();
        return view('orders.order_view', [
            'order' => $order,
        ]);
    }
}
