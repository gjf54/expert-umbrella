<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Modules\OrderStatusManager;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    public function index() {
        return view('order.index', [
            'orders' => Order::all(),
        ]);
    }


    public function edit() {
        return view('order.edit');
    }


    public function show($order_id) {

        $order = Order::find($order_id);

        if($order == null) {
            return abort(404);
        }

        return view('order.show', [
            'order' => $order,
        ]);
    }


    public function create(Request $request) {
        
        $v = Validator::validate($request->all(), [
            'customer' => 'required|string|max:150',
            'comment' => 'max:400',
        ]);

        $cart =  Cart::all()->first();
        $notes = $cart->notes;

        if($notes->first() == null) {
            return back()->withErrors(['cart' => 'Корзина товаров пуста!']);
        }

        $order = Order::create([
            'customer' => $request->customer,
            'comment' => $request->comment,
        ]);

        $manager = new OrderStatusManager($order);
        $manager->init_order();

        foreach ($notes as $note) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $note->id,
                'amount' => $note->amount,
            ]);
        }

        $cart->clear();

        return redirect(route('orders.show', ['order_id' => $order->id]));
    }


    public function finish(Request $request) {
        $order = Order::find($request->id);

        if($order == null) {
            return $request->id;
        }

        $status_manager = new OrderStatusManager($order);

        if($status_manager->is_ended()) {
            return 0;
        }

        return json_encode($status_manager->end_order());
    }
}
