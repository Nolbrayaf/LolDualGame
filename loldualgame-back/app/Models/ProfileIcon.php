<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileIcon extends Model
{
    use HasFactory;




    public function users()
    {
        return $this->hasMany(User::class, 'profile_icon_id');
    }
}
