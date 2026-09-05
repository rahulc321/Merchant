<?php

namespace App;

use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
 
class User extends Authenticatable
{
    use SoftDeletes, Notifiable, HasApiTokens;

    public $table = 'users';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'email_verified_at',
    ];

    protected $guarded = [];
    //protected $fillable = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            if (Schema::hasTable('user_referrals')) {
                static::ensureReferralCode($user);
            }
        });
    }

    public static function generateUniqueReferralCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (DB::table('user_referrals')->where('referral_code', $code)->exists());

        return $code;
    }

    public static function ensureReferralCode(User $user): void
    {
        if (!Schema::hasTable('user_referrals')) {
            return;
        }

        if (DB::table('user_referrals')->where('user_id', $user->id)->exists()) {
            return;
        }

        DB::table('user_referrals')->insert([
            'user_id' => $user->id,
            'referral_code' => static::generateUniqueReferralCode(),
            'referral_points' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public static function applyReferralCode(?string $code, User $newUser): ?User
    {
        $code = strtoupper(trim((string) $code));

        if (
            $code === '' ||
            !Schema::hasTable('user_referrals')
        ) {
            return null;
        }

        static::ensureReferralCode($newUser);

        $referral = DB::table('user_referrals')
            ->where('referral_code', $code)
            ->lockForUpdate()
            ->first();

        if (!$referral || $referral->user_id === $newUser->id) {
            return null;
        }

        $newUserReferral = DB::table('user_referrals')->where('user_id', $newUser->id)->first();

        if (!$newUserReferral || $newUserReferral->referred_by_user_id) {
            return null;
        }

        DB::table('user_referrals')
            ->where('user_id', $newUser->id)
            ->update([
                'referred_by_user_id' => $referral->user_id,
                'updated_at' => now(),
            ]);

        DB::table('user_referrals')
            ->where('user_id', $referral->user_id)
            ->increment('referral_points', 1, ['updated_at' => now()]);

        return static::find($referral->user_id);
    }

    public function getReferralCodeAttribute($value)
    {
        if ($value || !Schema::hasTable('user_referrals')) {
            return $value;
        }

        return optional($this->referralRecord)->referral_code;
    }

    public function getReferralPointsAttribute($value)
    {
        if ($value !== null || !Schema::hasTable('user_referrals')) {
            return $value;
        }

        return optional($this->referralRecord)->referral_points ?? 0;
    }

    public function getReferredByUserIdAttribute($value)
    {
        if ($value || !Schema::hasTable('user_referrals')) {
            return $value;
        }

        return optional($this->referralRecord)->referred_by_user_id;
    }

    public function referrer()
    {
        return static::find($this->referred_by_user_id);
    }

    public function referredUsers()
    {
        if (!Schema::hasTable('user_referrals')) {
            return collect();
        }

        $userIds = DB::table('user_referrals')
            ->where('referred_by_user_id', $this->id)
            ->pluck('user_id');

        return static::whereIn('id', $userIds)->get();
    }

    public function referralRecord()
    {
        return $this->hasOne(UserReferral::class);
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function deviceCount()
    {
        return $this->hasMany(Device::class, 'installer_id');
    }

    public function getTotalLeadAmountAttribute()
    {
        return $this->leads()->sum('charge_amount');
    }

    public function getUserCurrentRoleAttribute()
    {
        return $this->roles()->first(); // Assuming a user has multiple roles, returning the first assigned role
    }

    public function getAllDevicesAttribute()
    {   
        if($this->roles->contains('title', 'Installer')){
            return Device::where('installer_id', $this->id)->pluck('device_id');
        }else{
            return Device::where('user_id', $this->id)->pluck('device_id');
        }
    }

    public function addresses()
{
    return $this->hasMany(MerchantAddress::class, 'merchant_id');
}

    public function planPurchases()
    {
        return $this->hasMany(PlanPurchase::class);
    }

    public function activePlanPurchase()
    {
        return $this->hasOne(PlanPurchase::class)
            ->where('status', 'active')
            ->where('expires_at', '>=', now())
            ->latest('expires_at');
    }
}
