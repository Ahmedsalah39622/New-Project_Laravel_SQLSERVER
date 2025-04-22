<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Doctor\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorDashboardController;
use App\Http\Controllers\DiseaseStatisticsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/test', function () {
  return response()->json(['message' => 'API is working!']);
});

Route::get('/appointments', [AppointmentController::class, 'index']);
Route::post('/chatbot', [ChatbotController::class, 'getResponse']);
//Route::get('/appointments', [AppointmentController::class, 'getAppointments']);

Route::get('/appointments', [AppointmentController::class, 'getAppointments']);

// حجز موعد جديد
Route::post('/appointments', [AppointmentController::class, 'store']);

// جلب المواعيد المتاحة لطبيب معين
Route::get('/appointments/doctors/{doctorId}/time-slots', [AppointmentController::class, 'getTimeSlots']);

// جلب الأطباء حسب التخصص
Route::get('/appointments/doctors/{specialty}', [AppointmentController::class, 'getDoctorsBySpecialty']);

// البحث عن مريض
Route::get('/patient/search', [PatientController::class, 'search']);

// جلب بيانات لوحة القيادة للطبيب
Route::middleware('auth:api')->get('/api/doctor/dashboard', [DoctorDashboardController::class, 'getDashboardData']);

Route::get('/doctor/dashboard/patient/{patientId}', [DashboardController::class, 'getPatientData']);
Route::get('/doctor/dashboard/data', [DashboardController::class, 'getDashboardData']);

Route::get('/appointments-daily-count', [AppointmentController::class, 'getDailyAppointmentsCount']);
Route::get('/total-appointments', [AppointmentController::class, 'getTotalAppointments']);
Route::get('/total-doctors', [DoctorController::class, 'getTotalDoctors']);
Route::get('/total-patients', [DashboardController::class, 'getTotalPatients']);

///
Route::get('/top-diseases', [DiseaseStatisticsController::class, 'getTopDiseases']);
Route::get('/patient-statistics', [DashboardController::class, 'getPatientStatisticsApi'])
    ->name('api.patientStatistics');
Route::get('/patient-statistics', [PatientController::class, 'getPatientStatistics']);
Route::get('/new-patients', [PatientController::class, 'getNewPatients']);


Route::get('/total-patients', [DashboardController::class, 'getTotalPatients']);
