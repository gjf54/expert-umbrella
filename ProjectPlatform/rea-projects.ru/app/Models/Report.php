<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
    
    protected $fillable = [
        'id',
        'user_id',
        'project_id',
        'title',
        'description',
    ];

    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
