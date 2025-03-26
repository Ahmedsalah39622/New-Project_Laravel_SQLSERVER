<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompletedPrescription;
use App\Models\Prescription;
use Illuminate\Support\Facades\Log;

class DoctorController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Log the incoming request data
            Log::info('Incoming request data:', $request->all());

            // Validate the request data
            $data = $request->validate([
                'appointment_id' => 'required|exists:appointments,id',
                'drugs' => 'required|string',
                'dosage' => 'required|string',
                'frequency' => 'required|string',
                'duration' => 'required|string',
                'instructions' => 'required|string',
                'notes' => 'required|string',
            ]);

            // Log the validated data
            Log::info('Validated data:', $data);

            // Attempt to create the prescription
            $prescription = CompletedPrescription::create($data);

            // Log the created prescription
            Log::info('Prescription created:', $prescription->toArray());

            if (!$prescription) {
                throw new \Exception('Failed to create prescription record');
            }

            return redirect()->back()->with('success', 'Prescription saved successfully');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Failed to save prescription:', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            // Debugging: output the error message
            dd('Failed to save prescription: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to save prescription: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function storeCompletedPrescription(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'group-a.*.drugs' => 'required|string',
            'group-a.*.dosage' => 'required|string',
            'notes' => 'required|string',
        ]);

        Log::info('Form data:', $request->all());

        foreach ($request->input('group-a') as $item) {
            Log::info('Creating prescription:', [
                'appointment_id' => $request->appointment_id,
                'drugs' => $item['drugs'],
                'dosage' => $item['dosage'],
                'notes' => $request->notes,
            ]);

            Prescription::create([
                'appointment_id' => $request->appointment_id,
                'drugs' => $item['drugs'],
                'dosage' => $item['dosage'],
                'notes' => $request->notes,
            ]);
        }

        return redirect()->back()->with('success', 'Prescription saved successfully.');
    }
}
