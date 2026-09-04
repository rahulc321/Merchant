<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'benefits',
        'price',
        'days',
        'usage_limit',
        'status',
    ];

    protected $casts = [
        'benefits' => 'array',
        'price' => 'decimal:2',
        'days' => 'integer',
        'usage_limit' => 'integer',
        'status' => 'integer',
    ];

    public function purchases()
    {
        return $this->hasMany(PlanPurchase::class);
    }

    public function getBenefitsListAttribute()
    {
        if (is_array($this->benefits)) {
            return array_filter($this->benefits);
        }

        return array_filter(preg_split('/\r\n|\r|\n/', (string) $this->benefits));
    }
}
