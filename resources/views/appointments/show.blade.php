{{-- resources/views/appointments/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Appointment Details</h1>
    <p>Patient Name: {{ $appointment->patient_name }}</p>
    <p>Doctor: {{ $appointment->doctor->name ?? 'N/A' }}</p>
    <p>Date: {{ $appointment->appointment_date }}</p>
    <p>Time: {{ $appointment->start_time }} - {{ $appointment->end_time }}</p>
@endsection
