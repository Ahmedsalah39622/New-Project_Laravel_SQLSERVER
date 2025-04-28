<!-- filepath: d:\model\lifeline\resources\views\doctor\manage-prescriptions.blade.php -->
@extends('layouts.layoutMaster')

@section('title', 'Manage Prescriptions')

@section('content')
<div class="container">
    <h4>Manage Prescriptions for Appointment #{{ $appointment->id }}</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Drugs</th>
                <th>Dosage</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($prescriptions as $prescription)
                <tr>
                    <td>{{ $prescription->drugs }}</td>
                    <td>{{ $prescription->dosage }}</td>
                    <td>{{ $prescription->notes }}</td>
                    <td>
                        <form action="{{ route('doctor.prescription.destroy', $prescription->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this prescription?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No prescriptions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('doctor.app-invoice-preview', ['appointmentId' => $appointment->id]) }}" class="btn btn-secondary">Back to Prescription</a>
</div>
@endsection
