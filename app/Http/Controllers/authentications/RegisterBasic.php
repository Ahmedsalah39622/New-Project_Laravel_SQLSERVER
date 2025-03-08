<?php
namespace App\Http\Controllers\authentications;

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
    // Validate the request
    $validator = $this->validator($request->all());

    if ($validator->fails()) {
        return redirect()->back()
                         ->withErrors($validator)
                         ->withInput();
    }

    // Create the user first
    $user = $this->create($request->all());

    // Insert patient data using Eloquent
    Patient::create([
        'user_id' => $user->id,  // Associate patient with the user ID
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'age' => $request->input('age'),
        'gender' => $request->input('gender'),
        'blood_type' => $request->input('blood_type'),
        'insurance_provider' => $request->input('insurance_provider'), // Optional
    ]);

    // Log the user in
    auth()->guard('web')->login($user);

    return redirect()->route('home')->with('success', 'Registration successful!');
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
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'age' => $data['age'],
            'gender' => $data['gender'],
            'blood_type' => $data['blood_type'],
            'insurance' => $data['insurance_provider'],
        ]);

        // Assign role after user creation
        if (!empty($data['role'])) {
          $user->assignRole($data['role']);
      }
        return $user;

    }
}
