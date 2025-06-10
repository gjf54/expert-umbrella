<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function register_report(Request $request) {
        Validator::make($request->all(), [
            'report_text' => 'required|max:1000',
            'project_id' => 'required',
        ])->validate();

        if(Auth::user() == null) {
            return abort(401);
        }

        if(Auth::user()->id == Project::where(['id' => $request->project_id])->first()->user_id) {
            return abort(489, 'Вы не можете отправить жалобу на себя!');
        }

        if(Report::where(['user_id' => Auth::user()->id, 'project_id' => $request->project_id])->first()) {
            return abort(490, 'Вы уже отправили жалобу!');
        }

        $report = Report::create([
            'project_id' => $request->project_id,
            'user_id' => Auth::user()->id,
            'title' => "Жалоба от @" . Auth::user()->login,
            'description' => $request->report_text,
        ]);

        return $report;
    }
}
