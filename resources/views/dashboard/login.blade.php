<!DOCTYPE html>
<html>
<head>
    <title>SQL Server Dashboard - Login</title>
    <!-- Add your CSS links here, e.g., Bootstrap CSS -->
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h1>Login</h1>
        <form method="POST" action="{{ route('dashboard.authenticate') }}">
            @csrf
            <div class="form-group">
                <label for="server">Server Name:</label>
                <input type="text" id="server" name="server" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    @endsection

    <!-- Add your JavaScript links here, e.g., Bootstrap JS -->
</body>
</html>
