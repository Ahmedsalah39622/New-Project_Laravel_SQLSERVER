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


 use App\Http\Controllers\pages\Appointment;
 use App\Http\Controllers\ChatbotController;
use app\Http\Controllers\PatientController;
//use App\Http\Controllers\Appointmenttime;
use App\Http\Controllers\Doctorcon;

// Authentication Routes

// Main Page Route
Route::get('/', [Main::class, 'index'])->name('pages-home');

Route::get('/home', [HomePage::class, 'index'])->name('pages-home');
Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

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
Route::get('/appointment', [\App\Http\Controllers\AppointmentController::class, 'index']);
Route::post('/appointment', [\App\Http\Controllers\AppointmentController::class, 'store']);
Route::get('/doctors/{specialty}', [\App\Http\Controllers\AppointmentController::class, 'getDoctorsBySpecialty']);
Route::get('/appointment/doctors/{specialty}', [\App\Http\Controllers\AppointmentController::class, 'getDoctorsBySpecialty']);
Route::get('/appointment/doctors/{doctorId}/time-slots', [\App\Http\Controllers\AppointmentController::class, 'getTimeSlots']);
Route::post('/appointment/book', [\App\Http\Controllers\AppointmentController::class, 'store']);
Route::get('/appointment/doctors/{doctorId}/time-slots', [\App\Http\Controllers\AppointmentController::class, 'getTimeSlots']);
//chatbot
Route::get('/home', [\App\Http\Controllers\AppointmentController::class, 'home'])->middleware('auth');
//Route::post('/chatbot', [ChatbotController::class, 'getResponse']);
//STORE DATA
//Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
//Route::get('/appointmenttime', [Appointmenttime::class, 'index'])->name('appointmenttime');
// calender
Route::get('/calender', [CalendarController::class, 'index'])->name('app-calendar');
Route::post('/check-availability', [\App\Http\Controllers\AppointmentController::class, 'checkAvailability']);




