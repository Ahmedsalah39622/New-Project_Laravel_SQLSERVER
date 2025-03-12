@extends('layouts/layoutMaster')

@section('title', 'Appointment Page')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@vite('resources/assets/vendor/libs/fullcalendar/fullcalendar.js')
@vite('resources/assets/vendor/libs/fullcalendar/fullcalendar.css')
@vite('resources/assets/vendor/libs/flatpickr/flatpickr.js')
@vite('resources/assets/vendor/libs/flatpickr/flatpickr.css')
@endsection

@section('content')

<!-- Clinic Cards Section -->
<div class="row mb-12 g-6" id="clinic-cards">
  @foreach ([
      ['name' => 'Cardiology', 'image' => 'https://www.hawaiipacifichealth.org/media/3922/what-is-a-cardiologist-web.jpg', 'description' => 'Expert heart care and cardiovascular treatments.'],
      ['name' => 'Dentistry', 'image' => 'https://th.bing.com/th/id/OIP.FDv4CjYHYwDIfKollMEGwwHaE8?rs=1&pid=ImgDetMain', 'description' => 'Comprehensive dental services for all ages.'],
      ['name' => 'Neurology', 'image' => 'https://th.bing.com/th/id/OIP.G8GkePvKtmQ87SY1dmisIQHaE7?w=626&h=417&rs=1&pid=ImgDetMain', 'description' => 'Advanced brain and nervous system care.'],
      ['name' => 'Orthopedics', 'image' => 'https://res.cloudinary.com/lowellgeneral/image/upload/c_fill,w_auto,g_faces,q_auto,dpr_auto,f_auto/orthopedic-center1_BFAFBDC0-FC11-11E9-92C400218628D024.jpg', 'description' => 'Bone and joint health specialists.'],
      ['name' => 'Pediatrics', 'image' => 'https://th.bing.com/th/id/R.3ad22fe95e70c998264acaf1d471d668?rik=DohY9CkyOVlH2w&pid=ImgRaw&r=0', 'description' => 'Healthcare tailored for children and infants.'],
      ['name' => 'Dermatology', 'image' => 'https://www.nccpa.net/wp-content/uploads/2022/03/shutterstock_625301408.jpg', 'description' => 'Skin, hair, and nail treatment solutions.'],
      ['name' => 'Oncology', 'image' => 'https://th.bing.com/th/id/OIP.ltfNltFBGV21XxzgZuDbsgHaE8?w=1000&h=667&rs=1&pid=ImgDetMain', 'description' => 'Focuses on the diagnosis and treatment of cancer.'],
      ['name' => 'Ophthalmology', 'image' => 'https://th.bing.com/th/id/R.3cb7a106f02a04e3dff40f61ee317329?rik=3HaGAdZB%2bEYJzw&pid=ImgRaw&r=0', 'description' => 'Deals with eye and vision care.'],
      ['name' => 'Endocrinology', 'image' => 'https://eunamed.com/wp-content/uploads/2021/02/portada-endocrino-scaled.jpg', 'description' => 'Focuses on hormonal and metabolic disorders'],
      ['name' => 'Gastroenterology', 'image' => 'https://gastroliversc.com.sg/wp-content/uploads/2022/09/gastro-home-page-image-2-3.jpg', 'description' => 'Specializes in digestive system disorders'],
      ['name' => 'Urology', 'image' => 'https://amarhospital.com/wp-content/uploads/2020/06/urology.jpg', 'description' => 'Deals with the urinary tract and male reproductive system.'],
  ] as $card)
    <div class="col-md-6 col-lg-4">
      <div class="card h-100 clinic-card" data-specialty="{{ $card['name'] }}">
        <img class="document.addEventListener-img-top" src="{{ $card['image'] }}" alt="{{ $card['name'] }}">
        <div class="card-body">
          <h5 class="card-title">{{ $card['name'] }}</h5>
          <p class="card-text">{{ $card['description'] }}</p>
          <button class="btn btn-outline-primary choose-clinic">Choose Clinic</button>
        </div>
      </div>
    </div>
  @endforeach
</div>

<!-- Doctors Section (Hidden by Default) -->
<div class="row mb-12 g-6 d-none" id="doctors-section">
  <div class="col-12">
    <h3>Select a Doctor</h3>
    <div id="doctors-list" class="row"></div>
    <button class="btn btn-secondary mt-3" id="back-to-clinics">Back to Clinics</button>

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
            <input type="text" class="form-control" id="patientName" value="{{ auth()->user()->name }}" readonly>
          </div>
          <div class="mb-3">
            <label for="patientEmail" class="form-label">Patient Email</label>
            <input type="email" class="form-control" id="patientEmail" value="{{ auth()->user()->email }}" readonly>
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
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="confirmAppointment">Confirm Appointment</button>
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
    const appointmentModal = new bootstrap.Modal(document.getElementById('appointmentModal'), {
        backdrop: true,
        keyboard: true,
        focus: true
    });
    const appointmentDateInput = document.getElementById('appointmentDate');
    const timeSelection = document.getElementById('timeSelection');
    const timeSlots = document.getElementById('timeSlots');
    const confirmAppointmentBtn = document.getElementById('confirmAppointment');

    let selectedDoctorId;
    let selectedDate;
    let selectedTime;

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
                <button class="btn w-100 time-slot ${slot.isOccupied ? 'btn-danger' : 'btn-light'}" data-time="${slot.time}" ${slot.isOccupied ? 'disabled' : ''}>
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
                  //  alert('The selected time slot is already occupied. Please choose another time slot.');
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

            // Show the appointment modal
            appointmentModal.show();
        }
    });

    // Handle confirm appointment button
    confirmAppointmentBtn.addEventListener('click', async () => {
        const patientName = document.getElementById('patientName').value;
        const patientEmail = document.getElementById('patientEmail').value;
        const patientPhone = document.getElementById('patientPhone').value;

        if (!patientName || !patientEmail || !selectedDate || !selectedTime) {
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
                alert('Failed to book appointment. Please try again.');
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
  <style>
  /* Previous existing styles */

  /* Add vertical gap above the doctors list */
  #doctors-section {
    padding-top: 2rem; /* Adds space above the entire doctors section */
  }

  #doctors-list {
    row-gap: 1.5rem; /* Creates vertical gaps between rows of cards */
    column-gap: 1rem; /* Optional: adds horizontal spacing between columns */
  }
</style>
</style>
@endsection
