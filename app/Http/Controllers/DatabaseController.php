<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    public function fetchRoles()
    {
        try {
            $roles = DB::table('roles')->get();
            return view('dashboard.dataView', ['roles' => $roles]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchDatabaseData(Request $request)
    {
        try {
            $selectedDatabase = $request->query('database');

            // Switch to the selected database
            DB::statement("USE [$selectedDatabase]");

            $query = "SELECT * FROM INFORMATION_SCHEMA.TABLES";
            $results = DB::select($query);

            return view('dashboard.dataView', ['data' => $results, 'databaseName' => $selectedDatabase]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
