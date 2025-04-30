@extends('layouts.app')

@section('content')
<div class="productivity-container">
    <div class="container py-4">
        <!-- Header Section -->
        <div class="header-section mb-5">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 fw-bold text-primary mb-2">
                        <i class="fas fa-chart-line me-2"></i>Team Productivity
                    </h1>
                    <p class="lead text-muted">Track and optimize your team's workflow efficiency</p>
                </div>
                <div class="time-filter">
                    <select class="form-select border-primary" id="timeRange">
                        <option value="7">Last 7 Days</option>
                        <option value="14">Last 14 Days</option>
                        <option value="30">Last 30 Days</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Main Visualization -->
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-body">
                <div class="row g-4">
                    <!-- Progress Chart -->
                    <div class="col-12 col-lg-8">
                        <div class="chart-header mb-4">
                            <h5 class="fw-semibold">Task Completion Trend</h5>
                            <p class="text-muted small">Track completed vs pending tasks over time</p>
                        </div>
                        <canvas id="productivityChart" style="height: 300px;"></canvas>
                    </div>
                    
                    <!-- Key Metrics -->
                    <div class="col-12 col-lg-4">
                        <div class="metric-card bg-primary text-white p-4 rounded-3 mb-4">
                            <div class="metric-value display-5 fw-bold">84%</div>
                            <div class="metric-title">Completion Rate</div>
                            <div class="metric-subtitle text-white-50 small">Above team average</div>
                        </div>
                        
                        <div class="metric-list">
                            <div class="metric-item d-flex justify-content-between align-items-center p-3 bg-light rounded-3 mb-2">
                                <div>
                                    <div class="metric-label text-muted small">Bottleneck Tasks</div>
                                    <div class="metric-value fw-bold">5</div>
                                </div>
                                <i class="fas fa-exclamation-triangle text-warning fa-lg"></i>
                            </div>
                            <!-- Repeat similar metric items -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Insights -->
        <div class="row g-4">
            <div class="col-12 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Task Distribution</h6>
                        <canvas id="taskDistributionChart" style="height: 200px;"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Member Contribution</h6>
                        <div class="member-list">
                            <!-- Dynamic member contributions -->
                            @foreach($teamMembers as $member)
                            <div class="member-item d-flex align-items-center p-2 mb-2">
                                <div class="member-avatar me-3">
                                    <img src="{{ $member->avatar }}" class="rounded-circle" width="40" alt="">
                                </div>
                                <div class="flex-grow-1">
                                    <div class="member-name fw-semibold">{{ $member->name }}</div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-info" 
                                             role="progressbar" 
                                             style="width: {{ $member->completion_rate }}%">
                                        </div>
                                    </div>
                                </div>
                                <div class="metric-value ms-3">{{ $member->completed_tasks }} tasks</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.productivity-container {
    background: #f8fafc;
    min-height: 100vh;
}

.metric-card {
    background: linear-gradient(135deg, #4a90e2, #2d6cdb);
    box-shadow: 0 5px 15px rgba(74, 144, 226, 0.2);
}

.chart-header {
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 1rem;
}

.member-item {
    transition: all 0.2s ease;
    background: rgba(255,255,255,0.9);
    border-radius: 0.5rem;
}

.member-item:hover {
    transform: translateX(5px);
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

.progress {
    border-radius: 4px;
    background-color: rgba(233, 236, 239, 0.5);
}

.time-filter .form-select {
    border-width: 2px;
    border-radius: 0.5rem;
    min-width: 180px;
}

@media (max-width: 768px) {
    .header-section {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .time-filter {
        width: 100%;
        margin-top: 1rem;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Main Productivity Chart
    const ctx = document.getElementById('productivityChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartDates) !!},
            datasets: [{
                label: 'Completed Tasks',
                data: {!! json_encode($completedData) !!},
                borderColor: '#4a90e2',
                backgroundColor: 'rgba(74, 144, 226, 0.1)',
                tension: 0.3,
                fill: true
            },
            {
                label: 'Pending Tasks',
                data: {!! json_encode($pendingData) !!},
                borderColor: '#ffc107',
                backgroundColor: 'rgba(255, 193, 7, 0.1)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Tasks'
                    }
                }
            }
        }
    });

    // Task Distribution Chart
    const taskCtx = document.getElementById('taskDistributionChart').getContext('2d');
    new Chart(taskCtx, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'In Progress', 'Blocked', 'Pending'],
            datasets: [{
                data: {!! json_encode($taskDistribution) !!},
                backgroundColor: [
                    '#28a745',
                    '#17a2b8',
                    '#dc3545',
                    '#ffc107'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Time Range Filter
    $('#timeRange').change(function() {
        const days = $(this).val();
        window.location = "{{ route('productivity.index') }}?days=" + days;
    });
});
</script>
@endsection