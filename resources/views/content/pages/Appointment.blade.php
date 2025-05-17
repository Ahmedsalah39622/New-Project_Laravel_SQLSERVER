@extends('layouts/layoutMaster')

@section('title', 'Book Your Appointment')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@vite('resources/assets/vendor/libs/fullcalendar/fullcalendar.js')
@vite('resources/assets/vendor/libs/fullcalendar/fullcalendar.css')
@vite('resources/assets/vendor/libs/flatpickr/flatpickr.js')
@vite('resources/assets/vendor/libs/flatpickr/flatpickr.css')
@endsection

@section('title', 'Book Your Appointment')
@section('content')
<!-- Welcome Banner -->
<div class="card bg-primary mb-4 text-white position-relative overflow-hidden">
    <div class="card-body p-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="display-4 mb-3">Book Your Appointment</h2>
                <p class="lead mb-0">Choose from our expert medical specialists for personalized care.</p>
            </div>
        </div>
    </div>
    <div class="position-absolute top-0 end-0 w-25 h-100 d-none d-lg-block" style="background: url('assets/img/elements/doctor.png') no-repeat center right; background-size: cover; opacity: 0.1;"></div>
</div>

<!-- Specialties Grid -->
<div class="row g-4 mb-4" id="clinic-cards">
    @foreach ([
        ['name' => 'Cardiology', 'image' => 'https://www.hawaiipacifichealth.org/media/3922/what-is-a-cardiologist-web.jpg', 'description' => 'Expert heart care and cardiovascular treatments.'],
        ['name' => 'Dentistry', 'image' => 'https://th.bing.com/th/id/OIP.FDv4CjYHYwDIfKollMEGwwHaE8?rs=1&pid=ImgDetMain', 'description' => 'Comprehensive dental services for all ages.'],
        ['name' => 'Neurology', 'image' => 'https://th.bing.com/th/id/OIP.G8GkePvKtmQ87SY1dmisIQHaE7?w=626&h=417&rs=1&pid=ImgDetMain', 'description' => 'Advanced brain and nervous system care.'],
        ['name' => 'Orthopedics', 'image' => 'https://res.cloudinary.com/lowellgeneral/image/upload/c_fill,w_auto,g_faces,q_auto,dpr_auto,f_auto/orthopedic-center1_BFAFBDC0-FC11-11E9-92C400218628D024.jpg', 'description' => 'Bone and joint health specialists.'],
        ['name' => 'Pediatrics', 'image' => 'https://th.bing.com/th/id/OIP.VPe-t1oyyTxUuYA7s7Z-UgHaE8?rs=1&pid=ImgDetMain', 'description' => 'Healthcare tailored for children and infants.'],
        ['name' => 'Dermatology', 'image' => 'https://www.nccpa.net/wp-content/uploads/2022/03/shutterstock_625301408.jpg', 'description' => 'Skin, hair, and nail treatment solutions.'],
        ['name' => 'Oncology', 'image' => 'https://th.bing.com/th/id/OIP.ltfNltFBGV21XxzgZuDbsgHaE8?w=1000&h=667&rs=1&pid=ImgDetMain', 'description' => 'Focuses on the diagnosis and treatment of cancer.'],
        ['name' => 'Ophthalmology', 'image' => 'https://th.bing.com/th/id/R.3cb7a106f02a04e3dff40f61ee317329?rik=3HaGAdZB%2bEYJzw&pid=ImgRaw&r=0', 'description' => 'Deals with eye and vision care.'],
        ['name' => 'Endocrinology', 'image' => 'https://eunamed.com/wp-content/uploads/2021/02/portada-endocrino-scaled.jpg', 'description' => 'Focuses on hormonal and metabolic disorders'],
        ['name' => 'Gastroenterology', 'image' => 'https://assets-global.website-files.com/6265a955fd624c60a9c38baa/6298637e70be9df472603e4a_stomach.jpeg', 'description' => 'Specializes in digestive system disorders'],
        ['name' => 'Urology', 'image' => 'https://amarhospital.com/wp-content/uploads/2020/06/urology.jpg', 'description' => 'Deals with the urinary tract and male reproductive system.'],
    ] as $card)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 hover-elevate-up clinic-card" data-specialty="{{ $card['name'] }}">
            <div class="position-relative">
                <img class="card-img-top" src="{{ $card['image'] }}" alt="{{ $card['name'] }}" style="height: 200px; object-fit: cover;">
                <div class="card-img-overlay d-flex align-items-end bg-dark bg-opacity-25">
                    <h5 class="card-title text-white mb-0">{{ $card['name'] }}</h5>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text text-muted">{{ $card['description'] }}</p>
                <button class="btn btn-primary w-100 choose-clinic">
                    <i class="ti ti-calendar-plus me-2"></i>Book Now
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Doctors Section (Hidden by Default) -->
<div class="row mb-12 g-6 d-none" id="doctors-section">
  <div class="col-12">
    <h3>Select a Doctor</h3>
    <div id="doctors-list" class="row g-3"></div>
    <button class="btn btn-secondary mt-3" id="back-to-clinics">Back to Clinics</button>
  </div>
  <div class="card-body">
    <a href="/home" class="btn btn-secondary mt-3">Back to Main Dashboard</a>
       </div>
