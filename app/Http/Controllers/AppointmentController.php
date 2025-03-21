<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DoctorSchedule;
use Illuminate\Http\JsonResponse;

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
            'patient_phone' => 'nullable|string|max:20',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
        ]);

        // Check if the time slot is available
        $isBooked = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where('start_time', $validated['start_time'])
            ->exists();

        if ($isBooked) {
            return response()->json([
                'message' => 'The selected time slot is already occupied.',
            ], 400);
        }

        // Create the appointment
        $appointment = Appointment::create([
            'doctor_id' => $validated['doctor_id'],
            'patient_name' => $validated['patient_name'],
            'patient_email' => $validated['patient_email'],
            'patient_phone' => $validated['patient_phone'],
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $validated['start_time'],
            'status' => 'Pending',
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
     * @param  string  $appointmentDate
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTimeSlots($doctorId, $appointmentDate)
    {
        $doctor = Doctor::findOrFail($doctorId);

        // Fetch all appointments for the doctor on the given date
        $appointments = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $appointmentDate)
            ->get(['start_time']);

        // Define available time slots
        $timeSlots = [];
        $startTime = 9; // 9 AM
        $endTime = 17; // 5 PM
        $interval = 15; // 15 minutes

        for ($hour = $startTime; $hour < $endTime; $hour++) {
            for ($minute = 0; $minute < 60; $minute += $interval) {
                $time = sprintf('%02d:%02d', $hour, $minute);
                $isOccupied = $appointments->contains('start_time', $time);
                $timeSlots[] = [
                    'time' => $time,
                    'isOccupied' => $isOccupied,
                ];
            }
        }

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
          $appointments = Appointment::where('doctor_id', Auth::user()->id)
          ->with('patient')
          ->orderBy('appointment_date', 'desc')
          ->orderBy('start_time', 'desc')
          ->get();

      return view('doctor.dashboard', compact('appointments'));

        }
        else if (Auth::user()->hasRole('receptionist'))
        {
          return view('receptionist.dashboard');

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
        $validated = $request->validate([
            'doctor_id' => 'required|integer|exists:doctors,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
        ]);

        $isBooked = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where('start_time', $validated['start_time'])
            ->exists();

        return response()->json(['available' => !$isBooked]);
    }

    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->status == 'confirmed') {
            return response()->json(['message' => 'Confirmed appointments cannot be cancelled.'], 400);
        }

        $appointment->delete();
        return response()->json(['message' => 'Appointment cancelled successfully.']);
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

    public function details($id)
    {
        $appointment = Appointment::findOrFail($id);
        return response()->json($appointment);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->status == 'confirmed') {
            return response()->json(['message' => 'Confirmed appointments cannot be updated.'], 400);
        }

        $validated = $request->validate([
            'doctor_id' => 'required|integer|exists:doctors,id',
            'patient_name' => 'required|string|max:255',
            'patient_email' => 'required|email|max:255',
            'patient_phone' => 'nullable|string|max:20',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
        ]);

        $appointment->update($validated);

        return response()->json(['message' => 'Appointment updated successfully!', 'appointment' => $appointment]);
    }

    public function destroy($id): JsonResponse
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Appointment deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete appointment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function confirm($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->status = 'confirmed';
            $appointment->save();

            return response()->json([
                'success' => true,
                'message' => 'Appointment confirmed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to confirm appointment',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
