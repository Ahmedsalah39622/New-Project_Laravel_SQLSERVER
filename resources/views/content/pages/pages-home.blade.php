@extends('layouts/layoutMaster')

@section('title', 'Patient Dashboard')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')

<div class="row mb-12 g-6">
  <!-- Appointment Booking Card -->
  <div class="col-md-6 col-lg-4">
    <div class="card h-100">
      <img class="card-img-top" src="https://th.bing.com/th/id/R.0754e8acc8723455c10d45bed40f3ba9?rik=o4jgkcjXqc8Ukg&pid=ImgRaw&r=0&sres=1&sresct=1" alt="Card image cap" />
      <div class="card-body">
        <h5 class="card-title">Make an Appointment!</h5>
        <p class="card-text">
          Book your upcoming appointment, select a doctor, and get the best care. You can also view past appointment details.
        </p>
        <a href="/appointment" class="btn btn-outline-primary">Book an appointment</a>
      </div>
    </div>
  </div>

  <!-- Pharmacy Card -->
  <div class="col-md-6 col-lg-6">
    <div class="card text-white p-4" style="
      background-color: #1E73BE;
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: space-between;
      height: 150px;
      border-radius: 10px;
    ">
      <div>
        <h5 class="fw-bold">Pharmacy</h5>
        <p>Get your medicine and all your pharmacy needs.</p>
        <a href="{{ route('pharmacy') }}" class="btn btn-outline-primary">Visit Pharmacy</a>
      </div>
      <div>
        <img src="your-image-url.png" alt="Pharmacy Items" style="height: 100px;">
      </div>
    </div>
  </div>
</div>

<!-- Appointment History Section -->
<div class="col-md mt-4">
  <div class="card shadow-none">
    <div class="card-body">

      <h5 class="card-title text-primary">Appointment History</h5>
      <div class="table-responsive">
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
                    <span class="badge
                      @if($appointment->status == 'confirmed') bg-success
                      @elseif($appointment->status == 'cancelled') bg-danger
                      @else bg-warning
                      @endif">
                      {{ ucfirst($appointment->status) }}
                    </span>
                  </td>
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

      <p class="card-text text-muted">
        You can manage your past and upcoming appointments here.
      </p>
    </div>
  </div>
</div>

@endsection

@section('page-script')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Handle "View Details" and "Cancel" actions
    document.getElementById('appointmentsTable').addEventListener('click', async (e) => {
        if (e.target.classList.contains('view-details')) {
            const appointmentId = e.target.closest('tr').dataset.appointmentId;
            // Fetch and display appointment details
            const response = await fetch(`/appointment/details/${appointmentId}`);
            const appointment = await response.json();
            alert(`Appointment Details:\n\nPatient: ${appointment.patient_name}\nDate: ${appointment.appointment_date}\nTime: ${appointment.start_time}\nStatus: ${appointment.status}`);
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
                    throw new Error('Failed to fetch treatment plan.');
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
