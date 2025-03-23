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

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $doctorId = Auth::id();
            Log::info('Doctor ID: ' . $doctorId);

            $today = now()->toDateString();

            $todayAppointments = Appointment::where('doctor_id', $doctorId)
                ->whereDate('appointment_date', $today)
                ->count();

            $totalAppointments = Appointment::where('doctor_id', $doctorId)->count();

            $pendingAppointments = $this->countAppointmentsByStatus($doctorId, 'pending');
            $completedAppointments = $this->countAppointmentsByStatus($doctorId, 'completed');
            $cancelledAppointments = $this->countAppointmentsByStatus($doctorId, 'cancelled');

            $confirmedAppointments = Appointment::where('doctor_id', $doctorId)
                ->where('status', 'confirmed')
                ->select('patient_name', 'appointment_date', 'start_time', 'end_time')
                ->orderBy('appointment_date')
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
    }

    private function countAppointmentsByStatus($doctorId, $status)
    {
        return DB::table('appointments')
            ->where('doctor_id', $doctorId)
            ->where('status', $status)
        ->count();
    }
}
