@extends('Admin.Layouts.layout')
@section('meta_title', 'Departments | ChromoXpert')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            {{-- Unified Header --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Departments Management</h2>
                <p class="mb-0">Add, edit, and manage all department records from a single place</p>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-medical-bag"></i>
                </div>
            </div>

            {{-- Main Section --}}
            <div class="row g-4">
                {{-- Left Side: Department Form --}}
                <div class="col-lg-5">
                    <div class="card border-0 shadow-lg rounded-4"
                        style="background: rgba(255,255,255,0.95); backdrop-filter: blur(14px);">
                        <div class="card-body p-4">
                            <form action="{{ route('department.store') }}" method="POST" enctype="multipart/form-data"
                                id="departmentForm">
                                @csrf
                                <input type="hidden" name="id" value="{{ $department?->id ?? '' }}">

                                <div class="row g-3">

                                    {{-- Department Code (only for edit) --}}
                                    @if(isset($department) && $department->code)
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control rounded-3"
                                                value="{{ $department->code }}" readonly
                                                style="background: #f8f9fa; color: #6c757d; border: 1px solid #dee2e6;">
                                            <label style="color: #6267ae;">Department Code</label>
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Department Name --}}
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control rounded-3" id="department_name"
                                                name="department_name" placeholder=" "
                                                value="{{ old('department_name', $department?->department_name ?? '') }}"
                                                style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                            <label for="department_name" style="color: #6267ae;">Department
                                                Name*</label>
                                            @error('department_name')
                                            <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Description --}}
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control rounded-3" id="description" name="description"
                                                placeholder=" " style="background: #fff; color: #6267ae; border: 1px solid #f6b51d; min-height: 120px;">{{ old('description', $department?->description ?? '') }}</textarea>
                                            <label for="description" style="color: #6267ae;">Description</label>
                                            @error('description')
                                            <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Buttons --}}
                                <div class="mt-4 pt-3 border-top">
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="submit"
                                            class="btn btn-success flex-fill rounded-pill shadow-sm"
                                            style="background: #6267ae; color: #fff; border: none; padding: 12px;">
                                            <i class="mdi mdi-content-save me-2"></i>
                                            {{ isset($department) ? 'Update' : 'Save' }}
                                        </button>
                                        <button type="reset" class="btn flex-fill rounded-pill shadow-sm"
                                            style="background: #ac7fb6; color: #fff; border: none; padding: 12px;">
                                            <i class="mdi mdi-refresh me-2"></i> Reset
                                        </button>
                                        @if(isset($department))
                                        <a href="{{ route('departments.add') }}"
                                            class="btn btn-outline-secondary flex-fill rounded-pill shadow-sm"
                                            style="color: #6267ae; border-color: #6267ae; padding: 12px;">
                                            <i class="mdi mdi-plus me-2"></i> Add New
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Right Side: Department List --}}
                <div class="col-lg-7">
                    {{-- Search and Filter --}}
                    <div class="row g-2 mb-3 align-items-center">
                        <div class="col-md-6">
                            <input type="text" id="searchInput" class="form-control rounded-pill shadow-sm"
                                placeholder="Search departments..."
                                style="background: #fff; color: #6267ae; border: 1px solid #f6b51d; padding: 12px;">
                        </div>
                        <div class="col-md-4">
                            <select id="statusFilter" class="form-select rounded-pill shadow-sm"
                                style="background: #fff; color: #6267ae; border: 1px solid #f6b51d; padding: 12px;">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            {{-- <button type="button" id="refreshTable" class="btn btn-light rounded-pill shadow-sm w-100"
                                style="background: #f6b51d; color: #1f2937; border: none; padding: 12px;">
                                <i class="mdi mdi-refresh"></i>
                            </button> --}}
                        </div>
                    </div>

                    {{-- Departments Table --}}
                    <div class="card border-0 shadow-lg rounded-4"
                        style="background: rgba(255,255,255,0.95); backdrop-filter: blur(14px);">
                        <div class="card-body p-2">
                            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                <table id="cims_data_table" class="table align-middle table-hover w-100 mb-0">
                                    <thead
                                        style="background: linear-gradient(135deg, #ac7fb6 0%, #f6b51d 100%); color: #fff;">
                                        <tr>
                                            <th class="text-center" style="padding: 15px;">#</th>
                                            <th style="padding: 15px;">Code</th>
                                            <th style="padding: 15px;">Department Name</th>
                                            <th style="padding: 15px;">Description</th>
                                            <th style="padding: 15px;">Status</th>
                                            <th class="text-center" style="padding: 15px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
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
    .form-floating>.form-control,
    .form-floating>.form-select {
        height: calc(3.5rem + 2px);
    }

    .fade-in-row {
        animation: fadeInUp 0.6s ease-in-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #cims_data_table tbody td {
        padding: 15px !important;
        vertical-align: middle;
        border: none;
        color: #6267ae;
    }

    #cims_data_table tbody tr:hover {
        background-color: rgba(246, 181, 29, 0.1) !important;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #f6b51d !important;
        border-radius: 20px !important;
        padding: 8px 15px !important;
        color: #6267ae !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%) !important;
        color: white !important;
        border: none !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #f6b51d !important;
        color: white !important;
    }

    .btn {
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 991px) {
        .col-lg-5,
        .col-lg-7 {
            flex: 100%;
            max-width: 100%;
        }
    }
</style>

@endsection

@section('script')
<script src="{{ URL::asset('admin_panel/controller_js/cn_departments.js') }}"></script>
@endsection


