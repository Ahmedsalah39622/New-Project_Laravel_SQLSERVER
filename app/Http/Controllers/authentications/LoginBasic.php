<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Redirect to intended page or to /home after successful login
            return redirect()->intended('content.pages-home');
        }

        // Return back with error if login fails
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
}
