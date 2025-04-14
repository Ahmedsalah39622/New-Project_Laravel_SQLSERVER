<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AccessRolesController extends Controller
{
    public function index()
    {
        // Pass an empty array or mock data for roles
        $roles = []; // Replace with actual data if needed
        $users = []; // Replace with actual data if needed

        return view('admin.app-access-roles', compact('roles', 'users'));
    }
}