</div>

<!-- Popup Modal for Appointment Scheduling -->
<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="appointmentModalLabel">Schedule Appointment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="appointmentForm">
          <div class="mb-3">
            <label for="patientName" class="form-label">Patient Name</label>
            <input type="text" class="form-control" id="patientName" value="{{ auth()->user()->name }}" >
          </div>
          <div class="mb-3">
            <label for="patientEmail" class="form-label">Patient Email
              </label>
            <input type="email" class="form-control" id="patientEmail" value="{{ auth()->user()->email }}" >
          </div>
          <div class="mb-3">
            <label for="patientPhone" class="form-label">Patient Phone (Optional)</label>
            <input type="tel" class="form-control" id="patientPhone" value="{{ auth()->user()->phone }}" >
          </div>
          <div class="mb-3">
            <label for="appointmentDate" class="form-label">Appointment Date</label>
            <input type="date" class="form-control" id="appointmentDate" min="{{ date('Y-m-d') }}" required>
          </div>
          <div class="mb-3 d-none" id="timeSelection">
            <label class="form-label">Select Time Slot</label>
            <div class="row" id="timeSlots">
              <!-- Time slots will be dynamically inserted here -->
            </div>
          </div>
          <div class="mb-3">
            <span class="badge bg-success">Available</span>
            <span class="badge bg-danger">Unavailable</span>
        </div>

        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="confirmAppointment">Confirm Appointment</button>
      </div>
    </div>
  </div>
</div>

