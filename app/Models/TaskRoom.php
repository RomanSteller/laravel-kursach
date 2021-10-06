<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskRoom extends Model
{
    use HasFactory;

    public function users(){
        return $this->belongsToMany(User::class,'room_user','user_id','room_id');
    }

}
