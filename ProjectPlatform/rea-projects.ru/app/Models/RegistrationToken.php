<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationToken extends Model
{
    use HasFactory;

    protected $table = 'registration_tokens';

    protected $fillable = [
        'id',
        'token',
    ];

    protected function user() {
        return $this->belongsTo(User::class, 'id', 'registration_token_id');
    }
}
