<?php

use App\Http\Controllers\Render\RenderController;
use App\Http\Controllers\Resource\CartController;
use App\Http\Controllers\Resource\CartProductController;
use App\Http\Controllers\Resource\CategoryController;
use App\Http\Controllers\Resource\OrderController;
use App\Http\Controllers\Resource\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return view('welcome'); });


Route::group(['prefix' => 'products'], function ($r) {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/create', [ProductController::class, 'store'])->name('products.create');
});


Route::group(['prefix' => 'categories'], function ($r) {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    
    Route::group(['prefix' => '/{category_id}/products'], function ($r) {
        Route::get('/', [CategoryController::class, 'show'])->name('categories.show');
        
        Route::group(['prefix' => '/{product_id}'], function ($r) {
            Route::get('/', [ProductController::class, 'show'])->name('products.show');

            Route::get('/edit', [ProductController::class, 'edit'])->name('products.edit');
            Route::post('/edit', [ProductController::class, 'update'])->name('products.edit');

            Route::get('destroy', [ProductController::class, 'destroy'])->name('products.destroy');
        });
    });
});


Route::group(['prefix' => 'orders'], function ($r) {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    
    Route::get('/create', [OrderController::class, 'edit'])->name('orders.create');
    Route::post('/create', [OrderController::class, 'create'])->name('orders.create');

    Route::get('/{order_id}', [OrderController::class, 'show'])->name('orders.show');
    
    Route::post('/finish', [OrderController::class, 'finish'])->name('orders.finish');
});


Route::group(['prefix' => 'cart'], function ($r) {
    Route::get('/', [CartController::class, 'index'])->name('carts.index');

    Route::post('/set/{product_id}', [CartProductController::class, 'set'])->name('cartProducts.set');
    Route::post('/rem/{product_id}', [CartProductController::class, 'remove'])->name('cartProducts.remove');
    Route::post('/add/{product_id}', [CartProductController::class, 'add'])->name('cartProducts.add');
    Route::post('/delete/{product_id}', [CartProductController::class, 'delete'])->name('cartProducts.delete');
});
