<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewedProject extends Model
{
    protected $table = 'viewed_projects';

    protected $fillable = [
        'id',
        'user_id',
        'project_id',
    ];


    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
