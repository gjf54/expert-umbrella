<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JsProcessController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchBarController;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/info', function () {
    return view('info');
});

Route::get('/users/{id}/user/profile', [ProfileController::class, 'user_profile_view'])->name('user_profile_view');
Route::get('/users/{id}/user/projects', [ProjectController::class, 'user_projects_view'])->name('user_projects_view');

Route::group(['prefix' => 'projects'], function () {
    Route::get('/', [ProjectController::class, 'projects_page'])->name('projects_page');
    Route::get('search', [SearchBarController::class, 'find_projects'])->name('searchbar_find_projects');
    Route::get('/{id}/project', [ProjectController::class, 'project_page'])->name('project_page');
    Route::get('/{id}/project/view', [ProjectController::class, 'project_view'])->name('project_view');
    Route::get('/{id}/project/download', [ProjectController::class, 'project_download'])->name('project_download');
    Route::post('/project/find_project', [SearchBarController::class, 'get_projects_with_name'])->name('searchbar_get_projects');

    Route::group(['middleware' => ['auth', 'ban']], function () {
        Route::post('/project/send_report', [ReportController::class, 'register_report'])->name('project_send_report');
    });
    
});


// auth routes (guest)

Route::group(['middleware' => 'guest:web'], function ($router) {
    Route::get('/login', [AuthController::class, 'login_page'])->name('login_page');
    Route::get('/registration', [AuthController::class, 'registration_page'])->name('registration_page');
    
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/registration', [AuthController::class, 'register'])->name('register');
}); 

Route::group(['middleware' => ['auth']], function ($router) {
    Route::post('/projects/{id}/project/like', [ProjectController::class, 'like_project'])->name('project_like');

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'profile_page'])->name('profile_page');
        
        Route::group(['middleware' => 'ban'], function () {

            Route::get('/name/edit', [ProfileController::class, 'name_edit_form'])->name('profile_name_edit_form');
            Route::get('/password/edit', [ProfileController::class, 'password_edit_form'])->name('profile_password_edit_form');
            Route::get('/avatar/edit', [ProfileController::class, 'avatar_edit_form'])->name('profile_avatar_edit_form');
            Route::get('/add/edit', [ProfileController::class, 'add_edit_form'])->name('profile_add_edit_form');

            Route::post('/name/edit', [ProfileController::class, 'name_edit'])->name('profile_name_edit');
            Route::post('/password/edit', [ProfileController::class, 'password_edit'])->name('profile_password_edit');
            Route::post('/avatar/edit', [ProfileController::class, 'avatar_edit'])->name('profile_avatar_edit');
            Route::post('/add/edit', [ProfileController::class, 'add_edit'])->name('profile_add_edit');

            Route::get('/projects/upload/', [ProjectController::class, 'projects_form'])->name('project_upload_form');
            Route::post('/projects/upload/', [ProjectController::class, 'store_project'])->name('project_upload');

            Route::get('/project/{id}/edit', [ProjectController::class, 'settings_page'])->name('project_settings_page');
            Route::post('/project/{id}/edit', [ProjectController::class, 'settings_apply'])->name('project_settings_apply');

            Route::get('/projects', [ProfileController::class, 'profile_projects_view'])->name('profile_projects_view');

            Route::get('/project/{id}/delete', [ProjectController::class, 'delete_project'])->name('project_delete');

        });

        Route::get('logout', function () {
            Auth::logout();
            return redirect('/');
        })->name('logout');
    });
});


Route::group(['middleware' => ['auth', 'role:super_admin|admin', 'ban'], 'prefix' => 'dashboard'], function ($router) {
    Route::get('/', [DashboardController::class, 'main_page']);
    
    Route::group(['prefix' => 'users'], function ($router) {
        Route::get('/', [DashboardController::class, 'users_page'])->name('dashboard_users');
        
        Route::get('/grant_role/{role}', [DashboardController::class, 'roles_form'])->name('dashboard_users_roles_form');
        Route::post('/grant_role/{role}', [DashboardController::class, 'grant_role'])->name('dashboard_users_grant_role');

        Route::get('/{id}/user/remove_role/{role}', [DashboardController::class, 'remove_role'])->name('dashboard_users_remove_role');
    });

    Route::group(['prefix' => 'moderation'], function ($router) {
        Route::get('/', [DashboardController::class, 'moderation_page'])->name('dashboard_moderation');

        Route::group(['prefix' => 'bans'], function () {
            Route::get('/', [DashboardController::class, 'moderation_bans_page'])->name('dashboard_moderation_bans');

            Route::get('/{id}/ban', [DashboardController::class, 'moderation_ban_page'])->name('dashboard_moderation_ban_page');

            Route::post('/ban/remove', [DashboardController::class, 'moderation_unban'])->name('dashboard_moderation_unban');

            Route::get('/set_ban', [DashboardController::class, 'moderation_ban_form'])->name('dashboard_moderation_ban_form');
            Route::post('/set_ban', [DashboardController::class, 'moderation_ban_user'])->name('dashboard_moderation_ban_user');

            Route::get('/search', [SearchBarController::class, 'find_bans'])->name('dashboard_moderation_bans_search');
            Route::post('/find_bans', [SearchBarController::class, 'get_banned_users_with_login'])->name('dashboard_moderation_bans_find');
        });
    });

    Route::group(['prefix' => 'reports'], function () {
        Route::get('/', [DashboardController::class, 'moderation_reports_main_page'])->name('moderation_reports');
        Route::get('/{id}/report', [DashboardController::class, 'moderation_report_page'])->name('moderation_reports_report_page');
    });

    Route::group(['prefix' => 'tokens'], function () {
        Route::get('/', [DashboardController::class, 'tokens_main_page'])->name('dashboard_tokens');

        Route::group(['middleware' => 'can:god'], function () {
            Route::get('/add_token', [DashboardController::class, 'tokens_form'])->name('dashboard_tokens_token_form');
            Route::post('/add_token', [DashboardController::class, 'tokens_add_token'])->name('dashboard_tokens_add_token');
        });
    });
});


Route::group(['prefix' => 'processes'], function ($router) {
    Route::post('/get_logins', [JsProcessController::class, 'get_logins'])->name('data_get_logins'); 
    Route::post('/ban_user', [JsProcessController::class, 'ban_user'])->name('process_ban_user');
    Route::post('/remove_report', [JsProcessController::class, 'remove_report'])->name('process_remove_report');
    Route::post('/remove_project', [JsProcessController::class, 'remove_project'])->name('process_remove_project');

    Route::group(['middleware' => 'can:god'], function () {
        Route::post('/delete_token', [JsProcessController::class, 'delete_token'])->name('process_delete_token');
    });
});
