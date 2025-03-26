<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;

class PrescriptionController extends Controller
{
    public function store(Request $request)
    {
        $prescription = new Prescription();
        $prescription->appointment_id = $request->appointment_id;
        $prescription->drugs = json_encode($request->input('group-a')[0]['drugs']);
        $prescription->dosage = json_encode($request->input('group-a')[0]['dosage']);
        $prescription->notes = $request->notes;
        $prescription->save();

        // Set the prescription ID in the session
        $request->session()->put('prescription_id', $prescription->id);

        return redirect()->back()->with('success', 'Prescription saved successfully.');
    }
}
