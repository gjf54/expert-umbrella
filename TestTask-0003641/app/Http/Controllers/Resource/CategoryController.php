<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index() {
        return view('category.index', [
            'categories' => Category::all(),
        ]);
    }


    public function show($category_id) {
        return ProductController::index($category_id);
    }
}
