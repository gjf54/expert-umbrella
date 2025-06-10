<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainLayoutController extends Controller
{
    public function check() {
        return response()->json([
            'ifAuth' => !(auth()->user() == null),
        ]);
    }
}
