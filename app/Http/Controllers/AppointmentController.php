<?php

namespace App\Http\Controllers;
use App\Models\Doctor;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Show the appointment booking page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Example of the cards to be displayed on the page
        $specialties = [
            // Add your specialties array here
        ];

        return view('content.pages.Appointment', compact('specialties'));
    }

    /**
     * Store the appointment details in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming appointment data
        $validated = $request->validate([
            'specialty' => 'required|string',
            'doctor_id' => 'required|integer',
            'appointment_date' => 'required|date',
            'patient_name' => 'required|string',
            'patient_email' => 'required|email',
            // Add other validation as needed
        ]);

        // Logic to store the appointment in the database
        // Appointment::create($validated);

        // Redirect or return with success message
        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully!');
    }
    public function getDoctorsBySpecialty($specialty)
    {
        // Fetch doctors by specialization
        $doctors = Doctor::where('specialization', $specialty)
                         ->get(['id', 'name', 'specialization', 'email', 'phone']);

        return response()->json($doctors);
    }
}
