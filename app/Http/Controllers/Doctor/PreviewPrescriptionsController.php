<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PreviewPrescriptionsController extends Controller
{
    public function create()
    {
        // Fetch necessary data for the form
        $doctor = auth()->user(); // Assuming the doctor is the authenticated user
        $appointment = // Fetch appointment data based on your logic

        return view('doctor.addprescription', compact('doctor', 'appointment'));
    }

    public function store(Request $request)
    {
        // Handle form submission and save prescription data
        // Validate and save the prescription data
        // ...

        return redirect()->route('doctor.previewprescription')->with('success', 'Prescription saved successfully!');
    }

    public function preview()
    {
        // Fetch necessary data for the preview
        $prescription = // Fetch the prescription data based on your logic

        return view('doctor.previewprescription', compact('prescription'));
    }
}
