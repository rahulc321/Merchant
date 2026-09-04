<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'price',
        'days',
        'usage_limit',
        'used_count',
        'starts_at',
        'expires_at',
        'status',
        'payment_gateway',
        'payment_reference',
        'payment_tracking_id',
        'payment_redirect_url',
        'gateway_response',
        'paid_at',
    ];

    protected $dates = [
        'starts_at',
        'expires_at',
        'paid_at',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'days' => 'integer',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'active' && $this->expires_at && $this->expires_at->isFuture();
    }

    public function activate()
    {
        $startsAt = now();

        $this->update([
            'starts_at' => $startsAt,
            'expires_at' => $startsAt->copy()->addDays($this->days),
            'status' => 'active',
            'paid_at' => now(),
        ]);
    }
}
