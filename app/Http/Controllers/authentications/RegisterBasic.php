<?php
namespace App\Http\Controllers\Authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Correct import for DB
use App\Models\User; // Ensure you import the User model
use App\Models\Patient; // Import the Patient model

class RegisterBasic extends Controller
{
    public function index()
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('content.authentications.auth-register-basic', ['pageConfigs' => $pageConfigs]);
    }

    // Handle registration form submission
    public function register(Request $request)
    {
        // Validate the request data
        $validator = $this->validator($request->all());

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        // Create the user
        $user = $this->create($request->all());

        // Check if patient exists for the user and update or insert accordingly
        $patient = Patient::where('ID', $user->id)->first(); // Find existing patient by user ID

        if ($patient) {
            // If patient exists, update their information
            $patient->update([
                'Name' => $request->input('name'),
                'Age' => $request->input('age'),
                'Gender' => $request->input('gender'),
                'Blood_Type' => $request->input('blood_type'),
                'insurance_provider' => $request->input('insurance_provider'), // If provided
            ]);
        } else {
            // If no patient record exists, create a new patient record
            Patient::create([
                'ID' => $user->id,
                'Name' => $request->input('name'),
                'Age' => $request->input('age'),
                'Gender' => $request->input('gender'),
                'Blood_Type' => $request->input('blood_type'),
                'insurance_provider' => $request->input('insurance_provider'), // If provided
            ]);
        }

        // Optionally, log the user in after registration
        auth()->guard('web')->login($user);

        // Redirect to a specific route after successful registration
        return redirect()->route('/home')->with('success', 'Registration successful!');
    }

    // Validation rules
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'age' => ['required', 'integer', 'min:1'],
            'gender' => ['required', 'string', 'in:male,female,other'],
            'blood_type' => ['required', 'string', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'insurance_provider' => ['nullable', 'string', 'max:255'],
        ]);
    }

    // Create a new user
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'age' => $data['age'],
            'gender' => $data['gender'],
            'blood_type' => $data['blood_type'],
            'insurance' => $data['insurance_provider'], // Updated from 'insurance' to 'insurance_provider'
        ]);
    }
}
