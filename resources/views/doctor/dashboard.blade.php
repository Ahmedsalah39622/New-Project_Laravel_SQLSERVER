@extends('layouts.layoutMaster')

@section('title', 'Doctor Dashboard')

@section('content')
<div class="container">
    <h2 class="text-primary" id="greetingMessage">Welcome, Doctor</h2>
    <p>Manage appointments and patients efficiently.</p>

    <div class="d-flex justify-content-between mb-4">
        <div>
            <a href="{{ url('/appointment') }}" class="btn btn-primary">Schedule Appointment</a>
            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#managePatientModal">Manage Patient Data</button>
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewPatientRecordsModal">View Patient Records</button>
        </div>
    </div>

    <!-- Appointment Counts Section -->
    <div id="appointmentCounts" class="row mt-4">
        <!-- Total Appointments Card -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Appointments</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $appointments->count() }}</h5>
                </div>
            </div>
        </div>

        <!-- Confirmed Appointments Card -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Confirmed Appointments</div>
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $appointments->where('status', 'confirmed')->count() }}
                    </h5>
                </div>
            </div>
        </div>

        <!-- Pending Appointments Card -->
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Pending Appointments</div>
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $appointments->where('status', 'pending')->count() }}
                    </h5>
                </div>
            </div>
        </div>

        <!-- Today's Appointments Card -->
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Today's Appointments</div>
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $appointments->where('appointment_date', now()->toDateString())->count() }}
                    </h5>
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
                    <table class="table table-bordered">
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
                            @forelse ($appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->patient_name }}</td>
                                    <td>{{ auth()->user()->name }}<br>
                                        <small class="text-muted">{{ auth()->user()->specialization }}</small>
                                    </td>
                                    <td>{{ $appointment->appointment_date }}</td>
                                    <td>{{ $appointment->start_time }}</td>
                                    <td>
                                        <span class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : 'warning' }}">
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
                                    <td colspan="7">No appointments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Total Appointments Count -->
                <p id="filteredAppointmentCount" class="mt-3">
                    Total Appointments: {{ $appointments->count() }}
                </p>
            </div>
        </div>
    </div>

    <!-- Manage Patient Data Modal -->
    <div class="modal fade" id="managePatientModal" tabindex="-1" aria-labelledby="managePatientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="managePatientModalLabel">Manage Patient Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form content for managing patient data -->
                    <form>
                        <div class="mb-3">
                            <label for="patientName" class="form-label">Patient Name</label>
                            <input type="text" class="form-control" id="patientName" required>
                        </div>
                        <div class="mb-3">
                            <label for="patientEmail" class="form-label">Patient Email</label>
                            <input type="email" class="form-control" id="patientEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="patientPhone" class="form-label">Patient Phone</label>
                            <input type="tel" class="form-control" id="patientPhone" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Patient Records Modal -->
    <div class="modal fade" id="viewPatientRecordsModal" tabindex="-1" aria-labelledby="viewPatientRecordsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPatientRecordsModalLabel">View Patient Records</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Content for viewing patient records -->
                    <p>Patient records will be displayed here.</p>
                </div>
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
        let greeting = 'Welcome, Doctor';

        if (hours < 12) {
            greeting = 'Good Morning, Doctor';
        } else if (hours < 18) {
            greeting = 'Good Afternoon, Doctor';
        } else {
            greeting = 'Good Evening, Doctor';
        }

        document.getElementById('greetingMessage').innerText = greeting;
    }

    document.addEventListener('DOMContentLoaded', function() {
        setGreetingMessage();
        fetchAllAppointments();
    });
</script>
@endsection
