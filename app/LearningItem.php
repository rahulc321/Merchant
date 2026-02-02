<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function collection()
    {
        return $this->belongsTo(LearningCollection::class);
    }

    public function question()
    {
        return $this->hasOne(Question::class);
    }
}
