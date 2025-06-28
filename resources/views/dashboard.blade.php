@extends('layouts.app')

@section('title', 'Dashboard - Bengkel Management')

@section('content')
<div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-icon">
            <i class="fas fa-bars"></i>
        </div>
        <a href="#" class="sidebar-icon">
            <i class="fas fa-home"></i>
        </a>
        <a href="#" class="sidebar-icon">
            <i class="fas fa-envelope"></i>
        </a>
        <a href="#" class="sidebar-icon">
            <i class="fas fa-phone"></i>
        </a>
        <div class="sidebar-divider"></div>
        <a href="#" class="sidebar-icon">
            <i class="fas fa-comment"></i>
        </a>
        <a href="#" class="sidebar-icon">
            <i class="fas fa-cog"></i>
        </a>
        <a href="#" class="sidebar-icon" style="margin-top: auto;">
            <i class="fas fa-dot-circle"></i>
        </a>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stat-card">
                    <div class="stat-label">Total Services</div>
                    <div class="stat-number">{{ $totalServices }}</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stat-card cyan">
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stat-card purple">
                    <div class="stat-label">Total Vehicles</div>
                    <div class="stat-number">{{ $totalVehicles }}</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="stat-card orange">
                    <div class="stat-label">Active Services</div>
                    <div class="stat-number">{{ $activeServices }}</div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="chart-container">
                    <h3 class="chart-title">Service Trends</h3>
                    <div style="height: 300px; position: relative;">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="chart-container">
                    <h3 class="chart-title">Monthly Services</h3>
                    <div style="height: 300px; position: relative;">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress and Pie Charts Section -->
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="progress-container">
                    <h3 class="chart-title">Service Status</h3>
                    <div class="progress-item">
                        <div class="progress-bar-custom">
                            <div class="progress-fill purple" style="width: 60%"></div>
                        </div>
                        <span class="progress-percentage text-purple-600">60%</span>
                    </div>
                    <div class="progress-item">
                        <div class="progress-bar-custom">
                            <div class="progress-fill purple" style="width: 40%; opacity: 0.6;"></div>
                        </div>
                        <span class="progress-percentage text-purple-400">40%</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="progress-container">
                    <h3 class="chart-title">Revenue Status</h3>
                    <div class="progress-item">
                        <div class="progress-bar-custom">
                            <div class="progress-fill orange" style="width: 80%"></div>
                        </div>
                        <span class="progress-percentage text-orange-600">80%</span>
                    </div>
                    <div class="progress-item">
                        <div class="progress-bar-custom">
                            <div class="progress-fill orange" style="width: 30%; opacity: 0.6;"></div>
                        </div>
                        <span class="progress-percentage text-orange-400">30%</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="pie-chart-container">
                    <div class="pie-chart">
                        <canvas id="pieChart1"></canvas>
                    </div>
                    <div class="pie-info">
                        <div class="pie-percentage">13%</div>
                        <div class="pie-label">Completed</div>
                    </div>
                </div>
                <div class="pie-chart-container">
                    <div class="pie-chart">
                        <canvas id="pieChart2"></canvas>
                    </div>
                    <div class="pie-info">
                        <div class="pie-percentage">26%</div>
                        <div class="pie-label">In Progress</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Services Table -->
        <div class="table-container">
            <div class="table-header">
                <h3 class="table-title">Recent Services</h3>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Vehicle</th>
                            <th>Service Type</th>
                            <th>Status</th>
                            <th>Cost</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentServices as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>{{ $service->vehicle->license_plate ?? 'N/A' }}</td>
                            <td>{{ $service->description ?? 'N/A' }}</td>
                            <td>
                                <span class="status-badge {{ $service->status === 'completed' ? 'completed' : ($service->status === 'in_progress' ? 'in-progress' : 'pending') }}">
                                    {{ ucfirst($service->status) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($service->total_cost, 0, ',', '.') }}</td>
                            <td>{{ $service->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script>
    // Line Chart
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Services',
                data: [12, 19, 3, 5, 2, 3, 9],
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139,92,246,0.1)',
                fill: true,
                tension: 0.4
            }, {
                label: 'Revenue',
                data: [2, 29, 5, 5, 2, 3, 10],
                borderColor: '#f59e42',
                backgroundColor: 'rgba(245,158,66,0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Bar Chart
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Services',
                data: [5, 10, 8, 12, 7, 14, 6],
                backgroundColor: '#8b5cf6'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Pie Charts
    new Chart(document.getElementById('pieChart1'), {
        type: 'doughnut',
        data: {
            labels: ['Done', 'Remaining'],
            datasets: [{
                data: [13, 87],
                backgroundColor: ['#3b82f6', '#e5e7eb'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    new Chart(document.getElementById('pieChart2'), {
        type: 'doughnut',
        data: {
            labels: ['Done', 'Remaining'],
            datasets: [{
                data: [26, 74],
                backgroundColor: ['#8b5cf6', '#e5e7eb'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endpush
@endsection 