<!-- Symptoms Modal -->
<div class="modal fade" id="symptomsModal" tabindex="-1" aria-labelledby="symptomsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="symptomsModalLabel">Fill in Your Symptoms</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="symptomsForm">
          <div class="mb-3">
            <label for="symptoms" class="form-label">Symptoms</label>
            <textarea class="form-control" id="symptoms" rows="4" required></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submitSymptoms">Submit Symptoms</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const clinicCards = document.getElementById('clinic-cards');
    const doctorsSection = document.getElementById('doctors-section');
    const doctorsList = document.getElementById('doctors-list');
    const backToClinicsBtn = document.getElementById('back-to-clinics');
    const symptomsModal = new bootstrap.Modal(document.getElementById('symptomsModal'), {
        backdrop: true,
        keyboard: true,
        focus: true
    });
    const appointmentModal = new bootstrap.Modal(document.getElementById('appointmentModal'), {
        backdrop: true,
        keyboard: true,
        focus: true
    });
    const appointmentDateInput = document.getElementById('appointmentDate');
    const timeSelection = document.getElementById('timeSelection');
    const timeSlots = document.getElementById('timeSlots');
    const confirmAppointmentBtn = document.getElementById('confirmAppointment');
    const submitSymptomsBtn = document.getElementById('submitSymptoms');
    const symptomsTextarea = document.getElementById('symptoms');

    let selectedDoctorId;
    let selectedDate;
    let selectedTime;
    let symptoms;

    // Handle date input change
    appointmentDateInput.addEventListener('change', async function () {
        selectedDate = this.value;
        if (selectedDate) {
            await generateTimeSlots();
            timeSelection.classList.remove('d-none');
        } else {
            timeSelection.classList.add('d-none');
        }
    });

    // Generate time slots from 9 AM to 5 PM in 15-minute intervals
    async function generateTimeSlots() {
        const response = await fetch(`/appointment/timeslots/${selectedDoctorId}/${selectedDate}`);
        const slots = await response.json();
        timeSlots.innerHTML = ''; // Clear previous slots

        slots.forEach(slot => {
            const timeSlot = document.createElement('div');
            timeSlot.className = 'col-md-3 mb-3';
            timeSlot.innerHTML = `
                <button class="btn w-100 time-slot ${slot.isOccupied ? 'btn-danger disabled' : 'btn-light'}" data-time="${slot.time}" ${slot.isOccupied ? 'disabled' : ''}>
                    ${slot.time}
                </button>
            `;
            timeSlots.appendChild(timeSlot);
        });

        // Handle time slot selection
        timeSlots.querySelectorAll('.time-slot').forEach(button => {
            button.addEventListener('click', async function (e) {
                e.preventDefault(); // Prevent form submission
                // Remove selected class from all time slots
                document.querySelectorAll('.time-slot').forEach(btn => {
                    btn.classList.remove('selected', 'btn-success');
                    btn.classList.add('btn-light');
                });
                // Add selected class to this time slot
                this.classList.add('selected');
                selectedTime = this.dataset.time;

                // Check if the selected time slot is still available
                const availabilityResponse = await fetch(`/appointment/check-availability`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        doctor_id: selectedDoctorId,
                        appointment_date: selectedDate,
                        start_time: selectedTime,
                    }),
                });

                const availabilityResult = await availabilityResponse.json();

                if (availabilityResult.available) {
                    this.classList.remove('btn-light');
                    this.classList.add('btn-success');
                } else {
                    this.classList.remove('btn-light');
                    this.classList.add('btn-danger');
                }
            });
        });
    }

    // Handle clinic card click
    clinicCards.addEventListener('click', async (e) => {
        if (e.target.classList.contains('choose-clinic')) {
            const specialty = e.target.closest('.clinic-card').dataset.specialty;

            // Fetch doctors for the selected specialty
            const response = await fetch(`/appointment/doctors/${specialty}`);
            const doctors = await response.json();

            // Hide clinic cards and show doctors section
            clinicCards.classList.add('d-none');
            doctorsSection.classList.remove('d-none');

            // Render doctors
            doctorsList.innerHTML = doctors.map(doctor => `
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 doctor-card" data-doctor-id="${doctor.id}">
                        <div class="card-body">
                            <h5 class="card-title">${doctor.name}</h5>
                            <p class="card-text"><strong>Specialization:</strong> ${doctor.specialization}</p>
                            <p class="card-text"><strong>Email:</strong> ${doctor.email}</p>
                            <p class="card-text"><strong>Phone:</strong> ${doctor.phone}</p>
                            <button class="btn btn-outline-primary choose-doctor">Choose Doctor</button>
                        </div>
                    </div>
                </div>
            `).join('');
        }
    });

    // Handle back to clinics button
    backToClinicsBtn.addEventListener('click', () => {
        doctorsSection.classList.add('d-none');
        clinicCards.classList.remove('d-none');
    });

    // Handle doctor card click
    doctorsList.addEventListener('click', async (e) => {
        if (e.target.classList.contains('choose-doctor')) {
            selectedDoctorId = e.target.closest('.doctor-card').dataset.doctorId;

            // Reset the modal state
            timeSelection.classList.add('d-none');
            appointmentDateInput.value = '';
            selectedDate = null;
            selectedTime = null;

            // Show the symptoms modal
            symptomsModal.show();
        }
    });

    // Handle submit symptoms button
    submitSymptomsBtn.addEventListener('click', () => {
        symptoms = symptomsTextarea.value.trim();
        if (!symptoms) {
            alert('Please fill in your symptoms.');
            return;
        }

        // Hide the symptoms modal and show the appointment modal
        symptomsModal.hide();
        appointmentModal.show();
    });

    // Handle confirm appointment button
    confirmAppointmentBtn.addEventListener('click', async () => {
        const patientName = document.getElementById('patientName').value;
        const patientEmail = document.getElementById('patientEmail').value;
        const patientPhone = document.getElementById('patientPhone').value;

        if (!patientName || !patientEmail || !selectedDate || !selectedTime || !symptoms) {
            alert('Please fill in all required fields and select a valid date and time.');
            return;
        }

        const appointmentData = {
            doctor_id: selectedDoctorId,
            patient_name: patientName,
            patient_email: patientEmail,
            patient_phone: patientPhone || null,
            appointment_date: selectedDate,
            start_time: selectedTime,
            symptoms: symptoms,
        };

        try {
            const response = await fetch('/appointment/book', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(appointmentData),
            });

            const result = await response.json();

            if (response.ok) {
                // Hide the modal and show a pending payment message
                appointmentModal.hide();

                const paymentMessage = document.createElement('div');
                paymentMessage.classList.add('alert', 'alert-warning', 'mt-3');
                paymentMessage.innerHTML = `
                    <strong>Appointment Pending!</strong> Please complete your payment to confirm your appointment.
                    <br>
                    <a href="/payment?appointment_id=${result.appointment.id}" class="btn btn-primary mt-2">Proceed to Payment</a>
                `;

                // Insert message into the page (adjust according to your layout)
                document.getElementById('clinic-cards').insertAdjacentElement('beforebegin', paymentMessage);
            } else {
                // Find the selected time slot button and update its class to btn-danger
                const selectedButton = document.querySelector(`.time-slot[data-time="${selectedTime}"]`);
                if (selectedButton) {
                    selectedButton.classList.remove('btn-success');
                    selectedButton.classList.add('btn-danger');
                }
                alert('That time is already booked, please choose another time.');
            }
        } catch (error) {
            console.error('Error booking appointment:', error);
            // Find the selected time slot button and update its class to btn-danger
            const selectedButton = document.querySelector(`.time-slot[data-time="${selectedTime}"]`);
            if (selectedButton) {
                selectedButton.classList.remove('btn-success');
                selectedButton.classList.add('btn-danger');
            }
            alert('An error occurred. Please try again.');
        }
    });
});
</script>
@endsection

