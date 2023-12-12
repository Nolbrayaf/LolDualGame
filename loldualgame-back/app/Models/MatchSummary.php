<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchSummary extends Model
{
    use HasFactory;




    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function championUsed()
    {
        return $this->belongsTo(Champion::class, 'champion_used_id');
    }

    public function battlelogs()
    {
        return $this->hasMany(Battlelog::class, 'match_id');
    }
}
