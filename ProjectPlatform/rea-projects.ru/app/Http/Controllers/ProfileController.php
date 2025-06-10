<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected $default_avatar = 'default.png';
    protected $default_avatar_path = '/imgs/avatars/';


    public function profile_page() {
        $user = Auth::user();

        $projects = $user->projects;
        $using_space = 0;

        foreach($projects as $project) {
            $using_space += Storage::disk('public')->size('projects/' . $user->login . '/' . $project->file);
        }

        $using_space = intval($using_space / 1024 / 1024);

        // dd($using_space);

        return view('user.profile', [
            'user' => $user,
        ]);
    }


    public function name_edit_form() {
        return view('user.edit.name');
    }


    public function password_edit_form() {
        return view('user.edit.password');
    }


    public function avatar_edit_form() {
        return view('user.edit.avatar');
    }


    public function add_edit_form() {
        return view('user.edit.additional');
    }


    public function name_edit(Request $request) {
        $validator = validator($request->all(), [
            'name' => 'required|max:32',
            'last_name' => 'required|max:32',
            'password' => 'required',
        ])->validate();

        if(Auth::attempt(['login' => Auth::user()->login, 'password' => $request->password ])) {
            $user = User::where(['login' => Auth::user()->login])->first();
            
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            
            $user->save();

            return redirect('/profile');
        } else {
            return back()->withErrors(['error' => 'Неверный пароль']);
        }
    }


    public function password_edit(Request $request) {
        $validator = validator($request->all(), [
            'new_password' => 'required|max:32',
            'new_password_repeat' => 'required|max:32|same:new_password',
            'password' => 'required',
        ])->validate();

        if(Auth::attempt(['login' => Auth::user()->login, 'password' => $request->password ])) {
            $user = User::where(['login' => Auth::user()->login])->first();
            
            $user->password = $request->new_password;
            
            $user->save();

            return redirect('/profile');
        } else {
            return back()->withErrors(['error' => 'Неверный пароль']);
        }
    }


    public function avatar_edit(Request $request){

        $validator = validator()->make($request->all(), [
            'avatar' => 'required|file|image',
            'password' => 'required',
        ])->validate();
        
        $auth_user = Auth::user();

        if(Auth::attempt(['login' => $auth_user->login, 'password' => $request->password])) {
            $user = User::where(['login' => $auth_user->login])->first();

            if($user->avatar != $this->default_avatar) {
                Storage::disk('public')->delete($this->default_avatar_path . $user->avatar);
            }

            $file = Storage::disk('public')->put($this->default_avatar_path, $request->avatar);


            $user->avatar = basename($file);
            $user->save();

            return redirect('/profile');

        } else {
            return back()->withErrors(['error' => 'Неверный пароль']);
        }
    }


    public function add_edit(Request $request) {
        $validator = validator($request->all(), [
            'description' => 'required|max:3000',
            'password' => 'required',
        ])->validate();

        if(Auth::attempt(['login' => Auth::user()->login, 'password' => $request->password])) {
            $user = User::where(['login' => Auth::user()->login])->first();
            $user->description = $request->description;
            $user->save();

            return redirect('/profile');
        }

        return back()->withErrors(['error' => 'Неверный пароль']);
    }

    
    public function user_profile_view($id) {
        $user = User::where(['id' => $id])->first();

        if($user == null) {
            abort(404);
        }

        if(Auth::user() != null) {
            if($user->id == Auth::user()->id) {
                return redirect('/profile');
            }
        }

        return view('profile_view', [
            'user' => $user,
        ]);
    }

    public function profile_projects_view() {
        $user = Auth::user();
        $show_privates = true;

        $projects = $user->projects;

        return view('user.projects_page', [
            'projects' => $projects,
            'show_privates' => $show_privates,
        ]);
    }
}

