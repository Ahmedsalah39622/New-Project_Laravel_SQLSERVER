@extends('layouts/layoutMaster')

@section('title', 'Patient Dashboard')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('title', 'Patient Dashboard')
@section('content')
<!-- Greeting Message -->
<div class="mb-4">
    <h2 id="greetingMessage" class="display-6 text-primary greeting-animation"></h2>
</div>

<!-- Main Patient Dashboard Grid -->
<div class="row g-4">
    <!-- Left Column - Large Cards -->
    <div class="col-xl-8 col-lg-7">
        <!-- Appointment Booking Card -->
        <div class="card mb-4">
            <div class="row g-0">
                <div class="col-md-4">
                    <img class="card-img h-100" src="https://th.bing.com/th/id/R.0754e8acc8723455c10d45bed40f3ba9?rik=o4jgkcjXqc8Ukg&pid=ImgRaw&r=0&sres=1&sresct=1" alt="Book Appointment" style="object-fit: cover;" />
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Schedule Your Next Visit</h5>
                        <p class="card-text">Book your upcoming appointment, select a doctor, and get the best care.</p>
                        <a href="/appointment" class="btn btn-primary">Book an appointment</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appointment History Section - Preserved Functionality -->
        <div class="card shadow-none">
            <div class="card-header">
                <h5 class="card-title text-primary m-0">Appointment History</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <!-- Existing Table with preserved ID and structure -->
                    <table class="table table-bordered" id="appointmentsTable">
                        <thead>
                            <tr>
                                <th>Doctor</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($appointments) && count($appointments) > 0)
                                @foreach ($appointments as $appointment)
                                    <tr data-appointment-id="{{ $appointment->id }}">
                                        <td>
                                            <i class="ti ti-user ti-md text-primary me-3"></i>
                                            <span class="fw-medium">{{ $appointment->doctor->name ?? 'N/A' }}</span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}</td>
                                        <td>
                                            <!-- Color of the appointment status-->
                                            <span class="badge
                                                @if($appointment->status == 'confirmed') bg-success
                                                @elseif($appointment->status == 'cancelled') bg-danger
                                                @else bg-warning
                                                @endif">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        </td>
                                        <!-- Actions of the appointment-->
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a href="javascript:void(0)" class="dropdown-item view-details">
                                                        <i class="ti ti-eye me-1"></i> View Details
                                                    </a>
                                                    <a href="javascript:void(0)" class="dropdown-item cancel-appointment @if($appointment->status == 'confirmed') disabled @endif">
                                                        <i class="ti ti-trash me-1"></i> Cancel
                                                    </a>
                                                    <!-- New Action for Viewing Treatment Plan -->
                                                    <a href="javascript:void(0)" class="dropdown-item view-treatment-plan" data-appointment-id="{{ $appointment->id }}">
                                                        <i class="ti ti-file-text me-1"></i> View Treatment Plan
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No appointment history found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Small Cards -->
    <div class="col-xl-4 col-lg-5">
        <!-- Quick Stats Card -->
        <div class="card mb-4 bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title text-white">Your Health Overview</h5>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Next Appointment</span>
                    <span class="badge bg-white text-primary">
                        @if(isset($appointments))
                            {{ $appointments->where('appointment_date', '>=', now())->count() }}
                        @else
                            0
                        @endif
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Total Appointments</span>
                    <span class="badge bg-white text-primary">
                        @if(isset($appointments))
                            {{ $appointments->count() }}
                        @else
                            0
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Pharmacy Quick Access -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Pharmacy</h5>
                <p class="card-text">Quick access to your prescriptions and medications.</p>
                <a href="{{ route('pharmacy') }}" class="btn btn-outline-primary w-100">Visit Pharmacy</a>
            </div>
        </div>

        <!-- Medical Records Card -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Medical Records</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Lab Results
                        <i class="ti ti-file-medical text-primary"></i>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Prescriptions
                        <i class="ti ti-medicine text-primary"></i>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Medical History
                        <i class="ti ti-history text-primary"></i>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Emergency Contacts -->
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h5 class="card-title text-white">Emergency Contact</h5>
                <p class="card-text">24/7 Emergency Hotline</p>
                <div class="d-flex align-items-center">
                    <i class="ti ti-phone me-2"></i>
                    <span class="fs-4">911</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preserve existing scripts and functionality -->
