<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function learningItem()
    {
        return $this->belongsTo(LearningItem::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
    
    
}
