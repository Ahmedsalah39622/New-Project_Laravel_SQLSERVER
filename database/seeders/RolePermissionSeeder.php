<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create Roles
        $admin = Role::create(['name' => 'admin']);
        $doctor = Role::create(['name' => 'doctor']);
        $patient = Role::create(['name' => 'patient']);

        // Create Permissions
        $permissions = [
            'create appointment',
            'view appointment',
            'edit appointment',
            'delete appointment'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign Permissions to Roles
        $admin->givePermissionTo($permissions);
        $doctor->givePermissionTo(['view appointment', 'edit appointment']);
        $patient->givePermissionTo(['create appointment', 'view appointment']);
    }
}
