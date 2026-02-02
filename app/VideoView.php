<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoView extends Model
{
    use HasFactory;
    protected $table = 'video_views';

    protected $fillable = ['video_id', 'user_id', 'view_count'];
    
}