@endsection

@section('page-script')
<style>
    .greeting-animation {
        opacity: 0;
        transform: translateY(-20px);
        animation: fadeInDown 0.5s ease-out forwards;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .text-morning { color: #FF6B6B !important; }     /* Sunrise color */
    .text-afternoon { color: #4ECDC4 !important; }   /* Sky blue */
    .text-evening { color: #6C5CE7 !important; }     /* Evening purple */
</style>

<script>
    function setGreetingMessage() {
        const now = new Date();
        const hours = now.getHours();
        const greetingElement = document.getElementById('greetingMessage');
        let greeting = 'Welcome, {{ auth()->user()->name }}';
        let colorClass = 'text-primary';

        if (hours < 12) {
            greeting = 'Good Morning, {{ auth()->user()->name }}';
            colorClass = 'text-morning';
        } else if (hours < 18) {
            greeting = 'Good Afternoon, {{ auth()->user()->name }}';
            colorClass = 'text-afternoon';
        } else {
            greeting = 'Good Evening, {{ auth()->user()->name }}';
            colorClass = 'text-evening';
        }

        greetingElement.innerText = greeting;
        greetingElement.className = `display-6 greeting-animation ${colorClass}`;
    }

    document.addEventListener('DOMContentLoaded', function () {
        setGreetingMessage();

        // Handle "View Details" and "Cancel" actions
        document.getElementById('appointmentsTable').addEventListener('click', async (e) => {
            if (e.target.classList.contains('view-details')) {
                const appointmentId = e.target.closest('tr').dataset.appointmentId
                // Fetch and display appointment details
                const response = await fetch(`/appointment/details/${appointmentId}`);
                const appointment = await response.json();
                alert(`Appointment Details:\n\nPatient: ${appointment.patient_name}\nDate: ${appointment.appointment_date}\nTime: ${appointment.start_time}\nStatus: ${appointment.status}`);
                //if the appointment status is pending that is mean that the action has cancel appointment class and not disabled this means that the appointments status are pending
            } else if (e.target.classList.contains('cancel-appointment') && !e.target.classList.contains('disabled')) {
                const appointmentId = e.target.closest('tr').dataset.appointmentId;
                // Cancel the appointment
                const response = await fetch(`/appointment/cancel/${appointmentId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });
                if (response.ok) {
                    alert('Appointment cancelled successfully.');
                    // Remove the appointment row from the table
                    e.target.closest('tr').remove();
                } else {
                    alert('Failed to cancel appointment. Please try again.');
                }
            }
        });

        // Handle "View Treatment Plan" action
        document.querySelectorAll('.view-treatment-plan').forEach(button => {
            button.addEventListener('click', async function () {
                const appointmentId = this.getAttribute('data-appointment-id');

                try {
                    const response = await fetch(`/appointment/${appointmentId}/treatment-plan`);
                    if (!response.ok) {
                        throw new Error('There is no treatment plan yet. Please follow up with your doctor.');
                    }

                    const data = await response.json();
                    if (data.treatment_plan) {
                        let treatmentPlanDetails = 'Treatment Plan:\n\n';
                        data.treatment_plan.forEach(plan => {
                            treatmentPlanDetails += `Drug: ${plan.drug}\nDosage: ${plan.dosage}\nNotes: ${plan.notes}\n\n`;
                        });
                        alert(treatmentPlanDetails);
                    } else {
                        alert('No treatment plan found for this appointment.');
                    }
                } catch (error) {
                    alert(error.message);
                }
            });
        });
    });
</script>
@endsection
