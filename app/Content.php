<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use SoftDeletes;

    public $table = 'contents';

    protected $guarded = [];

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function mcqQuestions()
    {
        return $this->hasMany(Question::class, 'content_id');
    }
}
