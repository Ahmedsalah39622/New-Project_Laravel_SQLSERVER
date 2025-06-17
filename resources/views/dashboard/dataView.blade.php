@extends('layouts.app')

@section('content')
<div class="container">
    @if(!isset($databaseName) || empty($databaseName))
        <h2>Select Database</h2>
        <form method="POST" action="/select-database">
            @csrf
            <select name="database" class="form-control">
                @if(isset($databases) && count($databases) > 0)
                    @foreach ($databases as $db)
                        <option value="{{ $db['name'] }}" {{ $db['name'] === $databaseName ? 'selected' : '' }}>{{ $db['name'] }}</option>
                    @endforeach
                @endif
            </select>
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    @endif
</div>

@if(request()->path() !== 'databases')
<div class="container mt-4">
    <h4>Active Database: {{ $databaseName ?? 'None' }}</h4>
</div>

<div class="container">
    <h1>Fetched Data</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                @if (!empty($data) && count($data) > 0)
                    @foreach (array_keys((array)$data[0]) as $key)
                        <th>{{ $key }}</th>
                    @endforeach
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ((array)$row as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@if(request()->path() !== 'databases')
<div class="container mt-4">
    <a href="/databases" class="btn btn-secondary">Back to Databases</a>
</div>
@endif
@endsection
