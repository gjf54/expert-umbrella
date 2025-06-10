<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartCollection;
use App\Models\User;
use Exception;
use FFI\Exception as FFIException;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function generate_cart_page() {
        $user = auth()->user();
        $cart = $user->shopping_cart;
        $collection = $cart->products_collection;
        
        return view('shopping_cart', [
            'collection' => $collection,
        ]);
    }

    public function add_amount($id) {
        $element = ShoppingCartCollection::where(['cart_id' => auth()->user()->shopping_cart->id, 'product_id' => $id])->first();
        $element->amount += 1;
        $element->save();

        return json_encode($element);
    }

    public function remove_amount($id) {
        $element = ShoppingCartCollection::where(['cart_id' => auth()->user()->shopping_cart->id, 'product_id' => $id])->first();
        
        if($element->amount < 2) {
            return 0;
        }
        
        $element->amount -= 1;
        $element->save();

        return json_encode($element);
    }

    public function remove_element($id) {
        $element = ShoppingCartCollection::find($id);

        if($element == null) {
            return 0;
        }

        $element->delete();
        return json_encode(['status' => 'ok', 'id' => $id]);
    }

    public function set_element($id) {
        $user = auth()->user();
        $cart = $user->shopping_cart;
        $notes = $cart->products_collection;

        foreach($notes as $note) {
            if($note->product_id == $id) {
                return 0;
            }
        }

        if(Product::where(['id' => $id])->first()){
            $data = ['cart_id' => $cart->id,'product_id' => $id, 'amount' => 1];
            $note = ShoppingCartCollection::create($data);
            return json_encode(['status' => 'ok', 'id_prod' => $id, 'id_el' => $note->id]);
        }
        return 0;       
    }

    public function make_order() {
        try {
            $collection = auth()->user()->shopping_cart->products_collection;
            $order_list = Order::create(['user_id' => auth()->user()->id]);
            foreach ($collection as $element) {
                OrderList::create(['product_id' => $element->product_id, 'amount' => $element->amount, 'list_id' => $order_list->id]);
                $this->remove_element($element->id);
            }
        } catch(Exception $e) {
            return json_encode($e);
        }
    }
}
