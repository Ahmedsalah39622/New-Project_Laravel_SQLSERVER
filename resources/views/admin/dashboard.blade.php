@extends('layouts/layoutMaster')

@section('title', 'Hospital Dashboard')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
  'resources/assets/vendor/libs/swiper/swiper.scss',
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss'
])
@endsection

@section('page-style')
@vite(['resources/assets/vendor/scss/pages/cards-advance.scss'])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/apex-charts/apexcharts.js',
  'resources/assets/vendor/libs/swiper/swiper.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
])
@endsection

@section('page-script')
@vite(['resources/assets/js/dashboards-analytics.js'])
@endsection

@section('content')

<div class="row g-4">
    <!-- Total Patients Section -->
    <div class="col-xl-6 col-md-12">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h5 class="mb-3 card-title">Total Patients</h5>
                <p class="mb-0 text-body">Registered Patients</p>
                <!-- Dynamic Total Patients Count -->
                <h4 class="mb-0" id="totalPatients">Loading...</h4>
            </div>
            <div class="card-body px-0">
                <!-- Graph Container for Total Patients -->
                <div id="totalPatientsChart" style="height: 300px;"></div>
            </div>
        </div>
    </div>

    <!-- Total Doctors Section -->
    <div class="col-xl-3 col-sm-6">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h5 class="mb-3 card-title">Total Doctors</h5>
                <p class="mb-0 text-body">Active vs Total Staff</p>
            </div>
            <div class="card-body d-flex justify-content-center align-items-center">
                <!-- Chart Container for Total Doctors -->
                <div id="totalDoctorsChart" style="height: 200px; width: 100%;"></div>
            </div>
        </div>
    </div>

    <!-- Appointments This Month Section -->
    <div class="col-xl-3 col-md-6">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h5 class="mb-3 card-title">Appointments This Month</h5>
                <p class="mb-0 text-body">Total Appointments</p>
                <!-- Static Total Appointments Count -->
                <h4 class="mb-0" id="totalAppointments">120</h4>
            </div>
            <div class="card-body px-0">
                <!-- Chart Container for Appointments -->
                <div id="Appointmentspermonth" style="height: 150px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-4">
    <!-- Disease Statistics Section -->
    <div class="col-xl-6 col-md-12">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Disease Statistics</h5>
            </div>
            <div class="card-body">
                <!-- Download Disease Statistics Button -->
                <div class="btn-group">
                    <!-- Main Button for Viewing -->
                    <a href="http://127.0.0.1:8000/disease-statistics" class="btn btn-primary">
                        <i class="ti ti-eye"></i> View Disease Statistics
                    </a>

                    <!-- Dropdown Toggle -->
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>

                    <!-- Dropdown Menu -->
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('disease-statistics.export') }}">
                                <i class="ti ti-download"></i> Download as CSV
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Form for Predicting Disease Statistics -->
                <form action="{{ route('disease-statistics.predict') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">Upload CSV File</label>
                        <input type="file" name="file" id="file" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="months_to_predict">Months to Predict</label>
                        <input type="number" name="months_to_predict" id="months_to_predict" class="form-control" min="1" max="12" value="3" required>
                    </div>
                    <!-- Submit Button for Prediction -->
                    <button type="submit" class="btn btn-primary mt-3">Predict</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Earnings Report Section -->
    <div class="col-xl-6 col-md-12">
        <div class="card h-100">
            <div class="card-header pb-0 d-flex justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1">Earning Reports</h5>
                    <p class="card-subtitle">Weekly Earnings Overview</p>
                </div>
            </div>
            <div class="card-body">
                <!-- Weekly Earnings Overview -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="mb-0">$468</h2>
                        <small class="text-success">+4.2%</small>
                    </div>
                    <small>You informed of this week compared to last week</small>
                </div>
                <!-- Chart Container for Weekly Earnings -->
                <div id="weeklyEarningReports" style="height: 200px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-4">
    <!-- Top 3 Diseases by Cases Section -->
    <div class="col-xl-4 col-md-6">
        <div class="card h-100">
            <div class="card-header pb-0 d-flex justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1">Top 3 Diseases by Cases</h5>
                    <p class="card-subtitle">Most Prevalent Diseases</p>
                </div>
            </div>
            <div class="card-body">
                <!-- Chart Container for Top Diseases -->
                <div id="topDiseasesChart" style="height: 150px;"></div>
            </div>
        </div>
    </div>

    <!-- New Patients Section -->
    <div class="col-xl-4 col-md-6">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h5 class="mb-3 card-title">New Patients</h5>
                <p class="mb-0 text-body">This Month</p>
                <!-- Static New Patients Count -->
                <h4 class="mb-0">50</h4>
                <small class="text-success">+10% from last month</small>
            </div>
        </div>
    </div>

    <!-- Access Roles Section -->
    <div class="col-xl-4 col-md-12">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h5 class="mb-3 card-title">Access Roles</h5>
                <p class="mb-0 text-body">Manage User Permissions</p>
            </div>
            <div class="card-body">
                <!-- Manage Roles Button -->
                <a href="{{ route('admin.access-roles') }}" class="btn btn-primary">
                    <i class="ti ti-lock"></i> Manage Roles
                </a>
                <p class="mt-3">Control and assign roles to users for secure access to the system.</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-4">
    <!-- Query Results Section -->
    <div class="col-xl-12 col-md-12">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Query Results</h5>
            </div>
            <div class="card-body">
                @if(isset($data) && count($data) > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Company Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $row)
                                <tr>
                                    <td>{{ $row['Code'] }}</td>
                                    <td>{{ $row['Name'] }}</td>
                                    <td>{{ $row['Compny_Code'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No data available.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Button to navigate to /databases -->
<div class="mt-4">
    <a href="/databases" class="btn btn-primary">Go to Databases</a>
</div>

@endsection
