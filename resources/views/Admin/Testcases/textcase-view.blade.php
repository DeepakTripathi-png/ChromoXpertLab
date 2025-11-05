@extends('Admin.Layouts.layout')
@section('meta_title') View Test | ChromoXpert @endsection

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            {{-- Hero Header with Gradient Background --}}

            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6b6e9d 0%, #c9365e 100%); color: #fff; min-height: 150px;">
                <h2 class="fw-bold mb-1">View Laboratory Test</h2>
                <p class="mb-0">Review the details and configurations of the laboratory test</p>
                
                    <a href="{{ url()->previous() }}" 
                       class="btn btn-light mt-3 fw-semibold rounded-pill shadow-sm"
                        style="background: #f6b51d; color: #1f2937; border: none; transition: transform 0.2s;"
                       data-bs-toggle="tooltip" title="Return to previous page">
                        <i class="mdi mdi-arrow-left me-2"></i> Back
                    </a>
           
                <div class="position-absolute top-0 end-0 opacity-20" style="font-size: 180px; color: #d1a7c8;">
                    <i class="mdi mdi-test-tube"></i>
                </div>
            </div>

         

            {{-- Success and Error Messages --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert"
                 style="background: #6b6e9d; color: #fff; border: none;">
                <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert"
                 style="background: #c9365e; color: #fff; border: none;">
                <i class="mdi mdi-alert me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            {{-- Glassmorphic Card with Fade-in Animation --}}
            <div class="card border-0 shadow-lg rounded-4 fade-in"
                 style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px);">
                <div class="card-body p-5">
                    <!-- Basic Info -->
                    <h4 class="fw-bold mb-4 text-primary">Test Details</h4>
                    <div class="row row-cols-1 row-cols-md-2 g-4 fade-in-row">
                        <div class="col">
                            <div class="bg-light p-3 rounded shadow-sm">
                                <label class="form-label text-muted small">Test Code</label>
                                <p class="fs-4 fw-semibold text-dark">{{ $test->test_code ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bg-light p-3 rounded shadow-sm">
                                <label class="form-label text-muted small">Test Name</label>
                                <p class="fs-4 fw-semibold text-dark">{{ $test->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bg-light p-3 rounded shadow-sm">
                                <label class="form-label text-muted small">Short Name</label>
                                <p class="fs-4 fw-semibold text-dark">{{ $test->short_name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bg-light p-3 rounded shadow-sm">
                                <label class="form-label text-muted small">Department</label>
                                <p class="fs-4 fw-semibold text-dark">{{ $test->department->department_name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bg-light p-3 rounded shadow-sm">
                                <label class="form-label text-muted small">Sample Type</label>
                                <p class="fs-4 fw-semibold text-dark">{{ $test->sample_type ?? 'N/A' }}</p>
                            </div>
                        </div>

                         <div class="col">
                            <div class="bg-light p-3 rounded shadow-sm">
                                <label class="form-label text-muted small">Test For</label>
                                <p class="fs-4 fw-semibold text-dark text-capitalize">{{ $test->test_for?? 'All' }}</p>
                            </div>
                        </div>

                        <div class="col">
                            <div class="bg-light p-3 rounded shadow-sm">
                                <label class="form-label text-muted small">Price (₹)</label>
                                <p class="fs-4 fw-semibold text-dark">{{ number_format($test->base_price, 2) ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="bg-light p-3 rounded shadow-sm">
                                <label class="form-label text-muted small">Status</label>
                                <p class="fs-4 fw-semibold text-dark">{{ ucfirst($test->status) ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="bg-light p-3 rounded shadow-sm">
                                <label class="form-label text-muted small">Precautions</label>
                                <p class="fs-4 fw-semibold text-dark">{{ $test->precautions ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Test Components -->
                    <h4 class="fw-bold mb-4 mt-5 text-primary">Test Components</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead style="background: linear-gradient(135deg, #ac7fb6 0%, #f7c948 100%); color: #fff;">
                                <tr>
                                    <th class="text-white py-3">Name</th>
                                    <th class="text-white py-3">Unit</th>
                                    <th class="text-white py-3">Result</th>
                                    <th class="text-white py-3">Reference Range</th>
                                    <th class="text-white py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($test->parameters as $component)
                                <tr>
                                    <td class="align-middle fs-5">{{ $component->title ?? $component->name ?? 'N/A' }}</td>
                                    <td class="align-middle fs-5">{{ $component->unit ?? 'N/A' }}</td>
                                    <td class="align-middle fs-5">{{ $component->result_type == 'text' ? 'Text' : ($component->options->pluck('option_value')->implode(', ') ?? 'N/A') }}</td>
                                    <td class="align-middle fs-5">{{ $component->reference_range ?? 'N/A' }}</td>
                                    <td class="align-middle fs-5">
                                        @if($component->status == 'active')
                                            <span class="badge bg-success rounded-pill">Active</span>
                                        @else
                                            <span class="badge bg-danger rounded-pill">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center fs-5">No components available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    .fade-in-row { animation: fadeInUp 0.6s ease-in-out; }
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .alert { border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .table thead th { border-bottom: 3px solid #e9ecef; }
    .badge { font-size: 0.9rem; padding: 0.4rem 0.8rem; }
    .text-muted { color: #6c757d !important; }
    .bg-light { background-color: #f8f9fa !important; transition: all 0.3s ease; }
    .bg-light:hover { background-color: #e9ecef !important; }

    @media (max-width: 768px) {
        .btn-lg { font-size: 0.875rem; padding: 0.5rem 1rem; }
        .fs-4 { font-size: 1.1rem !important; }
        .p-5 { padding: 1.25rem !important; }
        .table { font-size: 0.9rem; }
        .col-md-6 { margin-bottom: 1.5rem; }
        .display-6 { font-size: 1.5rem !important; }
    }
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>
@endsection