@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Connect to SQL Server</h1>
    <form method="POST" action="/dashboard/connect">
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

        <div class="form-group">
            <label for="database">Database Name:</label>
            <input type="text" id="database" name="database" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Connect</button>
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

{{--
    Route definitions should be placed in the routes/web.php file, not in Blade templates.
    Please move the following line to routes/web.php:

    Route::post('/dashboard/connect', [App\Http\Controllers\DashboardController::class, 'connect']);
