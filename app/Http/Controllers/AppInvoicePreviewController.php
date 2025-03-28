<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Appointment;
use App\Models\Doctor;

class AppInvoicePreviewController extends Controller
{
    public function index($appointmentId = null)
    {
        // Fetch the appointment details
        $appointment = Appointment::find($appointmentId);

        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found.');
        }

        // Fetch prescriptions for the given appointment ID
        $prescriptions = Prescription::where('appointment_id', $appointmentId)->get();

        // Fetch the doctor details
        $doctor = $appointment->doctor;

        return view('doctor.app-invoice-preview', compact('prescriptions', 'appointment', 'doctor'));
    }
}
