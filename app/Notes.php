<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;
    protected $table = 'notes';

    public function get_name(){
        return $this->hasOne(User::class,'id','user_id');
    }
  
}
