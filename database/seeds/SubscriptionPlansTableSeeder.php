<?php

use App\Plan;
use Illuminate\Database\Seeder;

class SubscriptionPlansTableSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'title' => 'Starter Learning',
                'benefits' => [
                    'Access basic learning materials',
                    'Valid for short trial usage',
                    'Standard dashboard access',
                ],
                'price' => 99,
                'days' => 7,
                'usage_limit' => 5,
                'status' => 1,
            ],
            [
                'title' => 'Monthly Growth',
                'benefits' => [
                    'Access all active learning materials',
                    'Plan history and expiry tracking',
                    'Best for regular students',
                ],
                'price' => 499,
                'days' => 30,
                'usage_limit' => 30,
                'status' => 1,
            ],
            [
                'title' => 'Quarterly Pro',
                'benefits' => [
                    '90 days uninterrupted access',
                    'Priority learning updates',
                    'Better value for long-term users',
                ],
                'price' => 1299,
                'days' => 90,
                'usage_limit' => 100,
                'status' => 1,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(
                ['title' => $plan['title']],
                [
                    'benefits' => $plan['benefits'],
                    'price' => $plan['price'],
                    'days' => $plan['days'],
                    'usage_limit' => $plan['usage_limit'],
                    'status' => $plan['status'],
                ]
            );
        }
    }
}
