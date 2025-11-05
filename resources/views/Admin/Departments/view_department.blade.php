@extends('Admin.Layouts.layout')

@section('meta_title', 'View Department | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            {{-- Hero Header --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">View Department</h2>
                <p class="mb-0">Details of {{ $department->department_name }}</p>
                <a href="{{ url()->previous() }}" 
                   class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                   style="background: #f6b51d; color: #1f2937; border: none;">
                    <i class="mdi mdi-arrow-left me-2"></i> Back
                </a>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-medical-bag"></i>
                </div>
            </div>

            {{-- Details Card --}}
            <div class="card border-0 shadow-lg rounded-4" 
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <h5 style="color: #6267ae;">Code</h5>
                            <p>{{ $department->code ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 style="color: #6267ae;">Department Name</h5>
                            <p>{{ $department->department_name ?? 'N/A' }}</p>
                        </div>

                        <div class="col-md-6">
                            <h5 style="color: #6267ae;">Department Head</h5>
                            <p>{{ $department->head ? $department->head->user_name : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 style="color: #6267ae;">Phone Number</h5>
                            <p>{{ $department->mobile ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 style="color: #6267ae;">Email Address</h5>
                            <p>{{ $department->email ?? 'N/A' }}</p>
                        </div>
                        <div class="col-12">
                            <h5 style="color: #6267ae;">Description</h5>
                            <p>{{ $department->description ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 style="color: #6267ae;">Status</h5>
                            <p>{{ ucfirst($department->status) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
    h5 { font-weight: 600; }
    p { margin-bottom: 0; color: #1f2937; }
</style>
@endsection