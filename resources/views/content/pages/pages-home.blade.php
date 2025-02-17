@extends('layouts/layoutMaster')

@section('title', 'Patient Dashboard')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
<div></div>
<div class="row mb-12 g-6">
  <div class="col-md-6 col-lg-4">
    <div class="card h-100">
<img class="card-img-top" src="https://th.bing.com/th/id/R.0754e8acc8723455c10d45bed40f3ba9?rik=o4jgkcjXqc8Ukg&pid=ImgRaw&r=0&sres=1&sresct=1" alt="Card image cap" />
      <div class="card-body">
        <h5 class="card-title">Make Appointment !</h5>
        <p class="card-text">
          This section contains all the details about the patient's upcoming appointment. It includes the doctor’s name, the scheduled time, the reason for the visit, and any pre-appointment instructions that the patient needs to follow..
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
      <!-- Left Side -->
      <div>
        <h5 class="fw-bold">Pharmacy</h5>
        <p>Get your medicine and all your pharmacy needs.</p>
        <a href="javascript:void(0)" class="btn btn-outline-light px-4 py-2">Place order</a>
      </div>

      <!-- Right Side Image -->
      <div>
        <img src="your-image-url.png" alt="Pharmacy Items" style="height: 100px;">
      </div>
    </div>
  </div>
</div>






<div class="col-md">
  <div class="card shadow-none bg-success-">
    <div class="card-body text-success">

      <h5 class="card-title text-success">Success card title</h5>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Project</th>
              <th>Client</th>
              <th>Users</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><i class="ti ti-brand-angular ti-md text-danger me-3"></i> <span class="fw-medium">Angular Project</span></td>
              <td>Albert Cook</td>
              <td>
                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Lilian Fuller">
                    <img src="assets/img/avatars/5.png" alt="Avatar" class="rounded-circle">
                  </li>
                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                    <img src="assets/img/avatars/6.png" alt="Avatar" class="rounded-circle">
                  </li>
                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Christina Parker">
                    <img src="assets/img/avatars/7.png" alt="Avatar" class="rounded-circle">
                  </li>
                </ul>
              </td>
              <td><span class="badge bg-label-primary me-1">Active</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-pencil me-1"></i>Edit</a>
                    <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-trash me-1"></i>Delete</a>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td><i class="ti ti-brand-react-native ti-md text-info me-3"></i> <span class="fw-medium">React Project</span></td>
              <td>Barry Hunter</td>
              <td>
                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Lilian Fuller">
                    <img src="assets/img/avatars/5.png" alt="Avatar" class="rounded-circle">
                  </li>
                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                    <img src="assets/img/avatars/6.png" alt="Avatar" class="rounded-circle">
                  </li>
                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Christina Parker">
                    <img src="assets/img/avatars/7.png" alt="Avatar" class="rounded-circle">
                  </li>
                </ul>
              </td>
              <td><span class="badge bg-label-success me-1">Act</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-pencil me-1"></i>Edit</a>
                    <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-trash me-1"></i>Delete</a>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td><i class="ti ti-brand-vue ti-md text-success me-3"></i> <span class="fw-medium">VueJs Project</span></td>
              <td>Trevor Baker</td>
              <td>
                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Lilian Fuller">
                    <img src="assets/img/avatars/5.png" alt="Avatar" class="rounded-circle">
                  </li>
                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                    <img src="assets/img/avatars/6.png" alt="Avatar" class="rounded-circle">
                  </li>
                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Christina Parker">
                    <img src="assets/img/avatars/7.png" alt="Avatar" class="rounded-circle">
                  </li>
                </ul>
              </td>
              <td><span class="badge bg-label-info me-1">Scheduled</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-pencil me-1"></i>Edit</a>
                    <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-trash me-1"></i>Delete</a>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td><i class="ti ti-brand-bootstrap ti-md text-primary me-3"></i> <span class="fw-medium">Bootstrap Project</span></td>
              <td>Jerry Milton</td>
              <td>
                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Lilian Fuller">
                    <img src="assets/img/avatars/5.png" alt="Avatar" class="rounded-circle">
                  </li>
                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Sophia Wilkerson">
                    <img src="assets/img/avatars/6.png" alt="Avatar" class="rounded-circle">
                  </li>
                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Christina Parker">
                    <img src="assets/img/avatars/7.png" alt="Avatar" class="rounded-circle">
                  </li>
                </ul>
              </td>
              <td><span class="badge bg-label-warning me-1">Pending</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-pencil me-1"></i>Edit</a>
                    <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-trash me-1"></i>Delete</a>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="card-text">
        Some quick example text to build on the card title and make up the bulk of the card's content.
      </p>
    </div>
  </div>
</div>


<!-- Text alignment -->


@endsection
