<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;

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

        return redirect()->back()->with('success', 'Prescription saved successfully!');
    }
}
