<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DashboardUsersController extends Controller
{
    public static function users_page() {
        $super_admins = User::role('super_admin')->get();
        $admins = User::role('admin')->get();
        $user = Auth::user();

        return view('dashboard.users.main', [
            'super_admins' => $super_admins,
            'admins' => $admins,
            'user' => $user,
        ]);
    }

    public static function roles_form($role) {
        return view('dashboard.users.roles_form', [
            'role' => $role,
        ]);
    }

    private static function validate_role_operation($user, $selected_user, $selected_role) {
        if(! $user->hasRole('super_admin')) {
            return 'У Вас нет прав на выполнение операции!'; // temporary
        }

        if($selected_role->name == 'super_admin') {
            return 'У Вас нет прав на присовение данной роли!';
        }

        if($selected_role == null) {
            return 'Такой роли не сущесвует!';
        }

        if($selected_user == null) {
            return 'Такого пользователя не существует!';
        }

        if($selected_user->hasRole('super_admin')) {
            return 'У Вас нет прав на присвоение роли супер-администратору!';
        }

        return 0;
    }

    public static function grant_role(Request $request, $role) {
        $user = User::where(['id' => Auth::user()->id])->first();
        $selected_user = User::where(['login' => $request->selected_login])->first();
        $selected_role = Role::where(['name' => $role])->first();

        if(! Auth::attempt(['login' => $user->login, 'password' => $request->password])) {
            return back()->withErrors(['error' => 'Неверный пароль!']);
        }

        $error = self::validate_role_operation($user, $selected_user, $selected_role);

        if($error) {
            return back()->withErrors(['error' => $error]);
        }

        if($selected_user->hasRole($selected_role->name)) {
            return back()->withErrors(['error' => 'Пользователю уже назначена роль!']);
        }

        $selected_user->assignRole($selected_role->name);

        return self::users_page();

    }

    public static function remove_role($id, $role) {
        $user = User::where(['id' => Auth::user()->id])->first();
        $selected_user = User::where(['id' => $id])->first();
        $selected_role = Role::where(['name' => $role])->first();

        $error = self::validate_role_operation($user, $selected_user, $selected_role);

        if($error) {
            return back()->withErrors(['error' => $error]);
        }

        $selected_user->removeRole($selected_role->name);

        return self::users_page();
    }
}
