<!-- filepath: resources/views/disease_statistics/index.blade.php -->
@extends('layouts/layoutMaster')

@section('content')
<div class="container">
    <h1>Disease Statistics</h1>

    <!-- Display Dataset -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                @foreach ($columns as $column)
                    <th>{{ ucfirst(str_replace('_', ' ', $column)) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td>{{ $row->ds }}</td>
                    @foreach ($columns as $column)
                        <td>{{ $row->$column }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Add New Disease -->
    <form action="{{ route('disease-statistics.add-disease') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="disease_name" class="form-label">New Disease Name</label>
            <input type="text" name="disease_name" id="disease_name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Disease</button>
    </form>

    <!-- Add New Data -->
    <form action="{{ route('disease-statistics.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-3">
            <label for="ds" class="form-label">Date</label>
            <input type="date" name="ds" id="ds" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="data" class="form-label">Data (JSON format)</label>
            <textarea name="data" id="data" class="form-control" rows="3" placeholder='{"heart_failure": 10, "stemi": 5}' required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Add Data</button>
    </form>
</div>
@endsection
