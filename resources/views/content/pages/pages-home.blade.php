@extends('layouts/layoutMaster')

@section('title', 'Patient Dashboard')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
<!-- Examples -->
<div class="row mb-12 g-6">
  <!-- Make Appointment Card -->
  <div class="col-md-6 col-lg-6">
    <div class="card h-100">
      <img class="card-img-top" src="{{url('https://th.bing.com/th/id/OIP.B1TorMhyNFXBDUW-1A87qQHaE8?rs=1&pid=ImgDetMain')}}" alt="Card image" />
      <div class="card-body">
        <h5 class="card-title">Make Appointment</h5>
        <p class="card-text">
          Some quick example text to build on the card title and make up the bulk of the card's content.
        </p>
        <a href="javascript:void(0)" class="btn btn-outline-primary">Make Appointment</a>
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

  <div class="col-md-6 col-lg-4">
    <div class="card text-center">
      <div class="card-body">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="javascript:void(0)" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-4">
    <div class="card text-end">
      <div class="card-body">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="javascript:void(0)" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
  </div>
</div>
<!--/ Text alignment -->

<!-- Navigation -->
<h5 class="pb-1 mb-6">Navigation</h5>
<div class="row mb-12 g-6">
  <div class="col-md-6">
    <div class="card text-center">
      <div class="card-header px-0 pt-0">
        <div class="nav-align-top">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-home" aria-controls="navs-tab-home" aria-selected="true">Home</button>
            </li>
            <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tab-profile" aria-controls="navs-tab-profile" aria-selected="false">Profile</button>
            </li>
            <li class="nav-item">
              <button type="button" class="nav-link disabled" data-bs-toggle="tab" role="tab" aria-selected="false">Disabled</button>
            </li>
          </ul>
        </div>
      </div>
      <div class="card-body">
        <div class="tab-content p-0">
          <div class="tab-pane fade show active" id="navs-tab-home" role="tabpanel">
            <h5 class="card-title">Special title treatment</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="javascript:void(0);" class="btn btn-primary">Go home</a>
          </div>
          <div class="tab-pane fade" id="navs-tab-profile" role="tabpanel">
            <h5 class="card-title">Special title treatment</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="javascript:void(0);" class="btn btn-primary">Go profile</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card text-center">
      <div class="card-header">
        <div class="nav-align-top">
          <ul class="nav nav-pills row-gap-2" role="tablist">
            <li class="nav-item">
              <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-tab-home" aria-controls="navs-pills-tab-home" aria-selected="true">Home</button>
            </li>
            <li class="nav-item">
              <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-tab-profile" aria-controls="navs-pills-tab-profile" aria-selected="false">Profile</button>
            </li>
            <li class="nav-item">
              <button type="button" class="nav-link disabled" role="tab" data-bs-toggle="tab" aria-selected="false">Disabled</button>
            </li>
          </ul>
        </div>
      </div>
      <div class="card-body">
        <div class="tab-content p-0">
          <div class="tab-pane fade show active" id="navs-pills-tab-home" role="tabpanel">
            <h5 class="card-title">Special title treatment</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="javascript:void(0);" class="btn btn-primary">Go home</a>
          </div>
          <div class="tab-pane fade" id="navs-pills-tab-profile" role="tabpanel">
            <h5 class="card-title">Special title treatment</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="javascript:void(0);" class="btn btn-primary">Go profile</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--/ Navigation -->

<!-- Images -->
<h5 class="pb-1 mb-6">Images caps & overlay</h5>
<div class="row mb-12 g-6">
  <div class="col-md-6 col-xl-4">
    <div class="card">
      <img class="card-img-top" src="{{asset('assets/img/elements/13.jpg')}}" alt="Card image cap" />
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">
          This is a wider card with supporting text below as a natural lead-in to additional content. This content is a
          little bit longer.
        </p>
        <p class="card-text">
          <small class="text-muted">Last updated 3 mins ago</small>
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">
          This is a wider card with supporting text below as a natural lead-in to additional content. This content is a
          little bit longer.
        </p>
        <p class="card-text">
          <small class="text-muted">Last updated 3 mins ago</small>
        </p>
      </div>
      <img class="card-img-bottom" src="{{asset('assets/img/elements/1.jpg')}}" alt="Card image cap" />
    </div>
  </div>
  <div class="col-md-6 col-xl-4">
    <div class="card bg-dark border-0 text-white">
      <img class="card-img" src="{{asset('assets/img/elements/8.jpg')}}" alt="Card image" />
      <div class="card-img-overlay">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">
          This is a wider card with supporting text below as a natural lead-in to additional content. This content is a
          little bit longer.
        </p>
        <p class="card-text">Last updated 3 mins ago</p>
      </div>
    </div>
  </div>
</div>
<!--/ Images -->

