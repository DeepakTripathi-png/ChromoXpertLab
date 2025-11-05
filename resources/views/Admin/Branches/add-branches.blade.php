@extends('Admin.Layouts.layout')

@section('meta_title', 'Add Branch/Collection Center/Hospital | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            {{-- Hero Header --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">{{ !empty($branch) ? 'Edit Branch/Collection Center/Hospital' : 'Add New Branch/Collection Center/Hospital' }}</h2>
                <p class="mb-0">Fill in the details to {{ !empty($branch) ? 'update the' : 'create a new' }} branch/collection center/hospital record</p>
                <a href="{{ url()->previous() }}" 
                   class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                   style="background: #f6b51d; color: #1f2937; border: none;">
                    <i class="mdi mdi-arrow-left me-2"></i> Back
                </a>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-hospital-building"></i>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card border-0 shadow-lg rounded-4" 
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-4">
                    
                    <form action="{{ route('branch.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $branch?->id ?? '' }}">

                        <div class="row">
                            {{-- Left Column --}}
                            <div class="col-md-8">
                                <div class="row g-3">

                                    {{-- Type --}}
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select rounded-3" id="type" name="type">
                                                <option value="">Select Type</option>
                                                <option value="branch" {{ old('type', $branch?->type ?? '') == 'branch' ? 'selected' : '' }}>Branch</option>
                                                <option value="collection_center" {{ old('type', $branch?->type ?? '') == 'collection_center' ? 'selected' : '' }}>Collection Center</option>
                                                <option value="hospital" {{ old('type', $branch?->type ?? '') == 'hospital' ? 'selected' : '' }}>Hospital</option>
                                            </select>
                                            <label for="type" style="color: #6267ae;">Type*</label>
                                            @error('type')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    {{-- Branch Name --}}
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control rounded-3" id="branch_name" 
                                                name="branch_name" value="{{ old('branch_name', $branch?->branch_name ?? '') }}" placeholder=" ">
                                            <label for="branch_name" style="color: #6267ae;">Branch/Collection Center/Hospital Name*</label>
                                            @error('branch_name')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    {{-- Mobile --}}
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control rounded-3" id="mobile" 
                                                name="mobile" value="{{ old('mobile', $branch?->mobile ?? '') }}" 
                                                placeholder="+91XXXXXXXXXX"  pattern="(\+91)?[0-9]{10}"  
                                                title="Mobile number must start with +91 followed by 10 digits">
                                            <label for="mobile" style="color: #6267ae;">Mobile*</label>
                                            @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    {{-- Password --}}
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password" class="form-control rounded-3" id="password" 
                                                name="password" value="" placeholder=" ">
                                            <label for="password" style="color: #6267ae;">Password{{ !empty($branch) ? ' (Leave blank to keep current)' : '*' }}</label>
                                            @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control rounded-3" id="email" 
                                                name="email" value="{{ old('email', $branch?->email ?? '') }}" placeholder=" ">
                                            <label for="email" style="color: #6267ae;">Email*</label>
                                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    {{-- Address --}}
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control rounded-3" id="address" 
                                                name="address" value="{{ old('address', $branch?->address ?? '') }}" placeholder=" ">
                                            <label for="address" style="color: #6267ae;">Address*</label>
                                            @error('address')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Right Column: Lab Logo --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" style="color: #6267ae;">Branch/Collection Center/Hospital Logo</label>
                                <input type="file" data-plugins="dropify" name="branch_logo_path" id="branch_logo_path" accept="image/*"
                                    data-default-file="{{ !empty($branch?->branch_logo_path) ? asset('storage/'.$branch?->branch_logo_path) : '' }}">
                                @error('branch_logo_path')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm px-4"
                                    style="background: #6267ae; color: #fff; border: none;">
                                <i class="mdi mdi-content-save me-2"></i> {{ !empty($branch) ? 'Update Branch/Collection Center/Hospital' : 'Save Branch/Collection Center/Hospital' }}
                            </button>
                            <button type="reset" class="btn btn-secondary btn-lg rounded-pill shadow-sm px-4">
                                <i class="mdi mdi-refresh me-2"></i> Reset
                            </button>
                        </div>
                    </form>
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
    .dropify-wrapper {
        border-radius: 1rem !important;
        background: #fff;
        color: #6267ae;
        border: 1px solid #f6b51d;
    }
</style>
@endsection

@section('scripts')
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('[data-plugins="dropify"]').dropify();

        // ✅ Mobile number logic (fixed)
        $('#mobile').on('input', function() {
            let value = $(this).val().replace(/[^\d\+]/g, '');

            if (value.startsWith('+91')) {
                value = '+91' + value.slice(3).replace(/[^\d]/g, '');
            } else if (value.startsWith('+')) {
                value = '+91' + value.replace(/[^\d]/g, '').slice(2);
            } else {
                value = value.replace(/[^\d]/g, '');
            }

            $(this).val(value);
        });

        // Auto-add +91 only once on blur
        $('#mobile').on('blur', function() {
            let value = $(this).val().trim();
            if (value !== '' && !value.startsWith('+91')) {
                value = '+91' + value.replace(/[^\d]/g, '');
                $(this).val(value);
            }
        });
    });
</script>
@endsection