<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    // Fetch roles and users
    public function index(Request $request)
    {
        $search = $request->input('search'); // Get the search query

        // Fetch roles with user counts
        $roles = Role::withCount('users')->get();

        // Fetch users, filtered by search query if provided
        $users = User::with('roles')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(10); // Paginate resultste(10); // Paginate results

        return view('admin.app-access-roles', compact('roles', 'users', 'search'));
    }

    // Add a new role
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        Role::create(['name' => $request->name]);

        return response()->json(['success' => true, 'message' => 'Role added successfully']);
    }

    // Update an existing role
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
        ]);

        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);

        return response()->json(['success' => true, 'message' => 'Role updated successfully']);
    }

    // Delete a role
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(['success' => true, 'message' => 'Role deleted successfully']);
    }

    public function assignRoleToUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::find($request->user_id);
        $user->role_id = $request->role_id;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Role assigned successfully']);
    }

    public function changeUserRole(Request $request, $userId)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($userId);
        $user->role_id = $request->role_id; // Assuming `role_id` is the foreign key in the `users` table
        $user->save();

        return response()->json(['success' => true, 'message' => 'Role updated successfully']);
    }

    // Assign a role to a user
    public function assignRole(Request $request, $userId)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($userId);
        $user->assignRole($request->role);

        return response()->json(['success' => true, 'message' => 'Role assigned successfully!']);
    }

    // Remove a role from a user
    public function removeRole(Request $request, $userId)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($userId);
        $role = Role::where('name', $request->input('role'))->first();

        if ($user->roles()->detach($role)) {
            return response()->json(['success' => true, 'message' => 'Role removed successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Failed to remove role.']);
    }

    public function exportUsers()
    {
        $users = User::with('roles')->get();

        $response = new StreamedResponse(function () use ($users) {
            $handle = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($handle, ['Name', 'Email', 'Roles', 'Status']);

            // Add user data
            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->name,
                    $user->email,
                    $user->roles->pluck('name')->implode(', '),
                    $user->status ? 'Active' : 'Inactive',
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="users.csv"');

        return $response;
    }
}
