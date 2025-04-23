@extends('layouts.layoutMaster')

@section('title', 'Doctor Dashboard')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate/animate.css') }}" />
<style>
    /* Professional Medical Theme */
    :root {
        --medical-blue: #4F46E5;
        --medical-green: #059669;
        --medical-red: #DC2626;
    }

    .medical-gradient {
        background: linear-gradient(135deg, var(--medical-blue), #818CF8);
    }

    .stats-card {
        transition: transform 0.2s;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .appointment-table th {
        background-color: #F3F4F6;
        color: #374151;
    }

    .appointment-table tbody tr:hover {
        background-color: #F9FAFB;
    }

    .quick-action-btn {
        transition: all 0.3s;
        border-radius: 8px;
        padding: 1rem;
    }

    .quick-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@section('content')
<div class="container-fluid p-4">
    <!-- Welcome Banner -->
    <div class="card medical-gradient text-white mb-4 overflow-hidden">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 id="greetingMessage" class="display-6 mb-2">Welcome, Dr. {{ auth()->user()->name }}</h2>
                    <p class="mb-0 fs-5">{{ auth()->user()->specialization }}</p>
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

    <!-- Quick Actions Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stats-card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Today's Patients</h6>
                            <h2 class="mt-2 mb-0">{{ $appointments->where('appointment_date', now()->toDateString())->count() }}</h2>
                        </div>
                        <i class="ti ti-users fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Confirmed</h6>
                            <h2 class="mt-2 mb-0">{{ $appointments->where('status', 'confirmed')->count() }}</h2>
                        </div>
                        <i class="ti ti-check fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Pending</h6>
                            <h2 class="mt-2 mb-0">{{ $appointments->where('status', 'pending')->count() }}</h2>
                        </div>
                        <i class="ti ti-clock fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Today's Appointments</h6>
                            <h2 class="mt-2 mb-0">{{ $appointments->where('appointment_date', now()->toDateString())->count() }}</h2>
                        </div>
                        <i class="ti ti-calendar fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtered Appointments Section -->
    <div id="filteredAppointments" class="mt-4">
        <h3>Today Appointments</h3>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered appointment-table">
                        <thead>
                            <tr>
                                <th>Patient Name</th>
                                <th>Doctor Name</th>
                                <th>Appointment Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($appointments->where('appointment_date', now()->toDateString())->where('status', 'confirmed') as $appointment)
                                <tr>
                                    <td>{{ $appointment->patient_name }}</td>
                                    <td>{{ auth()->user()->name }}<br>
                                        <small class="text-muted">{{ auth()->user()->specialization }}</small>
                                    </td>
                                    <td>{{ $appointment->appointment_date }}</td>
                                    <td>{{ $appointment->start_time }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ $appointment->status }}
                                        </span>
                                    </td>
                                    <td>{{ $appointment->notes ?? 'N/A' }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" onclick="viewAppointment({{ $appointment->id }})">
                                            <i class="fas fa-eye me-1"></i> View
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteAppointment({{ $appointment->id }})">
                                            <i class="fas fa-trash me-1"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">No confirmed appointments found for today.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Total Appointments Count -->
                <p id="filteredAppointmentCount" class="mt-3">
                    Total Appointments: {{ $appointments->where('appointment_date', now()->toDateString())->where('status', 'confirmed')->count() }}
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    let authUserName = @json(auth()->user()->name);
    let authUserSpec = @json(auth()->user()->specialization);

    let currentAppointmentId = null;

    async function fetchAllAppointments() {
        console.log('Fetching all appointments...');
        // Logic for fetching appointments
    }

    function viewAppointment(appointmentId) {
        currentAppointmentId = appointmentId;
        window.location.href = `/addprescription/${appointmentId}`;
    }

    function setGreetingMessage() {
        const now = new Date();
        const hours = now.getHours();
        let greeting = 'Welcome, {{ auth()->user()->name }}';

        if (hours < 12) {
            greeting = 'Good Morning, {{ auth()->user()->name }}';
        } else if (hours < 18) {
            greeting = 'Good Afternoon, {{ auth()->user()->name }}';
        } else {
            greeting = 'Good Evening, {{ auth()->user()->name }}';
        }

        document.getElementById('greetingMessage').innerText = greeting;
    }

    document.addEventListener('DOMContentLoaded', function() {
        setGreetingMessage();
        fetchAllAppointments();
    });
</script>
@endsection