<!-- Horizontal -->
<h5 class="pb-1 mb-6">Horizontal</h5>
<div class="row mb-12 g-6">
  <div class="col-md">
    <div class="card">
      <div class="row g-0">
        <div class="col-md-4">
          <img class="card-img card-img-left" src="{{asset('assets/img/elements/9.jpg')}}" alt="Card image" />
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">
              This is a wider card with supporting text below as a natural lead-in to additional content. This content
              is a
              little bit longer.
            </p>
            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md">
    <div class="card">
      <div class="row g-0">
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">
              This is a wider card with supporting text below as a natural lead-in to additional content. This content
              is a
              little bit longer.
            </p>
            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
          </div>
        </div>
        <div class="col-md-4">
          <img class="card-img card-img-right" src="{{asset('assets/img/elements/12.jpg')}}" alt="Card image" />
        </div>
      </div>
    </div>
  </div>
</div>
<!--/ Horizontal -->

<!-- Style variation -->
<h5 class="pb-1 mb-4">Style variation</h5>
<h6 class="pb-1 mb-4 text-muted">Default(solid)</h6>
<div class="row g-6 mb-6">
  <div class="col-md-6 col-xl-4">
    <div class="card bg-primary text-white">
      <div class="card-body">
        <h5 class="card-title text-white">Primary card title</h5>
        <p class="card-text">
          Some quick example text to build on the card title and make up.
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-4">
    <div class="card bg-secondary text-white">
      <div class="card-body">
        <h5 class="card-title text-white">Secondary card title</h5>
        <p class="card-text">
          Some quick example text to build on the card title and make up.
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-4">
    <div class="card bg-success text-white">
      <div class="card-body">
        <h5 class="card-title text-white">Success card title</h5>
        <p class="card-text">
          Some quick example text to build on the card title and make up.
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-4">
    <div class="card bg-danger text-white">
      <div class="card-body">
        <h5 class="card-title text-white">Danger card title</h5>
        <p class="card-text">
          Some quick example text to build on the card title and make up.
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-4">
    <div class="card bg-warning text-white">
      <div class="card-body">
        <h5 class="card-title text-white">Warning card title</h5>
        <p class="card-text">
          Some quick example text to build on the card title and make up.
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-4">
    <div class="card bg-info text-white">
      <div class="card-body">
        <h5 class="card-title text-white">Info card title</h5>
        <p class="card-text">
          Some quick example text to build on the card title and make up.
        </p>
      </div>
    </div>
  </div>
</div>
<!-- Label -->
<h6 class="pb-1 mb-4 text-muted">Label</h6>
<div class="row g-6 mb-4">
  <div class="col-md-6 col-xl-4">
    <div class="card shadow-none bg-primary-subtle">
      <div class="card-body">
        <h5 class="card-title text-primary">Primary card title</h5>
        <p class="card-text text-primary">
          Some quick example text to build on the card title and make up.
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-4">
    <div class="card shadow-none bg-secondary-subtle">
      <div class="card-body">
        <h5 class="card-title text-secondary">Secondary card title</h5>
        <p class="card-text  text-secondary">
          Some quick example text to build on the card title and make up.
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-4">
    <div class="card shadow-none bg-success-subtle">
      <div class="card-body">
        <h5 class="card-title text-success">Success card title</h5>
        <p class="card-text text-success">
          Some quick example text to build on the card title and make up.
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-4">
    <div class="card shadow-none bg-danger-subtle">
      <div class="card-body">
        <h5 class="card-title text-danger">Danger card title</h5>
        <p class="card-text text-danger">
          Some quick example text to build on the card title and make up.
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-4">
    <div class="card shadow-none bg-warning-subtle">
      <div class="card-body">
        <h5 class="card-title text-warning">Warning card title</h5>
        <p class="card-text text-warning">
          Some quick example text to build on the card title and make up.
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-4">
    <div class="card shadow-none bg-info-subtle">
      <div class="card-body">
        <h5 class="card-title text-info">Info card title</h5>
        <p class="card-text text-info">
          Some quick example text to build on the card title and make up.
        </p>
      </div>
    </div>
  </div>
</div>
<!-- Outline -->
<h6 class="pb-1 mb-4 text-muted">Outline</h6>
<div class="row g-6">
  <div class="col-md-6 col-xl-4">
    <div class="card shadow-none bg-transparent border border-primary">
      <div class="card-body">
        <h5 class="card-title text-primary">Primary card title</h5>
        <p class="card-text text-primary">
          Some quick example text to build on the card title and make up.
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-4">
    <div class="card shadow-none bg-transparent border border-secondary">
      <div class="card-body">
        <h5 class="card-title text-secondary">Secondary card title</h5>
        <p class="card-text text-secondary">
          Some quick example text to build on the card title and make up.
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-4">
    <div class="card shadow-none bg-transparent border border-success">
      <div class="card-body">
        <h5 class="card-title text-success">Success card title</h5>
        <p class="card-text text-success">
          Some quick example text to build on the card title and make up.
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-4">
    <div class="card shadow-none bg-transparent border border-danger">
      <div class="card-body">
        <h5 class="card-title text-danger">Danger card title</h5>
        <p class="card-text text-danger">
          Some quick example text to build on the card title and make up.
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-4">
    <div class="card shadow-none bg-transparent border border-warning">
      <div class="card-body">
        <h5 class="card-title text-warning">Warning card title</h5>
        <p class="card-text text-warning">
          Some quick example text to build on the card title and make up.
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-4">
    <div class="card shadow-none bg-transparent border border-info">
      <div class="card-body">
        <h5 class="card-title text-info">Info card title</h5>
        <p class="card-text text-info">
          Some quick example text to build on the card title and make up.
        </p>
      </div>
    </div>
  </div>
