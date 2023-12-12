<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Champion extends Model
{
    use HasFactory;


    public function spells()
    {
        return $this->hasMany(Spell::class, 'champion_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_champions');
    }
}
