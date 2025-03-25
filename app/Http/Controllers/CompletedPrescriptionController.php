<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompletedPrescription;
use Illuminate\Support\Facades\Log;

class CompletedPrescriptionController extends Controller
{
    public function store(Request $request)
    {
            $validatedData = $request->validate([
                'appointment_id' => 'required|integer',
                'drugs' => 'required|array',
                'dosage' => 'required|array',
                'notes' => 'required|string',
            ]);

        Log::info('Validated Data:', $validatedData);

        $completedPrescription = new CompletedPrescription();
        $completedPrescription->appointment_id = $validatedData['appointment_id'];
        $completedPrescription->drugs = json_encode($validatedData['drugs']);
        $completedPrescription->dosage = json_encode($validatedData['dosage']);
        $completedPrescription->notes = $validatedData['notes'];
        $completedPrescription->save();

        Log::info('Completed Prescription Saved:', $completedPrescription);

        return redirect()->back()->with('success', 'Prescription completed successfully.');
    }
}
