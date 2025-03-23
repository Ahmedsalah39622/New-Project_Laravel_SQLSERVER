<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        $doctor_id = Auth::id();

        $todayAppointments = Appointment::where('doctor_id', $doctor_id)
            ->whereDate('appointment_date', Carbon::today())
            ->count();

        $totalAppointments = Appointment::where('doctor_id', $doctor_id)->count();

        $pendingAppointments = Appointment::where('doctor_id', $doctor_id)
            ->where('status', 'pending')
            ->count();

        $appointments = Appointment::where('doctor_id', $doctor_id)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'asc')
            ->get();


    }

    public function getDashboardData()
    {
        try {
            $doctor_id = Auth::id();
            $today = Carbon::today();

            $todayAppointments = Appointment::where('doctor_id', $doctor_id)
                ->whereDate('appointment_date', $today)
                ->count();

            $totalAppointments = Appointment::where('doctor_id', $doctor_id)->count();

            $pendingAppointments = Appointment::where('doctor_id', $doctor_id)
                ->where('status', 'pending')
                ->count();

            $completedAppointments = Appointment::where('doctor_id', $doctor_id)
                ->where('status', 'completed')
                ->count();

            $cancelledAppointments = Appointment::where('doctor_id', $doctor_id)
                ->where('status', 'cancelled')
                ->count();

            $confirmedAppointments = Appointment::where('doctor_id', $doctor_id)
                ->where('status', 'confirmed')
                ->orderBy('appointment_date', 'asc')
                ->orderBy('start_time', 'asc')
                ->get(['patient_name', 'appointment_date', 'start_time', 'end_time']);

            Log::info('Dashboard data fetched successfully', [
                'todayAppointments' => $todayAppointments,
                'totalAppointments' => $totalAppointments,
                'pendingAppointments' => $pendingAppointments,
                'completedAppointments' => $completedAppointments,
                'cancelledAppointments' => $cancelledAppointments,
                'confirmedAppointments' => $confirmedAppointments
            ]);

            return response()->json([
                'todayAppointments' => $todayAppointments,
                'totalAppointments' => $totalAppointments,
                'pendingAppointments' => $pendingAppointments,
                'completedAppointments' => $completedAppointments,
                'cancelledAppointments' => $cancelledAppointments,
                'confirmedAppointments' => $confirmedAppointments
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching dashboard data: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
