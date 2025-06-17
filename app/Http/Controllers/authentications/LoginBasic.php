<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class LoginBasic extends Controller
{
    // Show the login form
    public function index()
    {
        return view('content.authentications.auth-login-basic'); // The login view (adjust based on your layout)
    }

    // Handle the login submission
    public function login(Request $request)
    {
        // Validate the incoming login data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if the user's email is verified
            if (!$user->confirmed) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your registration request has been sent to the admin. Please wait for confirmation.']);
            }

            // Check user role and redirect accordingly
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('doctor')) {
                return redirect()->route('doctor.dashboard');
            } elseif ($user->hasRole('patient')) {
                return redirect()->route('patient.dashboard');
            } else {
                return redirect()->route('main.page');
            }
        }

        // Return back with error if login fails
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
}
