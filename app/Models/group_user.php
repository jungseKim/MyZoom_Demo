<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class group_user extends Model
{
    use HasFactory;
    protected $table = "group_user";
    protected $fillable = ['user_id', 'group_id'];

    public function room()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
