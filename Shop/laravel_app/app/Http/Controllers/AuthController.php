<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(),[
            'login' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'min:3|required',
            'name' => 'required',
            'surname' => 'required',
        ]);

        $validator->validate();

        $user = User::create($validator->validated(), [
            'password' => Hash::make($request->password),
        ]); 

        Auth::attempt($validator->validated(), true);
        return redirect(route('profile'));
    }

    public function login(Request $request){
        
        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required',
        ]);

        if(!auth()->attempt($validator->validated(), true)) {
            return back()->withErrors([
                'auth' => 'Incorrect login or password!',
            ]);
        }   

        return redirect(route('profile'));
    }

    public function profile() {
        $user = auth()->user();
        $orders = $user->orders;
        return view('profile', [    
            'user' => $user,
            'orders' => $orders,
            'avatar' => 'main.jpg',
        ]);
    }

    public function logout() {
        auth()->logout();
        return redirect(route('home'));
    }
}
