<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class room_user extends Model
{
    protected $table = "room_user";
    protected $fillable = ['user_id', 'room_id'];
    use HasFactory;

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
