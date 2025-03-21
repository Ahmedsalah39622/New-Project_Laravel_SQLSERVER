<?php

use App\Http\Controllers\Appointment as ControllersAppointment;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
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
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\pages\ReceptionistController ;
use App\Http\Controllers\Doctor\DashboardController;

// Main Page Route
Route::get('/', [Main::class, 'index'])->name('pages-home');

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
use App\Http\Controllers\pages\PaymentController;
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
  // Add other patient routes here
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

Route::middleware(['auth', 'doctor'])->group(function () {
    Route::prefix('doctor')->group(function () {
        Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('doctor.dashboard'); // Updated namespace
        Route::post('/schedule', [DoctorDashboardController::class, 'updateAvailability']);
        Route::post('/consultation/{appointment}', [DoctorDashboardController::class, 'startConsultation']);
        Route::get('/appointment/{appointment}/details', [DoctorDashboardController::class, 'viewPatientDetails']);
        Route::post('/appointment/{appointment}/reschedule', [DoctorDashboardController::class, 'rescheduleAppointment']);
    });
});

Route::middleware(['auth', 'doctor'])->group(function () {
    Route::prefix('doctor')->group(function () {
        Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('doctor.dashboard');
        Route::post('/consultation/{appointment}', [DoctorDashboardController::class, 'startConsultation']);
        Route::get('/appointment/{appointment}/details', [DoctorDashboardController::class, 'viewPatientDetails']);
        Route::post('/appointment/{appointment}/reschedule', [DoctorDashboardController::class, 'rescheduleAppointment']);
    });
});

// Route for the doctor's dashboard
Route::get('/doctor/dashboard', [DashboardController::class, 'index'])->name('doctor.dashboard');

// Route to update the status of an appointment
Route::post('/doctor/appointments/{id}/status/{status}', [DashboardController::class, 'updateStatus'])->name('doctor.appointments.updateStatus');

Route::middleware(['auth'])->group(function () {
    // Doctor Dashboard
    Route::get('/doctor/dashboard', [DashboardController::class, 'index'])->name('doctor.dashboard');

    // Update Appointment Status
    Route::post('/doctor/appointments/{id}/status/{status}', [DashboardController::class, 'updateStatus'])->name('doctor.appointments.updateStatus');
});


Route::get('/doctor/dashboard', [DashboardController::class, 'index'])->name('doctor.dashboard');
Route::get('/doctor/dashboard', [DashboardController::class, 'index'])->name('doctor.dashboard');



Route::get('/doctor/dashboard', [DashboardController::class, 'index'])->name('doctor.dashboard');
Route::get('/doctor/dashboard/data', [DashboardController::class, 'getDashboardData'])->name('doctor.dashboard.data');
