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
    <!-- Appointments This Month -->
    <div class="col-xl-3 col-sm-6">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h5 class="mb-3 card-title">Appointments This Month</h5>
                <p class="mb-0 text-body">Total Appointments</p>
                <h4 class="mb-0" id="totalAppointments">120</h4>            </div>
            <div class="card-body px-0">
              <div id="averageDailySales" style="height: 200px;"></div>
            </div>
        </div>
    </div>

    <!-- Total Doctors -->
    <div class="col-xl-3 col-sm-6">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h5 class="mb-3 card-title">Total Doctors</h5>
                <p class="mb-0 text-body">Active Doctors</p>
                <h4 class="mb-0" id="totalDoctors">120</h4>            </div>
            <div class="card-body px-0">
              <div id="totalDoctorsChart" style="height: 200px;"></div>
            </div>
        </div>
    </div>

    <!-- Total Patients -->
    <div class="col-xl-3 col-sm-6">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h5 class="mb-3 card-title">Total Patients</h5>
                <p class="mb-0 text-body">Registered Patients</p>
                <h4 class="mb-0">450</h4>
            </div>
            <div class="card-body px-0">
                <div id="totalPatientsChart" style="height: 150px;"></div>
            </div>
        </div>
    </div>

    <!-- Revenue -->
    <div class="col-xl-3 col-sm-6">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h5 class="mb-3 card-title">Revenue</h5>
                <p class="mb-0 text-body">This Month</p>
                <h4 class="mb-0">$15,000</h4>
            </div>
            <div class="card-body px-0">
                <div id="revenueChart" style="height: 150px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-4">
    <!-- Average Daily Sales -->
    <div class="col-xxl-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Average Daily Sales</h5>
            </div>
            <div class="card-body">
                <div id="averageDailySales" style="height: 200px;"></div>
            </div>
        </div>
    </div>

    <!-- Weekly Earning Reports -->
    <div class="col-xxl-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Weekly Earning Reports</h5>
            </div>
            <div class="card-body">
                <div id="weeklyEarningReports" style="height: 200px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-4">
    <!-- Support Tracker -->
    <div class="col-xxl-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Support Tracker</h5>
            </div>
            <div class="card-body">
                <div id="supportTracker" style="height: 300px;"></div>
            </div>
        </div>
    </div>

    <!-- Total Earning Chart -->
    <div class="col-xxl-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Total Earning Chart</h5>
            </div>
            <div class="card-body">
                <div id="totalEarningChart" style="height: 200px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-4">
    <!-- Doctors Growth Over Time -->
    <div class="col-xxl-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Doctors Growth Over Time</h5>
            </div>
            <div class="card-body">
                <div id="doctorsGrowthChart" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>

<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.access-roles') }}">
        <i class="ti ti-lock"></i>
        <span>Access Roles</span>
    </a>
</li>

@endsection
