<?php

use App\Http\Controllers\Appointment as ControllersAppointment;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;// Use the correct namespace for LoginBasic
use App\Http\Controllers\authentications\RegisterBasic;// Use the correct namespace for RegisterBasic
use App\Http\Controllers\pages\Main;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\pages\payment;
use App\Http\Controllers\DoctorDashboardController;
use App\Http\Controllers\PatientDashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\pages\Appointment;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Controllers\pages\AdminPermissionsController;
use App\Http\Controllers\pages\AdminDashboardController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\UserController;
use app\Http\Controllers\pages\PatientController;
use App\Http\Controllers\CompletedPrescriptionController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\Doctor\DashboardController;
use App\Http\Controllers\pages\ReceptionistController ;
use App\Http\Controllers\Doctor\AddPrescriptionController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\Doctor\PreviewPrescriptionsController;
use App\Http\Controllers\AppInvoicePreviewController;
use App\Http\Controllers\DiseaseStatisticController;
use App\Http\Controllers\DiseaseStatisticsController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\DatabaseDashboardController;
use App\Http\Controllers\DatabaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Main Page Route
Route::get('/', [DashboardController::class, 'fetchDatabaseList'])->name('main.page');
Route::get('/', [DashboardController::class, 'fetchComplexQueryResults'])->name('main.page');
Route::get('/home', [HomePage::class, 'index'])->name('pages-home');
Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');
Route::get('/payment', [payment::class, 'index'])->name('payment-page');

// locale
Route::get('/lang/{locale}', [LanguageController::class, 'swap']);
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/account/settings', function () {
  return view('pages.account.settings.account');
})->name('pages.account.settings.account');
//account
//Route::get('/user/profile', [MiscError::class, 'index'])->name('pages-account-settings-account');
//////////////////////////////patient
Route::post('/confirm-appointment/{id}', [AppointmentController::class, 'confirmAppointment']);
Route::post('/confirm-appointment/{id}', [AppointmentController::class, 'confirmAppointment']);
Route::post('/confirm-appointment/{id}', [AppointmentController::class, 'confirmAppointment']);
Route::get('/payment/{appointment_id}', [payment::class, 'showPaymentPage']);

Route::post('/process-payment', [payment::class, 'processPayment'])->name('process.payment');

Route::post('/process-payment', [Payment::class, 'processPayment'])->middleware('web')->name('process.payment');
Route::get('/payment/{appointmentId}', [Payment::class, 'showPaymentPage'])->name('payment.page');

Route::get('/payment/{appointmentId}', [Payment::class, 'showPaymentPage']);
Route::post('/process-payment', [Payment::class, 'processPayment']);
Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->name('appointments.show');
Route::get('/payment/{appointmentId}', [Payment::class, 'showPaymentPage']);
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function (

    ) {
        return view('content.pages.pages-home');
    })->name('dashboard');
});
//appointment:
Route::get('/appointment', [AppointmentController::class, 'index']);
Route::post('/appointment', [AppointmentController::class, 'store']);
Route::get('/doctors/{specialty}', [AppointmentController::class, 'getDoctorsBySpecialty']);
Route::get('/appointment/doctors/{specialty}', [AppointmentController::class, 'getDoctorsBySpecialty']);
Route::get('/appointment/doctors/{doctorId}/time-slots', [AppointmentController::class, 'getTimeSlots']);
Route::post('/appointment/book', [AppointmentController::class, 'store']);
Route::get('/appointment/doctors/{doctorId}/time-slots', [AppointmentController::class, 'getTimeSlots']);
Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment.index');
//chatbot
Route::get('/home', [AppointmentController::class, 'home'])->middleware('auth');
//Route::post('/chatbot', [ChatbotController::class, 'getResponse']);
//STORE DATA
//Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
//Route::get('/appointmenttime', [Appointmenttime::class, 'index'])->name('appointmenttime');
// calender
Route::get('/calender', [CalendarController::class, 'index'])->name('app-calendar');
Route::post('/check-availability', [AppointmentController::class, 'checkAvailability']);

Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

