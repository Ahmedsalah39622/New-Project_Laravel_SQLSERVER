<!DOCTYPE html>
<html>
<head>
    <title>SQL Server Dashboard - View Table</title>
    @extends('layouts.app')
</head>
<body>
    @section('content')
    <div class="container">
        <h1>View Tables in {{ $database }}</h1>
        <form method="GET" action="{{ route('dashboard.showTableData') }}">
            <input type="hidden" name="database" value="{{ $database }}">
            <div class="form-group">
                <label for="table">Table:</label>
                <select id="table" name="table" class="form-control" required>
                    @foreach ($tables as $table)
                        <option value="{{ $table->TABLE_NAME }}">{{ $table->TABLE_NAME }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">View Data</button>
        </form>
    </div>
    @endsection
</body>
</html>
