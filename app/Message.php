<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Message extends Model
{
    use HasFactory;

    public function postedBy(){
        return $this->hasOne(User::class,'id','posted_by');
    }

    public function getReceiversAttribute()
    {
        return User::whereIn('id', explode(',', $this->user_id))->get();
    }
}
