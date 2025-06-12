<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Http\Request;


class CartProductController extends Controller
{
    public function set(Request $request, $product_id) {
        $product = Product::find($product_id);
        $cart =  Cart::all()->first();

        $t_note = CartProduct::where([
            'product_id' => $product->id,
            'cart_id' => $cart->id,
        ]);

        if($product == null or $t_note->first() != null) {
            return 0;
        }

        CartProduct::create([
            'cart_id' => Cart::all()->first()->id,
            'product_id' => $product->id,
        ]);

        return 1;
    }


    public function remove(Request $request, $product_id) {
        $product = Product::find($product_id);
        $cart =  Cart::all()->first();

        if($product == null) {
            return 0;
        }

        $note = CartProduct::where([
            'product_id' => $product->id, 
            'cart_id' => $cart->id,
        ])->first();

        if($note == null or $note->amount < 2) {
            return 0;
        }

        $note->amount -= 1;
        $note->save();

        return json_encode($note);
    }


    public function add(Request $request, $product_id) {
        $product = Product::find($product_id);
        $cart =  Cart::all()->first();

        if($product == null) {
            return 0;
        }

        $note = CartProduct::where([
            'product_id' => $product->id, 
            'cart_id' => $cart->id,
        ])->first();

        if($note == null) {
            return 0;
        }

        $note->amount += 1;
        $note->save();

        return json_encode($note);
    }


    public function delete(Request $request, $product_id) {
        $product = Product::find($product_id);
        $cart =  Cart::all()->first();

        if($product == null) {
            return 0;
        }

        $note = CartProduct::where([
            'product_id' => $product->id, 
            'cart_id' => $cart->id,
        ])->first();

        if($note == null) {
            return 0;
        }

        $note->delete();

        return json_encode($note);
    }


}
