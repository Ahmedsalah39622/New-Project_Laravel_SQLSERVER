<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PatientController extends Controller
{
    /**
     * Search for a patient and their appointment history
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $generalQuery = $request->input('general');
            $idQuery = $request->input('id');

            $query = Patient::query();

            // Add ID search condition if provided
            if (!empty($idQuery)) {
                $query->where('id', $idQuery);
            }

            // Add general search conditions if provided
            if (!empty($generalQuery)) {
                $query->where(function($q) use ($generalQuery) {
                    $q->where('name', 'LIKE', "%{$generalQuery}%")
                      ->orWhere('email', 'LIKE', "%{$generalQuery}%")
                      ->orWhere('phone', 'LIKE', "%{$generalQuery}%");
                });
            }

            $patient = $query->first();

            if (!$patient) {
                return response()->json([
                    'success' => false,
                    'message' => 'Patient not found. Please check your search criteria.',
                    'patient' => null,
                    'appointments' => []
                ], 404);
            }

            // Get appointments using patient's email
            $appointments = Appointment::where('patient_email', $patient->email)
                ->with('doctor')
                ->orderBy('appointment_date', 'desc')
                ->get()
                ->map(function ($appointment) {
                    return [
                        'id' => $appointment->id,
                        'doctor_name' => $appointment->doctor ? $appointment->doctor->name : 'N/A',
                        'doctor_specialization' => $appointment->doctor ? $appointment->doctor->specialization : 'N/A',
                        'appointment_date' => $appointment->appointment_date,
                        'start_time' => $appointment->start_time,
                        'status' => $appointment->status ?? 'pending',
                        'symptoms' => $appointment->symptoms ?? 'No symptoms recorded'
                    ];
                });

            return response()->json([
                'success' => true,
                'patient' => [
                    'id' => $patient->id,
                    'name' => $patient->name,
                    'email' => $patient->email,
                    'phone' => $patient->phone,
                    'created_at' => $patient->created_at
                ],
                'appointments' => $appointments,
                'count' => $appointments->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while searching for the patient',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
