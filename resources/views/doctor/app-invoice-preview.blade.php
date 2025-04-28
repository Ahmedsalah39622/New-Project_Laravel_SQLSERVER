@extends('layouts/layoutMaster')

@section('title', 'Preview - Prescription')

@section('content')

<div class="row invoice-preview">
  <!-- Invoice -->
  <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-6">
    <div class="card invoice-preview-card p-sm-12 p-6" id="printableArea">
      <div class="card-body invoice-preview-header rounded">
        <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column">
          <div class="mb-xl-0 mb-6 text-heading">
            <div class="d-flex svg-illustration mb-6 gap-2 align-items-center">
              <div class="app-brand-logo demo">@include('_partials.macros',["height"=>22,"withbg"=>''])</div>
              <span class="app-brand-text fw-bold fs-4 ms-50">
                {{ config('variables.templateName') }}
              </span>
            </div>
            <p class="mb-2">Office 149, 450 South Brand Brooklyn</p>
            <p class="mb-2">San Diego County, CA 91905, USA</p>
            <p class="mb-0">+1 (123) 456 7891, +44 (876) 543 2198</p>
          </div>
          <div>
            <h5 class="mb-6">Appointment ID: {{$appointment->id}}</h5>
            <div class="mb-1 text-heading">
              <span>Date Issued:</span>
              <span>{{ $appointment->appointment_date }}</span>
            </div>
            <div class="text-heading">
              <span>Date Due:</span>
              <span>{{ now()->addDays(7)->toDateString() }}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body px-0">
        <div class="row">
          <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-6 mb-sm-0 mb-6">
            <h6>Patient Information:</h6>
            <p class="mb-1">Name: {{ $appointment->patient_name }}</p>
          </div>
          <div class="col-xl-6 col-md-12 col-sm-7 col-12">
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
      <h6>Prescription Details:</h6>

      <div class="table-responsive border border-bottom-0 border-top-0 rounded">
        <table class="table m-0">
          <thead>
            <tr>
              <th>Drugs</th>
              <th>Dosage</th>
              <th>Notes</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($prescriptions as $prescription)
              <tr>
                <td class="text-nowrap text-heading">{{ $prescription->drugs }}</td>
                <td class="text-nowrap">{{ $prescription->dosage }}</td>
                <td>{{ $prescription->notes ?? 'N/A' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="text-center">No prescriptions found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="table-responsive">
        <table class="table m-0 table-borderless">
          <tbody>
            <tr>
              <td class="align-top pe-6 ps-0 py-6">
                <p class="mb-1">
                  <span class="me-2 h6">Receptionist:</span>
                  <span>{{ $receptionist->name ?? 'N/A' }}</span>
                </p>
                <p class="text-center">Thanks for your Trust!</p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="table-responsive">
        <table class="table m-0 table-borderless">
          <tbody>
            <tr>
              <td class="align-top pe-6 ps-0 py-6">
                <p class="mb-1">
                  <span class="me-2 h6">Prescription Summary:</span>
                </p>
              </td>
              <td class="px-0 py-6 w-px-100">
                <p class="mb-2 border-bottom pb-2">Total Drugs:</p>
              </td>
              <td class="text-end px-0 py-6 w-px-100 fw-medium text-heading">
                <p class="fw-medium mb-2 border-bottom pb-2">{{ $prescriptions->count() }}</p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <hr class="mt-0 mb-6">
      <div class="card-body p-0">
        <div class="row">
          <div class="col-12">
            <span class="fw-medium text-heading">Note:</span>
            <span>It was a pleasure working with you and the LifeLine team. We hope that you will keep us in mind for future freelance projects related to LifeLine and patient management. Thank you for the opportunity to contribute to such an impactful project!</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Invoice -->

  <!-- Invoice Actions -->
  <div class="col-xl-3 col-md-4 col-12 invoice-actions">
    <div class="card">
        <div class="card-body">
            <button class="btn btn-primary d-grid w-100 mb-4" data-bs-toggle="offcanvas" data-bs-target="#sendInvoiceOffcanvas">
                <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-send ti-xs me-2"></i>Send Invoice</span>
            </button>
            <div class="d-flex mb-4">
                <button class="btn btn-label-secondary d-grid w-100 me-4" onclick="printInvoice()">
                    Print
                </button>
                <a href="{{ route('doctor.prescription.edit', ['appointmentId' => $appointment->id]) }}" class="btn btn-label-secondary d-grid w-100">
                    Edit
                </a>
            </div>
            <a href="{{ route('doctor.dashboard') }}" class="btn btn-success d-grid w-100">
                <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-arrow-left ti-xs me-2"></i>Back to Dashboard</span>
            </a>
        </div>
    </div>
  </div>
  <!-- /Invoice Actions -->
</div>

<script>
  function printInvoice() {
    const printContents = document.getElementById('printableArea').innerHTML;
    const originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;

    window.location.reload();
  }
</script>
<style>
  @media print {
    body {
      -webkit-print-color-adjust: exact;
      color-adjust: exact;
    }

    .invoice-preview {
      margin: 0 auto;
      width: 100%;
      max-width: 800px;
    }

    .invoice-preview-card {
      border: none;
      box-shadow: none;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
    }

    .table th, .table td {
      border: 1px solid #ddd;
      padding: 8px;
    }

    .btn, .invoice-actions {
      display: none;
    }

    hr {
      border: 1px solid #ddd;
    }
  }
</style>
@endsection
