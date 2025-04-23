@extends('layouts.layoutMaster')

@section('title', 'Receptionist Dashboard')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate/animate.css') }}" />


@section('content')
<!-- Welcome Section with Quick Stats -->
<div class="card bg-primary text-white mb-4">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="mb-3">Welcome, {{ auth()->user()->name }}!</h2>
                <p class="mb-0 fs-5">Manage appointments and patient records efficiently</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="current-time fs-4 mb-2">
                    <i class="ti ti-clock me-2"></i>
                    <span id="currentTime"></span>
                </div>
                <div class="current-date">
                    <i class="ti ti-calendar me-2"></i>
                    <span id="currentDate"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions and Search Section -->
<div class="row g-4 mb-4">
    <!-- Quick Actions -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ url('/appointment') }}" class="btn btn-primary">
                        <i class="ti ti-calendar-plus me-2"></i>Schedule Appointment
                    </a>
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#managePatientModal">
                        <i class="ti ti-user-plus me-2"></i>Manage Patient Data
                    </button>
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewPatientRecordsModal">
                        <i class="ti ti-file-text me-2"></i>View Patient Records
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Patient Search</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Search by Name/Email/Phone</label>
                        <input type="text" class="form-control" id="searchGeneral" placeholder="Enter patient details">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Search by ID</label>
                        <input type="number" class="form-control" id="searchId" placeholder="Patient ID" min="1">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="d-grid gap-2 w-100">
                            <button class="btn btn-primary" id="searchBtn">
                                <i class="ti ti-search me-2"></i>Search
                            </button>
                            <button class="btn btn-outline-secondary" id="clearBtn">
                                <i class="ti ti-x me-2"></i>Clear
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search Results Section with Enhanced Styling -->
<div id="searchResults" class="mt-4 d-none animate__animated animate__fadeIn">
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">Search Results</h5>
        </div>
        <div class="card-body">
            <!-- Patient Information Card -->
            <div class="card bg-light mb-4">
                <div class="card-body">
                    <h6 class="card-subtitle mb-3 text-muted">Patient Information</h6>
                    <div id="patientInfo" class="row"></div>
                </div>
            </div>

            <!-- Appointment History -->
            <h6 class="mb-3">Appointment History</h6>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Doctor (Specialization)</th>
                            <th>Appointment Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="appointmentHistory"></tbody>
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

@endsection

@section('page-script')
<script>
    // Add current time and date display
    function updateDateTime() {
        const now = new Date();
        document.getElementById('currentTime').textContent = now.toLocaleTimeString();
        document.getElementById('currentDate').textContent = now.toLocaleDateString();
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();

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
                searchPatient(
                    document.getElementById('searchGeneral').value,
                    document.getElementById('searchId').value
                );
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
<style>
  /* Background Pattern */
  body {
      position: relative;
      background-color: #f8f9fa;
  }

  body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      background:
          linear-gradient(45deg, transparent 49%, rgba(115, 103, 240, 0.03) 50%, transparent 51%);
      background-size: 20px 20px;
  }

  /* Enhance card visibility against pattern */
  .card {
      backdrop-filter: blur(5px);
      background-color: rgba(255, 255, 255, 0.95);
  }

  /* Override primary card background */
  .card.bg-primary {
      backdrop-filter: none;
      background: linear-gradient(135deg, #7367f0, #9754cb) !important;
  }
</style>
@endsection
<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(115, 103, 240, 0.06);
    }

    .btn {
        padding: 0.6rem 1rem;
        font-weight: 500;
    }

    .btn i {
        font-size: 1.1em;
    }

    .current-time, .current-date {
        opacity: 0.9;
    }
</style>
@endsection
