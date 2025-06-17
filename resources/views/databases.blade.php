@extends('layouts.layoutMaster')

@section('title', 'Databases Overview')

@section('content')
<div class="container-fluid p-4">
    <h1>Databases Overview</h1>
    <p>Select a database from the dropdown below:</p>

    <!-- Dropdown for databases -->
    <div class="form-group">
        <label for="databaseDropdown">Choose a Database:</label>
        <select id="databaseDropdown" class="form-control" onchange="fetchDatabaseData(this.value)">
            @foreach ($databases as $database)
                <option value="{{ $database['name'] ?? $database }}">{{ $database['name'] ?? $database }}</option>
            @endforeach
        </select>
    </div>

    <!-- Query Results Section -->
    <div id="queryResults" class="mt-4">
        <h3>Query Results</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        @if (!empty($data) && isset($data[0]))
                            @foreach ($data[0] as $column => $value)
                                <th>{{ $column }}</th>
                            @endforeach
                        @else
                            <th>No Data Available</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            @foreach ($row as $value)
                                <td>{{ $value }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function fetchDatabaseData(databaseName) {
        fetch(`/databases/query?database=${databaseName}`)
            .then(response => response.json())
            .then(data => {
                const resultsBody = document.getElementById('queryResultsBody');
                resultsBody.innerHTML = '';
                data.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${row.Code}</td>
                        <td>${row.Name}</td>
                        <td>${row.Compny_Code}</td>
                        <td>${row.AccountName}</td>
                    `;
                    resultsBody.appendChild(tr);
                });
            })
            .catch(error => console.error('Error fetching query results:', error));
    }
</script>
@endsection
