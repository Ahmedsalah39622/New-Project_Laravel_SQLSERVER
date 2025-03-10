<?php

namespace App\Http\Controllers\pages;

use Illuminate\Http\Request;
use App\Models\Patient; // تأكد من استيراد موديل Patient
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
  public function index()
    {
        return view('content.pages.pages-home');
    }
  public function store(Request $request)
  {
      // Validate the input data
      $request->validate([
          'name' => 'required|string|max:255',
          'email' => 'required|email|unique:patients,email',
          'age' => 'required|integer|min:0',
          'birthdate' => 'nullable|date',
          'gender' => 'required|in:male,female,other',
          'blood_type' => 'nullable|string',
          'phone' => 'nullable|string',
          'insurance_provider' => 'nullable|string',
          'password' => 'required|string|min:8|confirmed',
      ]);

      // Create a new patient and save to the database
      $patient = new Patient();
      $patient->name = $request->name;
      $patient->email = $request->email;
      $patient->age = $request->age;
      $patient->birthdate = $request->birthdate;
      $patient->gender = $request->gender;
      $patient->blood_type = $request->blood_type;
      $patient->phone = $request->phone;
      $patient->insurance_provider = $request->insurance_provider;
      $patient->password = bcrypt($request->password); // Hash the password
      $patient->save();

      // Redirect with a success message
      return redirect()->back()->with('success', 'Patient registered successfully!');

  }

}
