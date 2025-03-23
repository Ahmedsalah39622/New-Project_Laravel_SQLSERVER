<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Doctor\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorDashboardController;

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

