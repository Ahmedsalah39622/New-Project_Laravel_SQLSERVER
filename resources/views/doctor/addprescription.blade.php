@extends('layouts/layoutMaster')

@section('title', 'Add Prescription')

@section('vendor-style')
@vite('resources/assets/vendor/libs/flatpickr/flatpickr.scss')
@endsection

@section('page-style')
@vite('resources/assets/vendor/scss/pages/app-invoice.scss')
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/flatpickr/flatpickr.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/jquery-repeater/jquery-repeater.js'
])
@endsection

@section('page-script')
@vite([
  'resources/assets/js/offcanvas-send-invoice.js',
  'resources/assets/js/app-invoice-add.js'
])
@endsection

@section('content')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Doctor:', @json($doctor));
        console.log('Appointment:', @json($appointment));
    });
</script>

<div class="row prescription-add">
  <!-- Prescription Add-->
  <div class="col-lg-9 col-12 mb-lg-0 mb-6">
    <div class="card prescription-preview-card p-sm-12 p-6">
      <div class="card-body prescription-preview-header rounded">
        <div class="d-flex flex-wrap flex-column flex-sm-row justify-content-between text-heading">
          <div class="mb-md-0 mb-6">
            <div class="d-flex svg-illustration mb-6 gap-2 align-items-center">
              <div class="app-brand-logo demo">@include('_partials.macros',["height"=>22,"withbg"=>''])</div>
              <span class="app-brand-text fw-bold fs-4 ms-50">
                {{ config('variables.templateName') }}
              </span>
            </div>
            <p class="mb-2">Office 149, 450 South Brand Brooklyn</p>
            <p class="mb-2">San Diego County, CA 91905, USA</p>
            <p class="mb-3">+1 (123) 456 7891, +44 (876) 543 2198</p>
          </div>
          <div class="col-md-5 col-8 pe-0 ps-0 ps-md-2">
            <dl class="row mb-0">
              <dt class="col-sm-5 mb-2 d-md-flex align-items-center justify-content-end">
                <span class="h5 text-capitalize mb-0 text-nowrap">Prescription</span>
              </dt>
              <dd class="col-sm-7">
                <div class="input-group input-group-merge disabled">
                  <span class="input-group-text">#</span>
                  <input type="text" class="form-control" disabled placeholder="Auto-generated" id="prescriptionId" />
                </div>
              </dd>
              <dt class="col-sm-5 mb-2 d-md-flex align-items-center justify-content-end">
                <span class="fw-normal">Date Issued:</span>
              </dt>
              <dd class="col-sm-7">
                <input type="text" class="form-control prescription-date" value="{{ date('Y-m-d') }}" disabled />
              </dd>
              <dt class="col-sm-5 d-md-flex align-items-center justify-content-end">
                <span class="fw-normal">Due Date:</span>
              </dt>
              <dd class="col-sm-7 mb-0">
                <input type="text" class="form-control due-date" value="{{ date('Y-m-d', strtotime('+7 days')) }}" disabled />
              </dd>
            </dl>
          </div>
        </div>
      </div>

      <div class="card-body px-0">

        <div class="row">
          <div class="col-md-6 col-sm-5 col-12 mb-sm-0 mb-6">
            <h6>Patient Information:</h6>
            <p class="mb-1">Name: {{ $appointment->patient_name }}</p>
            <p class="mb-0">ID: {{ $appointment->patient }}</p>
          </div>
          <div class="col-md-6 col-sm-7">
            <h6>Doctor Information:</h6>
            <table>
              <tbody>
                <tr>
                  <td class="pe-4">Doctor Name:</td>
                  <td>{{ $doctor->name }}</td>
                </tr>
                <tr>
                  <td class="pe-4">Specialization:</td>
                  <td>{{ $doctor->specialization }}</td>
                </tr>
                <tr>
                  <td class="pe-4">Contact:</td>
                  <td>{{ $doctor->phone }}</td>
                </tr>
                <tr>
                  <td class="pe-4">Email:</td>
                  <td>{{ $doctor->email }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <hr class="mt-0 mb-6">
      <div class="card-body pt-0 px-0">
        <form id="prescription-form" class="source-item" method="POST" action="{{ route('doctor.completedprescriptions.store') }}">
          @csrf
          <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
          <input type="hidden" name="prescription_id" id="prescription_id" value="">
          <div class="mb-4" data-repeater-list="group-a">
            <div class="repeater-wrapper pt-0 pt-md-9" data-repeater-item>
              <div class="d-flex border rounded position-relative pe-0">
                <div class="row w-100 p-6">
                  <div class="col-md-6 col-12 mb-md-0 mb-4">
                    <p class="h6 repeater-title">Drugs</p>
                    <textarea class="form-control" name="group-a[][drugs]" rows="2" placeholder="Enter drug name" required></textarea>
                  </div>
                  <div class="col-md-6 col-12 mb-md-0 mb-4">
                    <p class="h6 repeater-title">Dosage</p>
                    <textarea class="form-control" name="group-a[][dosage]" rows="2" placeholder="Enter dosage details" required></textarea>
                  </div>
                </div>
                <div class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                  <i class="ti ti-x ti-lg cursor-pointer" data-repeater-delete></i>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="button" class="btn btn-sm btn-primary" data-repeater-create><i class='ti ti-plus ti-14px me-1_5'></i>Add Item</button>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label for="notes" class="me-2 fw-medium text-heading">Notes:</label>
              <textarea class="form-control" name="notes" id="notes" rows="2" placeholder="Enter any additional notes" required></textarea>
            </div>
          </div>
        </form>
      </div>
      <hr class="my-0">
      <div class="card-body px-0">

        <div class="row row-gap-4">
          <div class="col-md-6 mb-md-0 mb-4">
            <div class="d-flex align-items-center mb-4">
              <label for="notes" class="me-2 fw-medium text-heading">Notes:</label>
              <textarea class="form-control" id="notes" rows="2" placeholder="Enter any additional notes"></textarea>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- /Prescription Add-->

  <!-- Prescription Actions -->
  <div class="col-lg-3 col-12 prescription-actions">
    <div class="card mb-6">
      <div class="card-body">
        <button type="submit" form="prescription-form" class="btn btn-primary d-grid w-100 mb-4">
          <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-save ti-xs me-2"></i>Save Prescription</span>
        </button>
        <button type="submit" form="prescription-form" formaction="{{ route('doctor.completedprescriptions.store') }}" class="btn btn-success d-grid w-100 mb-4">
          <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-check ti-xs me-2"></i>Complete Prescription</span>
        </button>
        <button class="btn btn-primary d-grid w-100 mb-4" data-bs-toggle="offcanvas" data-bs-target="#sendPrescriptionOffcanvas">
          <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-send ti-xs me-2"></i>Send Prescription</span>
        </button>
        <a href="{{url('app/prescription/preview')}}" class="btn btn-label-secondary d-grid w-100 mb-4">Preview</a>
        <button type="button" class="btn btn-secondary d-grid w-100 mb-4" onclick="printPrescription()">
          <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-printer ti-xs me-2"></i>Print Prescription</span>
        </button>
      </div>
    </div>
    <div>
      <label for="acceptPaymentsVia" class="form-label">Accept payments via</label>
      <select class="form-select mb-6" id="acceptPaymentsVia">
        <option value="Bank Account">Bank Account</option>
        <option value="Paypal">Paypal</option>
        <option value="Card">Credit/Debit Card</option>
        <option value="UPI Transfer">UPI Transfer</option>
      </select>
      <div class="d-flex justify-content-between mb-2">
        <label for="payment-terms">Payment Terms</label>
        <div class="form-check form-switch me-n2">
          <input type="checkbox" class="form-check-input" id="payment-terms" checked />
        </div>
      </div>
      <div class="d-flex justify-content-between mb-2">
        <label for="client-notes">Client Notes</label>
        <div class="form-check form-switch me-n2">
          <input type="checkbox" class="form-check-input" id="client-notes" checked />
        </div>
      </div>
      <div class="d-flex justify-content-between">
        <label for="payment-stub">Payment Stub</label>
        <div class="form-check form-switch me-n2">
          <input type="checkbox" class="form-check-input" id="payment-stub" checked />
        </div>
      </div>
    </div>
  </div>
  <!-- /Prescription Actions -->
</div>

<script>
document.getElementById('prescription-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent actual form submission for testing
    const formData = new FormData(this);

    for (let [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
    }

    // Allow submission only for debugging purposes
    this.submit();
});

// Add success message handler
@if(session('success'))
    console.log('Prescription saved successfully:', @json(session('success')));
    alert('Prescription saved successfully!');
@endif

function printPrescription() {
    const printContents = document.querySelector('.prescription-add').innerHTML;
    const originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

// Redirect to preview page after completing prescription
document.querySelector('button.btn-success').addEventListener('click', function() {
    document.getElementById('prescription-form').addEventListener('submit', function() {
        window.location.href = "{{ url('doctor/prescription/previewprescription') }}";
    });
});
</script>
@endsection

