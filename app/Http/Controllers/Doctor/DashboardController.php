<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch appointments for the logged-in doctor
        $appointments = Appointment::where('doctor_id', Auth::id())->get();

        // Pass the appointments to the view
        return view('doctor.dashboard', compact('appointments'));
    }

    public function getDashboardData()
    {
        try {
            $today = Carbon::today();

            $todayAppointments = Appointment::whereDate('appointment_date', $today)->count();
            $totalAppointments = Appointment::count();
            $pendingAppointments = Appointment::where('status', 'pending')->count();
            $completedAppointments = Appointment::where('status', 'completed')->count();
            $cancelledAppointments = Appointment::where('status', 'cancelled')->count();

            return view("doctor.dashboard", [
                'todayAppointments' => $todayAppointments,
                'totalAppointments' => $totalAppointments,
                'pendingAppointments' => $pendingAppointments,
                'completedAppointments' => $completedAppointments,
                'cancelledAppointments' => $cancelledAppointments,
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getDashboardData method: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPatientData(Request $request, $patientId)
    {
        try {
            $doctorId = Auth::id();

            $patient = Patient::find($patientId);

            if (!$patient) {
                return response()->json(['error' => 'Patient not found'], 404);
            }

            $appointments = Appointment::where('patient_id', $patientId)
                ->where('doctor_id', $doctorId)
                ->select('appointment_date', 'start_time', 'status')
                ->get();

            return response()->json([
                'patientName' => $patient->name,
                'patientEmail' => $patient->email,
                'patientPhone' => $patient->phone,
                'appointments' => $appointments,
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getPatientData method: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchDataView()
    {
        $serverName = 'AHMED_MAHMOUD';
        $username = 'ahmed';
        $password = 'omar2007';
        $database = 'DB_ECG';

        try {
            $dsn = "sqlsrv:Server={$serverName};Database={$database};Encrypt=yes;TrustServerCertificate=true";
            $pdo = new \PDO($dsn, $username, $password);

            $query = "SELECT        Supliser_Code AS Code, Supliser_Name AS Name, Compny_Code
FROM            dbo.St_SuppliserData";

            $stmt = $pdo->query($query);
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return view('dashboard.dataView', ['data' => $data]);
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

            return view('dashboard.dataView', ['data' => $results, 'databaseName' => $selectedDatabase]);
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

            return view('dashboard.dataView', ['databases' => $databases]);
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

            return view('dashboard.dataView', ['data' => $results, 'databaseName' => $selectedDatabase]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchQueryFromSelectedDatabase(Request $request)
    {
        try {
            $selectedDatabase = $request->input('database');

            if (empty($selectedDatabase)) {
                return redirect()->back()->withErrors(['error' => 'Please select a database.']);
            }

            // Fetch databases
            $query = "SELECT name FROM sys.databases";
            $databases = DB::select($query);

            // Convert stdClass objects to arrays
            $databases = array_map(function ($item) {
                return (array) $item;
            }, $databases);

            // Switch to the selected database
            DB::statement("USE [$selectedDatabase]");

            $query = "SELECT Supliser_Code AS Code, Supliser_Name AS Name, Compny_Code FROM dbo.St_SuppliserData";
            $results = DB::select($query);

            return view('dashboard.dataView', ['data' => $results, 'databases' => $databases, 'databaseName' => $selectedDatabase]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
