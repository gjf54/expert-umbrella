<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Post extends Model
{
    use HasFactory;
    
    public $fillable = [
        'id',
        'title',
        'text',
        'id_creator',
        'id_editor',
        'is_edited',
    ];

    protected $table = 'posts';

    protected $appends = ['creator_login', 'editor_login'];

    public function getCreatorLoginAttribute() {
        $user = User::where(['id' => $this->id_creator])->first();

        if(isset($user->login)){
            return '@'.$user->login; 
        }

        $user = auth()->user();

        return '@'.$user->login;
    }
    
    public function getEditorLoginAttribute() {
        $user = User::where(['id' => $this->id_editor])->first();

        if(isset($user->login)){
            return '@'.$user->login; 
        }

        $user = auth()->user();

        return '@'.$user->login;
    }
}
