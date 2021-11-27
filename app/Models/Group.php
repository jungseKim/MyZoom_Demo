<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    public $with = ['users'];

    public function users()
    {
        // return $this->hasMany(user_room::class);
        return $this->belongsToMany(User::class);
    }
}
