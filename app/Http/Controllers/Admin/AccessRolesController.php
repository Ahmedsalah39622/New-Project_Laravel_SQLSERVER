<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AccessRolesController extends Controller
{
    public function index()
    {
        $roles = [];
        $users = [];

        return view('admin.app-access-roles', compact('roles', 'users'));
    }
}
