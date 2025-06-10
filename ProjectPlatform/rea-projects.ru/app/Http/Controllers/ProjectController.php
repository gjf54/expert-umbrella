<?php

namespace App\Http\Controllers;

use App\Models\FavoriteProject;
use App\Models\Project;
use App\Models\User;
use App\Models\ViewedProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\error;

class ProjectController extends Controller
{
    protected $default_project_folder = 'projects/';

    public function projects_form() {
        return view('user.projects_form');
    }

    public function store_project(Request $request) {
        $validator = validator($request->all(), [
            'project_name' => 'required|max:200',
            'project_file' => 'required|file|mimes:pptx,docx,xlsx,doc,pdf|max:100000',
            'mode' => 'required',
            'project_description' => 'max:2000',
        ])->validate();
         
        $user = User::where(['id' => Auth::user()->id])->first();

        if($user->get_data_size() > $user->data_limit) {
            return back()->withErrors('Превышен Ваш допустимый лимит!');
        }

        $file = Storage::disk('public')->put($this->default_project_folder . Auth::user()->login . '/', $request->project_file);    

        Project::create([
            'name' => $request->project_name,
            'extension' => $request->file('project_file')->extension(),
            'user_id' => Auth::user()->id,
            'file' => basename($file),
            'is_private' => $request->mode == 'private',
            'description' => $request->project_description,
        ]);

        return redirect('/profile');
    }

    public function settings_page($id) {
        $project = Project::where(['id' => $id])->first();
        $user = Auth::user();

        if($project == null) {
            return abort(404);
        }



        if($project->user_id != $user->id) {
            return redirect('/profile');
        }

        return view('user.project_settings', [
            'project' => $project,
        ]);
    }

    public function settings_apply(Request $request, $id) {
        $project = Project::where(['id' => $id])->first();
        $user = Auth::user();

        if($project == null) {
            return abort(404);
        }

        if($project->user_id != $user->id) {
            return redirect('/profile');
        }

        $validator = validator($request->all(), [
            'name' => 'required|max:200',
            'description' => 'max:2000',
            'mode' => 'required',
        ]);

        $is_private = 0;

        if($request->mode == 'private') { 
            $is_private = 1;
        }

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_private' => $is_private,
        ]);

        return redirect('/profile');
    }

    public function projects_page() {
        $projects = Project::all();
        $projects_to_search = [];

        foreach($projects as $project) {
            array_push($projects_to_search, [$project->name, route('project_page', ['id' => $project->id])]);
        }

        return view('projects.projects_page', [
            'projects' => $projects,
            'projects_to_search' => $projects_to_search,
            'show_privates' => false,
        ]);
    }

    public function user_projects_view($id) {
        $user = User::where(['id' => $id])->first();
        
        if($user == null) {
            abort(404);
        }

        $show_privates = false;

        if(Auth::user() != null) {
            if(Auth::user()->id == $user->id) {
                $show_privates = true;
            }
        }

        $projects = $user->projects;

        return view('projects.projects_page', [
            'projects' => $projects,
            'show_privates' => $show_privates,
        ]);
    }

    public function project_page($id) {
        $project = Project::where(['id' => $id])->first();

        if($project == null) {
            abort(404);
        }

        if(Auth::user()) {
            $user = User::where(['id' => Auth::user()->id])->first();

            if($project->is_private and $user->can('moderate') == false) {
                if($user == null or $user->id != $project->user_id) {
                    return abort(404);
                }
            }

        } else {
            if($project->is_private) {
                return abort(404);
            }
        }

        if(Auth::user() != null) {
            if($user->id != $project->user_id) {
                if(ViewedProject::where(['user_id' => $user->id, 'project_id' => $project->id])->first() == null) {
                    ViewedProject::create([
                        'user_id' => $user->id,
                        'project_id' => $project->id,
                    ]);
                
                    $project->views += 1;
                }
            }
        } else {
            $session_adress = 'project-' . $project->id;
            if(session($session_adress) == null) {
                session([$session_adress => 'viewed']);

                $project->views += 1;
            }
        }

        $project->save();
        
        return view('projects.project_page', [
            'project' => $project,
        ]);
    }

    public function project_view($id) {
        $project = Project::where(['id' => $id])->first();
        $user = User::where(['id' => Auth::user()->id])->first();

        if($project->is_private and $user->can('moderate') == false) {
            if($user == null or $user->id != $project->user_id) {
                return abort(404);
            }
        }

        if($project == null) {
            return abort(404);
        }

        $file_name = $project->file;
        $file_path= Storage::disk('public')->path('projects/' . $project->user->login . '/' . $project->file);
        // $file_url=asset('storage/' . $this->default_project_folder . $project->user->login . '/' . $project->file);
        $file_url = 'https://rea-projects.ru/storage/projects/' . $project->user->login . '/' . $project->file;

        // dd($file_url);

        return view('projects.project_view', [
            'project' => $project,
            'project_url' => $file_url,
        ]);
    }

    public function project_download($id) {
        $project = Project::where(['id' => $id])->first();
        if($project == null) {
            return abort(404);
        }

        // dd($project->is_private);

        if(Auth::user() == null and $project->is_private) {
            return redirect('/');
        }

        if($project->is_private and $project->user->id != Auth::user()->id) {
            return abort(404);
        }

        return response()->download(Storage::disk('public')->path('projects/' . $project->user->login . '/' . $project->file), $project->name . '_' . $project->id . '.' . $project->extension);
    }

    public function like_project($id) {
        $user = Auth::user();
        
        foreach($user->favorite_projects as $favorite_project) {
            if($favorite_project->project_id == $id) {
                $project = $favorite_project->project;
                $project->likes -= 1;
                
                $project->save();
                $favorite_project->delete();
                return $project->likes;
            }
        }

        $project = Project::where(['id' => $id])->first();
        $favorite_project = FavoriteProject::create([
            'user_id' => $user->id,
            'project_id' => $id,
        ]);

        $project->likes += 1;
        $project->save();

        return $project->likes;
    }

    public function delete_project($id) {
        $project = Project::where(['id' => $id])->first();

        Storage::disk('public')->delete('projects/' . Auth::user()->login . '/' . $project->file);
        $project->delete();

        return redirect('/profile');
    }
}
