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
