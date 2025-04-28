<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Models\Appointment;
use App\Models\CompletedPrescription; // Import the CompletedPrescription model
use App\Models\Prescription; // Import the Prescription model

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
        $appointment = Appointment::find($appointmentId);
        $doctor = $appointment->doctor;
        $prescriptions = CompletedPrescription::where('patient_id', $appointment->patient_id ?? null)->get();

        // Fetch all column names from the disease_statistics table
        $columns = Schema::getColumnListing('disease_statistics');

        // Exclude non-disease columns like 'id', 'ds', 'created_at', 'updated_at'
        $diseases = array_filter($columns, function ($column) {
            return !in_array($column, ['id', 'ds', 'created_at', 'updated_at']);
        });

        // Pass the diseases to the view
        return view('doctor.addprescription', compact('appointment', 'doctor', 'prescriptions', 'diseases'));
    }

    public function store(Request $request)
    {
        Log::info('Store method called');
        Log::info('Request data: ', $request->all());

        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'drugs' => 'required|array',
            'dosage' => 'required|array',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::find(id: $request->appointment_id);

        $prescription = new Prescription();
        $prescription->patient_id = $appointment->patient_id;
        $prescription->doctor_id = Auth::id();
        $prescription->date_issued = now(); // Set date issued to current date
        $prescription->due_date = now()->addDays(7); // Set due date to 7 days after date issued
        $prescription->drugs = json_encode($request->drugs);
        $prescription->dosage = json_encode($request->dosage);
        $prescription->notes = $request->notes; // Store notes if provided
        $prescription->save();

        Log::info('Prescription saved: ', $prescription->toArray());
        return redirect()->route('doctor.app-invoice-preview', ['appointmentId' => $request->appointment_id])->with('success', 'Prescription saved successfully.');
    }

    public function storeManual(Request $request)
    {
        Log::info('Manual Store method called');
        Log::info('Request data: ', $request->all());

        $request->validate([
            'appointment_id' => 'required|exists:appointments,id'
        ]);

        $appointment = Appointment::find($request->appointment_id);

        $prescription = new Prescription();
        $prescription->patient_id = $appointment->patient_id;
        $prescription->doctor_id = Auth::id();
        $prescription->date_issued = now();
        $prescription->due_date = now()->addDays(7);
        $prescription->drugs = 'Written Manually';
        $prescription->dosage = 'Written Manually';
        $prescription->notes = 'Written Manually';
        $prescription->save();

        Log::info('Manual Prescription saved: ', $prescription->toArray());
        return redirect()
            ->route('doctor.app-invoice-preview', ['appointmentId' => $request->appointment_id])
            ->with('success', 'Manual Prescription saved successfully.');
    }

    public function edit($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $prescriptions = Prescription::where('appointment_id', $appointmentId)->get();

        return view('doctor.manage-prescriptions', compact('appointment', 'prescriptions'));
    }

    public function destroy($prescriptionId)
    {
        $prescription = Prescription::findOrFail($prescriptionId);
        $prescription->delete();

        return redirect()->back()->with('success', 'Prescription deleted successfully.');
    }
}
