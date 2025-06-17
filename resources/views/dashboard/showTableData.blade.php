<!DOCTYPE html>
<html>
<head>
    <title>SQL Server Dashboard - Table Data</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h1>Data from Table: {{ $table }}</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    @if (!empty($data))
                        @foreach (array_keys((array)$data[0]) as $column)
                            <th>{{ $column }}</th>
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
    @endsection

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
