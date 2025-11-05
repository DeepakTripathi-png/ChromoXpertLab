@section('meta_title') Dashboard | Pets Lab Chain @endsection
@extends('Admin.Layouts.layout')

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

    .morris-donut-example svg text tspan {
        font-size: 10px !important;
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

    .lab-select {
        max-width: 200px;
        margin-bottom: 1rem;
        background: #fff;
        color: #6267ae;
        border: 1px solid #f6b51d;
        border-radius: 0.5rem;
    }

    .lab-select:focus {
        border-color: #f6b51d;
        box-shadow: 0 0 0 0.25rem rgba(246, 181, 29, 0.25);
    }

    .header-title {
        color: #6267ae;
    }
</style>
@endsection

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid dashboard-cards">
            <!-- Hero Header -->
        
            <!-- Key Metrics Cards -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-4">Total Pet Bookings</h4>
                            <div class="widget-chart-1">
                                <div class="widget-chart-box-1 float-start" dir="ltr">
                                    <i class="mdi mdi-paw"></i>
                                </div>
                                <div class="widget-detail-1 text-end">
                                    <h2 class="fw-normal pt-2 mb-1" style="color: #6267ae;">1,250</h2>
                                    <p class="mb-1" style="color: #6267ae;">Total Test Bookings</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-4">Active pets/animals' owners</h4>
                            <div class="widget-chart-1">
                                <div class="widget-chart-box-1 float-start" dir="ltr">
                                    <i class="mdi mdi-account"></i>
                                </div>
                                <div class="widget-detail-1 text-end">
                                    <h2 class="fw-normal pt-2 mb-1" style="color: #6267ae;">850</h2>
                                    <p class="mb-1" style="color: #6267ae;">Registered Pet Owners</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-4">Lab Tests Conducted</h4>
                            <div class="widget-chart-1">
                                <div class="widget-chart-box-1 float-start" dir="ltr">
                                    <i class="mdi mdi-test-tube"></i>
                                </div>
                                <div class="widget-detail-1 text-end">
                                    <h2 class="fw-normal pt-2 mb-1" style="color: #6267ae;">3,200</h2>
                                    <p class="mb-1" style="color: #6267ae;">Total Tests</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-4">Total Revenue</h4>
                            <div class="widget-chart-1">
                                <div class="widget-chart-box-1 float-start" dir="ltr">
                                    <i class="mdi mdi-currency-inr"></i>
                                </div>
                                <div class="widget-detail-1 text-end">
                                    <h2 class="fw-normal pt-2 mb-1" style="color: #6267ae;">3,750</h2>
                                    <p class="mb-1" style="color: #6267ae;">This Month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Graphs -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-3">Revenue Overview</h4>
                            <div class="d-flex justify-content-between align-items-center mb-3">
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
                                <select class="form-select lab-select" id="lab-select">
                                    <option value="all">All Labs</option>
                                    <option value="labA">Lab A</option>
                                    <option value="labB">Lab B</option>
                                    <option value="labC">Lab C</option>
                                </select>
                            </div>
                            <div class="chartjs-chart">
                                <canvas id="revenue-line-chart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Test Bookings and Lab Test Types -->
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-3">Test  Status</h4>
                            <div class="chartjs-chart">
                                <canvas data-counts='[150, 80, 30]' id="booking-pie-chart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mt-0 mb-3">Lab Test Types</h4>
                            <div class="chartjs-chart">
                                <canvas data-counts='[200, 150, 100]' id="test-types-doughnut-chart" height="300"></canvas>
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
    // Test Bookings Pie Chart
    var pieCanvas = document.getElementById('booking-pie-chart').getContext('2d');
    var booking_counts = JSON.parse($("#booking-pie-chart").attr('data-counts'));
    var pieData = {
        labels: ['Completed', 'Pending', 'Cancelled'],
        datasets: [{
            data: booking_counts,
            backgroundColor: ["#6267ae", "#f6b51d", "#cc235e"],
            hoverBackgroundColor: ["#6267ae", "#f6b51d", "#cc235e"],
            hoverBorderColor: "#fff",
        }]
    };
    new Chart(pieCanvas, {
        type: 'pie',
        data: pieData,
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#6267ae'
                    }
                }
            }
        }
    });

    // Lab Test Types Doughnut Chart
    var doughnutCanvas = document.getElementById('test-types-doughnut-chart').getContext('2d');
    var test_types_counts = JSON.parse($("#test-types-doughnut-chart").attr('data-counts'));
    var doughnutData = {
        labels: ['Blood Test', 'Urine Test', 'X-Ray'],
        datasets: [{
            data: test_types_counts,
            backgroundColor: ["#6267ae", "#f6b51d", "#cc235e"],
            hoverBackgroundColor: ["#6267ae", "#f6b51d", "#cc235e"],
            hoverBorderColor: "#fff",
        }]
    };
    new Chart(doughnutCanvas, {
        type: 'doughnut',
        data: doughnutData,
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#6267ae'
                    }
                }
            }
        }
    });

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

    // Revenue Data by Lab
    const revenueData = {
        all: {
            daily: { labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], data: [40000, 55000, 50000, 65000, 70000, 80000, 95000] },
            monthly: { labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], data: [400000, 500000, 450000, 600000, 650000, 600000, 700000, 650000, 750000, 800000, 900000, 1000000] },
            yearly: { labels: ['2021', '2022', '2023', '2024', '2025'], data: [4000000, 5000000, 6000000, 7500000, 8500000] }
        },
        labA: {
            daily: { labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], data: [15000, 20000, 18000, 22000, 25000, 30000, 35000] },
            monthly: { labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], data: [150000, 180000, 160000, 200000, 220000, 200000, 250000, 230000, 260000, 280000, 300000, 350000] },
            yearly: { labels: ['2021', '2022', '2023', '2024', '2025'], data: [1500000, 1800000, 2000000, 2500000, 3000000] }
        },
        labB: {
            daily: { labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], data: [12000, 15000, 14000, 18000, 20000, 22000, 25000] },
            monthly: { labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], data: [120000, 140000, 130000, 150000, 160000, 150000, 180000, 170000, 190000, 200000, 220000, 250000] },
            yearly: { labels: ['2021', '2022', '2023', '2024', '2025'], data: [1200000, 1400000, 1600000, 1800000, 2000000] }
        },
        labC: {
            daily: { labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], data: [13000, 16000, 15000, 19000, 21000, 23000, 27000] },
            monthly: { labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], data: [130000, 150000, 140000, 160000, 170000, 160000, 190000, 180000, 200000, 220000, 230000, 260000] },
            yearly: { labels: ['2021', '2022', '2023', '2024', '2025'], data: [1300000, 1500000, 1700000, 1900000, 2100000] }
        }
    };

    // Update Revenue Chart based on tab and dropdown selection
    function updateRevenueChart(type, lab) {
        const data = revenueData[lab][type];
        revenueChart.data.labels = data.labels;
        revenueChart.data.datasets[0].data = data.data;
        revenueChart.options.scales.x.title.text = type.charAt(0).toUpperCase() + type.slice(1);
        revenueChart.data.datasets[0].label = `Revenue (₹) - ${lab === 'all' ? 'All Labs' : lab.replace('lab', 'Lab ').replace(/(\b\w)/, c => c.toUpperCase())}`;
        revenueChart.update();
    }

    // Tab click handler
    document.querySelectorAll('.revenue-chart-tabs .nav-link').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.revenue-chart-tabs .nav-link').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const type = this.getAttribute('data-type');
            const lab = document.getElementById('lab-select').value;
            updateRevenueChart(type, lab);
        });
    });

    // Dropdown change handler
    document.getElementById('lab-select').addEventListener('change', function () {
        const lab = this.value;
        const activeTab = document.querySelector('.revenue-chart-tabs .nav-link.active').getAttribute('data-type');
        updateRevenueChart(activeTab, lab);
    });

    // Trigger daily tab and All Labs by default
    document.querySelector('.revenue-chart-tabs .nav-link[data-type="daily"]').click();
</script>
@endsection