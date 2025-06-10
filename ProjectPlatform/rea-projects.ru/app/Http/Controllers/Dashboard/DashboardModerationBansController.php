<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ban;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardModerationBansController extends Controller
{
    public static function moderation_page() {
        return view('dashboard.moderation.main');
    }

    public static function bans_page() {
        $bans = Ban::all(); 

        return view('dashboard.moderation.bans', [
            'bans' => $bans,
        ]);
    }


    public static function remove_ban($id) {
        
        if(Auth::user() == null) {
            return back();
        }

        $ban = Ban::where(['id' => $id])->first();
        $moderator = User::where(['id' => Auth::user()->id])->first();
        $banned_user = $ban->user;

        if($ban == null) {
            return back();
        }

        if(! $moderator->can('moderate')) {
            return back()->withErrors(['err' => 'У вас нет прав']);
        }


        $ban->delete();
        
        return redirect(route('dashboard_moderation_bans'))->with('message', 'Блокировка с пользователя @' . $banned_user->login . ' успешно снята!');
    }


    public static function ban_form() {
        return view('dashboard.moderation.ban_form');
    }


    public static function ban_user(Request $request) {
        if(Auth::user() == null) {
            return back();
        }

        Validator::make($request->all(), [
            'login' => 'required',
            'reason' => 'max:500',
            'password' => 'required',
        ])->validate();

        $moderator = User::where(['id' => Auth::user()->id])->first();
        $user_to_ban = User::where(['login' => $request->login])->first();
        
        if($user_to_ban == null) {
            return back()->withErrors(['err' => 'Такого пользователя не существует!']);
        }

        if($user_to_ban->can('moderate')) { 
            if (! $moderator->can('god')) {
                return back()->withErrors(['err' => 'Вы не можете выдать блокировку этому пользователю!']);
            }
        }

        if($moderator->id == $user_to_ban->id) {
            return back()->withErrors(['err' => 'Вы не можете выдать себе блокировку!']);
        }

        if(! Auth::attempt(['login' => $moderator->login, 'password' => $request->password])) {
            return back()->withErrors(['err' => 'Неверный пароль!']);
        }

        Ban::create([
            'moderator_id' => Auth::user()->id,
            'banned_user_id' => $user_to_ban->id,
            'reason' => $request->reason,
        ]);

        $user_to_ban->roles()->detach();

        return redirect(route('dashboard_moderation_bans'));
    }


    public static function ban_page($id) {
        $ban = Ban::where(['id' => $id])->first();

        if($ban == null) {
            return back();
        }

        return view('dashboard.moderation.ban_page', [
            'ban' => $ban,
        ]);
    }   
}
