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

    public function storeCompletedPrescription(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'group-a.*.drugs' => 'required|string',
            'group-a.*.dosage' => 'required|string',
            'notes' => 'required|string',
        ]);

        foreach ($request->input('group-a') as $item) {
            Prescription::create([
                'appointment_id' => $request->appointment_id,
                'drugs' => $item['drugs'],
                'dosage' => $item['dosage'],
                'notes' => $request->notes,
            ]);
        }

        return redirect()->back()->with('success', 'Prescription saved successfully.');
    }

    public function filterAppointmentsByDoctor(Request $request)
    {
        try {
            $userId = Auth::id(); // Get the authenticated user's ID

            // Fetch the doctor's appointments where user_id matches the user's ID
            $appointments = Appointment::whereHas('doctor', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->get();

            // Count the filtered appointmentsw
            $filteredAppointmentsCount = $appointments->count();

            return view('doctor.dashboard', compact('appointments', 'filteredAppointmentsCount'));
        } catch (\Exception $e) {
            Log::error('Error in filterAppointmentsByDoctor method: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getTotalPatients(): JsonResponse
    {
        try {
            // Fetch the total number of patients
            $totalPatients = Patient::count();

            return response()->json(['totalPatients' => $totalPatients], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch total patients'], 500);
        }
    }
}

