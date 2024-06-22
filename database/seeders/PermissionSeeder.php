<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Users
        DB::table('permissions')->insert([
            'name' => 'Create User',
            'slug' => 'users.create',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'View User',
            'slug' => 'users.index',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Update User',
            'slug' => 'users.edit',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Delete User',
            'slug' => 'users.delete',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Roles
        DB::table('permissions')->insert([
            'name' => 'Create Roles',
            'slug' => 'roles.create',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'View Roles',
            'slug' => 'roles.index',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Update Roles',
            'slug' => 'roles.edit',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('permissions')->insert([
            'name' => 'Delete Roles',
            'slug' => 'roles.delete',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
