<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'name' => 'Administrator',
            'slug' => 'Responsible for managing and maintaining the system.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Analyst',
            'slug' => 'Responsible for analyzing and processing data to extract relevant information and make strategic decisions.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Supervisor',
            'slug' => 'Responsible for overseeing and coordinating team activities.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Business Validator',
            'slug' => 'Responsible for validating information and ensuring its accuracy. | Business',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Telemarketing Validator',
            'slug' => 'Responsible for validating information and ensuring its accuracy. | Telemarketing',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Mulfood Validator',
            'slug' => 'Responsible for validating information and ensuring its accuracy. | Mulfood',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Teleservices Validator',
            'slug' => 'Responsible for validating information and ensuring its accuracy. | Teleservices',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            'name' => 'Principal Validator',
            'slug' => 'Responsible for validating information and ensuring its accuracy.',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
