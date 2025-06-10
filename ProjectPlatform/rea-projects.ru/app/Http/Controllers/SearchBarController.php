<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SearchBarController extends Controller
{
    public function get_projects_with_name(Request $request) {
        $projects = Project::all();
        $projects_arr = [];
        $data = $request->all();

        foreach($projects as $project) {
            $tmp_str = " " . $project->name;
            $tmp_usr = " " . $project->user->name;
            if(mb_strpos($tmp_str, $data["name"]) and $project->is_private == false ) {
                array_push($projects_arr, [$project->name, route('project_page', ['id' => $project->id])]);
            }
        }

        return $projects_arr;
    }

    public function find_projects() {
        $name = '';
        $accepted = [];

        if(Auth::user()) {
            $user = User::where(['id' => Auth::user()->id])->first();
        }

        if(request('name') != null) {
            $name = request('name');
        }

        $projects = Project::all();
        
        if($name != '') {
            for($i = 0; $i < sizeof($projects); $i++) {
                $pr_name = ' ' . $projects[$i]->name;
                
                if((mb_strpos($pr_name, $name) or $projects[$i]->user->login == $name)) {
                    array_push($accepted, $projects[$i]);
                    continue;
                }
            }
            $projects = $accepted;
        } 

        return view('projects.search_projects', [
            'projects' => $projects,
            'show_privates' => (Auth::user() ? ($user->can('moderate') ? true : false) : false),
            'searchbar_input_value' => $name,
        ]);
    }

    public function get_banned_users_with_login(Request $request) {
        $users_arr = [];
        $bans = Ban::all();

        foreach($bans as $ban) {
            $tmp_login = " " . $ban->user->login;
            if(mb_strpos($tmp_login, $request->login)) {

                array_push($users_arr, [$ban->user->login, route('dashboard_moderation_ban_page', ['id' => $ban->id])]);
            }
        }

        return $users_arr;
    }

    public function find_bans() {
        $login = request('login');
        $accepted = [];

        if($login == null) {
            return view('dashboard.moderation.bans_search', [
                'bans' => $accepted,
            ]);
        }

        $bans = Ban::all();

        if($login != '') {
            for($i = 0; $i < sizeof($bans); $i++) {
                $tmp_login = ' ' . $bans[$i]->user->login;
                if(mb_strpos($tmp_login, $login)) {
                    array_push($accepted, $bans[$i]);
                    continue;
                }
            }
        } 
        
        return view('dashboard.moderation.bans_search', [
            'bans' => $accepted,
        ]);
    }
}
