@extends('layouts.layoutMaster')

@section('title', 'Main Dashboard')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate/animate.css') }}" />
@endsection

@section('content')
<div class="container-fluid p-4">
    <!-- Welcome Banner -->
    <div class="card medical-gradient text-white mb-4 overflow-hidden">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 id="greetingMessage" class="display-6 mb-2">Welcome to the Main Dashboard</h2>
                    <p class="mb-0 fs-5">Explore your data and insights</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="current-datetime">
                        <h3 class="mb-0" id="currentTime"></h3>
                        <p class="mb-0" id="currentDate"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Database and Table Selection -->
    <div class="card mt-4">
        <div class="card-body">
            <!-- Dropdown for databases -->
            <div class="form-group">
                <label for="databaseDropdown">Choose a Database:</label>
                <form method="POST" action="{{ route('fetchQueryFromSelectedDatabase') }}">
                    @csrf
                    <select name="database" id="databaseDropdown" class="form-control">
                        @foreach ($databases as $database)
                            <option value="{{ $database['name'] ?? $database }}">{{ $database['name'] ?? $database }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary mt-3">Run Query</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Data Table Section -->
    <div id="dataTable" class="mt-4">
        <h3>Data Overview</h3>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Company Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($data) && count($data) > 0)
                                @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $row->Code }}</td>
                                        <td>{{ $row->Name }}</td>
                                        <td>{{ $row->Compny_Code }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">No data available.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Roles Management Section -->
    <div class="roles-section mt-4">
        <h3>Roles Management</h3>
        <div class="card">
            <div class="card-body">
                <ul>
                    @if (!empty($roles))
                        @foreach ($roles as $role)
                            <li>{{ $role->name }}</li>
                        @endforeach
                    @else
                        <li>No roles available</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const now = new Date();
        document.getElementById('currentTime').innerText = now.toLocaleTimeString();
        document.getElementById('currentDate').innerText = now.toLocaleDateString();
    });

    function fetchDatabaseTables(databaseName) {
        fetch(`/dashboard/database-tables?database=${databaseName}`)
            .then(response => response.json())
            .then(data => {
                const tableDropdown = document.getElementById('tableDropdown');
                tableDropdown.innerHTML = '';
                data.forEach(table => {
                    const option = document.createElement('option');
                    option.value = table.TABLE_NAME;
                    option.textContent = table.TABLE_NAME;
                    tableDropdown.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching tables:', error));
    }

    function fetchTableData(tableName) {
        const databaseName = document.getElementById('databaseDropdown').value;
        fetch(`/dashboard/table-data?database=${databaseName}&table=${tableName}`)
            .then(response => response.json())
            .then(data => {
                console.log('Table Data:', data);
                // Handle table data display logic here
            })
            .catch(error => console.error('Error fetching table data:', error));
    }
</script>
@endsection
