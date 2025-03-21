@extends('layouts.layoutMaster')

@section('title', 'Doctor Dashboard')

@php
use App\Http\Controllers\Doctor\DashboardController;
use Illuminate\Support\Facades\Auth;
@endphp

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Welcome Card -->
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Welcome Dr. {{ Auth::user()->name }}! 🎉</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <!-- Today's Appointments Card -->
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                    <i class="bx bx-calendar fs-4"></i>
                                </span>
                            </div>
                            <div class="card-info">
                                <small>Today's Appointments</small>
                                <h3 id="todayAppointments">Loading...</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Appointments Card -->
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar">
                                <span class="avatar-initial rounded-circle bg-label-success">
                                    <i class="bx bx-user fs-4"></i>
                                </span>
                            </div>
                            <div class="card-info">
                                <small>Total Appointments</small>
                                <h3 id="totalAppointments">Loading...</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Appointments -->
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar">
                                <span class="avatar-initial rounded-circle bg-label-warning">
                                    <i class="bx bx-time fs-4"></i>
                                </span>
                            </div>
                            <div class="card-info">
                                <small>Pending Appointments</small>
                                <h3>Loading...</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Appointments -->
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar">
                                <span class="avatar-initial rounded-circle bg-label-info">
                                    <i class="bx bx-check fs-4"></i>
                                </span>
                            </div>
                            <div class="card-info">
                                <small>Completed Appointments</small>
                                <h3>Loading...</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancelled Appointments -->
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar">
                                <span class="avatar-initial rounded-circle bg-label-danger">
                                    <i class="bx bx-x fs-4"></i>
                                </span>
                            </div>
                            <div class="card-info">
                                <small>Cancelled Appointments</small>
                                <h3>Loading...</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmed Appointments Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Confirmed Appointments</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Appointment Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                </thead>
                <tbody id="confirmedAppointmentsTable">
                    <!-- Data will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/doctor/dashboard/data')
            .then(response => response.json())
            .then(data => {
                document.getElementById('todayAppointments').innerText = data.todayAppointments;
                document.getElementById('totalAppointments').innerText = data.totalAppointments;
                document.getElementById('pendingAppointments').innerText = data.pendingAppointments;
                document.getElementById('completedAppointments').innerText = data.completedAppointments;
                document.getElementById('cancelledAppointments').innerText = data.cancelledAppointments;

                const confirmedAppointmentsTable = document.getElementById('confirmedAppointmentsTable');
                confirmedAppointmentsTable.innerHTML = '';
                data.confirmedAppointments.forEach(appointment => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${appointment.patient_name}</td>
                        <td>${appointment.appointment_date}</td>
                        <td>${appointment.start_time}</td>
                        <td>${appointment.end_time}</td>
                    `;
                    confirmedAppointmentsTable.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching dashboard data:', error));
    });
</script>
@endsection

