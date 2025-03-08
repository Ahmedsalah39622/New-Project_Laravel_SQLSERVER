<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            'manage users',
            'manage doctors',
            'manage appointments',
            'view dashboard',
        ];

        // Create and assign permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $doctorRole = Role::firstOrCreate(['name' => 'doctor']);
        $patientRole = Role::firstOrCreate(['name' => 'patient']);

        // Assign permissions to roles
        $adminRole->givePermissionTo($permissions);
        $doctorRole->givePermissionTo(['manage appointments', 'view dashboard']);
        $patientRole->givePermissionTo(['view dashboard']);

        // Assign roles to users
        $admin = \App\Models\User::where('email', 'admin@example.com')->first();
        if ($admin) {
            $admin->assignRole('admin');
        }
    }
}

