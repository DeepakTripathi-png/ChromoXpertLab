@extends('Admin.Layouts.layout')

@section('meta_title') Doctor Details | ChromoXpert @endsection

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            {{-- Hero Header with Gradient Background --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Doctor Details</h2>
                <p class="mb-0">View details of the selected internal doctor</p>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-doctor"></i>
                </div>
            </div>

            {{-- Glassmorphic Card for Doctor Details --}}
            <div class="card border-0 shadow-lg rounded-4"
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-4">
                    <div class="row g-3">
                        {{-- Code --}}
                        <div class="col-md-6">
                            <label class="fw-semibold" style="color: #6267ae;">Code</label>
                            <p class="mb-0">{{ $internalDoctor->code ?? 'N/A' }}</p>
                        </div>

                        {{-- Doctor Name --}}
                        <div class="col-md-6">
                            <label class="fw-semibold" style="color: #6267ae;">Name</label>
                            <p class="mb-0">{{ $internalDoctor->doctor_name ?? 'N/A' }}</p>
                        </div>

                        {{-- Gender --}}
                        <div class="col-md-6">
                            <label class="fw-semibold" style="color: #6267ae;">Gender</label>
                            <p class="mb-0">{{ $internalDoctor->gender ?? 'N/A' }}</p>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label class="fw-semibold" style="color: #6267ae;">Email</label>
                            <p class="mb-0">{{ $internalDoctor->email ?? 'N/A' }}</p>
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6">
                            <label class="fw-semibold" style="color: #6267ae;">Phone</label>
                            <p class="mb-0">{{ $internalDoctor->mobile ?? 'N/A' }}</p>
                        </div>

                        {{-- Address --}}
                        <div class="col-md-6">
                            <label class="fw-semibold" style="color: #6267ae;">Address</label>
                            <p class="mb-0">{{ $internalDoctor->address ?? 'N/A' }}</p>
                        </div>

                        {{-- Doctor Image --}}
                        <div class="col-md-6">
                            <label class="fw-semibold" style="color: #6267ae;">Doctor Image</label>
                            @if($internalDoctor->doctor_image_path)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $internalDoctor->doctor_image_path) }}" 
                                     alt="Doctor Image" 
                                     class="rounded-3 shadow-sm" 
                                     style="max-width: 150px; max-height: 150px; object-fit: cover;">
                            </div>
                            <p class="text-muted small mt-1">{{ $internalDoctor->doctor_image_name ?? 'N/A' }}</p>
                            @else
                            <p class="mb-0">N/A</p>
                            @endif
                        </div>

                        {{-- Doctor Signature --}}
                        <div class="col-md-6">
                            <label class="fw-semibold" style="color: #6267ae;">Doctor Signature</label>
                            @if($internalDoctor->doctor_sign_path)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $internalDoctor->doctor_sign_path) }}" 
                                     alt="Doctor Signature" 
                                     class="rounded-3 shadow-sm" 
                                     style="max-width: 150px; max-height: 150px; object-fit: cover;">
                            </div>
                            <p class="text-muted small mt-1">{{ $internalDoctor->doctor_sign_name ?? 'N/A' }}</p>
                            @else
                            <p class="mb-0">N/A</p>
                            @endif
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6">
                            <label class="fw-semibold" style="color: #6267ae;">Status</label>
                            <p class="mb-0">{{ ucfirst($internalDoctor->status) ?? 'N/A' }}</p>
                        </div>
                    </div>

                    {{-- Back Button --}}
                    <div class="mt-4">
                        <a href="{{ url()->previous() }}"  
                           class="btn btn-secondary btn-lg rounded-pill shadow-sm px-4"
                           style="background: #fff; color: #cc235e; border: 1px solid #cc235e;">
                            <i class="mdi mdi-arrow-left me-2"></i> Back to Doctors
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
    .fade-in-row { 
        animation: fadeInUp 0.6s ease-in-out; 
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-control:focus, .form-select:focus {
        border-color: #f6b51d;
        box-shadow: 0 0 8px rgba(246, 181, 29, 0.5);
    }

    @media (max-width: 768px) {
        .card-body { padding: 1.5rem; }
        img { max-width: 100px; max-height: 100px; }
        .btn-lg { font-size: 0.9rem; padding: 0.5rem 1rem; }
    }
</style>
@endsection

@section('script')
<script>
    // Initialize Bootstrap tooltips
    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endsection