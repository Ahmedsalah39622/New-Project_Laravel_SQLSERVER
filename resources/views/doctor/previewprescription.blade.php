@extends('layouts/layoutMaster')

@section('title', 'Preview Prescription')

@section('content')
<div class="row prescription-preview">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Prescription Preview</h5>
        @if($prescriptions && $prescriptions->count())
          @foreach($prescriptions as $prescription)
            <p class="card-text">Appointment ID: {{ $prescription->appointment_id }}</p>
            <p class="card-text">Drugs: {{ $prescription->drugs }}</p>
            <p class="card-text">Dosage: {{ $prescription->dosage }}</p>
            <p class="card-text">Notes: {{ $prescription->notes }}</p>
            <hr>
          @endforeach
        @else
          <p class="card-text text-danger">No prescription data available.</p>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
