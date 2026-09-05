<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BackfillUserReferralCodes extends Command
{
    protected $signature = 'users:backfill-referral-codes';
    protected $description = 'Create referral codes for users that do not have one';

    public function handle()
    {
        if (!Schema::hasTable('user_referrals')) {
            $this->error('user_referrals table does not exist. Run referral migration first.');
            return 1;
        }

        $updated = 0;

        User::withTrashed()
            ->whereNotIn('id', DB::table('user_referrals')->select('user_id'))
            ->orderBy('id')
            ->chunkById(100, function ($users) use (&$updated) {
                foreach ($users as $user) {
                    User::ensureReferralCode($user);

                    $updated++;
                }
            });

        $this->info("Referral codes created for {$updated} users.");

        return 0;
    }
}
