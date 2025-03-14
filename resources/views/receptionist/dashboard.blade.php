@extends('layouts.layoutMaster')

@section('title', 'Receptionist Dashboard')

@section('content')
<div class="container">
    <h2 class="text-primary">Receptionist Dashboard</h2>
    <p>Manage appointments and patients efficiently.</p>

    <div class="d-flex justify-content-between mb-4">
        <div>
            <a href="{{ url('/appointment') }}" class="btn btn-primary">Schedule Appointment</a>
            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#managePatientModal">Manage Patient Data</button>
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewPatientRecordsModal">View Patient Records</button>
        </div>
        <div class="d-flex gap-2">
            <input
                type="text"
                class="form-control"
                id="searchGeneral"
                placeholder="Search by name, email or phone"
            >
            <input
                type="number"
                class="form-control"
                id="searchId"
                placeholder="Search by Patient ID"
                min="1"
            >
            <button class="btn btn-outline-primary" id="searchBtn">Search</button>
            <button class="btn btn-outline-secondary" id="clearBtn">Clear</button>

        </div>
    </div>

    <!-- Search Results Section -->
    <div id="searchResults" class="mt-4 d-none">
        <h3>Search Results</h3>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Patient Information</h4>
                <div id="patientInfo"></div>

                <h4 class="card-title mt-4">Appointment History</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Doctor (Specialization)</th>
                                <th>Appointment Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="appointmentHistory">
                        </tbody>
                    </table>
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

<script>
    async function searchPatient(generalQuery, idQuery) {
        if (!generalQuery.trim() && !idQuery.trim()) return;

        try {
            const response = await fetch(`/api/patient/search?general=${encodeURIComponent(generalQuery)}&id=${encodeURIComponent(idQuery)}`);
            const data = await response.json();

            if (data.patient) {
                document.getElementById('searchResults').classList.remove('d-none');

                // Display patient information including ID
                const patientInfo = document.getElementById('patientInfo');
                patientInfo.innerHTML = `
                    <p><strong>Patient ID:</strong> ${data.patient.id}</p>
                    <p><strong>Name:</strong> ${data.patient.name}</p>
                    <p><strong>Email:</strong> ${data.patient.email}</p>
                    <p><strong>Phone:</strong> ${data.patient.phone}</p>
                `;

                // Display appointment history with color-coded status
                const appointmentHistory = document.getElementById('appointmentHistory');
                appointmentHistory.innerHTML = data.appointments.map(apt => {
                    const statusColor = apt.status === 'confirmed' ? 'success' :
                                      apt.status === 'completed' ? 'success' :
                                      apt.status === 'cancelled' ? 'danger' : 'warning';

                    return `
                        <tr>
                            <td>${apt.doctor_name}<br>
                                <small class="text-muted">${apt.doctor_specialization}</small>
                            </td>
                            <td>${apt.appointment_date}</td>
                            <td>${apt.start_time}</td>
                            <td><span class="badge bg-${statusColor}">${apt.status}</span></td>
                            <td>
                                ${apt.status !== 'confirmed' ? `
                                    <button class="btn btn-success btn-sm me-2" onclick="confirmAppointment(${apt.id})">
                                        <i class="fas fa-check"></i> Confirm
                                    </button>
                                ` : ''}
                                <button class="btn btn-danger btn-sm" onclick="deleteAppointment(${apt.id})">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    `;
                }).join('');
            } else {
                document.getElementById('searchResults').classList.remove('d-none');
                document.getElementById('patientInfo').innerHTML = '<p>No patient found with the given search criteria.</p>';
                document.getElementById('appointmentHistory').innerHTML = '';
            }
        } catch (error) {
            console.error('Error searching patient:', error);
            alert('Error searching patient. Please try again.');
        }
    }

    // Add delete appointment function
    async function deleteAppointment(appointmentId) {
        if (!confirm('Are you sure you want to delete this appointment?')) {
            return;
        }

        try {
            const response = await fetch(`/api/appointments/${appointmentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // Refresh the search results
                searchPatient(document.getElementById('search').value);
                alert('Appointment deleted successfully');
            } else {
                alert(data.message || 'Failed to delete appointment');
            }
        } catch (error) {
            console.error('Error deleting appointment:', error);
            alert('Error deleting appointment. Please try again.');
        }
    }

    // Add the confirmAppointment function
    async function confirmAppointment(appointmentId) {
        if (!confirm('Are you sure you want to confirm this appointment?')) {
            return;
        }

        try {
            const response = await fetch(`/api/appointments/${appointmentId}/confirm`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // Refresh the search results
                searchPatient(
                    document.getElementById('searchGeneral').value,
                    document.getElementById('searchId').value
                );
                alert('Appointment confirmed successfully');
            } else {
                alert(data.message || 'Failed to confirm appointment');
            }
        } catch (error) {
            console.error('Error confirming appointment:', error);
            alert('Error confirming appointment. Please try again.');
        }
    }

    // Add event listener for Enter key press on both inputs
    document.getElementById('searchGeneral').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            searchPatient(
                document.getElementById('searchGeneral').value,
                document.getElementById('searchId').value
            );
        }
    });

    document.getElementById('searchId').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            searchPatient(
                document.getElementById('searchGeneral').value,
                document.getElementById('searchId').value
            );
        }
    });

    // Update the click handler for the search button
    document.getElementById('searchBtn').addEventListener('click', function() {
        searchPatient(
            document.getElementById('searchGeneral').value,
            document.getElementById('searchId').value
        );
    });

    // Add clear functionality
    document.getElementById('clearBtn').addEventListener('click', function() {
        // Clear input fields
        document.getElementById('searchGeneral').value = '';
        document.getElementById('searchId').value = '';

        // Hide search results
        document.getElementById('searchResults').classList.add('d-none');

        // Clear results content
        document.getElementById('patientInfo').innerHTML = '';
        document.getElementById('appointmentHistory').innerHTML = '';
    });
</script>
@endsection
