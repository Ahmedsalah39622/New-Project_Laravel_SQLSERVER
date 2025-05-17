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
                @php
                    $historicalData = $forecast['historical_data'] ?? [];
                    $hasData = count($historicalData) > 0;
                    $hasEnoughData = count($historicalData) >= 6;
                @endphp

                @if(!$hasData)
                    <div class="alert alert-warning">
                        <strong>{{ Str::title(str_replace('_', ' ', $disease)) }}:</strong> No data available. Skipping prediction.
                    </div>
                    @continue
                @elseif(!$hasEnoughData)
                    <div class="alert alert-warning">
                        <strong>{{ Str::title(str_replace('_', ' ', $disease)) }}:</strong> Not enough data (only {{ count($historicalData) }} months). At least 6 months of data are required for reliable predictions.
                    </div>
                    @continue
                @endif

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
                            </div>
                        </div>
                    @endif

                    <canvas id="chart-{{ Str::slug($disease) }}" width="400" height="200"></canvas>

                    <!-- Table for Upper, Lower, Predicted values -->
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Predicted</th>
                                    <th>Upper Bound</th>
                                    <th>Lower Bound</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($forecast['future_forecast'] as $row)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($row['ds'])->format('M Y') }}</td>
                                        <td>{{ (int) $row['yhat'] }}</td>
                                        <td>{{ (int) $row['yhat_upper'] }}</td>
                                        <td>{{ (int) $row['yhat_lower'] }}</td>
                                        <td>
                                            @php
                                                // Calculate the percentage change from the previous predicted month
                                                $prevPredicted = null;
                                                $currentIndex = $loop->index;
                                                if ($currentIndex > 0 && isset($forecast['future_forecast'][$currentIndex - 1]['yhat'])) {
                                                    $prevPredicted = (int) $forecast['future_forecast'][$currentIndex - 1]['yhat'];
                                                }
                                                $currentValue = (int) $row['yhat'];
                                                $note = '';
                                                if ($prevPredicted !== null && $prevPredicted !== 0) {
                                                    $percentChange = (($currentValue - $prevPredicted) / abs($prevPredicted)) * 100;
                                                    $note = 'Change: ' . ($percentChange > 0 ? '+' : '') . number_format($percentChange, 1) . '%';
                                                } elseif ($prevPredicted !== null && $prevPredicted === 0) {
                                                    $note = 'No previous prediction (0)';
                                                } else {
                                                    $note = 'No previous prediction';
                                                }
                                            @endphp
                                            {{ $note }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

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

<div class="card mt-4 d-print-block">
    <div class="card-header d-print-none">
        <h5 class="card-title">LifeLine AI Advice</h5>
    </div>
    <div class="card-body">
        <div id="ai-advice" class="alert alert-info">
            <p>Fetching advice from AI...</p>
        </div>
    </div>
</div>

<style>
#ai-advice {
    font-size: 1rem;
    line-height: 1.5;
    color: #000000;
}

@media print {
    body * {
        visibility: hidden;
    }
    .card, .card * {
        visibility: visible;
    }
    .card {
        page-break-inside: avoid;
        margin-bottom: 2em;
    }
    .d-print-none {
        display: none !important;
    }
    .d-print-block {
        display: block !important;
    }
    canvas {
        display: block !important;
        page-break-inside: avoid;
    }
    .alert-info {
        color: #000 !important;
        background: #e9ecef !important;
        border-color: #b8daff !important;
    }
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('/api/ai-advice', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                predictions: @json($predictions['predictions'] ?? [])
            })
        })
        .then(response => response.text())
        .then(data => {
            console.log('Raw Response:', data);
            try {
                const jsonData = JSON.parse(data);
                const adviceElement = document.getElementById('ai-advice');
                if (jsonData.success) {
                    let adviceHtml = `<p>${jsonData.advice}</p>`;
                    // Add summary and bullets under the paragraph if advice is a string
                    if (typeof jsonData.advice === 'string') {
                        // Try to split into summary and bullets
                        const summaryMatch = jsonData.advice.match(/^(.*?)(?=\.|$)/);
                        const summary = summaryMatch ? summaryMatch[0] : '';
                        const rest = jsonData.advice.replace(summary, '').trim();
                        // Extract bullets (split by . or ;) and filter out empty/summary
                        const bullets = rest.split(/\.|;/).map(s => s.trim()).filter(bullet => bullet && bullet !== summary);
                        if (bullets.length > 0) {
                            adviceHtml += '<ul style="margin-top: 0.5em">';
                            bullets.forEach(bullet => {
                                adviceHtml += `<li>${bullet}</li>`;
                            });
                            adviceHtml += '</ul>';
                        }
                    }
                    adviceElement.innerHTML = adviceHtml;
                } else {
                    adviceElement.innerHTML = `<p class="text-danger">Failed to fetch advice: ${jsonData.message}</p>`;
                }
            } catch (error) {
                document.getElementById('ai-advice').innerHTML = `<p class="text-danger">Error parsing response: ${error.message}</p>`;
            }
        })
        .catch(error => {
            document.getElementById('ai-advice').innerHTML = `<p class="text-danger">Error fetching advice: ${error.message}</p>`;
        });
    });
</script>
@endsection
