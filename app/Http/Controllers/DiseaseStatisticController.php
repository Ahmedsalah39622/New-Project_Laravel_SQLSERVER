<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\DiseaseStatistic;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Http;

class DiseaseStatisticController extends Controller
{
    // Display the dataset
    public function index()
    {
        // Fetch all data from the table
        $data = DiseaseStatistic::all();

        // Get the column names, excluding unnecessary ones
        $columns = Schema::getColumnListing('disease_statistics');
        $columns = array_filter($columns, function ($column) {
            return !in_array($column, ['id', 'created_at', 'updated_at']);
        });

        return view('disease_statistics.index', compact('data', 'columns'));
    }

    // Add a new disease column
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

    // Add a new row to the dataset
    public function store(Request $request)
    {
        $request->validate([
            'ds' => 'required|date',
            'data' => 'required|array',
        ]);

        DiseaseStatistic::create($request->all());

        return redirect()->back()->with('success', 'Data added successfully!');
    }

    // Export data as CSV
    public function export()
    {
        // Get all column names from the disease_statistics table
        $columns = Schema::getColumnListing('disease_statistics');

        // Exclude 'id', 'created_at', and 'updated_at'
        $columns = array_diff($columns, ['id', 'created_at', 'updated_at']);

        // Fetch data from the database
        $data = DiseaseStatistic::select($columns)->get();

        // Prepare the CSV header row
        $csvData = [];
        $csvData[] = $columns; // Header row

        // Add rows of data
        foreach ($data as $row) {
            $csvData[] = $row->toArray();
        }

        // Create CSV content
        $csvContent = '';
        foreach ($csvData as $csvRow) {
            $csvContent .= implode(',', $csvRow) . "\n";
        }

        // Return CSV as a downloadable response
        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="disease_statistics.csv"',
        ]);
    }

    public function predict(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
            'months_to_predict' => 'required|integer|min:1|max:12',
        ]);

        $response = Http::attach(
            'file', file_get_contents($request->file('file')->getRealPath()), $request->file('file')->getClientOriginalName()
        )->post('http://127.0.0.1:5000/predict', [
            'months_to_predict' => $request->input('months_to_predict'),
        ]);

        if ($response->successful()) {
            $predictions = $response->json();

            // Debug the predictions data

            // Ensure predictions are sorted by disease name
            $predictions['predictions'] = collect($predictions['predictions'])->sortKeys()->toArray();

            return view('admin.predictions', compact('predictions'));
        } else {
            return redirect()->back()->with('error', 'Failed to get predictions from the AI model.');
        }
    }

}
