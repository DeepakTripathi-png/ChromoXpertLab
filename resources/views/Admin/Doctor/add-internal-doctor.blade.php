@extends('Admin.Layouts.layout')
@section('meta_title', 'Add Doctor | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            {{-- Hero Header with Gradient Background --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Add New Internal Doctor</h2>
                <p class="mb-0">Fill in the details to create a new doctor record</p>
                <a href="{{ url()->previous() }}" 
                   class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                   style="background: #f6b51d; color: #1f2937; border: none;">
                    <i class="mdi mdi-arrow-left me-2"></i> Back
                </a>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-doctor"></i>
                </div>
            </div>

            {{-- Glassmorphic Form Card --}}
            <div class="card border-0 shadow-lg rounded-4" 
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-4">

                    {{-- <form action="{{ url('admin/doctors/store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control rounded-3" id="name" 
                                           name="name" value="{{ old('name') }}" placeholder=" " required
                                           style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="name" style="color: #6267ae;">Doctor Name*</label>
                                    @error('name')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control rounded-3" id="email" 
                                           name="email" value="{{ old('email') }}" placeholder=" " required
                                           style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="email" style="color: #6267ae;">Email Address*</label>
                                    @error('email')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" class="form-control rounded-3" id="phone" 
                                           name="phone" value="{{ old('phone', '+91') }}" placeholder=" " required
                                           pattern="\+91[0-9]{10}" title="Phone number must start with +91 followed by 10 digits"
                                           style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="phone" style="color: #6267ae;">Phone Number* (+91)</label>
                                    @error('phone')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                      

                            
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control rounded-3" id="address" name="address" 
                                              rows="4" placeholder=" " style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">{{ old('address') }}</textarea>
                                    <label for="address" style="color: #6267ae;">Address</label>
                                    @error('address')
                                        <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                           
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #6267ae;">Doctor Image</label>
                                <input type="file" data-plugins="dropify" name="doctor_image" id="doctor_image" 
                                       accept="image/*" style="border: 1px solid #f6b51d;" />
                                <p class="text-center mt-2 mb-0 text-muted">Doctor Profile Image</p>
                                @error('doctor_image')
                                    <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                @enderror
                            </div>

                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #6267ae;">Doctor Signature</label>
                                <input type="file" data-plugins="dropify" name="doctor_signature" id="doctor_signature" 
                                       accept="image/*" style="border: 1px solid #f6b51d;" />
                                <p class="text-center mt-2 mb-0 text-muted">Doctor Signature Image</p>
                                @error('doctor_signature')
                                    <span class="text-danger" style="color: #cc235e;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm px-4"
                                    style="background: #6267ae; color: #fff; border: none;" id="submitBtn">
                                <i class="mdi mdi-content-save me-2"></i> Add Doctor
                                <span class="spinner-border spinner-border-sm text-light ms-2 d-none" id="submitSpinner" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </span>
                            </button>
                            <button type="reset" class="btn btn-secondary btn-lg rounded-pill shadow-sm px-4"
                                    style="background: #ac7fb6; color: #fff; border: none;">
                                <i class="mdi mdi-refresh me-2"></i> Reset
                            </button>
                        </div>
                    </form> --}}

                    <form action="{{ route('internaldoctor.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" id="id" name="id" value="{{ $internalDoctor->id ?? '' }}">

                        <div class="row g-3">
                            {{-- Doctor Name --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control rounded-3" id="doctor_name" name="doctor_name"
                                        value="{{ old('doctor_name', $internalDoctor->doctor_name ?? '') }}"
                                        placeholder=" " required style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="doctor_name" style="color: #6267ae;">Doctor Name*</label>
                                    @if($errors->has('doctor_name'))
                                    <div class="text-danger small mt-1">
                                        <i class="mdi mdi-alert-circle me-1"></i> {{ $errors->first('doctor_name') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Gender --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select rounded-3" id="gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ old('gender', $internalDoctor->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender', $internalDoctor->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ old('gender', $internalDoctor->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <label for="gender" style="color: #6267ae;">Gender*</label>
                                    @if($errors->has('gender'))
                                    <div class="text-danger small mt-1">
                                        <i class="mdi mdi-alert-circle me-1"></i> {{ $errors->first('gender') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control rounded-3" id="email" name="email"
                                        value="{{ old('email', $internalDoctor->email ?? '') }}"
                                        placeholder=" " required style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="email" style="color: #6267ae;">Email Address*</label>
                                    <div class="text-danger small mt-1 d-none" id="email_existence_message">
                                        <i class="mdi mdi-alert-circle me-1"></i> This Email has already been taken
                                    </div>
                                    @if($errors->has('email'))
                                    <div class="text-danger small mt-1">
                                        <i class="mdi mdi-alert-circle me-1"></i> {{ $errors->first('email') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                        {{-- Mobile --}}
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="tel" 
                                    class="form-control rounded-3" 
                                    id="mobile" 
                                    name="mobile"
                                    value="{{ old('mobile', $internalDoctor->mobile ?? '') }}"
                                    placeholder=" " 
                                    required
                                    pattern="(\+91)?[0-9]{10}" 
                                    title="Phone number must be 10 digits"
                                    style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                <label for="mobile" style="color: #6267ae;">Phone Number*</label>
                                @if($errors->has('mobile'))
                                <div class="text-danger small mt-1">
                                    <i class="mdi mdi-alert-circle me-1"></i> {{ $errors->first('mobile') }}
                                </div>
                                @endif
                            </div>
                        </div>

                            {{-- Address --}}
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control rounded-3" id="address" name="address"
                                            placeholder=" " style="height: 100px; background: #fff; color: #6267ae; border: 1px solid #f6b51d;">{{ old('address', $internalDoctor->address ?? '') }}</textarea>
                                    <label for="address" style="color: #6267ae;">Address</label>
                                    @if($errors->has('address'))
                                    <div class="text-danger small mt-1">
                                        <i class="mdi mdi-alert-circle me-1"></i> {{ $errors->first('address') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Doctor Image --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #6267ae;">Doctor Image</label>
                                <input type="file" data-plugins="dropify" name="doctor_image_path" id="doctor_image_path"
                                    accept="image/*" style="border: 1px solid #f6b51d;">
                                <p class="text-center mt-2 mb-0 text-muted">Doctor Profile Image</p>
                                @if($errors->has('doctor_image_path'))
                                <div class="text-danger small mt-1">
                                    <i class="mdi mdi-alert-circle me-1"></i> {{ $errors->first('doctor_image_path') }}
                                </div>
                                @endif
                                @if(!empty($internalDoctor->doctor_image_path))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $internalDoctor->doctor_image_path) }}" alt="Doctor Image" width="100">
                                </div>
                                @endif
                            </div>

                            {{-- Doctor Signature --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #6267ae;">Doctor Signature</label>
                                <input type="file" data-plugins="dropify" name="doctor_sign_path" id="doctor_sign_path"
                                    accept="image/*" style="border: 1px solid #f6b51d;">
                                <p class="text-center mt-2 mb-0 text-muted">Doctor Signature Image</p>
                                @if($errors->has('doctor_sign_path'))
                                <div class="text-danger small mt-1">
                                    <i class="mdi mdi-alert-circle me-1"></i> {{ $errors->first('doctor_sign_path') }}
                                </div>
                                @endif
                                @if(!empty($internalDoctor->doctor_sign_path))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $internalDoctor->doctor_sign_path) }}" alt="Doctor Signature" width="100">
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm px-4" id="submit-btn"
                                    style="background: #fff; color: #6267ae; border: 1px solid #6267ae;">
                                <i class="mdi mdi-content-save me-2"></i> {{ !empty($internalDoctor) ? 'Update' : 'Submit' }}
                            </button>
                            @if(empty($internalDoctor))
                            <button type="reset" class="btn btn-secondary btn-lg rounded-pill shadow-sm px-4"
                                    style="background: #fff; color: #cc235e; border: 1px solid #cc235e;">
                                <i class="mdi mdi-restore me-2"></i> Reset
                            </button>
                            @endif
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
    .form-control:focus, .form-select:focus {
        border-color: #f6b51d;
        box-shadow: 0 0 8px rgba(246, 181, 29, 0.5);
    }
    .dropify-wrapper {
        border-radius: 1rem !important;
        border: 1px solid #f6b51d !important;
        background: #fff !important;
    }
    .dropify-wrapper .dropify-message p {
        color: #6267ae !important;
    }
    .spinner-border { vertical-align: middle; }
    @media (max-width: 768px) {
        .btn-lg { font-size: 0.9rem; padding: 0.5rem 1rem; }
        .form-floating label { font-size: 0.9rem; }
    }
</style>
@endsection

@section('scripts')
<script src="{{ asset('assets/libs/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/libs/inputmask/jquery.inputmask.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Phone number formatting
        $('#phone').inputmask('+919999999999');

        // Initialize Dropify for file inputs
        $('#doctor_image').dropify();
        $('#doctor_signature').dropify();

        // Auto-prefix phone number with +91
        $('#phone').on('input', function(e) {
            let value = e.target.value;
            if (!value.startsWith('+91')) {
                e.target.value = '+91' + value.replace(/^\+91/, '');
            }
        });

        // Show loading spinner on form submission
        $('#submitBtn').on('click', function() {
            $('#submitSpinner').removeClass('d-none');
            $(this).prop('disabled', true);
            setTimeout(() => {
                $(this).prop('disabled', false);
                $('#submitSpinner').addClass('d-none');
            }, 2000); // Simulate submission delay
        });
    });
</script>
@endsection