<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'first_name' => 'Prevención',
            'last_name' => 'De Fraude',
            'email' => 'prevencion@apuestatotal.com',
            'password' => 'password',
        ]);

        User::factory(9)->create();

        $this->call([
            // UserSeeder::class,
            RoleSeeder::class,
            RoleUserSeeder::class,
            ModuleSeeder::class,
            PermissionSeeder::class,
            ModulePermissionSeeder::class
        ]);
    }
}
