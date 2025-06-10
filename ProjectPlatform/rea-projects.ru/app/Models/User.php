<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'login',
        'registration_token_id',
        'password',
        'avatar',
        'description',
        'data_limit'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function projects() {
        return $this->hasMany(Project::class, 'user_id', 'id');
    }

    public function views() {
        $projects = $this->projects;
        $views = 0;

        foreach($projects as $project) {
            $views += $project->views;
        }

        return $views;
    }

    public function likes() {
        $projects = $this->projects;
        $likes = 0;
        foreach($projects as $project) {
            $likes += $project->likes;
        }

        return $likes;
    }

    public function favorite_projects() {
        return $this->hasMany(FavoriteProject::class, 'user_id', 'id');
    }

    public function reports() {
        return $this->hasMany(Report::class, 'user_id', 'id');
    }

    public function ban() {
        return $this->hasOne(Ban::class, 'banned_user_id', 'id');
    }

    public function get_data_size() {
        $count = 0;
        
        if(Auth::user()) {
            $projects = Auth::user()->projects;

            if($projects) {
                foreach ($projects as $project) {
                    $count += Storage::disk('public')->size('projects/' . Auth::user()->login . '/' . $project->file);
                }
            }   
        }

        return (int)($count / 1024 / 1024);
    }
}
