<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'id',
        'name',
        'user_id',
        'is_private',
        'description',
        'file',
        'views',
        'likes',
        'extension',
        'created_at',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
