<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class DashboardModerationReportsController extends Controller
{
    public static function main_page() {
        $reports = Report::all();

        return view('dashboard.moderation.reports.main', [
            'reports' => $reports,
        ]);
    }

    public static function report_page($id) {
        $report = Report::where(['id' => $id])->first();

        return view('dashboard.moderation.reports.report_page', [
            'report' => $report,
        ]);
    }
}
