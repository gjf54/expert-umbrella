<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Dashboard\DashboardModerationBansController as BansControl;
use App\Http\Controllers\Dashboard\DashboardModerationReportsController as ReportsControl;
use App\Http\Controllers\Dashboard\DashboardUsersController as UsersControl;
use App\Http\Controllers\Dashboard\DashboardTokensController as TokensControl;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function main_page() {
        return view('dashboard.main');
    }

    public function users_page() {
        return UsersControl::users_page();
    }

    public function grant_role(Request $request, $role) {
        return UsersControl::grant_role($request, $role);
    }

    public function remove_role($id, $role) {
        return UsersControl::remove_role($id, $role);
    }

    public function roles_form($role) {
        return UsersControl::roles_form($role);
    }

    public function moderation_page() {
        return BansControl::moderation_page();
    }

    public function moderation_bans_page() {
        return BansControl::bans_page();
    }

    public function moderation_unban(Request $request) {
        return BansControl::remove_ban($request->id);
    }

    public function moderation_ban_form() {
        return BansControl::ban_form();
    }

    public function moderation_ban_user(Request $request)  {
        return BansControl::ban_user($request);
    }

    public function moderation_ban_page($id) {
        return BansControl::ban_page($id);
    }

    public function moderation_reports_main_page() {
        return ReportsControl::main_page();
    }

    public function moderation_report_page($id) {
        return ReportsControl::report_page($id);
    }

    public function tokens_main_page() {
        return TokensControl::main_page();
    }

    public function tokens_form() {
        return TokensControl::token_form();
    }

    public function tokens_add_token(Request $request) {
        return TokensControl::add_token($request);
    }
}
