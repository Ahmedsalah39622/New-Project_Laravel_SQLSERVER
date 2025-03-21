<?php

namespace App\Http\Controllers;
use App\Models\ConfirmedAppointment;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;

class ReceptionistController extends Controller
{
    public function index()
    {
        $appointments = Appointment::latest()->paginate(10);
        $patients = Patient::latest()->paginate(10);

        return view('receptionist.dashboard', compact('appointments', 'patients'));
    }
    public function confirmAppointment(Appointment $appointment)
{
    // First update the original appointment status
    $appointment->update(['status' => 'confirmed']);

    // Create record in confirmed_appointments table
    ConfirmedAppointment::create([
        'appointment_id' => $appointment->id,
        'doctor_id' => $appointment->doctor_id,
        'patient_name' => $appointment->patient_name,
        'patient_email' => $appointment->patient_email,
        'appointment_date' => $appointment->appointment_date,
        'start_time' => $appointment->start_time,
        'confirmed_at' => Carbon::now(),
    ]);

    return response()->json([
        'message' => 'Appointment confirmed successfully',
        'status' => 'success'
    ]);
}
}