</div>
<!--/ Style variation -->


<!-- Card layout -->
<h5 class="pb-1 my-12">Card layout</h5>

<!-- Card Groups -->
<h6 class="pb-1 mb-6 text-muted">Card Groups</h6>
<div class="card-group mb-12">
  <div class="card">
    <img class="card-img-top" src="{{asset('assets/img/elements/4.jpg')}}" alt="Card image cap" />
    <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <p class="card-text">
        This is a wider card with supporting text below as a natural lead-in to additional content. This content is a
        little
        bit longer.
      </p>
    </div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
  </div>
  <div class="card">
    <img class="card-img-top" src="{{asset('assets/img/elements/5.jpg')}}" alt="Card image cap" />
    <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
    </div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
  </div>
  <div class="card">
    <img class="card-img-top" src="{{asset('assets/img/elements/1.jpg')}}" alt="Card image cap" />
    <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <p class="card-text">
        This is a wider card with supporting text below as a natural lead-in to additional content. This card has even
        longer
        content than the first to show that equal height action.
      </p>
    </div>
    <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>
  </div>
</div>

<!-- Grid Card -->
<h6 class="pb-1 mb-6 text-muted">Grid Card</h6>
<div class="row row-cols-1 row-cols-md-3 g-6 mb-12">
  <div class="col">
    <div class="card h-100">
      <img class="card-img-top" src="{{asset('assets/img/elements/2.jpg')}}" alt="Card image cap" />
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card h-100">
      <img class="card-img-top" src="{{asset('assets/img/elements/10.jpg')}}" alt="Card image cap" />
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card h-100">
      <img class="card-img-top" src="{{asset('assets/img/elements/4.jpg')}}" alt="Card image cap" />
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card h-100">
      <img class="card-img-top" src="{{asset('assets/img/elements/13.jpg')}}" alt="Card image cap" />
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card h-100">
      <img class="card-img-top" src="{{asset('assets/img/elements/14.jpg')}}" alt="Card image cap" />
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card h-100">
      <img class="card-img-top" src="{{asset('assets/img/elements/15.jpg')}}" alt="Card image cap" />
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      </div>
    </div>
  </div>
</div>

<!-- Masonry -->
<h6 class="pb-1 mb-6 text-muted">Masonry</h6>
<div class="row g-6" data-masonry='{"percentPosition": true }'>
  <div class="col-sm-6 col-lg-4">
    <div class="card">
      <img class="card-img-top" src="{{asset('assets/img/elements/5.jpg')}}" alt="Card image cap" />
      <div class="card-body">
        <h5 class="card-title">Card title that wraps to a new line</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-4">
    <div class="card p-4">
      <figure class="p-4 mb-0">
        <blockquote class="blockquote">
          <p>A well-known quote, contained in a blockquote element.</p>
        </blockquote>
        <figcaption class="blockquote-footer mb-0 text-muted">
          Someone famous in <cite title="Source Title">Source Title</cite>
        </figcaption>
      </figure>
    </div>
  </div>
  <div class="col-sm-6 col-lg-4">
    <div class="card">
      <img class="card-img-top" src="{{asset('assets/img/elements/13.jpg')}}" alt="Card image cap" />
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-4">
    <div class="card bg-primary text-white text-center p-4">
      <figure class="mb-0">
        <blockquote class="blockquote">
          <p>A well-known quote, contained in a blockquote element.</p>
        </blockquote>
        <figcaption class="blockquote-footer mb-0 text-white">
          Someone famous in <cite title="Source Title">Source Title</cite>
        </figcaption>
      </figure>
    </div>
  </div>
  <div class="col-sm-6 col-lg-4">
    <div class="card text-center">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This card has a regular title and short paragraph of text below it.</p>
        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-4">
    <div class="card">
      <img class="card-img" src="{{asset('assets/img/elements/4.jpg')}}" alt="Card image cap" />
    </div>
  </div>
  <div class="col-sm-6 col-lg-4">
    <div class="card p-4 text-end">
      <figure class="mb-0">
        <blockquote class="blockquote">
          <p>A well-known quote, contained in a blockquote element.</p>
        </blockquote>
        <figcaption class="blockquote-footer mb-0 text-muted">
          Someone famous in <cite title="Source Title">Source Title</cite>
        </figcaption>
      </figure>
    </div>
  </div>
  <div class="col-sm-6 col-lg-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is another card with title and supporting text below. This card has some additional content to make it slightly taller overall.</p>
        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
      </div>
    </div>
  </div>
</div>
<!--/ Card layout -->
@endsection
