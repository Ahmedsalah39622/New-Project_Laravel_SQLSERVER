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

use App\Http\Controllers\ChatbotController;
use app\Http\Controllers\PatientController;
//use App\Http\Controllers\Appointmenttime;
use App\Http\Controllers\Doctorcon;

// Authentication Routes

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
    Route::get('/dashboard', function () {
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
  Route::get('/dashboard/doctor', [DoctorDashboardController::class, 'index'])->name('doctor.dashboard');
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
