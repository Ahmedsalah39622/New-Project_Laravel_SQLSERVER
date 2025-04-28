<?php
namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment; // Ensure you import the Appointment model
use Carbon\Carbon; // Import Carbon for date handling

class HomePage extends Controller
{
  public function index()
  {
    if (!Auth::check()) {
      return redirect()->route('login')->with('error', 'Please log in first.');
    }

    $user = Auth::user();
    $appointments = Appointment::query()
    ->orderBy('appointment_date')
    ->get();

    $nextAppointment = Appointment::where('appointment_date', '>=', now())
    ->where('status', '!=', 'cancelled')
    ->with('doctor')  // Eager load doctor relationship
    ->orderBy('appointment_date')
    ->orderBy('start_time')
    ->first();

$totalAppointments = Appointment::count();
    // Ensure $appointmentId is defined and assigned a value before using it
    $appointments = Appointment::where('patient_id', $user->id)

        ->orderBy('date', 'desc') // Sort by latest first
        ->get();
    // Check if the user has a specific role
        if ( $user->hasRole('admin'))
        {
          return view('admin.dashboard');

        }
    // Check if the user has a specific role

         if ( $user->hasRole('doctor'))
        {
          return view('doctor.dashboard');

        }
    // Check if the user has a specific role

        if ( $user->hasRole('receptionist'))
        {
          return view('receptionist.dashboard');

        }
            // Get upcoming appointments (next 2 appointments)



        // Pass the data to the view
    return view('content.pages.pages-home', compact('appointments', 'nextAppointment', 'totalAppointments'));
  }
}
