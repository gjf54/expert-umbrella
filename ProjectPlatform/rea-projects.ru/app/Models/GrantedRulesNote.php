<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrantedRulesNote extends Model
{
    use HasFactory;

    protected $table = 'granted_users_projects_rules';
    protected $dateFormat = 'U';

    protected $fillable = [
        'id',
        'user_id',
        'project_id',
        'level',
    ];

    public function project() {
        return $this->belongsTo(Project::class, 'id', 'project_id');
    }
}
