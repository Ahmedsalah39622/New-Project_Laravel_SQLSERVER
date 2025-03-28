@extends('layouts/layoutMaster')

@section('title', 'Preview Prescription')

@section('content')
<div class="row prescription-preview">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Prescription Preview</h5>
        @if($prescription)
          <p class="card-text">Prescription ID: {{ $prescription->id }}</p>
          <p class="card-text">Patient Name: {{ $prescription->patient_name }}</p>
          <p class="card-text">Doctor Name: {{ $prescription->doctor_name }}</p>
          <p class="card-text">Drugs: {{ $prescription->drugs }}</p>
          <p class="card-text">Dosage: {{ $prescription->dosage }}</p>
          <p class="card-text">Notes: {{ $prescription->notes }}</p>
        @else
          <p class="card-text text-danger">No prescription data available.</p>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
