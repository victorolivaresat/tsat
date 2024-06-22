<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ModulePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtén los IDs de los módulos y permisos
        $modules = DB::table('modules')->pluck('id', 'name');
        $permissions = DB::table('permissions')->pluck('id', 'slug');

        $module_permission = [
            // Usuarios
            ['module_id' => $modules['Users'], 'permission_id' => $permissions['users.create']],
            ['module_id' => $modules['Users'], 'permission_id' => $permissions['users.index']],
            ['module_id' => $modules['Users'], 'permission_id' => $permissions['users.edit']],
            ['module_id' => $modules['Users'], 'permission_id' => $permissions['users.delete']],

            // Roles
            ['module_id' => $modules['Roles'], 'permission_id' => $permissions['roles.create']],
            ['module_id' => $modules['Roles'], 'permission_id' => $permissions['roles.index']],
            ['module_id' => $modules['Roles'], 'permission_id' => $permissions['roles.edit']],
            ['module_id' => $modules['Roles'], 'permission_id' => $permissions['roles.delete']],

            // Agrega más relaciones según sea necesario
        ];

        DB::table('module_permission')->insert($module_permission);
    }
}