Route::get('/appointment/{id}', [AppointmentController::class, 'show'])->name('appointment.details');
Route::get('/appointment/{id}/cancel', [AppointmentController::class, 'show'])->name('appointment.cancel');
Route::get('/appointment/{id}', [AppointmentController::class, 'show'])->name('appointment.details');
//ROLES AND PERMISSIONS
Route::middleware(['auth', 'role:patient'])->group(function () {
  Route::get('/dashboard/patient', [PatientDashboardController::class, 'index'])->name('patient.dashboard');
});

// Doctor Dashboard
Route::middleware(['auth', 'role:doctor'])->group(function () {
  // Removed duplicate route pointing to DoctorController
});

Route::middleware(['auth', 'role:doctor'])->group(function () {
    // Removed duplicate route pointing to DoctorDashboardController
});

Route::middleware(['auth', 'role:doctor'])->group(function () {
    // Removed duplicate route pointing to DoctorController::dashboard
});

//permission middleware
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
  Route::get('/permissions', [PermissionController::class, 'index'])->name('admin.permissions');
  Route::post('/permissions', [PermissionController::class, 'store']);
  Route::put('/permissions/{id}', [PermissionController::class, 'update']);
  Route::delete('/permissions/{id}', [PermissionController::class, 'destroy']);
});
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
  Route::get('/permissions', [PermissionController::class, 'index'])->name('admin.permissions');
});

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin/permissions', [PermissionController::class, 'index']);
});
Route::middleware(['role:admin'])->group(function () {
  Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});
