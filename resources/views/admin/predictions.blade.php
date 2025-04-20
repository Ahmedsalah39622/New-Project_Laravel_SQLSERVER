<!-- filepath: d:\model\lifeline\resources\views\admin\predictions.blade.php -->
@extends('layouts.layoutMaster')

@section('title', 'Predictions')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">AI Predictions</h5>
    </div>
    <div class="card-body">
        @if(isset($predictions['predictions']))
            @foreach($predictions['predictions'] as $disease => $forecast)
                <h6>{{ ucfirst($disease) }}</h6>
                @if(isset($forecast['error']))
                    <p class="text-danger">{{ $forecast['error'] }}</p>
                @else
                    <h6>Accuracy Metrics</h6>
                    <ul>
                        <li><strong>Accuracy:</strong> {{ 100 - $forecast['metrics']['mape'] }}%</li>
                        <li><strong>MAE:</strong> {{ $forecast['metrics']['mae'] }}</li>
                        <li><strong>RMSE:</strong> {{ $forecast['metrics']['rmse'] }}</li>
                        <li><strong>MAPE:</strong> {{ $forecast['metrics']['mape'] }}%</li>
                    </ul>
                    <h6>Graph</h6>
                    <canvas id="chart-{{ $disease }}" width="400" height="200"></canvas>
                    <script>
                        const ctx{{ $disease }} = document.getElementById('chart-{{ $disease }}').getContext('2d');
                        const chart{{ $disease }} = new Chart(ctx{{ $disease }}, {
                            type: 'line',
                            data: {
                                labels: [
                                    @foreach($forecast['historical_data'] as $row)
                                        "{{ $row['ds'] }}",
                                    @endforeach
                                    @foreach($forecast['future_forecast'] as $row)
                                        "{{ $row['ds'] }}",
                                    @endforeach
                                ],
                                datasets: [
                                    {
                                        label: 'Historical Data',
                                        data: [
                                            @foreach($forecast['historical_data'] as $row)
                                                {{ $row['y'] }},
                                            @endforeach
                                        ],
                                        borderColor: 'blue',
                                        borderWidth: 2,
                                        fill: false,
                                    },
                                    {
                                        label: 'Predicted Data',
                                        data: [
                                            @foreach($forecast['future_forecast'] as $row)
                                                {{ $row['yhat'] }},
                                            @endforeach
                                        ],
                                        borderColor: 'red',
                                        borderWidth: 2,
                                        borderDash: [5, 5],
                                        fill: false,
                                    },
                                    {
                                        label: 'Lower Bound',
                                        data: [
                                            @foreach($forecast['future_forecast'] as $row)
                                                {{ $row['yhat_lower'] }},
                                            @endforeach
                                        ],
                                        borderColor: 'pink',
                                        borderWidth: 1,
                                        borderDash: [5, 5],
                                        fill: false,
                                    },
                                    {
                                        label: 'Upper Bound',
                                        data: [
                                            @foreach($forecast['future_forecast'] as $row)
                                                {{ $row['yhat_upper'] }},
                                            @endforeach
                                        ],
                                        borderColor: 'pink',
                                        borderWidth: 1,
                                        borderDash: [5, 5],
                                        fill: false,
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
                                        text: 'Predictions for {{ ucfirst($disease) }}'
                                    }
                                },
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Date'
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Number of Patients'
                                        }
                                    }
                                }
                            }
                        });
                    </script>
                @endif
            @endforeach
        @else
            <p>No predictions available.</p>
        @endif
    </div>
</div>
@endsection
