<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DoctorSchedule;

class AppointmentController extends Controller
{
    /**
     * Show the appointment booking page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $specialties = [
            'Cardiology',
            'Dermatology',
            'Neurology',
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
        $validated = $request->validate([
            'doctor_id' => 'required|integer|exists:doctors,id',
            'patient_name' => 'required|string|max:255',
            'patient_email' => 'required|email|max:255',
          //  'user_id' => 'required|exists:users,id',
            'patient_phone' => 'nullable|string|max:20',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
        ]);

        $appointment = Appointment::create([
            'doctor_id' => $validated['doctor_id'],
            'patient_name' => $validated['patient_name'],
            'patient_email' => $validated['patient_email'],
            'patient_phone' => $validated['patient_phone'],
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $validated['start_time'],
            'status' => 'pending',
        ]);

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
        $doctor = Doctor::findOrFail($doctorId);

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
        $patientEmail = Auth::user()->email;
        if (Auth::user()->hasRole('admin'))
        {
          return view('admin.dashboard');

        }
        else if (Auth::user()->hasRole('doctor'))
        {
          return view('doctor.dashboard');

        }
        $appointments = Appointment::where('patient_email', $patientEmail)
                                   ->with('doctor')
                                   ->orderBy('appointment_date', 'desc')
                                   ->get();



        return view('content.pages.pages-home', compact('appointments'));
    }
    public function show($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found.');
        }

        return view('appointments.show', compact('appointment'));
    }

    /**
     * Get all appointments.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAppointments()
    {
        $appointments = Appointment::select(
            'id', 'doctor_id', 'patient_name', 'appointment_date', 'start_time', 'end_time', 'status'
        )->get();

        return response()->json($appointments);
    }

    /**
     * Check doctor availability for a given date and time.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAvailability(Request $request)
    {
        $doctorId = $request->doctor;
        $date = $request->date;
        $time = $request->time;

        $scheduleExists = DoctorSchedule::where('doctor_id', $doctorId)
            ->where('date', $date)
            ->whereTime('start_time', '<=', $time)
            ->whereTime('end_time', '>=', $time)
            ->exists();

        if (!$scheduleExists) {
            return response()->json(['available' => false, 'message' => 'الطبيب غير متاح في هذا الوقت.']);
        }

        $isBooked = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date)
            ->where('start_time', $time)
            ->exists();

        return response()->json(['available' => !$isBooked]);
    }
    public function cancel($id)
{
    $appointment = Appointment::find($id);

    if (!$appointment) {
        return redirect()->back()->with('error', 'Appointment not found.');
    }

    // Mark appointment as canceled (or delete if needed)
    $appointment->status = 'canceled';
    $appointment->save();

    return redirect()->back()->with('success', 'Appointment canceled successfully.');
}
    public function confirmAppointment($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['success' => false, 'message' => 'Appointment not found'], 404);
        }

        $appointment->status = 'confirmed';
        $appointment->save();

        return response()->json(['success' => true, 'message' => 'Appointment confirmed']);
    }

    public function paymentPage($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found.');
        }

        return view('your-payment-view', compact('appointment'));
    }


  }
