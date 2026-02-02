<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FailureSeeder extends Seeder
{
    public function run()
    {
        $failures = [
            [
                'failure_code' => 'E05',
                'description' => 'High pressure protection',
                'failure_analysis' => "1. High pressure switch is broken\n2. Connection is loose",
                'solution' => 'Customer service to identify the reasons',
            ],
            [
                'failure_code' => 'E09',
                'description' => 'Communication failure',
                'failure_analysis' => "1. Signal wire connection loose\n2. There is strong magnetic field\n3. PCB is broken\n4. Signal wire is broken",
                'solution' => 'Replace the controller communication line (mainboard COM2 port)',
            ],
            [
                'failure_code' => 'E12',
                'description' => 'Exhaust temp. too high',
                'failure_analysis' => "1. Lack of refrigerant\n2. Fluorine system leak",
                'solution' => 'Check then add refrigerant',
            ],
            [
                'failure_code' => 'E14',
                'description' => 'Tank temp. sensor failure',
                'failure_analysis' => "1. Sensor failure\n2. Connection is loose",
                'solution' => 'Replace the T4 temp. sensor',
            ],
            [
                'failure_code' => 'E16',
                'description' => 'Coil temp. sensor failure',
                'failure_analysis' => "1. Sensor failure\n2. Connection is loose",
                'solution' => 'Replace the T1 temp. sensor',
            ],
            [
                'failure_code' => 'E18',
                'description' => 'Exhaust temp. sensor failure',
                'failure_analysis' => "1. Sensor failure\n2. Connection is loose",
                'solution' => 'Replace the T3 temp. sensor',
            ],
            [
                'failure_code' => 'E21',
                'description' => 'Ambient temp. sensor failure',
                'failure_analysis' => "1. Sensor failure\n2. Connection is loose",
                'solution' => 'Replace the T2 temp. sensor',
            ],
            [
                'failure_code' => 'E29',
                'description' => 'Suction temp. sensor failure',
                'failure_analysis' => "1. Sensor failure\n2. Connection is loose",
                'solution' => 'Replace the T5 temp. sensor',
            ],
        ];

        DB::table('faults')->insert($failures);
    }
}
