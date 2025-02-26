<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Show the appointment booking page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Example specialties to be displayed on the page
        $specialties = [
            'Cardiology',
            'Dermatology',
            'Neurology',
            // Add more specialties as needed
        ];

        return view('content.pages.Appointment', compact('specialties'));
    }

    /**
     * Store the appointment details in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming appointment data
        $validated = $request->validate([
            'doctor_id' => 'required|integer|exists:doctors,id',
            'patient_name' => 'required|string|max:255',
            'patient_email' => 'required|email|max:255',
            'patient_phone' => 'nullable|string|max:20',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Create the appointment
        $appointment = Appointment::create([
            'doctor_id' => $validated['doctor_id'],
            'patient_name' => $validated['patient_name'],
            'patient_email' => $validated['patient_email'],
            'patient_phone' => $validated['patient_phone'],
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => 'pending',
        ]);

        // Return a success response with the appointment data
        return response()->json([
            'message' => 'Appointment booked successfully!',
            'appointment' => $appointment,
        ]);
    }

    /**
     * Get doctors based on the specialty.
     *
     * @param  string  $specialty
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDoctorsBySpecialty($specialty)
    {
        // Fetch doctors by specialization
        $doctors = Doctor::where('specialization', $specialty)
                         ->get(['id', 'name', 'specialization', 'email', 'phone']);

        return response()->json($doctors);
    }

    /**
     * Get available time slots for the selected doctor.
     *
     * @param  int  $doctorId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTimeSlots($doctorId)
    {
        // Fetch the doctor
        $doctor = Doctor::findOrFail($doctorId);

        // Fetch available time slots (example logic)
        $timeSlots = [
            ['id' => 1, 'date' => '2023-10-25', 'start_time' => '09:00', 'end_time' => '10:00'],
            ['id' => 2, 'date' => '2023-10-25', 'start_time' => '10:00', 'end_time' => '11:00'],
            ['id' => 3, 'date' => '2023-10-26', 'start_time' => '14:00', 'end_time' => '15:00'],
        ];

        return response()->json($timeSlots);
    }

    /**
     * Show the patient's home page with their appointments.
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        // Fetch the authenticated patient's email
        $patientEmail = Auth::user()->email;

        // Fetch the patient's appointments with the associated doctor
        $appointments = Appointment::where('patient_email', $patientEmail)
                                   ->with('doctor') // Eager load the doctor relationship
                                   ->orderBy('appointment_date', 'desc')
                                   ->get();

        // Pass the appointments to the view
        return view('content.pages.pages-home', compact('appointments'));
    }
}
