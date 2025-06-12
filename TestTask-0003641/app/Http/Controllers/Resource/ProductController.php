<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public static function index($id = null) {
        $data = [];

        if(isset($id)) {
            $category = Category::find($id);

            if($category == null) {
                return redirect(route('products.index'));
            }

            $products = $category->products;

            $data['products'] = $products;
            $data['category'] = $category;
        } else {
            $products = Product::all();

            $data['products'] = $products;
        }

        return view('product.index', $data);
    }


    public function show($category_id, $product_id) {
        $product = Product::find($product_id);
        $category = Category::find($category_id);

        if($product == null or $category == null) {
            abort(404);
        }

        return view('product.show', [
            'product' => $product,
        ]);
    }


    public function create() {
        return view('product.edit', [
            'edit' => false,
        ]);
    }


    public function edit($category_id, $product_id) {
        $product = Product::find($product_id);
        $category = Category::find($category_id);

        if($product == null or $category == null) {
            return abort(404);
        }

        return view('product.edit', [
            'edit' => true,
            'product' => $product,
        ]);
    }


    public function store(Request $request) {
        $v = Validator::validate($request->all(), [
            'category_id' => 'required',
            'name' => 'required|string|max:70',
            'price' => 'required|decimal:2',
            'description' => 'max:400',
        ]);

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        return redirect(route('products.show', ['category_id' => $product->category->id, 'product_id' => $product->id]));
    }


    public function update(Request $request, $category_id, $product_id) {
        $product = Product::find($product_id);
        $category = Category::find($category_id);

        if($product == null or $category == null) {
            return abort(404);
        }   

        $v = Validator::validate($request->all(), [
            'name' => 'required|string|max:70',
            'price' => 'required|decimal:2',
            'description' => 'max:400',
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        return redirect(route('products.show', ['category_id' => $category_id, 'product_id' => $product_id]));
    }


    public function destroy($category_id, $product_id) {
        $product = Product::find($product_id);
        $category = Category::find($category_id);

        if($product == null or $category == null) {
            return back();
        }

        $product->delete();

        return redirect(route('categories.show', ['category_id' => $category->id]));
    }
}
