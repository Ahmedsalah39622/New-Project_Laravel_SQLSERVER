<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Appointmenttime extends Controller
{
  public function index(Request $request)
  {
      $clinic = $request->query('clinic'); // استقبال clinic من الـ Query String

      if (!$clinic) {
          return redirect()->route('PatientDashboard')->with('error', 'Clinic not specified!');
      }

      return view('Appointmenttime', compact('clinic'));
  }
}
