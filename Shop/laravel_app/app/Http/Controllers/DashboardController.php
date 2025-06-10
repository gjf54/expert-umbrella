<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    protected $routes = [
        'dashboard' => 'Dashboard',
        'dashboard_writers_posts' => 'Writer Posts',
        'dashboard_edit_post' => 'Edit Post',
        'dashboard_create_post' => 'Create Post',
        'dashboard_users' => 'Users',
        'dashboard_grant_role_to_user' => 'Grant Role',
        'dashboard_catalog' => 'Catalog',
        'dashboard_product_view' => 'View Product',
        'dashboard_category_contains' => 'Category Products',
        'dashboard_create_category' => 'Create Category',
        'dashboard_create_product' => 'Create Product',
        'dashboard_edit_category' => 'Edit Category',
        'dashboard_edit_product' => 'Edit Product',
    ];

    protected function edit_curr_path($route, $add_params = []) {
        $flag = 0;
        $marker = 0;
        $editing_route = session()->get('dashboard_route');
        
        for($i = 0; $i < count(session()->get('dashboard_route')); $i++) {
            $curr_route = $editing_route[$i][0];
            if($route == $curr_route) {
                $flag = 1;
                continue;
            }
            if($flag) {
                unset($editing_route[$i]);
            }
        }

        foreach($this->routes as $r => $n) {
            if($r == $route) {
                $marker = 1;
                break;
            }
        }

        session()->put('dashboard_route', $editing_route);

        if(!$marker) {
            $tmp = session()->get('dashboard_route');
            array_push($tmp, [$route, '. . .', $add_params]);
            session()->put('dashboard_route', $tmp);
            return;
        }

        if(!$flag) {
            $tmp = session()->get('dashboard_route');
            array_push($tmp, [$route, $this->routes[$route], $add_params]);
            session()->put('dashboard_route', $tmp);
        }
    }

    public function generate_home_page(Request $request) {
        $user = auth()->user();
        $curr_route = $request->route()->getName();
        session()->put('dashboard_route', [[$curr_route, $this->routes[$curr_route]]]);

        return view('dashboard.home', [
            'user' => $user,
            'route' => session()->get('dashboard_route'),
        ]);
    }

    public function generate_writer_page(Request $request) {
        $posts = Post::all();
        $curr_route = $request->route()->getName();

        $this->edit_curr_path($curr_route);

        return view('dashboard.posts.main_list', [
            'posts' => $posts,
            'route' => session()->get('dashboard_route'),
        ]);
    }

    public function generate_create_form_of_post(Request $request) {
        $curr_route = $request->route()->getName();
        $this->edit_curr_path($curr_route);

        return view('dashboard.posts.post_form', [
            'status' => 'create',
            'route' => session()->get('dashboard_route'),
        ]);
    }

    public function add_writers_post(Request $request, Post $post) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'text' => 'required|max:4000',
        ]);
        $validator->validate();

        $user = auth()->user();
        
        $post->id_creator = $user->id;
        $post->title = $request->title;
        $post->text = $request->text;
        $post->id_editor = $user->id;

        $post->save();

        return back()->with('message', 'Post created successfull!');
    }

    public function generate_edit_form_of_post(Request $request, $id) {
        $post = Post::where(['id' => $id])->first();

        if($post == null) {
            return abort(404);
        }

        $curr_route = $request->route()->getName();

        $this->edit_curr_path($curr_route, ['id' => $id]);

        return view('dashboard.posts.post_form', [
            'post' => $post,
            'status' => 'edit',
            'route' => session()->get('dashboard_route'),
        ]);
    }

    public function edit_writers_post($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'text' => 'required|max:4000',
        ]);
        $validator->validate();

        $post = Post::where(['id' => $id])->first();

        $post->title = $request->title;
        $post->text = $request->text;
        $post->id_editor = auth()->user()->id;
        $post->is_edited = 1;
        $post->save();

        return back()->with('message', 'Post edited successfull!');
    }

    public function delete_writers_post($id) {
        $post = Post::where(['id' => $id])->first();

        if($post == null) {
            return abort(404);
        }

        $post->delete();
        return back();
    }

    public function get_creator_of_post($id) {
        $user = User::where(['id' => $id])->first();

        return response([
            'login' => $user->login,
        ]);
    }

    public function generate_users_page(Request $request) {
        $super_admins = User::role('super_admin')->get();
        $admins = User::role('admin')->get();
        $managers = User::role('manager')->get();
        $writers = User::role('writer')->get();

        $user = auth()->user();

        $curr_route = $request->route()->getName();

        $this->edit_curr_path($curr_route);

        return view('dashboard.users.main_page', [
            'super_admins' => $super_admins,
            'admins' => $admins,
            'managers' => $managers,
            'writers' => $writers,
            'user' => $user,
            'route' => session()->get('dashboard_route'),
        ]);
    }

    public function remove_role_from_user($id, $role) {
        $selected_user = User::where(['id' => $id,])->first();
        $selected_role = Role::where(['name' => $role])->first();
        $user = User::where(['id' => auth()->user()->id])->first();

        if($selected_user == null) {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
            return back()->withErrors([
                'message' => 'User with does not exist',
            ]);
        }

		if($selected_role == null) {
			return back()->withErrors([	
				'message' => 'Role "' . $role . '" does not exist',
			]);
		}

        if($selected_user->hasRole('super_admin')) {
            return back()->withErrors([
                'message' => 'You can not remove super-admin role!'
            ]);
        }

        if($selected_user->can('control_user') and !($user->hasRole('super_admin'))) {
            return back()->withErrors([
                'message' => 'You can not remove other admin!'
            ]);
        }

        $selected_user->removeRole($role);
        $selected_user->save();

        return back()->with([
            'message' => 'User role success removed!'
        ]);
    }

    public function generate_user_role_form(Request $request, $role) {
    	$selected_role = Role::where(['name' => $role])->first();
    
    	if($selected_role == null) {
    		return back()->withErrors([
				'message' => 'Role "' . $role . '" does not exist',
			]);	
    	}
    
        if($role == 'super_admin') {
            abort(404);
        }

        $user = User::where(['login' => auth()->user()->login])->first();

        if($user->hasRole('admin') and !($user->hasRole('super_admin')) and $role == 'admin') {
            return back()->withErrors([
                'message' => 'You can not add admins!',
            ]);
        }

        $curr_route = $request->route()->getName();

        $this->edit_curr_path($curr_route, ['role' => $role]);

        return view('dashboard.users.add_role_to_user_form', [
            'role' => $role,
            'route' => session()->get('dashboard_route'),
        ]);
    }

    public function get_all_logins() {
        $logins = User::all()->pluck('login')->toArray();

        return response()->json($logins);
    }

    public function get_user_role(Request $request, $role) {
        $validator = Validator::make($request->all(), [
            'login' => 'required',
        ]);
        $validator->validate();

        $user = User::where(['login' => auth()->user()->login])->first();
        $selected_user = User::where(['login' => $request->login])->first();
        $selected_role = Role::where(['name' => $role])->first();
        
        if($selected_user == null) {
            return back()->withErrors([
                'message' => 'User with login "' . $request->login . '" does not exist',
            ]);
        }

        if($selected_role == null) {
			return back()->withErrors([	
				'message' => 'Role "' . $role . '" does not exist',
			]);
		}

        if($selected_user->hasRole('super_admin')){
            return back()->withErrors([
                'message' => 'You can not grant role to super-admin!',
            ]);
        }

        if($selected_user == null) {
            return back()->withErrors([
                'message' => 'User does not exist!',
            ]);
        }

        if($role == 'super_admin') {
            return back()->withErrors([
                'message' => 'You can not add super-admin!',
            ]);
        }

        if($role == 'admin' and !($user->hasRole('super_admin'))) {
            return back()->withErrors([
                'message' => 'You can not add admin!',
            ]);
        }

        $selected_user->assignRole($role);
        $selected_user->save();

        return back()->with('message', 'Role successfull granted!');
    }

    public function generate_catalog_home_page(Request $request) {
        $categories = Category::all();

        $max_lenght = 20;
        foreach ($categories as $category) {
            $name = $category->name;
            if(mb_strlen($name) > $max_lenght) {
                $name = mb_substr($name, 0, $max_lenght - 3) . '...';
                $category->name = $name;
            }
        }

        $curr_route = $request->route()->getName();

        $this->edit_curr_path($curr_route);

        return view('dashboard.catalog.categories_list', [
            'categories' => $categories,
            'route' => session()->get('dashboard_route'),
        ]);
    }

    public function generate_categories_create_form(Request $request) {
        $curr_route = $request->route()->getName();
        $this->edit_curr_path($curr_route);

        return view('dashboard.catalog.category_form', [
            'status' => 'create',
            'route' => session()->get('dashboard_route'),
        ]);
    }

    public function insert_created_category(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories',
        ]);
        $validator->validate();

        Category::create($validator->validated());

        return back()->with('message', 'Category successfull created!');
    }

    public function generate_categories_edit_form(Request $request, $id) {
        $category = Category::where(['id' => $id])->first();

        $curr_route = $request->route()->getName();
        $this->edit_curr_path($curr_route, ['id' => $id]);

        return view('dashboard.catalog.category_form', [
            'category' => $category,
            'status' => 'edit',
            'route' => session()->get('dashboard_route'),
        ]);
    }

    public function insert_edited_category($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        $validator->validate();

        $category = Category::where(['id' => $id])->first();
        
        $category->name = $request->name;
        $category->save();

        return back()->with('message', 'Category successfull updated!');
    }

    public function delete_category($id) {
        $category = Category::where(['id' => $id])->first();
        $category->delete();

        return back()->with('message', 'Category successfull deleted!');
    }

    public function generate_category_contains(Request $request, $id) {
        $category = Category::where(['id' => $id])->first();

        $products = $category->products;
        
        $curr_route = $request->route()->getName();
        $this->edit_curr_path($curr_route, ['id' => $id]);

        return view('dashboard.catalog.products_list', [
            'products' => $products,
            'category' => $category,
            'route' => session()->get('dashboard_route'),
        ]);
    }

    public function generate_products_create_form(Request $request, $id) {
        $category = Category::where(['id' => $id])->first();

        $curr_route = $request->route()->getName();
        $this->edit_curr_path($curr_route, ['id' => $id]);

        return view('dashboard.catalog.products_form', [
            'status' => 'create',
            'category' => $category,
            'route' => session()->get('dashboard_route'),
        ]);
    }

    public function insert_created_product(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'numeric|required',
            'description' => 'max:500',
        ]);
        $validator->validate();

        $category = Category::where(['id' => $id])->first();

        $category->products()->create($validator->validated());

        return back()->with('message', 'product successfull created');
    }

    public function generate_products_edit_form(Request $request, $id_category, $id_product){
        $category = Category::where(['id' => $id_category])->first();

        $product = $category->products->where('id', $id_product)->first();
        
        $curr_route = $request->route()->getName();
        $this->edit_curr_path($curr_route, ['id_category' => $id_category, 'id_product' => $id_product]);

        return view('dashboard.catalog.products_form', [
            'status' => 'edit',
            'category' => $category,
            'product' => $product,
            'route' => session()->get('dashboard_route'),
        ]);
    }

    public function insert_edited_product(Request $request, $id_category, $id_product){
        Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'numeric|required',
            'description' => 'max:500',
        ])->validate();

        $category = $category = Category::where(['id' => $id_category])->first();
        $product = $category->products->where('id', $id_product)->first();

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        $product->save();

        return back()->with('message', 'Successfull update');
    }

    public function generate_product_view(Request $request, $id_category, $id_product){
        $category = Category::where(['id' => $id_category])->first();
        $product = $category->products->where('id', $id_product)->first();

        $curr_route = $request->route()->getName();
        $this->edit_curr_path($curr_route, ['id_category' => $id_category, 'id_product' => $id_product]);

        return view('dashboard.catalog.product_view', [
            'product' => $product,
            'category' => $category,
            'route' => session()->get('dashboard_route'),
        ]);
    }

    public function delete_product($id_category, $id_product){
        $category = Category::where(['id' => $id_category])->first();
        $product = $category->products->where('id', $id_product)->first();

        $product->delete();

        return back()->with('message', 'Successfull product delete');
    }
}
