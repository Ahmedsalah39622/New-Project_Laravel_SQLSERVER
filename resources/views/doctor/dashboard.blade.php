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
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Appointments</div>
                <div class="card-body">
                    <h5 class="card-title" id="totalAppointments">0</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Confirmed Appointments</div>
                <div class="card-body">
                    <h5 class="card-title" id="confirmedCount">0</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Pending Appointments</div>
                <div class="card-body">
                    <h5 class="card-title" id="pendingCount">0</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Today's Appointments</div>
                <div class="card-body">
                    <h5 class="card-title" id="todaysAppointments">0</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- All Appointments Section -->
    <div id="allAppointments" class="mt-4">
        <h3>All Appointments</h3>
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
                        <tbody id="allAppointmentHistory">
                        </tbody>
                    </table>
                </div>
                <p id="allAppointmentCount" class="mt-3"></p>
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

    <!-- View Appointment Modal -->
    <div class="modal fade" id="viewAppointmentModal" tabindex="-1" aria-labelledby="viewAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewAppointmentModalLabel">Appointment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="appointmentDetails">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Patient Information</h4>
                                <p id="patientNameDetail"></p>
                                <p id="patientEmailDetail"></p>
                                <p id="patientPhoneDetail"></p>
                            </div>
                            <div class="col-md-6 text-end">
                                <h4>Appointment Information</h4>
                                <p id="appointmentDateDetail"></p>
                                <p id="appointmentTimeDetail"></p>
                                <p id="appointmentStatusDetail"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Diagnosis</h4>
                                <p id="diagnosisDetail"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Prescription</h4>
                                <p id="prescriptionDetail"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Notes</h4>
                                <p id="notesDetail"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="printAppointmentDetails()">Print</button>
                    <button type="button" class="btn btn-success" onclick="completeAppointment()">Complete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    let currentAppointmentId = null;

    async function fetchAllAppointments() {
        try {
            console.log('Fetching all appointments...');
            const response = await axios.get('/api/appointments');
            const data = response.data;

            console.log('Appointments data:', data);

            if (data.length > 0) {
                document.getElementById('allAppointments').classList.remove('d-none');

                // Filter and display only confirmed appointments
                const confirmedAppointments = data.filter(apt => apt.status === 'confirmed');

                // Display confirmed appointments
                const allAppointmentHistory = document.getElementById('allAppointmentHistory');
                const appointments = confirmedAppointments.map(apt => {
                    const statusColor = 'success';

                    return `
                        <tr>
                            <td>${apt.patient_name}</td>
                            <td>${apt.doctor ? apt.doctor.name : 'N/A'}<br>
                                <small class="text-muted">${apt.doctor ? apt.doctor.specialization : 'N/A'}</small>
                            </td>
                            <td>${apt.appointment_date}</td>
                            <td>${apt.start_time}</td>
                            <td><span class="badge bg-${statusColor}">${apt.status}</span></td>
                            <td>${apt.notes || 'N/A'}</td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="viewAppointment(${apt.id})">
                                    <i class="fas fa-eye me-1"></i> View
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteAppointment(${apt.id})">
                                    <i class="fas fa-trash me-1"></i> Delete
                                </button>
                            </td>
                        </tr>
                    `;
                }).join('');

                allAppointmentHistory.innerHTML = appointments;

                // Calculate and display the counts of appointments
                const confirmedCount = confirmedAppointments.length;
                const pendingCount = data.filter(apt => apt.status === 'pending').length;
                const cancelledCount = data.filter(apt => apt.status === 'cancelled').length;

                // Calculate today's appointments
                const today = new Date().toISOString().split('T')[0];
                const todaysAppointmentsCount = confirmedAppointments.filter(apt => apt.appointment_date === today).length;

                document.getElementById('confirmedCount').innerText = confirmedCount;
                document.getElementById('pendingCount').innerText = pendingCount;
                document.getElementById('todaysAppointments').innerText = todaysAppointmentsCount;

                // Display the count of all appointments
                document.getElementById('totalAppointments').innerText = data.length;
                document.getElementById('allAppointmentCount').innerText = `Total Appointments: ${data.length}`;
            } else {
                document.getElementById('allAppointments').classList.remove('d-none');
                document.getElementById('allAppointmentHistory').innerHTML = '<tr><td colspan="7">No appointments found.</td></tr>';
                document.getElementById('allAppointmentCount').innerText = 'Total Appointments: 0';
                document.getElementById('totalAppointments').innerText = '0';
                document.getElementById('todaysAppointments').innerText = '0';
            }
        } catch (error) {
            console.error('Error fetching all appointments:', error);
            console.error('Error details:', error.response ? error.response.data : error.message);
            alert('Error fetching all appointments. Please try again.');
        }
    }

    // Add view appointment function
    function viewAppointment(appointmentId) {
        currentAppointmentId = appointmentId;
        // Fetch appointment details and populate the modal fields
        // For demonstration, we'll use dummy data
        document.getElementById('patientNameDetail').innerText = 'Patient Name for appointment ID: ' + appointmentId;
        document.getElementById('patientEmailDetail').innerText = 'patient@example.com';
        document.getElementById('patientPhoneDetail').innerText = '123-456-7890';
        document.getElementById('appointmentDateDetail').innerText = 'Appointment Date: ' + new Date().toISOString().split('T')[0];
        document.getElementById('appointmentTimeDetail').innerText = 'Appointment Time: 10:00 AM';
        document.getElementById('appointmentStatusDetail').innerText = 'Status: Confirmed';
        document.getElementById('diagnosisDetail').innerText = 'Diagnosis details for appointment ID: ' + appointmentId;
        document.getElementById('prescriptionDetail').innerText = 'Prescription details for appointment ID: ' + appointmentId;
        document.getElementById('notesDetail').innerText = 'Notes for appointment ID: ' + appointmentId;

        // Show the modal
        const viewAppointmentModal = new bootstrap.Modal(document.getElementById('viewAppointmentModal'));
        viewAppointmentModal.show();
    }

    // Add complete appointment function
    async function completeAppointment() {
        if (!confirm('Are you sure you want to mark this appointment as completed?')) {
            return;
        }

        try {
            console.log(`Completing appointment with ID: ${currentAppointmentId}`);
            const response = await axios.post(`/api/appointments/${currentAppointmentId}/complete`, {}, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = response.data;

            console.log('Complete response data:', data);

            if (response.status === 200 && data.success) {
                // Refresh the appointments
                fetchAllAppointments();
                alert('Appointment marked as completed successfully');
                // Hide the modal
                const viewAppointmentModal = bootstrap.Modal.getInstance(document.getElementById('viewAppointmentModal'));
                viewAppointmentModal.hide();
            } else {
                alert(data.message || 'Failed to complete appointment');
            }
        } catch (error) {
            console.error('Error completing appointment:', error);
            console.error('Error details:', error.response ? error.response.data : error.message);
            alert('Error completing appointment. Please try again.');
        }
    }

    // Add delete appointment function
    async function deleteAppointment(appointmentId) {
        if (!confirm('Are you sure you want to delete this appointment?')) {
            return;
        }

        try {
            console.log(`Deleting appointment with ID: ${appointmentId}`);
            const response = await axios.delete(`/api/appointments/${appointmentId}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = response.data;

            console.log('Delete response data:', data);

            if (response.status === 200 && data.success) {
                // Refresh the appointments
                fetchAllAppointments();
                alert('Appointment deleted successfully');
            } else {
                alert(data.message || 'Failed to delete appointment');
            }
        } catch (error) {
            console.error('Error deleting appointment:', error);
            console.error('Error details:', error.response ? error.response.data : error.message);
            alert('Error deleting appointment. Please try again.');
        }
    }

    // Print appointment details
    function printAppointmentDetails() {
        const printContents = document.getElementById('appointmentDetails').innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        window.location.reload();
    }

    // Set greeting message based on the current time
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

    // Fetch appointments and set greeting message on page load
    document.addEventListener('DOMContentLoaded', function() {
        setGreetingMessage();
        fetchAllAppointments();
    });
</script>
@endsection
