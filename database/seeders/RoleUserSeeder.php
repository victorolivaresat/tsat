<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_user = [
            //Admin
            array('user_id' => '1', 'role_id' => '1'),
            //Analistas
            array('user_id' => '2', 'role_id' => '2'),
            array('user_id' => '3', 'role_id' => '2'),
            array('user_id' => '4', 'role_id' => '2'),
            array('user_id' => '5', 'role_id' => '2'),
            array('user_id' => '6', 'role_id' => '2'),
            array('user_id' => '7', 'role_id' => '2'),
            array('user_id' => '8', 'role_id' => '2'),
            array('user_id' => '9', 'role_id' => '2'),
            array('user_id' => '10', 'role_id' => '2'),

        ];

        DB::table('role_user')->insert($role_user);
    }
}
