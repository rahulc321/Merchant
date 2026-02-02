<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function postedBy(){
        return $this->hasOne(User::class,'id','created_by');
    }

    public function getReceiversAttribute()
    {
        return User::whereIn('id', explode(',', $this->assigned_to))->get();
         
    }


    public function end_user_name(){
        return $this->hasOne(User::class,'id','end_user');
    }

    public function agent_name(){
        return $this->hasOne(User::class,'id','assigned_to');
    }
}
