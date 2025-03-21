<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
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

        return view('doctor.dashboard', compact(
            'appointments',
            'todayAppointments',
            'totalAppointments',
            'pendingAppointments'
        ));
    }
}
