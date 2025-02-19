@extends('layouts/layoutMaster')

@section('title', 'Make an Appointment')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Select an Appointment Date</h2>
    <div class="table-responsive">
        <table class="table table-bordered text-center appointment-table">
            <thead>
                <tr>
                    <th>Sunday</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                </tr>
            </thead>
            <tbody>
                @foreach($calendar as $week)
                <tr>
                    @foreach($week as $day)
                    <td class="day-cell" data-date="{{ $day }}">
                        {{ $day }}
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center mt-4">
        <button class="btn btn-primary" id="confirm-appointment" disabled>Confirm Appointment</button>
    </div>
</div>

<style>
    .appointment-table td {
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
        padding: 20px;
        font-size: 18px;
    }
    .appointment-table td:hover {
        background-color: #f0f8ff;
        transform: scale(1.1);
    }
    .appointment-table .selected {
        background-color: #1E73BE;
        color: white;
        font-weight: bold;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let selectedDate = null;

        document.querySelectorAll(".day-cell").forEach(cell => {
            cell.addEventListener("click", function() {
                if (selectedDate) {
                    selectedDate.classList.remove("selected");
                }
                this.classList.add("selected");
                selectedDate = this;
                document.getElementById("confirm-appointment").disabled = false;
            });
        });
    });
</script>
@php
    $clinic = request()->query('clinic');
@endphp

@if($clinic)
    <h2 class="text-center mb-4">Booking for {{ $clinic }}</h2>
@else
    <h2 class="text-center mb-4">Please select a clinic</h2>
@endif

@endsection