Route::middleware(['role:admin'])->group(function () {
  Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['role:patient'])->group(function () {
  Route::get('/patient', [PatientController::class, 'index'])->name('patient.dashboard');

});

Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/permissions', [AdminPermissionsController::class, 'index'])->name('admin.app-access-permission.blade');
});
Route::middleware(['role:admin'])->group(function () {
  Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['role:patient'])->group(function () {
  Route::get('/patient', [PatientController::class, 'index'])->name('patient.dashboard');
  // Add other patient routes here
});
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
  Route::get('/export/users', [ExportController::class, 'exportUsers'])->name('admin.export.users');
  Route::get('/export/appointments', [ExportController::class, 'exportAppointments'])->name('admin.export.appointments');
});
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
  Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
});
Route::middleware(['auth', 'role:receptionist'])->group(function () {
  Route::get('/receptionist/dashboard', [ReceptionistController::class, 'index'])->name('receptionist.dashboard');
  Route::delete('/api/appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
});
Route::get('/appointment/timeslots/{doctorId}/{appointmentDate}', [AppointmentController::class, 'getTimeSlots']);
Route::post('/appointment/book', [AppointmentController::class, 'store']);
Route::post('/appointment/check-availability', [AppointmentController::class, 'checkAvailability']);
Route::get('/appointment/details/{id}', [AppointmentController::class, 'details']);
Route::post('/appointment/cancel/{id}', [AppointmentController::class, 'cancel']);
Route::post('/appointment/update/{id}', [AppointmentController::class, 'update']);
// Removed duplicate doctor dashboard route
Route::delete('/api/appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
Route::post('/api/appointments/{id}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
Route::get('/doctor/dashboard', [App\Http\Controllers\Doctor\DashboardController::class, 'index'])
    ->name('doctor.dashboard')
    ->middleware(['auth', 'role:doctor']);


// Route for the doctor's dashboard

Route::get('/doctor/dashboard', [DashboardController::class, 'index'])->name('doctor.dashboard');
Route::get('/doctor/dashboard/data', [DashboardController::class, 'getDashboardData'])->name('doctor.dashboard.data');

Route::get('/addprescription', [AddPrescriptionController::class, 'index'])->name('doctor.addprescription');

// Route for adding prescription
Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/addprescription/{appointmentId?}', [AddPrescriptionController::class, 'index'])->name('doctor.addprescription');
    Route::post('/addprescription', [AddPrescriptionController::class, 'store'])->name('doctor.addprescription.store');
});

// Remove or comment out these duplicate routes
// Route::post('/prescriptions/store', [AddPrescriptionController::class, 'store'])->name('prescriptions.store');
// Route::post('/doctor/completedprescriptions/store', [CompletedPrescriptionController::class, 'store'])->name('doctor.completedprescriptions.store');
// Route::post('/doctor/completedprescriptions/store', [DoctorController::class, 'store'])->name('doctor.completedprescriptions.store');

// Add this single, clear route

Route::post('/doctor/completedprescriptions/store', [PrescriptionController::class, 'store'])->name('doctor.completedprescriptions.store');

Route::get('/doctor/app-invoice-preview/{appointmentId}', [PrescriptionController::class, 'showInvoicePreview'])
    ->name('doctor.app-invoice-preview');

Route::get('/admin/dashboard', [AppointmentController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/dashboard', [DoctorController::class, 'dashboard'])->name('admin.dashboard');
//Route for role admin
Route::get('/admin/access-roles', [RoleController::class, 'index'])->name('admin.roles.index');
Route::post('/admin/roles', [RoleController::class, 'store'])->name('roles.store');
Route::put('/admin/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('/admin/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
Route::post('/admin/users/{userId}/change-role', [RoleController::class, 'changeUserRole'])->name('users.change-role');
Route::get('/admin/access-roles', [RoleController::class, 'index'])->name('admin.roles.index');
Route::post('/admin/users/{userId}/assign-role', [RoleController::class, 'assignRole'])->name('users.assign-role');
Route::post('/admin/users/{userId}/remove-role', [RoleController::class, 'removeRole'])->name('users.remove-role');
Route::post('/admin/users/{user}/remove-role', [RoleController::class, 'removeRole'])->name('users.remove-role');
Route::get('/admin/users/export', [RoleController::class, 'exportUsers'])->name('users.export');
Route::get('/admin/access-roles', [RoleController::class, 'index'])->name('admin.access-roles');
Route::get('/admin/access-roles', [RoleController::class, 'index'])->name('admin.access-roles');
Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles.index');
Route::post('/admin/users/{user}/remove-role', [RoleController::class, 'removeRole'])->name('users.remove-role');Route::post('/admin/users/{user}/remove-role', [RoleController::class, 'removeRole'])->name('users.remove-role');

Route::get('/appointment/{appointmentId}/treatment-plan', [PrescriptionController::class, 'getTreatmentPlan'])
    ->name('appointment.treatment-plan');

Route::get('/pharmacy', function () {
    return view('content.pages.pharmacy');
})->name('pharmacy');
//ai testing
Route::get('/disease-statistics', [DiseaseStatisticController::class, 'index'])->name('disease-statistics.index');
Route::post('/disease-statistics/add-disease', [DiseaseStatisticController::class, 'addDisease'])->name('disease-statistics.add-disease');
Route::post('/disease-statistics/store', [PrescriptionController::class, 'storeDiseases'])->name('disease-statistics.store');

Route::post('/disease-statistics/add-disease', [DiseaseStatisticsController::class, 'addDisease'])->name('disease-statistics.add-disease');

Route::get('/doctor/add-prescription', [PrescriptionController::class, 'create'])->name('doctor.addprescription.create');

Route::post('/disease-statistics/add-disease', [PrescriptionController::class, 'addDisease'])->name('disease-statistics.add-disease');
//admin csv download
Route::get('/admin/disease-statistics/export', [DiseaseStatisticController::class, 'export'])->name('disease-statistics.export');
Route::get('/admin/disease-statistics/export', [DiseaseStatisticController::class, 'export'])->name('disease-statistics.export');
Route::get('/admin/disease-statistics/export', [DiseaseStatisticController::class, 'export'])->name('disease-statistics.export');
Route::post('/admin/disease-statistics/predict', [DiseaseStatisticController::class, 'predict'])->name('disease-statistics.predict');
Route::get('/doctor/patient-statistics', [DashboardController::class, 'getPatientStatistics'])
    ->name('doctor.patientStatistics');

Route::middleware(['auth', 'role:doctor'])->group(function () {
    // ...existing routes...

    // Route for handling prescriptions (both digital and manual)
    Route::post('/doctor/prescription/store', [AddPrescriptionController::class, 'store'])
        ->name('doctor.prescription.store');

    Route::post('/doctor/prescription/store-manual', [AddPrescriptionController::class, 'storeManual'])
        ->name('doctor.prescription.store-manual');
});

Route::get('/doctor/prescription/{appointmentId}/edit', [AddPrescriptionController::class, 'edit'])
    ->name('doctor.prescription.edit');

Route::delete('/doctor/prescription/{prescriptionId}/delete', [AddPrescriptionController::class, 'destroy'])
    ->name('doctor.prescription.destroy');
//user status
Route::get('/admin/users/{userId}/activate', [UserController::class, 'activateUser'])->name('users.activate');
Route::delete('/admin/users/{userId}/delete', [UserController::class, 'deleteUser'])->name('users.delete');

// AI Advice Route
Route::post('/api/ai-advice', function (Request $request) {
    $predictions = $request->input('predictions');

    $payload = [
        "contents" => [
            [
                "parts" => [
                    [
                        "text" => "Given the following disease predictions, respond ONLY with a JSON object in this format: {\"logistics\": \"...\", \"doctors\": \"...\", \"clinics\": \"...\"}. For each field, provide clear, concise, and DYNAMIC recommendations with specific numbers (e.g., number of ambulances, ICU beds, doctors, clinics) that the hospital should increase or prepare, based on the data. Do NOT include any explanation, markdown, or code block, just the JSON object. Here are the predictions: " . json_encode($predictions, JSON_PRETTY_PRINT)
                    ]
                ]
            ]
        ]
    ];

    $aiApiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyB5mzFXtFQM_gm48cahNYXgOvBn7P7dZ8A';

    try {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($aiApiUrl, $payload);

        if ($response->successful()) {
            $data = $response->json();
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ??
                    $data['contents'][0]['parts'][0]['text'] ??
                    null;

            $advice = null;
            if ($text) {
                // Remove any code block markers if present
                $text = preg_replace('/^```json|^```|\s*```$/m', '', $text);
                $adviceArr = json_decode($text, true);
                if (is_array($adviceArr)) {
                    $advice =
                        "Logistics: " . ($adviceArr['logistics'] ?? '') . "\n" .
                        "Doctors: " . ($adviceArr['doctors'] ?? '') . "\n" .
                        "Clinics: " . ($adviceArr['clinics'] ?? '');
                } else {
                    $advice = $text;
                }
            }

            return response()->json([
                'success' => true,
                'advice' => $advice ?: 'No advice generated.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch advice from Gemini API.',
                'error' => $response->body(),
            ]);
        }
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ]);
    }
});

// Dashboard Routes
Route::get('/dashboard/login', [DatabaseDashboardController::class, 'login'])->name('dashboard.login');
Route::post('/dashboard/authenticate', [DatabaseDashboardController::class, 'authenticate'])->name('dashboard.authenticate');
Route::get('/dashboard/select-database', [DatabaseDashboardController::class, 'selectDatabase'])->name('dashboard.selectDatabase');
Route::get('/dashboard/view-table', [DatabaseDashboardController::class, 'viewTable'])->name('dashboard.viewTable');
Route::get('/dashboard/show-table-data', [DatabaseDashboardController::class, 'showTableData'])->name('dashboard.showTableData');
Route::post('/dashboard/test-connection', [DatabaseDashboardController::class, 'testConnection'])->name('dashboard.testConnection');
Route::post('/dashboard/check-connection', [DatabaseDashboardController::class, 'checkConnection'])->name('dashboard.checkConnection');
Route::post('/dashboard/connect', [DashboardController::class, 'connect']);
Route::get('/dashboard/connect', function () {
    return response()->json(['error' => 'Use POST method for this route'], 405);
});
Route::get('/dashboard/fetch-data', [DashboardController::class, 'fetchData']);
Route::get('/dashboard/fetch-tables', [DashboardController::class, 'fetchTables']);
Route::get('/dashboard/data-view', [DatabaseController::class, 'fetchRoles'])->name('dashboard.dataView');
Route::get('/dashboard/database-data', [DatabaseController::class, 'fetchDatabaseData'])->name('dashboard.databaseData');
Route::get('/databases', [DashboardController::class, 'fetchDatabaseList'])->name('main.page');
Route::post('/select-database', function (Request $request) {
    $selectedDatabase = $request->input('database');

    // Store the selected database in the session
    session(['selected_database' => $selectedDatabase]);

    return redirect()->route('main.page');
});
Route::get('/databases', [DashboardController::class, 'fetchDatabaseList']);
Route::get('/dashboard/databases', [DashboardController::class, 'fetchDatabaseList'])->name('dashboard.databases');

// Confirm and Reject User Routes
Route::post('/admin/confirm-user/{id}', [RoleController::class, 'confirmUser'])->name('admin.confirm-user');
Route::post('/admin/reject-user/{id}', [RoleController::class, 'rejectUser'])->name('admin.reject-user');
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('auth-login-basic');
})->name('logout');
Route::get('/admin/user-requests', [RoleController::class, 'viewUserRequests'])->name('admin.user-requests');

