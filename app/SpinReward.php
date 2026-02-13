<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpinReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'value',
        'chance',
        'icon',
        'status',
        'tbl_type'
    ];
}
