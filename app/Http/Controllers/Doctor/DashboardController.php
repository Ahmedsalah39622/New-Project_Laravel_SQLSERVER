<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch dashboard data
        $dashboardData = $this->getDashboardData();

        // Pass the data to the view
        return view('doctor.dashboard', $dashboardData);
    }

    public function getDashboardData()
    {    $dashboardData = $this->getDashboardData();

        $today = Carbon::today();

        // Get today's appointments
        $todayAppointments = Appointment::whereDate('appointment_date', $today)->count();

        // Get total appointments
        $totalAppointments = Appointment::count();

        // Get pending appointments
        $pendingAppointments = Appointment::where('status', 'pending')->count();

        // Get completed appointments
        $completedAppointments = Appointment::where('status', 'completed')->count();

        // Get cancelled appointments
        $cancelledAppointments = Appointment::where('status', 'cancelled')->count();

        // Get confirmed appointments
        $confirmedAppointments = Appointment::where('status', 'confirmed')
            ->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'asc')
            ->get(['patient_name', 'appointment_date', 'start_time', 'end_time']);

        return [
            'todayAppointments'   => $todayAppointments,
            'totalAppointments'   => $totalAppointments,
            'pendingAppointments' => $pendingAppointments,
            'completedAppointments' => $completedAppointments,
            'cancelledAppointments' => $cancelledAppointments,
            'confirmedAppointments' => $confirmedAppointments,
        ];
    }
}
