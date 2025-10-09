<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Role as ContractsRole;
use Spatie\Permission\Models\Role as ModelsRole;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //roles
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'developer', 'guard_name' => 'web']);
        Role::create(['name' => 'tester', 'guard_name' => 'web']);

        //permissions
        Permission::create(['name' => 'create-issue', 'guard_name' => 'web']);
        Permission::create(['name' => 'assign-issue', 'guard_name' => 'web']);
        Permission::create(['name' => 'update-issue', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete-issue', 'guard_name' => 'web']);

        //give permission
        $admin = ModelsRole::findByName('admin');
        $admin->givePermissionTo(Permission::all());

        $dev = ModelsRole::findByName('developer');
        $dev->givePermissionTo(['create-issue', 'update-issue']);

        $tester = ModelsRole::findByName('tester');
        $tester->givePermissionTo(['create-issue']);
    }
}
