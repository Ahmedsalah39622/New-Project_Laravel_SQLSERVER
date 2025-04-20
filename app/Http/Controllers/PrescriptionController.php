<?php
namespace App\Http\Controllers;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\DiseaseStatistic;

class PrescriptionController extends Controller
{
    public function store(Request $request)
    {
        // Log the request data
        Log::info($request->all());

        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'group-a' => 'required|array',
            'group-a.*.drugs' => 'required|string|max:65535',
            'group-a.*.dosage' => 'required|string|max:65535',
        ]);

        $appointmentId = $request->input('appointment_id');

        foreach ($request->input('group-a') as $item) {
          $drug = trim($item['drugs']);
          $dosage = trim($item['dosage']);

          $exists = Prescription::where('appointment_id', $appointmentId)
                      ->where('drugs', $drug)
                      ->where('dosage', $dosage)
                      ->exists();

          if (!$exists) {
              Prescription::create([
                  'appointment_id' => $appointmentId,
                  'drugs' => $drug,
                  'dosage' => $dosage,
                  'notes' => $request->input('notes'),
              ]);
          }
      }

        // Retrieve the appointment and related patient
        $appointment = Appointment::find($appointmentId);
        $patient = Patient::find($appointment->patient_id); // Correctly retrieve the patient by ID
        $doctor = $appointment->doctor;
        $prescriptions = Prescription::where('appointment_id', $appointmentId)->get();

        // Redirect to /doctor/app-invoice-preview after completing the prescription
        if ($request->has('complete')) {
            return redirect()->to('/doctor/app-invoice-preview?appointment_id=' . $appointmentId)
                ->with('success', 'Prescription completed successfully!');
        }

        return view('doctor.app-invoice-preview', compact('prescriptions', 'appointment', 'doctor', 'patient'));
    }

    public function showInvoicePreview($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $doctor = $appointment->doctor;
        $prescriptions = Prescription::where('appointment_id', $appointmentId)->get();

        // Assuming the receptionist is related to the appointment or fetched separately

        return view('doctor.app-invoice-preview', compact('appointment', 'doctor', 'prescriptions', 'receptionist'));
    }

    public function getTreatmentPlan($appointmentId)
    {
        // Fetch prescriptions for the given appointment ID
        $prescriptions = Prescription::where('appointment_id', $appointmentId)->get();

        if ($prescriptions->isEmpty()) {
            return response()->json(['error' => 'No treatment plan found for this appointment.'], 404);
        }

        // Format the treatment plan data
        $treatmentPlan = $prescriptions->map(function ($prescription) {
            return [
                'drug' => $prescription->drugs,
                'dosage' => $prescription->dosage,
                'notes' => $prescription->notes,
            ];
        });

        return response()->json(['treatment_plan' => $treatmentPlan]);
    }

    public function destroy($id)
    {
        $prescription = Prescription::findOrFail($id);
        $prescription->delete();

        return redirect()->back()->with('success', 'Prescription deleted successfully!');
    }

    public function storeDiseases(Request $request)
    {
        $request->validate([
            'diseases' => 'required|array',
            'diseases.*' => 'string',
            'ds' => 'required|date',
        ]);

        // Validate diseases against the table columns
        $validDiseases = Schema::getColumnListing('disease_statistics');
        $data = ['ds' => $request->input('ds')];

        foreach ($request->input('diseases') as $disease) {
            $diseaseColumn = strtolower(str_replace(' ', '_', $disease));
            if (in_array($diseaseColumn, $validDiseases)) {
                // Increment the count for the disease
                $existingRecord = DiseaseStatistic::where('ds', $data['ds'])->first();

                if ($existingRecord) {
                    $existingRecord->increment($diseaseColumn);
                } else {
                    $data[$diseaseColumn] = 1; // Initialize the count for the disease
                }
            } else {
                return redirect()->back()->with('error', "Disease '{$disease}' is not recognized.");
            }
        }

        // Insert or update the record in the database
        DiseaseStatistic::updateOrCreate(
            ['ds' => $data['ds']], // Match by date
            $data
        );

        return redirect()->back()->with('success', 'Diseases saved and counted successfully!');
    }

    public function create()
    {
        // Fetch all column names from the disease_statistics table
        $columns = Schema::getColumnListing('disease_statistics');

        // Exclude non-disease columns like 'id', 'ds', 'created_at', 'updated_at'
        $diseases = array_filter($columns, function ($column) {
            return !in_array($column, ['id', 'ds', 'created_at', 'updated_at']);
        });

        // Pass the diseases to the view
        return view('doctor.addprescription', compact('diseases'));
    }

    public function addDisease(Request $request)
    {
        $request->validate([
            'disease_name' => 'required|string',
        ]);

        $diseaseName = strtolower(str_replace(' ', '_', $request->disease_name));

        // Check if the column already exists in the table
        if (Schema::hasColumn('disease_statistics', $diseaseName)) {
            return redirect()->back()->with('error', 'The disease already exists!');
        }

        // Add the new column to the table
        Schema::table('disease_statistics', function (Blueprint $table) use ($diseaseName) {
            $table->integer($diseaseName)->default(0);
        });

        return redirect()->back()->with('success', 'New disease added successfully!');
    }
}
