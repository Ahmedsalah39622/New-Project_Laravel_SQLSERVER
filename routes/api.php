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
use Illuminate\Support\Facades\Http;

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

Route::post('/api/ai-advice', function (Request $request) {
    $predictions = $request->input('predictions');

    // Example payload for the AI API
    $payload = [
        'model' => 'text-davinci-003', // Specify the model
        'prompt' => 'Based on the following disease predictions, provide advice for logistics, number of doctors, and clinics: ' . json_encode($predictions),
        'max_tokens' => 500,
        'temperature' => 0.7,
    ];

    // Replace with the actual AI API URL
    $aiApiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyB5mzFXtFQM_gm48cahNYXgOvBn7P7dZ8A';

    try {
        $response = Http::withHeaders([
            'Authorization' => 'AIzaSyB5mzFXtFQM_gm48cahNYXgOvBn7P7dZ8A',
        ])->post($aiApiUrl, $payload);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'advice' => $response->json(),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch advice from AI API.',
            ]);
        }
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ]);
    }
});
