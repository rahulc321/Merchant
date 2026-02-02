<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getINameAttribute()
    {   
        return User::where('id', $this->installer_id)->first();
    }

    public function getUNameAttribute()
    {   
        return User::where('id', $this->user_id)->first();
    }
}
