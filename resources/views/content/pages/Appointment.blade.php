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

<!-- Calendar Section (Hidden by Default) -->
<div class="row mb-12 g-6 d-none" id="calendar-section">
  <div class="col-12">
    <h3>Select a Date and Time</h3>
    <div id="calendar"></div>
    <button class="btn btn-secondary mt-3" id="back-to-doctors">Back to Doctors</button>
  </div>
</div>

<!-- Appointment Booking Section -->

@endsection

@section('page-script')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const clinicCards = document.getElementById('clinic-cards');
    const doctorsSection = document.getElementById('doctors-section');
    const calendarSection = document.getElementById('calendar-section');
    const doctorsList = document.getElementById('doctors-list');
    const backToClinicsBtn = document.getElementById('back-to-clinics');
    const backToDoctorsBtn = document.getElementById('back-to-doctors');

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
    doctorsList.addEventListener('click', (e) => {
      if (e.target.classList.contains('choose-doctor')) {
        const doctorId = e.target.closest('.doctor-card').dataset.doctorId;

        // Hide doctors section and show calendar section
        doctorsSection.classList.add('d-none');
        calendarSection.classList.remove('d-none');

        // Initialize calendar (you can use a library like FullCalendar)
        // Example: Initialize FullCalendar here
      }
    });

    // Handle back to doctors button
    backToDoctorsBtn.addEventListener('click', () => {
      calendarSection.classList.add('d-none');
      doctorsSection.classList.remove('d-none');
    });
  });
</script>
@endsection
