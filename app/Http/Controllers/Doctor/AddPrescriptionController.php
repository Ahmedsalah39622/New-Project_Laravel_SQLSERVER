<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\CompletedPrescription; // Import the CompletedPrescription model

class AddPrescriptionController extends Controller
{
    public function index($appointmentId = null)
    {
        // Fetch appointment details if appointmentId is provided
        $appointment = null;
        if ($appointmentId) {
            $appointment = Appointment::find($appointmentId);
        }

        // Get the logged-in doctor's details
        $doctor = Auth::user();

        return view('doctor.addprescription', compact('appointment', 'doctor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'drugs' => 'required|array',
            'dosage' => 'required|array',
        ]);

        $prescription = new CompletedPrescription();
        $prescription->patient_id = Appointment::find($request->appointment_id)->patient_id;
        $prescription->doctor_id = Auth::id();
        $prescription->date_issued = now(); // Set date issued to current date
        $prescription->due_date = now()->addDays(7); // Set due date to 7 days after date issued
        $prescription->drugs = json_encode($request->drugs);
        $prescription->dosage = json_encode($request->dosage);
        $prescription->save();

        return redirect()->route('doctor.addprescription', ['appointmentId' => $request->appointment_id])->with('success', 'Prescription saved successfully.');
    }
}
