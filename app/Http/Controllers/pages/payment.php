<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;

class payment extends Controller
{
  public function index()
  {
    return view('content.pages.payment-page');
  }
  public function processPayment(Request $request)
{
    $appointment = Appointment::findOrFail($request->appointment_id);

    if (!$appointment) {
        return response()->json(['error' => 'Appointment not found'], 404);
    }

    // Update both status and paid_status
    $appointment->update([
        'status' => 'confirmed',
        'paid_status' => 'paid'
    ]);

    return response()->json(['success' => 'Payment successful', 'status' => $appointment->status]);
}

public function showPaymentPage($appointment_id)
{
    $appointment = Appointment::find($appointment_id);

    if (!$appointment) {
        return redirect()->back()->with('error', 'Appointment not found.');
    }

    return view('content.pages.payment-page', compact('appointment'));
}

}
