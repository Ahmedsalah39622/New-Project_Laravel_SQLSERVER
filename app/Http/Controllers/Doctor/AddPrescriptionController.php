<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;

class AddPrescriptionController extends Controller
{
    public function index($appointmentId = null)
    {
        // Fetch appointment details if appointmentId is provided
        $appointment = null;
        if ($appointmentId) {
            $appointment = Appointment::find($appointmentId);
        }

        return view('doctor.addprescription', compact('appointment'));
    }

    public function store(Request $request)
    {
        // Logic to store prescription data
    }
}
