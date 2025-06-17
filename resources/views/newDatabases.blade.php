@extends('layouts.layoutMaster')

@section('title', 'New Databases Overview')

@section('content')
<div class="container-fluid p-4">
    <h1>New Databases Overview</h1>
    <p>Select a database from the dropdown below:</p>

    <!-- Dropdown for databases -->
    <div class="form-group">
        <label for="databaseDropdown">Choose a Database:</label>
        <select id="databaseDropdown" class="form-control" onchange="fetchDatabaseData(this.value)">
            @foreach ($databases as $database)
                <option value="{{ $database }}">{{ $database }}</option>
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
                        <th>Code</th>
                        <th>Name</th>
                        <th>Company Code</th>
                        <th>Account Name</th>
                    </tr>
                </thead>
                <tbody id="queryResultsBody">
                    <!-- Results will be populated dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function fetchDatabaseData(databaseName) {
        fetch(`/new-databases/query?database=${databaseName}`)
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
