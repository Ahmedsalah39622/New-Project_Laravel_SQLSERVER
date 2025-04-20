<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\DiseaseStatistic;

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
}
