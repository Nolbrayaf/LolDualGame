<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Battlelog extends Model
{
    use HasFactory;

    public function matchSummary()
    {
        return $this->belongsTo(MatchSummary::class, 'match_id');
    }
}
