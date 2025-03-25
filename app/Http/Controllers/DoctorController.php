<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompletedPrescription;

class DoctorController extends Controller
{
    // ...existing code...

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'appointment_id' => 'required|integer',
            'group-a.*.drugs' => 'required|string',
            'group-a.*.dosage' => 'required|string',
            'notes' => 'required|string',
        ]);

        // Store the prescription data
        foreach ($request->input('group-a') as $item) {
            CompletedPrescription::create([
                'appointment_id' => $request->input('appointment_id'),
                'drugs' => $item['drugs'],
                'dosage' => $item['dosage'],
                'notes' => $request->input('notes'),
            ]);
        }

        // Redirect back with success message
        return redirect()->back()->with('success', 'Prescription saved successfully.');
    }

    // ...existing code...
}
