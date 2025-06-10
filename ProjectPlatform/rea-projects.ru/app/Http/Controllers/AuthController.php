<?php

namespace App\Http\Controllers;

use App\Models\RegistrationToken;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login_page() {
        return view('auth.login');
    }

    public function registration_page() {
        return view('auth.registration');
    }

    public function login(Request $request) {
        
        $validator = validator($request->all(), [
            'login' => 'required',
            'password' => 'required',
        ])->validate();
        if(Auth::attempt(['login' => $request->login, 'password' => $request->password], true)) {
            return redirect('/profile');
        }

        return back()->with('error', 'Неверный логин или пароль');
    }

    public function register(Request $request) {
        $validator = validator($request->all(), [
            'login' => 'required|max:32|unique:users',
            'password' => 'required|max:32',
            'password_repeat' => 'required|same:password',
        ])->validate();
        
        $token = RegistrationToken::where(['token' => $request->token])->first( );
            
        if($token) {
            if($token->user) {
                return back()->with('error', 'Токен уже был использован.');
            }
        } else {
            return back()->with('error', 'Такого токена не существует.');
        }

        $user = User::create([
            'login' => $request->login,
            'password' => $request->password,
            'registration_token_id' => $token->id,
        ]);
        
        Auth::login($user);

        return redirect('/profile');
    }
}
