<?php
namespace App\Http\Controllers;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Patient;
use App\Models\User;

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

        foreach ($request->input('group-a') as $item) {
          $drug = trim($item['drugs']);
          $dosage = trim($item['dosage']);

          $exists = Prescription::where('appointment_id', $appointmentId)
                      ->where('drugs', $drug)
                      ->where('dosage', $dosage)
                      ->exists();

          if (!$exists) {
              Prescription::create([
                  'appointment_id' => $appointmentId,
                  'drugs' => $drug,
                  'dosage' => $dosage,
                  'notes' => $request->input('notes'),
              ]);
          }
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

    public function showInvoicePreview($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $doctor = $appointment->doctor;
        $prescriptions = Prescription::where('appointment_id', $appointmentId)->get();

        // Assuming the receptionist is related to the appointment or fetched separately

        return view('doctor.app-invoice-preview', compact('appointment', 'doctor', 'prescriptions', 'receptionist'));
    }

    public function getTreatmentPlan($appointmentId)
    {
        // Fetch prescriptions for the given appointment ID
        $prescriptions = Prescription::where('appointment_id', $appointmentId)->get();

        if ($prescriptions->isEmpty()) {
            return response()->json(['error' => 'No treatment plan found for this appointment.'], 404);
        }

        // Format the treatment plan data
        $treatmentPlan = $prescriptions->map(function ($prescription) {
            return [
                'drug' => $prescription->drugs,
                'dosage' => $prescription->dosage,
                'notes' => $prescription->notes,
            ];
        });

        return response()->json(['treatment_plan' => $treatmentPlan]);
    }
}
