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
        <a href="javascript:void(0)" class="btn btn-outline-light px-4 py-2">Place Order</a>
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
        <table class="table table-bordered">
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
                <tr>
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
                        <a href="{{ route('appointments.show', $appointment->id) }}">View Details</a>

                        <a class="dropdown-item" href="{{ route('appointment.cancel', $appointment->id) }}">
                          <i class="ti ti-trash me-1"></i> Cancel
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
