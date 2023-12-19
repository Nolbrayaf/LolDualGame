<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Champion extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'title',
        'info',
        'tags',
        'partype',
        'stats',
        'difficulty',
        'splash_art_path',
        'square_art_path',
        'dual_art_path',
        'description',
        'required_level'

    ];

    public function spells()
    {
        return $this->hasMany(Spell::class, 'champion_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_champions');
    }
}