Route::get('/dashboard/database-tables', function (Request $request) {
    $database = $request->query('database');

    try {
        DB::statement("USE [$database]");

        $query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE'";
        $tables = DB::select($query);

        return response()->json($tables);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::get('/dashboard/table-data', function (Request $request) {
    $database = $request->query('database');

    try {
        DB::statement("USE [$database]");

        $query = "SELECT dbo.St_SuppliserData.Supliser_AccountNo AS Code, 
                         dbo.St_SuppliserData.Supliser_Name AS Name, 
                         dbo.St_SuppliserData.Compny_Code, 
                         RTRIM(dbo.ST_CHARTOFACCOUNT.AccountName) AS AccountName
                  FROM dbo.St_SuppliserData 
                  INNER JOIN dbo.ST_CHARTOFACCOUNT 
                  ON dbo.St_SuppliserData.Supliser_AccountNoGroup = dbo.ST_CHARTOFACCOUNT.Account_No_Update";

        $data = DB::select($query);

        return response()->json($data);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
Route::get('/databases/query', function () {
    try {
        $database = 'DB_ECG';
        DB::statement("USE [$database]");

        $query = "SELECT dbo.St_SuppliserData.Supliser_AccountNo AS Code, 
                         dbo.St_SuppliserData.Supliser_Name AS Name, 
                         dbo.St_SuppliserData.Compny_Code, 
                         RTRIM(dbo.ST_CHARTOFACCOUNT.AccountName) AS AccountName
                  FROM dbo.St_SuppliserData 
                  INNER JOIN dbo.ST_CHARTOFACCOUNT 
                  ON dbo.St_SuppliserData.Supliser_AccountNoGroup = dbo.ST_CHARTOFACCOUNT.Account_No_Update";

        $data = DB::select($query);

        return view('databases', ['data' => $data, 'databaseName' => $database]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
Route::post('/dashboard/query', [DashboardController::class, 'fetchQueryFromSelectedDatabase'])->name('fetchQueryFromSelectedDatabase');
