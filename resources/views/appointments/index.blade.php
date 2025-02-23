@extends('layouts.layoutMaster')

@section('title', 'Appointments')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Doctor Appointments</h2>

    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Doctor</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($calendar as $date => $data)
                    @foreach($data['appointments'] as $appointment)
                    <tr>
                        <td>{{ $date }}</td>
                        <td>{{ $appointment['doctor'] }}</td>
                        <td>{{ $appointment['time'] }}</td>
                        <td>
                            @if($appointment['status'] == 'Available')
                                <span class="badge bg-success">Available</span>
                            @else
                                <span class="badge bg-danger">Booked</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
