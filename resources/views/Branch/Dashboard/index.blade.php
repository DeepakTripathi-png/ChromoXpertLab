@extends('Branch.Layouts.layout')

@section('meta_title')
    Branch Dashboard | Pets Lab Chain
@endsection

@section('css')
<style>
    .card {
        display: block;
        min-width: 0;
        word-wrap: break-word;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(14px);
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        margin-bottom: 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .content {
        padding-top: 25px;
    }

    .content-page {
        padding: 0 12px 40px 12px;
    }

    .widget-chart-1 i {
        font-size: 2rem;
        margin-right: 1rem;
        color: #6267ae;
    }

    .chartjs-chart canvas {
        max-height: 300px;
    }

    .revenue-chart-tabs .nav-link {
        padding: 0.5rem 1rem;
        cursor: pointer;
        color: #6267ae;
        border: 1px solid #f6b51d;
        border-radius: 0.25rem;
        margin-right: 0.5rem;
    }

    .revenue-chart-tabs .nav-link.active {
        background: #6267ae;
        color: #fff;
        border: none;
    }

    .header-title {
        color: #6267ae;
    }

    .btn-info {
        background-color: #6267ae;
        border-color: #6267ae;
    }

    .btn-info:hover {
        background-color: #f6b51d;
        border-color: #f6b51d;
        color: #fff;
    }

    .btn-danger {
        background-color: #cc235e;
        border-color: #cc235e;
    }

    .btn-danger:hover {
        background-color: #b01f53;
        border-color: #b01f53;
    }

    .appointment-card,
    .report-card {
        border-left: 4px solid #6267ae;
        margin-bottom: 1rem;
    }

    .appointment-card .card-header,
    .report-card .card-header {
        background: none;
        border: none;
        padding: 0.75rem 1rem;
    }

    .appointment-card .card-body,
    .report-card .card-body {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
    }

    .status-badge {
        font-size: 0.75em;
    }

    .badge.bg-success {
        background-color: #6267ae !important;
    }

    .badge.bg-warning {
        background-color: #f6b51d !important;
        color: #000;
    }

    .badge.bg-danger {
        background-color: #cc235e !important;
    }

    .card-title {
        color: #6267ae;
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
    }

    .card-text {
        color: #6267ae;
        margin-bottom: 0.25rem;
    }
</style>
@endsection

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid dashboard-cards">
            <!-- Hero Header -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-3">
                                
                                @if(!empty($type) && $type == 'branch')
                                    Branch
                                @elseif(!empty($type) && $type == 'hospital')
                                    Hospital
                                @elseif(!empty($type) && $type == 'admin')
                                    Collection Center
                                @endif

                                
                                Dashboard</h4>
                            <p>Welcome, {{ Auth::guard('branch')->user()->name }}!</p>
                            @php
                                $privileges = explode(',', Auth::guard('branch')->user()->role->privileges ?? '');
                            @endphp
                            <div class="mb-3">
                                {{-- @if(in_array('branch_view', $privileges))
                                    <a href="{{ route('branches.index') }}" class="btn btn-info me-2">View Branch Details</a>
                                @endif
                                @if(in_array('appointments_view', $privileges))
                                    <a href="{{ route('appointments.index') }}" class="btn btn-info me-2">View Appointments</a>
                                @endif --}}
                                {{-- <a href="{{ route('branch.logout') }}" class="btn btn-danger">Logout</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Metrics Cards -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-4">Total Appointments</h4>
                            <div class="widget-chart-1">
                                <div class="widget-chart-box-1 float-start" dir="ltr">
                                    <i class="mdi mdi-calendar-check"></i>
                                </div>
                                <div class="widget-detail-1 text-end">
                                    <h2 class="fw-normal pt-2 mb-1" style="color: #6267ae;">450</h2>
                                    <p class="mb-1" style="color: #6267ae;">This Month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-4">Pending Tests</h4>
                            <div class="widget-chart-1">
                                <div class="widget-chart-box-1 float-start" dir="ltr">
                                    <i class="mdi mdi-test-tube"></i>
                                </div>
                                <div class="widget-detail-1 text-end">
                                    <h2 class="fw-normal pt-2 mb-1" style="color: #6267ae;">120</h2>
                                    <p class="mb-1" style="color: #6267ae;">Awaiting Results</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-4">Branch Revenue</h4>
                            <div class="widget-chart-1">
                                <div class="widget-chart-box-1 float-start" dir="ltr">
                                    <i class="mdi mdi-currency-inr"></i>
                                </div>
                                <div class="widget-detail-1 text-end">
                                    <h2 class="fw-normal pt-2 mb-1" style="color: #6267ae;">1,25,000</h2>
                                    <p class="mb-1" style="color: #6267ae;">This Month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-4">Pet Owners Served</h4>
                            <div class="widget-chart-1">
                                <div class="widget-chart-box-1 float-start" dir="ltr">
                                    <i class="mdi mdi-account"></i>
                                </div>
                                <div class="widget-detail-1 text-end">
                                    <h2 class="fw-normal pt-2 mb-1" style="color: #6267ae;">300</h2>
                                    <p class="mb-1" style="color: #6267ae;">Unique Owners</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Graph -->
            @if(!empty($type) && $type == 'branch')
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-3">Branch Revenue Overview</h4>
                            <ul class="nav nav-pills revenue-chart-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-type="daily">Daily</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-type="monthly">Monthly</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-type="yearly">Yearly</a>
                                </li>
                            </ul>
                            <div class="chartjs-chart">
                                <canvas id="revenue-line-chart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Latest Appointments and Reports -->
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-3">Latest Appointments</h4>
                            <div class="appointment-list mt-3">
                                <!-- Static Appointment Card 1 -->
                                <div class="card appointment-card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span class="card-title">Oct 1, 2025</span>
                                        <span class="badge bg-warning status-badge">Pending</span>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><strong>Pet:</strong> Max</p>
                                        <p class="card-text"><strong>Owner:</strong> John Doe</p>
                                    </div>
                                </div>
                                <!-- Static Appointment Card 2 -->
                                <div class="card appointment-card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span class="card-title">Sep 30, 2025</span>
                                        <span class="badge bg-success status-badge">Completed</span>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><strong>Pet:</strong> Bella</p>
                                        <p class="card-text"><strong>Owner:</strong> Jane Smith</p>
                                    </div>
                                </div>
                                <!-- Static Appointment Card 3 -->
                                <div class="card appointment-card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span class="card-title">Sep 29, 2025</span>
                                        <span class="badge bg-danger status-badge">Cancelled</span>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><strong>Pet:</strong> Rocky</p>
                                        <p class="card-text"><strong>Owner:</strong> Mike Johnson</p>
                                    </div>
                                </div>
                                <!-- Static Appointment Card 4 -->
                                <div class="card appointment-card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span class="card-title">Sep 28, 2025</span>
                                        <span class="badge bg-warning status-badge">Pending</span>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><strong>Pet:</strong> Luna</p>
                                        <p class="card-text"><strong>Owner:</strong> Sarah Wilson</p>
                                    </div>
                                </div>
                                <!-- Static Appointment Card 5 -->
                                <div class="card appointment-card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span class="card-title">Sep 27, 2025</span>
                                        <span class="badge bg-success status-badge">Completed</span>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><strong>Pet:</strong> Charlie</p>
                                        <p class="card-text"><strong>Owner:</strong> David Brown</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-3">Latest Reports</h4>
                            <div class="report-list mt-3">
                                <!-- Static Report Card 1 -->
                                <div class="card report-card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span class="card-title">Oct 1, 2025</span>
                                        <span class="badge bg-warning status-badge">Processing</span>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><strong>Test Type:</strong> Blood Test</p>
                                        <p class="card-text"><strong>Pet:</strong> Max</p>
                                    </div>
                                </div>
                                <!-- Static Report Card 2 -->
                                <div class="card report-card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span class="card-title">Sep 30, 2025</span>
                                        <span class="badge bg-success status-badge">Ready</span>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><strong>Test Type:</strong> Urine Test</p>
                                        <p class="card-text"><strong>Pet:</strong> Bella</p>
                                    </div>
                                </div>
                                <!-- Static Report Card 3 -->
                                <div class="card report-card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span class="card-title">Sep 29, 2025</span>
                                        <span class="badge bg-danger status-badge">Failed</span>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><strong>Test Type:</strong> X-Ray</p>
                                        <p class="card-text"><strong>Pet:</strong> Rocky</p>
                                    </div>
                                </div>
                                <!-- Static Report Card 4 -->
                                <div class="card report-card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span class="card-title">Sep 28, 2025</span>
                                        <span class="badge bg-success status-badge">Ready</span>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><strong>Test Type:</strong> Blood Test</p>
                                        <p class="card-text"><strong>Pet:</strong> Luna</p>
                                    </div>
                                </div>
                                <!-- Static Report Card 5 -->
                                <div class="card report-card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span class="card-title">Sep 27, 2025</span>
                                        <span class="badge bg-warning status-badge">Processing</span>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><strong>Test Type:</strong> Urine Test</p>
                                        <p class="card-text"><strong>Pet:</strong> Charlie</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Line Chart
    var revenueCanvas = document.getElementById('revenue-line-chart').getContext('2d');
    var revenueChart = new Chart(revenueCanvas, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Revenue (₹)',
                data: [],
                borderColor: '#6267ae',
                backgroundColor: 'rgba(98, 103, 174, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Revenue (₹)',
                        color: '#6267ae'
                    },
                    ticks: {
                        color: '#6267ae'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Time',
                        color: '#6267ae'
                    },
                    ticks: {
                        color: '#6267ae'
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#6267ae'
                    }
                }
            }
        }
    });

    // Revenue Data for Branch
    const revenueData = {
        daily: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            data: [10000, 15000, 12000, 18000, 20000, 22000, 25000]
        },
        monthly: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            data: [100000, 120000, 110000, 130000, 140000, 130000, 150000, 140000, 160000, 170000, 180000, 200000]
        },
        yearly: {
            labels: ['2021', '2022', '2023', '2024', '2025'],
            data: [1000000, 1200000, 1400000, 1600000, 1800000]
        }
    };

    // Update Revenue Chart based on tab selection
    function updateRevenueChart(type) {
        const data = revenueData[type];
        revenueChart.data.labels = data.labels;
        revenueChart.data.datasets[0].data = data.data;
        revenueChart.options.scales.x.title.text = type.charAt(0).toUpperCase() + type.slice(1);
        revenueChart.data.datasets[0].label = `Revenue (₹) - {{ Auth::guard('branch')->user()->branch_name }}`;
        revenueChart.update();
    }

    // Tab click handler
    document.querySelectorAll('.revenue-chart-tabs .nav-link').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.revenue-chart-tabs .nav-link').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const type = this.getAttribute('data-type');
            updateRevenueChart(type);
        });
    });

    // Trigger daily tab by default
    document.querySelector('.revenue-chart-tabs .nav-link[data-type="daily"]').click();
</script>
@endsection