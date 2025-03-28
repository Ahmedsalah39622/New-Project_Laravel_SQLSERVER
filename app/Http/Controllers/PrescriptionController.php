<?php
namespace App\Http\Controllers;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Patient;

class PrescriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'group-a' => 'required|array',
            'group-a.*.drugs' => 'required|string|max:65535',
            'group-a.*.dosage' => 'required|string|max:65535',
        ]);

        $appointmentId = $request->input('appointment_id');

        // Loop through the drugs and dosages to save them as separate entries
        foreach ($request->input('group-a') as $item) {
            Prescription::create([
                'appointment_id' => $appointmentId,
                'drugs' => trim($item['drugs']), // Ensure no leading/trailing spaces
                'dosage' => trim($item['dosage']),
                'notes' => $request->input('notes'),
            ]);
        }

        // Retrieve the appointment and related patient
        $appointment = Appointment::find($appointmentId);
        $patient = Patient::find($appointment->patient_id); // Correctly retrieve the patient by ID
        $doctor = $appointment->doctor;
        $prescriptions = Prescription::where('appointment_id', $appointmentId)->get();

        // Redirect to /doctor/app-invoice-preview after completing the prescription
        if ($request->has('complete')) {
            return redirect()->to('/doctor/app-invoice-preview?appointment_id=' . $appointmentId)
                ->with('success', 'Prescription completed successfully!');
        }

        return view('doctor.app-invoice-preview', compact('prescriptions', 'appointment', 'doctor', 'patient'));
    }
}
