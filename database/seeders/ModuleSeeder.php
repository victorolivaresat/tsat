<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modules')->insert([
            'name' => 'Users',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('modules')->insert([
            'name' => 'Roles',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('modules')->insert([
            'name' => 'Permissions',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('modules')->insert([
            'name' => 'Transactions',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('modules')->insert([
            'name' => 'Wallet',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('modules')->insert([
            'name' => 'Utilities',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
