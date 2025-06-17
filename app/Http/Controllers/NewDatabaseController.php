<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NewDatabaseController extends Controller
{
    public function fetchDataView()
    {
        $serverName = 'AHMED_MAHMOUD';
        $username = 'ahmed';
        $password = 'omar2007';
        $database = 'DB_Platinum';

        try {
            $dsn = "sqlsrv:Server={$serverName};Database={$database};Encrypt=yes;TrustServerCertificate=true";
            $pdo = new \PDO($dsn, $username, $password);

            $query = "SELECT        Supliser_Code AS Code, Supliser_Name AS Name, Compny_Code
FROM            dbo.St_SuppliserData";

            $stmt = $pdo->query($query);
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return view('databases', ['data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchComplexQueryResults()
    {
        try {
            $selectedDatabase = session('selected_database');

            if ($selectedDatabase) {
                DB::statement("USE [$selectedDatabase]");
            }

            $query = "SELECT        Supliser_Code AS Code, Supliser_Name AS Name, Compny_Code
FROM            dbo.St_SuppliserData";

            $results = DB::select($query);

            return view('databases', ['data' => $results, 'databaseName' => $selectedDatabase]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchDatabaseList()
    {
        try {
            $query = "SELECT name FROM sys.databases";
            $databases = DB::select($query);

            // Convert stdClass objects to arrays
            $databases = array_map(function ($item) {
                return (array) $item;
            }, $databases);

            return view('databases', ['databases' => $databases, 'data' => [], 'databaseName' => '']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchDatabaseAndTables(Request $request)
    {
        try {
            $selectedDatabase = $request->input('database');

            // Switch to the selected database
            DB::statement("USE [$selectedDatabase]");

            $query = "SELECT        Supliser_Code AS Code, Supliser_Name AS Name, Compny_Code
FROM            dbo.St_SuppliserData";

            $results = DB::select($query);

            return view('databases', ['data' => $results, 'databaseName' => $selectedDatabase]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchQueryResults(Request $request)
    {
        $databaseName = $request->input('database');

        if (empty($databaseName)) {
            return redirect()->back()->withErrors(['error' => 'Please select a database.']);
        }

        try {
            // Connect to the selected database
            DB::connection($databaseName)->getPdo();

            // Run the query
            $query = "SELECT Supliser_Code AS Code, Supliser_Name AS Name, Compny_Code FROM dbo.St_SuppliserData";
            $results = DB::connection($databaseName)->select($query);

            return view('databases', ['queryResults' => $results, 'selectedDatabase' => $databaseName]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error fetching data: ' . $e->getMessage()]);
        }
    }

    public function fetchAllDatabaseData()
    {
        try {
            $query = "SELECT name FROM sys.databases";
            $databases = DB::select($query);

            $allData = [];

            foreach ($databases as $database) {
                $dbName = $database->name;

                // Switch to each database
                DB::statement("USE [$dbName]");

                $query = "SELECT Supliser_Code AS Code, Supliser_Name AS Name, Compny_Code FROM dbo.St_SuppliserData";
                $results = DB::select($query);

                $allData[$dbName] = $results;
            }

            return view('databases', ['allData' => $allData]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
