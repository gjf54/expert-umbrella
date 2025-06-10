<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\RegistrationToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardTokensController extends Controller
{
    public static function main_page() {
        $tokens = RegistrationToken::all();

        return view('dashboard.tokens.main',[
           'tokens' => $tokens,
        ]);
    }

    public static function token_form() {
        return view('dashboard.tokens.token_form');
    }

    public static function add_token(Request $request) {
        Validator::make($request->all(), [
            'token' => 'required|min:3|max:12|unique:registration_tokens|ascii',
            'password' => 'required',
        ])->validate();

        if(! Auth::attempt(['login' => Auth::user()->login, 'password' => $request->password])) {
            return back()->withErrors(['err' => 'Неверный пароль!']);
        }

        RegistrationToken::create(['token' => $request->token]);

        return redirect(route('dashboard_tokens'));
    }
}
