<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }
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
public function deleteUser($userId)
{
    $user = User::findOrFail($userId);

    try {
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Failed to delete user. Please try again.']);
    }
}

}
