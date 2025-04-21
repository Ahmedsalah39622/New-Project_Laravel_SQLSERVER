@extends('layouts.layoutMaster')

@section('title', 'Predictions')

@php
use Illuminate\Support\Str;
@endphp

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">AI Predictions</h5>
    </div>
    <div class="card-body">
        @if(isset($predictions['predictions']))
            @foreach($predictions['predictions'] as $disease => $forecast)
                <div class="mb-4">
                    <h5>{{ Str::title(str_replace('_', ' ', $disease)) }}</h5>

                    @if(isset($forecast['metrics']))
                        <div class="alert alert-info">
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Accuracy:</strong>
                                    <span class="badge bg-success">
                                        {{ number_format(100 - $forecast['metrics']['mape'], 2) }}%
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <strong>MAE:</strong>
                                    {{ number_format($forecast['metrics']['mae'], 2) }}
                                </div>
                                <div class="col-md-3">
                                    <strong>RMSE:</strong>
                                    {{ number_format($forecast['metrics']['rmse'], 2) }}
                                </div>
                                <div class="col-md-3">
                                    <strong>MAPE:</strong>
                                    {{ number_format($forecast['metrics']['mape'], 2) }}%
                                </div>
                            </div>
                        </div>
                    @endif

                    <canvas id="chart-{{ Str::slug($disease) }}" width="400" height="200"></canvas>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const ctx = document.getElementById('chart-{{ Str::slug($disease) }}').getContext('2d');
                            new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: [
                                        @foreach($forecast['historical_data'] as $row)
                                            "{{ \Carbon\Carbon::parse($row['ds'])->format('M Y') }}",
                                        @endforeach
                                        @foreach($forecast['future_forecast'] as $row)
                                            "{{ \Carbon\Carbon::parse($row['ds'])->format('M Y') }}",
                                        @endforeach
                                    ],
                                    datasets: [
                                        {
                                            label: 'Historical Data',
                                            data: [
                                                @foreach($forecast['historical_data'] as $row)
                                                    {{ $row['y'] }},
                                                @endforeach
                                                @foreach($forecast['future_forecast'] as $row)
                                                    null,
                                                @endforeach
                                            ],
                                            borderColor: 'blue',
                                            borderWidth: 2,
                                            fill: false,
                                            pointRadius: 3,
                                            pointHoverRadius: 5
                                        },
                                        {
                                            label: 'Predicted Data',
                                            data: [
                                                @foreach($forecast['historical_data'] as $row)
                                                    null,
                                                @endforeach
                                                @foreach($forecast['future_forecast'] as $row)
                                                    {{ $row['yhat'] }},
                                                @endforeach
                                            ],
                                            borderColor: 'red',
                                            borderWidth: 2,
                                            borderDash: [5, 5],
                                            fill: false,
                                            pointRadius: 3,
                                            pointHoverRadius: 5
                                        },
                                        {
                                            label: 'Upper Bound',
                                            data: [
                                                @foreach($forecast['historical_data'] as $row)
                                                    null,
                                                @endforeach
                                                @foreach($forecast['future_forecast'] as $row)
                                                    {{ $row['yhat_upper'] }},
                                                @endforeach
                                            ],
                                            borderColor: 'rgba(255, 0, 0, 0.2)',
                                            borderWidth: 1,
                                            borderDash: [5, 5],
                                            fill: false,
                                            pointRadius: 0
                                        },
                                        {
                                            label: 'Lower Bound',
                                            data: [
                                                @foreach($forecast['historical_data'] as $row)
                                                    null,
                                                @endforeach
                                                @foreach($forecast['future_forecast'] as $row)
                                                    {{ $row['yhat_lower'] }},
                                                @endforeach
                                            ],
                                            borderColor: 'rgba(255, 0, 0, 0.2)',
                                            borderWidth: 1,
                                            borderDash: [5, 5],
                                            fill: '-1',
                                            backgroundColor: 'rgba(255, 0, 0, 0.1)',
                                            pointRadius: 0
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                        },
                                        title: {
                                            display: true,
                                            text: 'Predictions for {{ Str::title(str_replace('_', ' ', $disease)) }}'
                                        },
                                        tooltip: {
                                            mode: 'index',
                                            intersect: false
                                        }
                                    },
                                    scales: {
                                        x: {
                                            title: {
                                                display: true,
                                                text: 'Date'
                                            },
                                            ticks: {
                                                maxRotation: 45,
                                                minRotation: 45
                                            }
                                        },
                                        y: {
                                            title: {
                                                display: true,
                                                text: 'Number of Patients'
                                            },
                                            beginAtZero: true
                                        }
                                    },
                                    interaction: {
                                        intersect: false,
                                        mode: 'index'
                                    }
                                }
                            });
                        });
                    </script>
                </div>
            @endforeach
        @else
            <p>No predictions available.</p>
        @endif
    </div>
</div>
@endsection
