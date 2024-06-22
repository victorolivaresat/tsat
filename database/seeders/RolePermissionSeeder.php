<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission_role = [
            //Admin
            array('role_id' => '1', 'permission_id' => '1'),
            array('role_id' => '1', 'permission_id' => '2'),
            array('role_id' => '1', 'permission_id' => '3'),
            array('role_id' => '1', 'permission_id' => '4'),
            array('role_id' => '1', 'permission_id' => '5'),
            array('role_id' => '1', 'permission_id' => '6'),
            array('role_id' => '1', 'permission_id' => '7'),
            array('role_id' => '1', 'permission_id' => '8'),

        ];

        DB::table('permission_role')->insert($permission_role);
    }
}
