<!DOCTYPE html>
<html>
<head>
    <title>SQL Server Dashboard - Select Database</title>
    <!-- Add your CSS and JS links here, e.g., Bootstrap CSS/JS -->
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h1>Select a Database</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="GET" action="{{ route('dashboard.viewTable') }}">
            <div class="form-group">
                <label for="database">Database:</label>
                <select id="database" name="database" class="form-control" required>
                    @foreach ($databases as $database)
                        <option value="{{ $database->name }}">{{ $database->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Select</button>
        </form>
    </div>
    @endsection
</body>
</html>
