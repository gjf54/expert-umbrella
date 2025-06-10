<?php

use App\Http\Controllers\MainLayoutController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EditProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ShoppingCartController;
use App\Models\Category;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// navigation routes

{
    Route::get('/', [HomeController::class, 'load'])->name('home');
    Route::get('/catalog', [CatalogController::class, 'display_categories'])->name('catalog');
}

// special global rotues

{
    Route::post('/checkAuth', [MainLayoutController::class, 'check'])->name('checkAuth');
}



// catalog routes

Route::group(['prefix' => 'catalog'], function($router) {
    Route::get('/{id}/products', [CatalogController::class, 'display_category_products'])->name('products_in_category');
    Route::get('/{id_category}/products/{id_product}/product', [CatalogController::class, 'display_product_view'])->name('catalog_product_view');
});



// auth routes

Route::group(['middleware' => 'guest:web'], function ($router) {

    // registration

    Route::get('/register', function() {
        return view('auth.register');
    })->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // log in

    Route::get('/login', function() {
        return view('auth.login');
    })->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});





// user-routes group

Route::group(['middleware' => 'auth'], function ($router) {

    // main abilities

    Route::get('/cart', [ShoppingCartController::class, 'generate_cart_page'])->name('shopping_cart');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // manage user profile

    Route::group(['prefix' => 'profile'], function ($router) {

        // edit user data

        Route::get('/edit/data', function () {
            return view('edit_profile.data', ['user' => auth()->user(),]);
        })->name('edit_data');

        Route::get('/edit/password', function () {
            return view('edit_profile.password');
        })->name('edit_password');

        Route::get('/edit/email', function () {
            return view('edit_profile.email', ['user' => auth()->user(),]);
        })->name('edit_email');

        Route::get('/edit/avatar', function () {
            return view('edit_profile.avatar');
        })->name('edit_avatar');

        Route::post('edit/data', [EditProfileController::class, 'fresh_data'])->name('fresh_profile_data');
        Route::post('edit/password', [EditProfileController::class, 'fresh_password'])->name('fresh_profile_password');
        Route::post('edit/email', [EditProfileController::class, 'fresh_email'])->name('fresh_profile_email');
        Route::post('edit/avatar', [EditProfileController::class, 'fresh_avatar'])->name('fresh_profile_avatar');

        
        // orders routes

        Route::get('/orders', [OrdersController::class, 'view_all_orders'])->name('view_all_orders');
        Route::get('/orders/{id}/order', [OrdersController::class, 'view_order'])->name('view_order');
    });

    // shopping cart control

    Route::post('/cart/{id}/add_amount', [ShoppingCartController::class, 'add_amount'])->name('cart_add_amount');
    Route::post('/cart/{id}/rem_amount', [ShoppingCartController::class, 'remove_amount'])->name('cart_rem_amount');
    Route::post('/cart/{id}/rem_element', [ShoppingCartController::class, 'remove_element'])->name('cart_rem_element');
    Route::post('/cart/{id}/set_element', [ShoppingCartController::class, 'set_element'])->name('cart_set_element');

    Route::post('/cart', [ShoppingCartController::class, 'make_order'])->name('cart_make_order');

});

// Dashboard

Route::group(['middleware' => ['auth', 'role:admin|manager|super_admin|writer'], 'prefix' => 'dashboard',], function () {
    Route::get('/', [DashboardController::class, 'generate_home_page'])->name('dashboard');

    // Routes to contorll posts. Minimum-access role: writer.

    Route::group(['prefix' => 'writers_posts',], function () {
        Route::get('/', [DashboardController::class, 'generate_writer_page'])->name('dashboard_writers_posts');

        // edit

        Route::get('/post/{id}/edit', [DashboardController::class, 'generate_edit_form_of_post'])->name('dashboard_edit_post');
        Route::post('/post/{id}/edit', [DashboardController::class, 'edit_writers_post'])->name('dashboard_send_edit_post');

        // delete

        Route::get('/post/{id}/delete', [DashboardController::class, 'delete_writers_post'])->name('dashboard_delete_post');

        // create

        Route::get('/create', [DashboardController::class, 'generate_create_form_of_post'])->name('dashboard_create_post');
        Route::post('/create', [DashboardController::class, 'add_writers_post'])->name('dashboard_send_created_post');

        // special routes

        Route::post('/post/{id}/get_creator', [DashboardController::class, 'get_creator_of_post'])->name('dashboard_get_post_creator');
    });

    // Routes to controll users. Minimum-access role: admin.

    Route::group(['middleware' => 'role:admin|super_admin', 'prefix' => 'users'], function () {
        Route::get('/', [DashboardController::class, 'generate_users_page'])->name('dashboard_users');

        Route::get('user/{id}/remove_role/{role}', [DashboardController::class, 'remove_role_from_user'])->name('dashboard_remove_user_role');
        Route::get('grant_role/{role}', [DashboardController::class, 'generate_user_role_form'])->name('dashboard_grant_role_to_user');
        Route::post('grant_role/{role}', [DashboardController::class, 'get_user_role'])->name('dashboard_set_role_to_user');

        // Route created special for bar in users form.
        Route::post('/get_all_logins', [DashboardController::class, 'get_all_logins'])->name('get_all_logins');
    });

    // Routes to controll catalog. Minimum-access role: manager.

    Route::group(['middleware' => 'role:super_admin|admin|manager', 'prefix' => 'catalog'], function () {
        Route::get('/', [DashboardController::class, 'generate_catalog_home_page'])->name('dashboard_catalog');

        // view

        Route::get('category/{id_category}/product/{id_product}', [DashboardController::class, 'generate_product_view'])->name('dashboard_product_view');
        Route::get('/category/{id}/', [DashboardController::class, 'generate_category_contains'])->name('dashboard_category_contains');

        Route::get('/orders', [])->name('dashboard_orders_view');

        // create

        Route::get('/create_category', [DashboardController::class, 'generate_categories_create_form'])->name('dashboard_create_category');
        Route::post('/create_category', [DashboardController::class, 'insert_created_category'])->name('dashboard_send_created_category');

        Route::get('/category/{id}/create_product', [DashboardController::class, 'generate_products_create_form'])->name('dashboard_create_product');
        Route::post('/category/{id}/create_product', [DashboardController::class, 'insert_created_product'])->name('dashboard_send_created_product');

        // edit

        Route::get('/category/{id}/edit', [DashboardController::class, 'generate_categories_edit_form'])->name('dashboard_edit_category');
        Route::post('/category/{id}/edit', [DashboardController::class, 'insert_edited_category'])->name('dashboard_save_edited_category');
        Route::get('/category/{id_category}/product/{id_product}/edit', [DashboardController::class, 'generate_products_edit_form'])->name('dashboard_edit_product');
        Route::post('/category/{id_category}/product/{id_product}/edit', [DashboardController::class, 'insert_edited_product'])->name('dashboard_save_edited_product');

        // delete

        Route::get('/category/{id}/delete', [DashboardController::class, 'delete_category'])->name('dashboard_category_delete');
        Route::get('/category/{id_category}/product/{id_product}/delete', [DashboardController::class, 'delete_product'])->name('dashboard_product_delete');
    });
});


// Route::get('/linkstorage', function () { $targetFolder = base_path().'/storage/app/public'; $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage'; symlink($targetFolder, $linkFolder); });

