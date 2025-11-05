@extends('Branch.Layouts.layout')

@section('meta_title', 'Notifications | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            {{-- Hero Header --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Notifications</h2>
                <p class="mb-0">View and manage your system notifications</p>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-bell"></i>
                </div>
            </div>

            {{-- Notification Cards --}}
            <div class="row g-3 mb-5">
                @php
                    $notifications = [
                        [
                            'icon' => 'mdi-check-circle text-success',
                            'title' => 'New Pet Parent Added',
                            'time' => '2 hours ago',
                            'message' => 'A new pet parent, John Doe, has been successfully registered in the system.'
                        ],
                        [
                            'icon' => 'mdi-alert-circle text-warning',
                            'title' => 'Payment Pending',
                            'time' => '1 day ago',
                            'message' => 'Payment for order #12345 is pending. Please follow up with the pet parent.'
                        ],
                        [
                            'icon' => 'mdi-information text-info',
                            'title' => 'System Update',
                            'time' => '3 days ago',
                            'message' => 'The system has been updated to version 2.1.3. Check the changelog for details.'
                        ],
                        [
                            'icon' => 'mdi-account-plus text-primary',
                            'title' => 'New Staff Joined',
                            'time' => '5 days ago',
                            'message' => 'A new staff member, Jane Smith, has joined the clinic team.'
                        ],
                        [
                            'icon' => 'mdi-cash text-success',
                            'title' => 'Invoice Paid',
                            'time' => '6 days ago',
                            'message' => 'Invoice #45678 has been paid successfully by Mr. Patel.'
                        ],
                        [
                            'icon' => 'mdi-calendar-check text-purple',
                            'title' => 'Appointment Scheduled',
                            'time' => '1 week ago',
                            'message' => 'An appointment with Dr. Mehta has been scheduled for tomorrow.'
                        ],
                        [
                            'icon' => 'mdi-database-refresh text-info',
                            'title' => 'Backup Completed',
                            'time' => '2 weeks ago',
                            'message' => 'System backup completed successfully on the server.'
                        ],
                        [
                            'icon' => 'mdi-alert text-danger',
                            'title' => 'Low Stock Alert',
                            'time' => '3 weeks ago',
                            'message' => 'Medicine stock for Vaccine-X is running low. Please restock soon.'
                        ],
                    ];
                @endphp

                @foreach ($notifications as $notify)
                <div class="col-md-6 col-lg-4 notification-card">
                    <div class="card border-0 shadow-lg rounded-4 h-100" 
                         style="background: rgba(255,255,255,0.9); backdrop-filter: blur(14px);">
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="mdi {{ $notify['icon'] }} fs-3"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="fw-semibold mb-1" style="color: #6267ae;">{{ $notify['title'] }}</h5>
                                        <small class="text-muted">{{ $notify['time'] }}</small>
                                    </div>
                                </div>
                                <p class="mb-3" style="color: #333;">{{ $notify['message'] }}</p>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="#" 
                                   class="btn btn-sm rounded-pill shadow-sm flex-grow-1 view-btn"
                                   style="background: #fff; color: #6267ae; border: 1px solid #6267ae;">
                                    <i class="mdi mdi-eye me-1"></i> View
                                </a>
                                <button type="button" 
                                        class="btn btn-sm rounded-pill shadow-sm flex-grow-1 mark-read-btn"
                                        style="background: #fff; color: #cc235e; border: 1px solid #cc235e;">
                                    <i class="mdi mdi-check me-1"></i> Mark as Read
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endsection

@section('style')
<style>
    .card { transition: transform 0.2s ease-in-out; }
    .card:hover { transform: translateY(-5px); }
    .d-flex.gap-2 > .btn { min-width: 100px; }
    .btn { font-weight: 500; }
    .btn i { vertical-align: middle; }

    /* Extra bottom margin for last card row */
    .notification-card:last-child {
        margin-bottom: 30px;
    }

    /* Button hover effects */
    .view-btn:hover {
        background: #6267ae;
        color: #fff;
        border-color: #6267ae;
    }

    .mark-read-btn:hover {
        background: #cc235e;
        color: #fff;
        border-color: #cc235e;
    }
</style>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Highlight active menu
        $(".notifications").addClass("menuitem-active");

        // Example "Mark as Read" action
        $(".mark-read-btn").on("click", function() {
            $(this).closest(".card").fadeOut();
        });
    });
</script>
@endsection