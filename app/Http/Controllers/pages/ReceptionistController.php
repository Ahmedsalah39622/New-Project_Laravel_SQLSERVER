<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;

class ReceptionistController extends Controller
{
    public function index()
    {
        $appointments = Appointment::latest()->paginate(10);
        $patients = Patient::latest()->paginate(10);

        return view('receptionist.dashboard', compact('appointments', 'patients'));
    }
}
