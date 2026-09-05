<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('user_referrals')) {
            Schema::create('user_referrals', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('user_id')->unique();
                $table->string('referral_code', 20)->unique();
                $table->unsignedInteger('referred_by_user_id')->nullable();
                $table->unsignedInteger('referral_points')->default(0);
                $table->timestamps();
            });
        }

        DB::table('users')
            ->orderBy('id')
            ->select('id')
            ->chunk(100, function ($users) {
                foreach ($users as $user) {
                    if (DB::table('user_referrals')->where('user_id', $user->id)->exists()) {
                        continue;
                    }

                    DB::table('user_referrals')->insert([
                        'user_id' => $user->id,
                        'referral_code' => $this->uniqueReferralCode(),
                        'referral_points' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
    }

    public function down()
    {
        Schema::dropIfExists('user_referrals');
    }

    private function uniqueReferralCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (DB::table('user_referrals')->where('referral_code', $code)->exists());

        return $code;
    }
};
