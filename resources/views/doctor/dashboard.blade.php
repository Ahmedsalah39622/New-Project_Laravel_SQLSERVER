@extends('layouts.layoutMaster')

@section('title', 'Doctor Dashboard')

@section('content')
<div class="container">
    <h2 class="text-primary">Doctor Dashboard</h2>
    <p>Manage appointments and patients efficiently.</p>

    <div class="d-flex justify-content-between mb-4">
        <div>
            <a href="{{ url('/appointment') }}" class="btn btn-primary">Schedule Appointment</a>
            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#managePatientModal">Manage Patient Data</button>
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewPatientRecordsModal">View Patient Records</button>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-info" id="showAllBtn">Show All Appointments</button>
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
                                <th>Doctor (ID)</th>
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

    <!-- Appointment Counts Section -->
    <div id="appointmentCounts" class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Confirmed Appointments</div>
                <div class="card-body">
                    <h5 class="card-title" id="confirmedCount">0</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Pending Appointments</div>
                <div class="card-body">
                    <h5 class="card-title" id="pendingCount">0</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Cancelled Appointments</div>
                <div class="card-body">
                    <h5 class="card-title" id="cancelledCount">0</h5>
                </div>
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
    async function fetchAllAppointments() {
        try {
            console.log('Fetching all appointments...');
            const response = await axios.get('/api/appointments');
            const data = response.data;

            console.log('Appointments data:', data);

            if (data.length > 0) {
                document.getElementById('allAppointments').classList.remove('d-none');

                // Display all appointments
                const allAppointmentHistory = document.getElementById('allAppointmentHistory');
                const appointments = data.map(apt => {
                    const statusColor = apt.status === 'confirmed' ? 'success' :
                                      apt.status === 'completed' ? 'success' :
                                      apt.status === 'cancelled' ? 'danger' : 'warning';

                    return `
                        <tr>
                            <td>${apt.patient_name}</td>
                            <td>${apt.doctor_id}<br>
                                <small class="text-muted">${apt.doctor ? apt.doctor.specialization : 'N/A'}</small>
                            </td>
                            <td>${apt.appointment_date}</td>
                            <td>${apt.start_time}</td>
                            <td><span class="badge bg-${statusColor}">${apt.status}</span></td>
                            <td>${apt.notes || 'N/A'}</td>
                            <td>
                                ${apt.status !== 'confirmed' ? `
                                    <button class="btn btn-success btn-sm me-2" onclick="confirmAppointment(${apt.id})">
                                        <i class="fas fa-check me-1"></i> Confirm
                                    </button>
                                ` : ''}
                                <button class="btn btn-danger btn-sm" onclick="deleteAppointment(${apt.id})">
                                    <i class="fas fa-trash me-1"></i> Delete
                                </button>
                            </td>
                        </tr>
                    `;
                }).join('');

                allAppointmentHistory.innerHTML = appointments;

                // Calculate and display the counts of appointments
                const confirmedCount = data.filter(apt => apt.status === 'confirmed' || apt.status === 'completed').length;
                const pendingCount = data.filter(apt => apt.status === 'pending').length;
                const cancelledCount = data.filter(apt => apt.status === 'cancelled').length;

                document.getElementById('confirmedCount').innerText = confirmedCount;
                document.getElementById('pendingCount').innerText = pendingCount;
                document.getElementById('cancelledCount').innerText = cancelledCount;

                // Display the count of all appointments
                document.getElementById('allAppointmentCount').innerText = `Total Appointments: ${data.length}`;
            } else {
                document.getElementById('allAppointments').classList.remove('d-none');
                document.getElementById('allAppointmentHistory').innerHTML = '<tr><td colspan="7">No appointments found.</td></tr>';
                document.getElementById('allAppointmentCount').innerText = 'Total Appointments: 0';
            }
        } catch (error) {
            console.error('Error fetching all appointments:', error);
            console.error('Error details:', error.response ? error.response.data : error.message);
            alert('Error fetching all appointments. Please try again.');
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

    // Add the confirmAppointment function
    async function confirmAppointment(appointmentId) {
        if (!confirm('Are you sure you want to confirm this appointment?')) {
            return;
        }

        try {
            console.log(`Confirming appointment with ID: ${appointmentId}`);
            const response = await axios.post(`/api/appointments/${appointmentId}/confirm`, {}, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = response.data;

            console.log('Confirm response data:', data);

            if (response.status === 200 && data.success) {
                // Refresh the appointments
                fetchAllAppointments();
                alert('Appointment confirmed successfully');
            } else {
                alert(data.message || 'Failed to confirm appointment');
            }
        } catch (error) {
            console.error('Error confirming appointment:', error);
            console.error('Error details:', error.response ? error.response.data : error.message);
            alert('Error confirming appointment. Please try again.');
        }
    }

    document.getElementById('showAllBtn').addEventListener('click', function() {
        fetchAllAppointments();
    });

    // Add clear functionality
    document.getElementById('clearBtn').addEventListener('click', function() {
        // Clear input fields
        document.getElementById('searchGeneral').value = '';
        document.getElementById('searchId').value = '';

        // Hide search results
        document.getElementById('searchResults').classList.add('d-none');

        // Clear results content
        document.getElementById('appointmentHistory').innerHTML = '';
        document.getElementById('appointmentCount').innerText = '';
        document.getElementById('appointmentCounts').classList.add('d-none');
    });
</script>
@endsection
