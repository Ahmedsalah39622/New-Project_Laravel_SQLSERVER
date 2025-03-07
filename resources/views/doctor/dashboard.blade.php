@extends('layouts.layoutMaster')

@section('title', 'Doctor Dashboard')

@section('content')
<div class="container">
    <h2 class="text-primary">Doctor Dashboard</h2>
    <p>Manage your appointments, patients, and schedule.</p>

    <a href="{{ route('appointments.index') }}" class="btn btn-primary">View Appointments</a>
</div>
@endsection