@section('styles')
<style>
    /* Enhanced Card Styling */
    .hover-elevate-up {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        overflow: hidden;
    }

    .hover-elevate-up:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    /* Time Slot Styling */
    .time-slot {
        padding: 12px;
        border-radius: 8px;
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .time-slot:not(.disabled):hover {
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* Doctor Cards */
    .doctor-card {
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .doctor-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(115, 103, 240, 0.15);
    }

    /* Modal Enhancements */
    .modal-content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    /* Status Badges */
    .badge {
        padding: 8px 12px;
        font-weight: 500;
        border-radius: 6px;
    }

    /* Existing styles */
    #timeSlots .time-slot {
        padding: 10px;
        font-size: 14px;
        text-align: center;
    }

    #timeSlots .time-slot:hover {
        background-color: #007bff;
        color: #fff;
    }

    #timeSlots .time-slot.selected {
        background-color: #007bff;
        color: #fff;
    }

    /* Modal centering styles */
    .modal-dialog {
        display: flex;
        align-items: center;
        min-height: calc(100% - 1rem);
    }

    .modal {
        display: flex !important;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        margin: 0 auto;
    }

    /* New styles for doctors list */
    #doctors-list .col-md-6.col-lg-4 {
        margin-bottom: 1rem; /* Adds vertical space between rows of cards */
    }

    #doctors-list .doctor-card {
        margin-bottom: 1rem; /* Adds additional space if needed */
    }

    /* Add vertical gap above the doctors list */
    #doctors-section {
        padding-top: 2rem; /* Adds space above the entire doctors section */
    }

    #doctors-list {
        row-gap: 1.5rem; /* Creates vertical gaps between rows of cards */
        column-gap: 1rem; /* Optional: adds horizontal spacing between columns */
    }

    /* Chatbot styles */
    .chatbot-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 300px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        z-index: 1000;
    }
    .chatbot-header {
        background: #7367F0;
        color: #fff;
        padding: 10px;
        text-align: center;
    }
    .chatbot-body {
        height: 300px;
        overflow-y: auto;
        padding: 10px;
    }
    .chatbot-footer {
        display: flex;
        padding: 10px;
        border-top: 1px solid #ddd;
    }
    #chatbotInput {
        flex: 1;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    #chatbotSend {
        margin-left: 10px;
    }
</style>
@endsection
