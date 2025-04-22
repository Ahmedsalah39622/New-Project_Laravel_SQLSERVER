<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiseaseStatistic;
use Illuminate\Support\Facades\Schema;
use League\Config\SchemaBuilderInterface;
use Illuminate\Support\Facades\DB;

class DiseaseStatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statistics = DiseaseStatistic::all();
        return view('disease_statistics.index', compact('statistics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('disease_statistics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'diseases' => 'required|array',
        ]);

        // Extract the current month and year
        $currentMonth = now()->month; // Get the current month
        $currentYear = now()->year;   // Get the current year

        // Loop through the selected diseases and store them
        foreach ($request->diseases as $disease) {
            DiseaseStatistic::create([
                'disease_name' => $disease,
                'month' => $currentMonth,
                'year' => $currentYear,
            ]);
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Diseases saved successfully with the current month and year.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $statistic = DiseaseStatistic::findOrFail($id);
        return view('disease_statistics.show', compact('statistic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $statistic = DiseaseStatistic::findOrFail($id);
        return view('disease_statistics.edit', compact('statistic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'disease_name' => 'required|string|max:255',
        ]);

        $statistic = DiseaseStatistic::findOrFail($id);
        $statistic->update($request->only('disease_name'));

        return redirect()->route('disease_statistics.index')->with('success', 'Disease statistic updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $statistic = DiseaseStatistic::findOrFail($id);
        $statistic->delete();

        return redirect()->route('disease_statistics.index')->with('success', 'Disease statistic deleted successfully.');
    }

    /**
     * Add a new disease to the statistics.
     */
    public function addDisease(Request $request)
    {
        $request->validate([
            'disease_name' => 'required|string|max:255|unique:disease_statistics,disease_name',
        ]);

        $disease = DiseaseStatistic::create([
            'disease_name' => $request->disease_name,
            'month' => now()->month,
            'year' => now()->year,
        ]);

        return redirect()->back()->with('success', 'Disease added successfully.');
    }
    public function getTopDiseases()
    {
        // Get all column names from the disease_statistics table
        $columns = DB::getSchemaBuilder()->getColumnListing('disease_statistics');

        // Exclude non-disease columns
        $diseaseColumns = collect($columns)->filter(function ($column) {
            return !in_array($column, ['id', 'ds', 'created_at', 'updated_at', 'test', 'done?', 'yy']);
        });

        // Dynamically sum the cases for each disease
        $diseaseTotals = DB::table('disease_statistics')
            ->selectRaw(implode(', ', $diseaseColumns->map(fn($col) => "SUM($col) as $col")->toArray()))
            ->first();

        // Convert the totals to an array and sort them
        $diseaseTotalsArray = collect((array) $diseaseTotals)->sortDesc();

        // Get the top 3 diseases
        $topDiseases = $diseaseTotalsArray->take(3);

        // Return the data as JSON
        return response()->json([
            'top_diseases' => $topDiseases
        ]);
    }
}
