<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'id',
    ];


    public function notes() {
        return $this->hasMany(CartProduct::class);
    }

    
    public function clear() {
        $notes = $this->notes;

        foreach ($notes as $note) {
            $note->delete();
        }

        return 1;
    }
}
