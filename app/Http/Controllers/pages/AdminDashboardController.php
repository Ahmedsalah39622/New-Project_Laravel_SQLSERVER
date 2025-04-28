<?php
namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment; 

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
}
