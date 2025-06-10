<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CatalogController extends Controller
{
    public function display_categories() {
    	$categories = Category::all();
    
        return view('catalog.catalog',  [
			'categories' => $categories,
		]);
    }
    
    public function display_category_products($id) {
        $category = Category::find(['id' => $id])->first();
        $products = $category->products;

        if(auth()->user()){
            $cart = auth()->user()->shopping_cart; 
            $cart_products = $cart->products_collection; 
            return view('catalog.products', [
                'products' => $products,
                'category' => $category,
                'cart' => $cart_products,
            ]);
        }
        return view('catalog.products', [
            'products' => $products,
            'category' => $category,
            'cart' => [],
        ]);
    }

    public function display_product_view($id_category, $id_product){
        $product = Product::find(['id' => $id_product])->first();
        $category = Category::find(['id' => $id_category])->first();
        $user = auth()->user();
        $cart = [];
        $collection = [];

        if($user) {
            $cart = auth()->user()->shopping_cart;
            $collection = $cart->products_collection;
        }
        return view('catalog.product_view', [
            'product' => $product,
            'category' => $category,
            'collection' => $collection,
        ]);
    }
}
