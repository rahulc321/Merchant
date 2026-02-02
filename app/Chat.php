<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';
}
