<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class CalendarController extends Controller
{
    public function index()
    {
        $Appointment = Appointment::with('doctor')->get();

        return view('content.pages.app-calendar', compact('Appointment'));
    }
}
