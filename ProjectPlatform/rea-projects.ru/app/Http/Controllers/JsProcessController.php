<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\Project;
use App\Models\RegistrationToken;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class JsProcessController extends Controller
{
    public function get_logins() {
        $logins = User::all()->pluck('login')->toArray();
        return response()->json($logins);
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
            return 0;
        }

        if($user_to_ban->can('moderate')) { 
            return 0;
        }

        if($moderator->id == $user_to_ban->id) {
            return 0;
        }

        if(! Auth::attempt(['login' => $moderator->login, 'password' => $request->password])) {
            return 0;
        }

        Ban::create([
            'moderator_id' => Auth::user()->id,
            'banned_user_id' => $user_to_ban->id,
            'reason' => $request->reason,
        ]);

        $user_to_ban->roles()->detach();

        return 1;
    }

    public function remove_report(Request $request) {
        Validator::make($request->all(), [
            'report_id' => 'required'
        ])->validate();

        $report = Report::where(['id' => $request->report_id])->first();
        $report->delete();

        return 1;
    }

    public function remove_project(Request $request) {
        Validator::make($request->all(), [
            'project_id' => 'required',
        ])->validate();

        $project = Project::where(['id' => $request->project_id])->first();

        $project->delete();

        return 1;
    }

    public function delete_token(Request $request) {
        Validator::make($request->all(),[
            'token_id' => 'required',
        ])->validate();

        $token = RegistrationToken::where(['id' => $request->token_id])->first();
        
        if($token == null) {
            return 0;
        }

        if($token->user != null) {
            return 0;
        }

        $token->delete();

        return 1;
    }
}
