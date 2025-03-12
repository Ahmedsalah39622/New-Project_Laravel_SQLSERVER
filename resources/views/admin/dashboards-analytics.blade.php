@extends('layouts/layoutMaster')

@section('title', 'Dashboard - Hospital Management')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
  'resources/assets/vendor/libs/swiper/swiper.scss',
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss'
])
@endsection

@section('page-style')
<!-- Page -->
@vite(['resources/assets/vendor/scss/pages/cards-advance.scss'])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/apex-charts/apexcharts.js',
  'resources/assets/vendor/libs/swiper/swiper.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
])
@endsection

@section('page-script')
@vite([
  'resources/assets/js/dashboards-analytics.js'
])
@endsection

@section('content')

<div class="row g-6">
  <!-- Patient Flow Analytics -->
  <div class="col-lg-6">
    <div class="swiper-container swiper-container-horizontal swiper swiper-card-advance-bg" id="swiper-with-pagination-cards">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <div class="row">
            <div class="col-12">
              <h5 class="text-white mb-0">Patient Flow Analytics</h5>
              <small>Total 28.5% Admission Rate</small>
            </div>
            <div class="row">
              <div class="col-lg-7 col-md-9 col-12 order-2 order-md-1 pt-md-9">
                <h6 class="text-white mt-0 mt-md-3 mb-4">Patient Metrics</h6>
                <div class="row">
                  <div class="col-6">
                    <ul class="list-unstyled mb-0">
                      <li class="d-flex mb-4 align-items-center">
                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">1.2k</p>
                        <p class="mb-0">Total Patients</p>
                      </li>
                      <li class="d-flex align-items-center">
                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">45m</p>
                        <p class="mb-0">Avg. Wait Time</p>
                      </li>
                    </ul>
                  </div>
                  <div class="col-6">
                    <ul class="list-unstyled mb-0">
                      <li class="d-flex mb-4 align-items-center">
                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">980</p>
                        <p class="mb-0">Patients Treated</p>
                      </li>
                      <li class="d-flex align-items-center">
                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">120</p>
                        <p class="mb-0">Patients Admitted</p>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-lg-5 col-md-3 col-12 order-1 order-md-2 my-4 my-md-0 text-center">
                <img src="{{asset('assets/img/illustrations/card-patient-flow.png')}}" alt="Patient Flow Analytics" height="150" class="card-website-analytics-img">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
  <!--/ Patient Flow Analytics -->

  <!-- Average Daily Patients -->
  <div class="col-xl-3 col-sm-6">
    <div class="card h-100">
      <div class="card-header pb-0">
        <h5 class="mb-3 card-title">Average Daily Patients</h5>
        <p class="mb-0 text-body">Total Patients Today</p>
        <h4 class="mb-0">1,200</h4>
      </div>
      <div class="card-body px-0">
        <div id="averageDailyPatients"></div>
      </div>
    </div>
  </div>
  <!--/ Average Daily Patients -->

  <!-- Staff Performance Overview -->
  <div class="col-xl-3 col-sm-6">
    <div class="card h-100">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <p class="mb-0 text-body">Staff Performance Overview</p>
          <p class="card-text fw-medium text-success">+18.2%</p>
        </div>
        <h4 class="card-title mb-1">45 Staff On Duty</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-4">
            <div class="d-flex gap-2 align-items-center mb-2">
              <span class="badge bg-label-info p-1 rounded"><i class="ti ti-user ti-sm"></i></span>
              <p class="mb-0">On Duty</p>
            </div>
            <h5 class="mb-0 pt-1">45</h5>
            <small class="text-muted">Staff</small>
          </div>
          <div class="col-4">
            <div class="divider divider-vertical">
              <div class="divider-text">
                <span class="badge-divider-bg bg-label-secondary">VS</span>
              </div>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
              <p class="mb-0">Patients/Staff</p>
              <span class="badge bg-label-primary p-1 rounded"><i class="ti ti-users ti-sm"></i></span>
            </div>
            <h5 class="mb-0 pt-1">26.7</h5>
            <small class="text-muted">Avg.</small>
          </div>
        </div>
        <div class="d-flex align-items-center mt-6">
          <div class="progress w-100" style="height: 10px;">
            <div class="progress-bar bg-info" style="width: 70%" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar bg-primary" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Staff Performance Overview -->

  <!-- Resource Utilization Reports -->
  <div class="col-lg-6">
    <div class="card h-100">
      <div class="card-header pb-0 d-flex justify-content-between">
        <div class="card-title mb-0">
          <h5 class="mb-1">Resource Utilization Reports</h5>
          <p class="card-subtitle">Weekly Utilization Overview</p>
        </div>
        <div class="dropdown">
          <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1" type="button" id="resourceUtilizationReportsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti ti-dots-vertical ti-md text-muted"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="resourceUtilizationReportsId">
            <a class="dropdown-item" href="javascript:void(0);">View More</a>
            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row align-items-center g-md-8">
          <div class="col-12 col-md-5 d-flex flex-column">
            <div class="d-flex gap-2 align-items-center mb-3 flex-wrap">
              <h2 class="mb-0">85%</h2>
              <div class="badge rounded bg-label-success">+4.2%</div>
            </div>
            <small class="text-body">Bed Occupancy Rate</small>
          </div>
          <div class="col-12 col-md-7 ps-xl-8">
            <div id="weeklyResourceUtilization"></div>
          </div>
        </div>
        <div class="border rounded p-5 mt-5">
          <div class="row gap-4 gap-sm-0">
            <div class="col-12 col-sm-4">
              <div class="d-flex gap-2 align-items-center">
                <div class="badge rounded bg-label-primary p-1"><i class="ti ti-bed ti-sm"></i></div>
                <h6 class="mb-0 fw-normal">Bed Occupancy</h6>
              </div>
              <h4 class="my-2">85%</h4>
              <div class="progress w-75" style="height:4px">
                <div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="d-flex gap-2 align-items-center">
                <div class="badge rounded bg-label-info p-1"><i class="ti ti-scissors ti-sm"></i></div>
                <h6 class="mb-0 fw-normal">OR Utilization</h6>
              </div>
              <h4 class="my-2">70%</h4>
              <div class="progress w-75" style="height:4px">
                <div class="progress-bar bg-info" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="d-flex gap-2 align-items-center">
                <div class="badge rounded bg-label-danger p-1"><i class="ti ti-user ti-sm"></i></div>
                <h6 class="mb-0 fw-normal">Staff Utilization</h6>
              </div>
              <h4 class="my-2">90%</h4>
              <div class="progress w-75" style="height:4px">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Resource Utilization Reports -->

  <!-- Emergency Response Tracker -->
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-header d-flex justify-content-between">
        <div class="card-title mb-0">
          <h5 class="mb-1">Emergency Response Tracker</h5>
          <p class="card-subtitle">Last 7 Days</p>
        </div>
        <div class="dropdown">
          <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1" type="button" id="emergencyResponseTrackerMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti ti-dots-vertical ti-md text-muted"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="emergencyResponseTrackerMenu">
            <a class="dropdown-item" href="javascript:void(0);">View More</a>
            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
          </div>
        </div>
      </div>
      <div class="card-body row">
        <div class="col-12 col-sm-4 col-md-12 col-lg-4">
          <div class="mt-lg-4 mt-lg-2 mb-lg-6 mb-2">
            <h2 class="mb-0">164</h2>
            <p class="mb-0">Total Emergencies</p>
          </div>
          <ul class="p-0 m-0">
            <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
              <div class="badge rounded bg-label-primary p-1_5"><i class="ti ti-alert-triangle ti-md"></i></div>
              <div>
                <h6 class="mb-0 text-nowrap">New Emergencies</h6>
                <small class="text-muted">142</small>
              </div>
            </li>
            <li class="d-flex gap-4 align-items-center mb-lg-3 pb-1">
              <div class="badge rounded bg-label-info p-1_5"><i class="ti ti-clock ti-md"></i></div>
              <div>
                <h6 class="mb-0 text-nowrap">Response Time</h6>
                <small class="text-muted">15m</small>
              </div>
            </li>
            <li class="d-flex gap-4 align-items-center pb-1">
              <div class="badge rounded bg-label-warning p-1_5"><i class="ti ti-check ti-md"></i></div>
              <div>
                <h6 class="mb-0 text-nowrap">Resolved Emergencies</h6>
                <small class="text-muted">120</small>
              </div>
            </li>
          </ul>
        </div>
        <div class="col-12 col-sm-8 col-md-12 col-lg-8">
          <div id="emergencyResponseTracker"></div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Emergency Response Tracker -->

  <!-- Patients By Department -->
  <div class="col-xxl-4 col-md-6">
    <div class="card h-100">
      <div class="card-header d-flex justify-content-between">
        <div class="card-title mb-0">
          <h5 class="mb-1">Patients By Department</h5>
          <p class="card-subtitle">Monthly Patients Overview</p>
        </div>
        <div class="dropdown">
          <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1" type="button" id="patientsByDepartment" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ti ti-dots-vertical ti-md text-muted"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="patientsByDepartment">
            <a class="dropdown-item" href="javascript:void(0);">Download</a>
            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
            <a class="dropdown-item" href="javascript:void(0);">Share</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <ul class="p-0 m-0">
          <li class="d-flex align-items-center mb-4">
            <div class="avatar flex-shrink-0 me-4">
              <i class="fis fi fi-emergency rounded-circle fs-2"></i>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <div class="d-flex align-items-center">
                  <h6 class="mb-0 me-1">1,200</h6>
                </div>
                <small class="text-body">Emergency</small>
              </div>
              <div class="user-progress">
                <p class="text-success fw-medium mb-0 d-flex align-items-center gap-1">
                  <i class='ti ti-chevron-up'></i>
                  25.8%
                </p>
              </div>
            </div>
          </li>
          <li class="d-flex align-items-center mb-4">
            <div class="avatar flex-shrink-0 me-4">
              <i class="fis fi fi-surgery rounded-circle fs-2"></i>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <div class="d-flex align-items-center">
                  <h6 class="mb-0 me-1">450</h6>
                </div>
                <small class="text-body">Surgery</small>
              </div>
              <div class="user-progress">
                <p class="text-danger fw-medium mb-0 d-flex align-items-center gap-1">
                  <i class='ti ti-chevron-down'></i>
                  6.2%
                </p>
              </div>
            </div>
          </li>
          <li class="d-flex align-items-center mb-4">
            <div class="avatar flex-shrink-0 me-4">
              <i class="fis fi fi-pediatrics rounded-circle fs-2"></i>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <div class="d-flex align-items-center">
                  <h6 class="mb-0 me-1">320</h6>
                </div>
                <small class="text-body">Pediatrics</small>
              </div>
              <div class="user-progress">
                <p class="text-success fw-medium mb-0 d-flex align-items-center gap-1">
                  <i class='ti ti-chevron-up'></i>
                  12.4%
                </p>
              </div>
            </div>
          </li>
          <li class="d-flex align-items-center mb-4">
            <div class="avatar flex-shrink-0 me-4">
              <i class="fis fi fi-icu rounded-circle fs-2"></i>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <div class="d-flex align-items-center">
                  <h6 class="mb-0 me-1">150</h6>
                </div>
                <small class="text-body">ICU</small>
              </div>
              <div class="user-progress">
                <p class="text-success fw-medium mb-0 d-flex align-items-center gap-1">
                  <i class='ti ti-chevron-up'></i>
                  8.5%
                </p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!--/ Patients By Department -->
</div>

@endsection
