<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
class Training extends Model
{
    use HasFactory;
    protected $table = 'training';

    public function viewedByUser()
    {
        return $this->hasOne(VideoView::class, 'video_id', 'id')
                    ->where('user_id', Auth::Id());
    }

    public function contents()
    {
        return $this->hasMany(Content::class, 'collection_id');
    }
}
