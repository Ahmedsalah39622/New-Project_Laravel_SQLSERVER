use App\Models\DiseaseStatistic;

public function create()
{
    // Fetch all diseases from the database
    $diseases = DiseaseStatistic::all();

    // Pass the diseases to the view
    return view('doctor.addprescription', compact('diseases'));
}
