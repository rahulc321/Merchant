<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatObject extends Model
{
    use HasFactory;

    protected $fillable = [
        'cat_id',
        'obj_id',
        'type',
        'value',
        'chance',
        'icon',
        'status',
        'tbl_type'
    ];


    public function category()
    {
        return $this->belongsTo(SpinReward::class, 'cat_id');
    }

    public function rewardName()
    {
        return $this->belongsTo(SpinReward::class, 'obj_id', 'id');
    }
}
