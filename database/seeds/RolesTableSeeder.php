<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'         => 1,
                'title'      => 'Admin',
                'created_at' => '2019-09-10 14:00:26',
                'updated_at' => '2019-09-10 14:00:26',
            ],
            [
                'id'         => 2,
                'title'      => 'end_user',
                'created_at' => '2019-09-10 14:00:26',
                'updated_at' => '2019-09-10 14:00:26',
            ],[
                'id'         => 3,
                'title'      => 'service_agent',
                'created_at' => '2019-09-10 14:00:26',
                'updated_at' => '2019-09-10 14:00:26',
            ],[
                'id'         => 4,
                'title'      => 'potential_user',
                'created_at' => '2019-09-10 14:00:26',
                'updated_at' => '2019-09-10 14:00:26',
            ],
            [
                'id'         => 5,
                'title'      => 'reseller',
                'created_at' => '2019-09-10 14:00:26',
                'updated_at' => '2019-09-10 14:00:26',
            ],[
                'id'         => 6,
                'title'      => 'retailer',
                'created_at' => '2019-09-10 14:00:26',
                'updated_at' => '2019-09-10 14:00:26',
            ],[
                'id'         => 7,
                'title'      => 'distributor',
                'created_at' => '2019-09-10 14:00:26',
                'updated_at' => '2019-09-10 14:00:26',
            ],
        ];

        Role::insert($roles);

    }
}
