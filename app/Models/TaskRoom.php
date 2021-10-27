<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskRoom extends Model
{
    use HasFactory;

    public function users(){
        return $this->belongsToMany(User::class,'room_user','room_id','user_id');
    }

    public function tasks(){
        return $this->hasMany(TaskRoom::class);
    }

}
