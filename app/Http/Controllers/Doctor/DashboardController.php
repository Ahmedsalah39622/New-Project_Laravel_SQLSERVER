<?php

namespace App\Http\Controllers\Doctor;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Patient;
use App\Models\Appointment;
use Carbon\Carbon;
use Exception;
use App\Models\Prescription;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $doctorId = Auth::id(); // Get the authenticated doctor's ID
            Log::info('Doctor ID: ' . $doctorId);

            $today = now()->toDateString();

            // Calculate counts for the cards
            $todayAppointments = Appointment::where('doctor_id', $doctorId)
                ->whereDate('appointment_date', $today)
                ->count();

            $totalAppointments = Appointment::where('doctor_id', $doctorId)->count();

            $pendingAppointments = Appointment::where('doctor_id', $doctorId)
                ->where('status', 'pending')
                ->count();

            $confirmedAppointments = Appointment::where('doctor_id', $doctorId)
                ->where('status', 'confirmed')
                ->count();

            // Pass the counts to the view
            return view("doctor.dashboard", [
                'todayAppointments' => $todayAppointments,
                'totalAppointments' => $totalAppointments,
                'pendingAppointments' => $pendingAppointments,
                'confirmedAppointments' => $confirmedAppointments,
            ]);
        } catch (Exception $e) {
            Log::error('Error in index method: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
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

            $confirmedAppointments = Appointment::where('status', 'confirmed')
                ->select('patient_name', 'appointment_date', 'start_time', 'end_time')
                ->orderByDesc('appointment_date')
                ->orderBy('start_time')
                ->get();

            return view("doctor.dashboard", [
                'todayAppointments' => $todayAppointments,
                'totalAppointments' => $totalAppointments,
                'pendingAppointments' => $pendingAppointments,
                'completedAppointments' => $completedAppointments,
                'cancelledAppointments' => $cancelledAppointments,
                'confirmedAppointments' => $confirmedAppointments,
            ]);
        } catch (Exception $e) {
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
        } catch (Exception $e) {
            Log::error('Error in getPatientData method: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getDoctorSchedule(Request $request)
    {
        try {
            $doctorId = Auth::id();
            $today = today();

            $todaysAppointments = Appointment::where('doctor_id', $doctorId)
                ->whereDate('appointment_date', $today)
                ->count();

            $nextAppointment = Appointment::where('doctor_id', $doctorId)
                ->whereDate('appointment_date', '>=', $today)
                ->orderBy('appointment_date')
                ->orderBy('start_time')
                ->first();

            $nextAppointmentText = $nextAppointment
                ? $nextAppointment->appointment_date . ' ' . $nextAppointment->start_time
                : 'No upcoming appointments';

            return response()->json([
                'todaysAppointments' => $todaysAppointments,
                'nextAppointment' => $nextAppointmentText,
            ]);
        } catch (Exception $e) {
            Log::error('Error in getDoctorSchedule method: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }   public function dashboard()
    {
        $doctor = Auth::user()->doctor;
        $doctorName = $doctor ? $doctor->name : 'Doctor';

        return view('doctor.dashboard', compact('doctorName'));
    }

    private function countAppointmentsByStatus($doctorId, $status)
    {
        return DB::table('appointments')
            ->where('doctor_id', $doctorId)
            ->where('status', $status)
        ->count();
    }
    public function storeCompletedPrescription(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'group-a.*.drugs' => 'required|string',
            'group-a.*.dosage' => 'required|string',
            'notes' => 'required|string',
        ]);

        Log::info('Form data:', $request->all());

        foreach ($request->input('group-a') as $item) {
            Log::info('Creating prescription:', [
                'appointment_id' => $request->appointment_id,
                'drugs' => $item['drugs'],
                'dosage' => $item['dosage'],
                'notes' => $request->notes,
            ]);

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

            // Count the filtered appointments
            $filteredAppointmentsCount = $appointments->count();

            return view('doctor.dashboard', compact('appointments', 'filteredAppointmentsCount'));
        } catch (Exception $e) {
            Log::error('Error in filterAppointmentsByDoctor method: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

