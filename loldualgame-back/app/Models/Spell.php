<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spell extends Model
{
    use HasFactory;

    protected $fillable = [
        'champion_id',
        'name',
        'description',
        'max_rank',
        'image_path',
        'cooldowns',
        'cost',
        'effect',
        'effect_type',
        'is_passive'
    ];

    public function champion()
    {
        return $this->belongsTo(Champion::class);
    }
}
