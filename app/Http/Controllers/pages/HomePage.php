<?php
namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment; // Ensure you import the Appointment model

class HomePage extends Controller
{
  public function index()
  {
    if (!Auth::check()) {
      return redirect()->route('login')->with('error', 'Please log in first.');
    }

    $user = Auth::user();

    $appointments = Appointment::where('patient_id', $user->id)

        ->orderBy('date', 'desc') // Sort by latest first
        ->get();
        if ( $user->hasRole('admin'))
        {
          return view('admin.dashboard');

        }

         if ( $user->hasRole('doctor'))
        {
          return view('doctor.dashboard');

        }


    return view('content.pages.pages-home', compact('appointments'));
  }
}
