@extends('Branch.Layouts.layout')
@section('meta_title', 'View Sample Collection | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            {{-- Hero Header --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-1">View Sample Collection</h2>
                        <p class="mb-0">Details for Sample Code: {{ !empty($sample->sample_code) ? $sample->sample_code : 'N/A' }}</p>
                          <a href="{{ route('branch.sample.index') }}" 
                           class="btn btn-light btn-lg fw-semibold rounded-pill shadow-sm"
                           style="background: #f6b51d; color: #1f2937; border: none;">
                            <i class="mdi mdi-arrow-left me-2"></i> Back to List
                        </a>
                    </div>
                    
                </div>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-test-tube"></i>
                </div>
            </div>

            {{-- Details Card --}}
            <div class="card border-0 shadow-lg rounded-4" 
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-4">
                    
                    {{-- Basic Info Section --}}
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="fw-bold text-center mb-3 d-flex align-items-center justify-content-center" style="color: #6267ae;">
                                <i class="mdi mdi-clipboard-text me-2"></i> Basic Information
                            </h5>
                            <hr class="border-primary border-2 opacity-10 mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <label class="fw-semibold me-3" style="color: #6267ae; min-width: 150px;">
                                            <i class="mdi mdi-barcode me-1"></i>Sample Code:
                                        </label>
                                        <span class="text-muted">{{ !empty($sample->sample_code) ? $sample->sample_code : 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <label class="fw-semibold me-3" style="color: #6267ae; min-width: 150px;">
                                            <i class="mdi mdi-flask me-1"></i>Sample Type:
                                        </label>
                                        <span class="text-muted">{{ !empty($sample->sample_type) ? $sample->sample_type : 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <label class="fw-semibold me-3" style="color: #6267ae; min-width: 150px;">
                                            <i class="mdi mdi-flag-variant me-1"></i>Status:
                                        </label>
                                        @php
                                            $status = $sample->status ?? 'N/A';
                                            $badgeClass = match($status) {
                                                'Pending' => 'warning',
                                                'Collected' => 'primary',
                                                'In Transit' => 'info',
                                                'Received' => 'success',
                                                'Processing' => 'warning',
                                                'Analyzed' => 'info',
                                                'Reported' => 'success',
                                                'Completed' => 'success',
                                                'Cancelled' => 'danger',
                                                'Rejected' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }} fs-6">{{ $status }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <label class="fw-semibold me-3" style="color: #6267ae; min-width: 150px;">
                                            <i class="mdi mdi-calendar-clock me-1"></i>Collection Date & Time:
                                        </label>
                                        <span class="text-muted">
                                            @if(!empty($sample->collection_date) && !empty($sample->collection_time))
                                                @php
                                                    $dateStr = is_object($sample->collection_date) ? $sample->collection_date->format('Y-m-d') : $sample->collection_date;
                                                    $timeStr = is_object($sample->collection_time) ? $sample->collection_time->format('H:i:s') : $sample->collection_time;
                                                @endphp
                                                {{ \Carbon\Carbon::parse($dateStr . ' ' . $timeStr)->format('d M Y h:i A') }}
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex align-items-start">
                                        <label class="fw-semibold me-3" style="color: #6267ae; min-width: 150px;">
                                            <i class="mdi mdi-note-text me-1"></i>Notes:
                                        </label>
                                        <span class="text-muted flex-grow-1">{{ !empty($sample->notes) ? $sample->notes : 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Appointment Section --}}
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="fw-bold text-center mb-3 d-flex align-items-center justify-content-center" style="color: #6267ae;">
                                <i class="mdi mdi-calendar-check me-2"></i> Appointment Details
                            </h5>
                            <hr class="border-primary border-2 opacity-10 mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <label class="fw-semibold me-3" style="color: #6267ae; min-width: 150px;">
                                            <i class="mdi mdi-calendar-edit me-1"></i>Appointment Code:
                                        </label>
                                        <span class="text-muted">{{ !empty($sample->appointment) && !empty($sample->appointment->appointment_code) ? $sample->appointment->appointment_code : 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <label class="fw-semibold me-3" style="color: #6267ae; min-width: 150px;">
                                            <i class="mdi mdi-account me-1"></i>Patient Name:
                                        </label>
                                        <span class="text-muted">
                                            @if(!empty($sample->appointment))
                                                @if(!empty($sample->appointment->patient_name))
                                                    {{ $sample->appointment->patient_name }}
                                                @elseif(!empty($sample->appointment->pet) && !empty($sample->appointment->pet->petParent) && !empty($sample->appointment->pet->petParent->name))
                                                    {{ $sample->appointment->pet->petParent->name }}
                                                @else
                                                    N/A
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Source & Destination Section --}}
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="fw-bold text-center mb-3 d-flex align-items-center justify-content-center" style="color: #6267ae;">
                                <i class="mdi mdi-map-marker-multiple me-2"></i> Collection Source & Destination
                            </h5>
                            <hr class="border-primary border-2 opacity-10 mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <label class="fw-semibold me-3" style="color: #6267ae; min-width: 150px;">
                                            <i class="mdi mdi-map-marker me-1"></i>Collection Source:
                                        </label>
                                        <span class="text-muted">
                                            @if(!empty($sample->collectionSource))
                                                {{ !empty($sample->collectionSource->branch_name) ? $sample->collectionSource->branch_name : 'N/A' }} 
                                                ({{ !empty($sample->collectionSource->branch_code) ? $sample->collectionSource->branch_code : 'N/A' }})
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <label class="fw-semibold me-3" style="color: #6267ae; min-width: 150px;">
                                            <i class="mdi mdi-laboratory me-1"></i>Destination Lab:
                                        </label>
                                        <span class="text-muted">
                                            @if(!empty($sample->destinationLab))
                                                {{ !empty($sample->destinationLab->branch_name) ? $sample->destinationLab->branch_name : 'N/A' }} 
                                                ({{ !empty($sample->destinationLab->branch_code) ? $sample->destinationLab->branch_code : 'N/A' }})
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Audit Info Section --}}
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="fw-bold text-center mb-3 d-flex align-items-center justify-content-center" style="color: #6267ae;">
                                <i class="mdi mdi-history me-2"></i> Audit Information
                            </h5>
                            <hr class="border-primary border-2 opacity-10 mb-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <label class="fw-semibold me-3" style="color: #6267ae; min-width: 150px;">
                                            <i class="mdi mdi-account-plus me-1"></i>Created By:
                                        </label>
                                        <span class="text-muted">{{ !empty($sample->created_by) ? 'Admin ID: ' . $sample->created_by : 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <label class="fw-semibold me-3" style="color: #6267ae; min-width: 150px;">
                                            <i class="mdi mdi-clock-outline me-1"></i>Created At:
                                        </label>
                                        <span class="text-muted">{{ !empty($sample->created_at) ? $sample->created_at->format('d M Y h:i A') : 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <label class="fw-semibold me-3" style="color: #6267ae; min-width: 150px;">
                                            <i class="mdi mdi-account-edit me-1"></i>Modified By:
                                        </label>
                                        <span class="text-muted">{{ !empty($sample->modified_by) ? 'Admin ID: ' . $sample->modified_by : 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <label class="fw-semibold me-3" style="color: #6267ae; min-width: 150px;">
                                            <i class="mdi mdi-clock-fast me-1"></i>Modified At:
                                        </label>
                                        <span class="text-muted">{{ !empty($sample->updated_at) ? $sample->updated_at->format('d M Y h:i A') : 'N/A' }}</span>
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