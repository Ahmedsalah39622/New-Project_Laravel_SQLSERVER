<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use PDO;

class DatabaseDashboardController extends Controller
{
    public function login(Request $request)
    {
        return view('dashboard.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'server' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            session([
                'server' => $request->input('server'),
                'username' => $request->input('username'),
                'password' => $request->input('password'),
            ]);

            return redirect()->route('dashboard.selectDatabase');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Login failed: ' . $e->getMessage()]);
        }
    }

    public function selectDatabase()
    {
        try {
            $server = session('server');
            $username = session('username');
            $password = session('password');

            if (!is_string($server) || !is_string($username) || !is_string($password)) {
                return redirect()->route('dashboard.login');
            }

            Config::set('database.connections.dynamic_sqlsrv', [
                'driver' => 'sqlsrv',
                'host' => $server,
                'username' => $username,
                'password' => $password,
                'database' => null,
                'options' => [
                    'TrustServerCertificate' => true,
                ],
            ]);

            $connection = DB::connection('dynamic_sqlsrv');
            $databases = $connection->select("SELECT name FROM sys.databases");

            return view('dashboard.selectDatabase', ['databases' => $databases]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to fetch databases: ' . $e->getMessage()]);
        }
    }

    public function viewTable(Request $request)
    {
        $connection = session('connection');

        if (!$connection) {
            return redirect()->route('dashboard.login');
        }

        $connection->statement("USE {$request->database}");
        $tables = $connection->select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES");

        return view('dashboard.viewTable', ['tables' => $tables, 'database' => $request->database]);
    }

    public function showTableData(Request $request)
    {
        $connection = session('connection');

        if (!$connection) {
            return redirect()->route('dashboard.login');
        }

        $connection->statement("USE {$request->database}");
        $data = $connection->select("SELECT * FROM {$request->table}");

        return view('dashboard.showTableData', ['data' => $data, 'table' => $request->table]);
    }

    public function testConnection(Request $request)
    {
        $request->validate([
            'server' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            Config::set('database.connections.test_sqlsrv', [
                'driver' => 'sqlsrv',
                'host' => $request->input('server'),
                'username' => $request->input('username'),
                'password' => $request->input('password'),
                'database' => null,
            ]);

            $connection = DB::connection('test_sqlsrv');
            $connection->getPdo();

            return response()->json(['success' => true, 'message' => 'Connection to SQL Server succeeded.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()]);
        }
    }

    public function checkConnection(Request $request)
    {
        $request->validate([
            'server' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
            'database' => 'required|string',
        ]);

        try {
            Config::set('database.connections.dynamic_sqlsrv', [
                'driver' => 'sqlsrv',
                'host' => $request->input('server'),
                'username' => $request->input('username'),
                'password' => $request->input('password'),
                'database' => $request->input('database'),
                'options' => [
                    'TrustServerCertificate' => true,
                ],
            ]);

            $connection = DB::connection('dynamic_sqlsrv');
            $connection->getPdo();

            return response()->json(['success' => true, 'message' => 'Connection to SQL Server succeeded.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()]);
        }
    }

    public function connectToSqlServer(Request $request)
    {
        $request->validate([
            'server' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
            'database' => 'required|string',
        ]);

        try {
            $dsn = "sqlsrv:Server={$request->input('server')};Database={$request->input('database')};Encrypt=yes;TrustServerCertificate=true";
            $pdo = new \PDO($dsn, $request->input('username'), $request->input('password'));

            return response()->json(['success' => true, 'message' => 'Connection to SQL Server succeeded.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()]);
        }
    }
}
