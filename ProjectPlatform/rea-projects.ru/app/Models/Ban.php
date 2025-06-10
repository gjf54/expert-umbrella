<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    protected $table = 'bans';

    protected $fillable = [
        'id',
        'moderator_id',
        'banned_user_id',
        'reason',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'banned_user_id', 'id');
    }

    public function moderator() {
        return $this->belongsTo(User::class, 'moderator_id', 'id');
    }
}
