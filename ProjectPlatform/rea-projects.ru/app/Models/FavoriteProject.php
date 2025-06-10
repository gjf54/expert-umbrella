<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteProject extends Model
{
    use HasFactory;

    protected $table = 'favorite_projects';

    protected $fillable = [
        'id',
        'project_id',
        'user_id',
    ];

    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
