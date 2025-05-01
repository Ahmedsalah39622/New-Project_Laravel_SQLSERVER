<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function getMenu()
    {
        // Load the verticalMenu JSON file from the resources/menu directory
        $menuData = json_decode(file_get_contents(resource_path('menu/verticalMenu.json')), true);

        // Get the currently logged-in user's role (ensure auth()->user()->role is available)
        $userRole = Auth::user()->role;

        // Filter the menu items: include items with no 'role' property or match the user's role
        $filteredMenu = array_filter($menuData['menu'], function ($item) use ($userRole) {
            return !isset($item['role']) || $item['role'] === $userRole;
        });

        // Pass the filtered menu to a view (e.g., dashboard)
        return view('dashboard', ['menu' => $filteredMenu]);
    }
}
