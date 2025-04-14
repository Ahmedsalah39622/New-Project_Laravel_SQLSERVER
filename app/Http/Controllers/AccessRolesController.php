<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;

class AccessRolesController extends Controller
{
    public function index()
    {
        // Fetch roles and users data
        $roles = Role::with('users')->get();
        $users = User::with('roles')->get();

        return view('admin.app-access-roles', compact('roles', 'users'));
    }
}
