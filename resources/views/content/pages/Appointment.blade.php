@extends('layouts/layoutMaster')

@section('title', 'Appointment Page')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
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
        <img class="card-img-top" src="{{ $card['image'] }}" alt="{{ $card['name'] }}">
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

<!-- Available Time Slots Section (Hidden by Default) -->
<div class="row mb-12 g-6 d-none" id="time-slots-section">
  <div class="col-12">
    <h3>Available Time Slots</h3>
    <table class="table table-bordered table-lg">
      <thead>
        <tr>
          <th>Date</th>
          <th>Time Slot</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="time-slots-list">
        <!-- Time slots will be dynamically inserted here -->
      </tbody>
    </table>
    <button class="btn btn-secondary mt-3" id="back-to-doctors">Back to Doctors</button>
  </div>
</div>
@endsection

@section('page-script')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const clinicCards = document.getElementById('clinic-cards');
    const doctorsSection = document.getElementById('doctors-section');
    const timeSlotsSection = document.getElementById('time-slots-section');
    const doctorsList = document.getElementById('doctors-list');
    const timeSlotsList = document.getElementById('time-slots-list');
    const backToClinicsBtn = document.getElementById('back-to-clinics');
    const backToDoctorsBtn = document.getElementById('back-to-doctors');

    let selectedDoctorId;

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

        // Fetch available time slots for the selected doctor
        const response = await fetch(`/appointment/doctors/${selectedDoctorId}/time-slots`);
        const timeSlots = await response.json();

        // Hide doctors section and show time slots section
        doctorsSection.classList.add('d-none');
        timeSlotsSection.classList.remove('d-none');

        // Render time slots
        timeSlotsList.innerHTML = timeSlots.map(slot => `
          <tr>
            <td>${slot.date}</td>
            <td>${slot.start_time} - ${slot.end_time}</td>
            <td>
              <button class="btn btn-outline-primary book-slot" data-slot-id="${slot.id}">Book</button>
            </td>
          </tr>
        `).join('');
      }
    });

    // Handle back to doctors button
    backToDoctorsBtn.addEventListener('click', () => {
      timeSlotsSection.classList.add('d-none');
      doctorsSection.classList.remove('d-none');
    });

    // Handle booking a time slot
    timeSlotsList.addEventListener('click', async (e) => {
      if (e.target.classList.contains('book-slot')) {
        const slotId = e.target.dataset.slotId;
        const slotRow = e.target.closest('tr');
        const slotDate = slotRow.querySelector('td:nth-child(1)').textContent;
        const slotTime = slotRow.querySelector('td:nth-child(2)').textContent;
        const [startTime, endTime] = slotTime.split(' - ');

        // Collect patient details using prompts
        const patientName = prompt('Enter your name:');
        const patientEmail = prompt('Enter your email:');
        const patientPhone = prompt('Enter your phone number (optional):');

        // Validate patient details
        if (patientName && patientEmail) {
          // Prepare the appointment data
          const appointmentData = {
            doctor_id: selectedDoctorId,
            patient_name: patientName,
            patient_email: patientEmail,
            patient_phone: patientPhone || null,
            appointment_date: slotDate,
            start_time: startTime,
            end_time: endTime,
          };

          try {
            // Send the appointment data to the backend
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
              // Show success message
              alert('Appointment booked successfully!');

              // Mark the time slot as booked in the UI
              slotRow.classList.add('booked');
              e.target.disabled = true;
              e.target.textContent = 'Booked';
            } else {
              // Show error message
              alert('Failed to book appointment. Please try again.');
            }
          } catch (error) {
            console.error('Error booking appointment:', error);
            alert('An error occurred. Please try again.');
          }
        } else {
          // Show validation error
          alert('Name and email are required to book an appointment.');
        }
      }
    });
  });
</script>


@endsection

@section('styles')
<style>
  /* Make the table larger and more accessible */
  .table-lg {
    font-size: 18px;
    width: 100%;
    border-collapse: collapse;
  }

  .table-lg th,
  .table-lg td {
    padding: 15px;
    text-align: center;
  }

  .table-lg th {
    background-color: #f8f9fa;
    font-weight: bold;
    color: #495057;
  }

  .table-lg td {
    background-color: #ffffff;
    color: #495057;
  }

  .table-lg tbody tr:hover {
    background-color: #e9ecef;
  }

  /* Button styling inside the table */
  .table-lg .btn-outline-primary {
    padding: 10px 20px;
    font-size: 16px;
    width: 100%;
  }

  .table-lg .btn-outline-primary:hover {
    background-color: #007bff;
    color: #fff;
  }

  /* Make the table more visually appealing */
  .table-lg td,
  .table-lg th {
    vertical-align: middle;
  }

  /* Responsive design to adjust the table size on smaller screens */
  @media (max-width: 768px) {
    .table-lg {
      font-size: 16px;
    }

    .table-lg th,
    .table-lg td {
      padding: 12px;
    }

    .table-lg .btn-outline-primary {
      font-size: 14px;
      padding: 8px 15px;
    }
  }
</style>
@endsection
