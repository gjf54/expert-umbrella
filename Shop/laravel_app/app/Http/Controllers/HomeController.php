<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public $isAuth = False;

    public function load() {
        if(auth()->user() != null) {
            $this->isAuth = True;
        }

        return view('home', [
            'isAuth' => $this->isAuth,
        ]);
    }
}
