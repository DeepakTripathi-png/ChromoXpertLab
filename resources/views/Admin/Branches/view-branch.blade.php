@extends('Admin.Layouts.layout')

@section('meta_title', 'Branch Details | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            {{-- Hero Header with Gradient Background --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Branch Details</h2>
                <p class="mb-0">View details of the selected branch</p>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-office-building" aria-hidden="true"></i>
                </div>
            </div>

            {{-- Glassmorphic Card for Branch Details --}}
            <div class="card border-0 shadow-lg rounded-4"
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-4">
                    <div class="row g-3">
                        @php
                            $fields = [
                                ['label' => 'Branch Code', 'value' => $branch->branch_code],
                                ['label' => 'Branch Name', 'value' => $branch->branch_name],
                                ['label' => 'Email', 'value' => $branch->email],
                                ['label' => 'Mobile', 'value' => $branch->mobile],
                                ['label' => 'Address', 'value' => $branch->address],
                                ['label' => 'Lab Incharge', 'value' => $labIncharge->user_name ?? null],
                                ['label' => 'Country', 'value' => $country->name ?? null],
                                ['label' => 'State', 'value' => $state->name ?? null],
                                ['label' => 'City', 'value' => $city->name ?? null],
                                ['label' => 'Pincode', 'value' => $branch->pincode],
                            ];
                        @endphp

                        @foreach ($fields as $field)
                            <div class="col-md-6 fade-in-row">
                                <label class="fw-semibold text-primary" style="color: #6267ae;">{{ $field['label'] }}</label>
                                <p class="mb-0">{{ $field['value'] ?? 'N/A' }}</p>
                            </div>
                        @endforeach

                        {{-- Branch Logo --}}
                        <div class="col-md-6 fade-in-row">
                            <label class="fw-semibold text-primary" style="color: #6267ae;" for="branch-logo">Branch Logo</label>
                            @if($branch->branch_logo_path)
                                <div class="mt-2">
                                    <img id="branch-logo"
                                         src="{{ Storage::url($branch->branch_logo_path) }}"
                                         alt="{{ $branch->branch_name ?? 'Branch' }} Logo"
                                         class="branch-logo rounded-3 shadow-sm"
                                         onerror="this.onerror=null; this.src='/images/placeholder-branch.png'">
                                </div>
                                <p class="text-muted small mt-1">{{ $branch->branch_logo_name ?? 'N/A' }}</p>
                            @else
                                <p class="mb-0">N/A</p>
                            @endif
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-4 d-flex gap-3 justify-content-start flex-wrap">
                        <a href="{{ url('admin/branches') }}"  
                           class="btn btn-outline-danger btn-lg rounded-pill shadow-sm px-4 d-flex align-items-center">
                            <i class="mdi mdi-arrow-left me-2" aria-hidden="true"></i> Back to Branches
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

    .branch-logo {
        max-width: 150px;
        max-height: 150px;
        object-fit: contain;
    }

    .text-primary {
        color: #6267ae !important;
    }

    @media (max-width: 768px) {
        .card-body { padding: 1.5rem; }
        .branch-logo { max-width: 100px; max-height: 100px; }
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