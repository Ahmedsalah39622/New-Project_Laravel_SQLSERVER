<?php
namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment; // Ensure you import the Appointment model


class AdminPermissionsController extends Controller
{
    public function index()
    {
        return view('admin.app-access-permission');
    }
}
