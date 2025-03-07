<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    public function createRolesAndPermissions()
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $doctorRole = Role::firstOrCreate(['name' => 'doctor']);
        $patientRole = Role::firstOrCreate(['name' => 'patient']);

        // Define permissions
        $permissions = ['manage users', 'manage appointments', 'view reports', 'edit settings'];

        foreach ($permissions as $perm) {
            $permission = Permission::firstOrCreate(['name' => $perm]);
            $adminRole->givePermissionTo($permission);
        }

        return "Roles and permissions created!";
    }

    public function assignAdminRole($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->assignRole('admin');
            return "Admin role assigned to user ID: $userId";
        }
        return "User not found.";
    }
}
