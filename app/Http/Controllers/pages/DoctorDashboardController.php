<?php

namespace App\Http\Controllers\pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        return view('doctor.dashboard');
    }
}
