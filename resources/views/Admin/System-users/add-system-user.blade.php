@extends('Admin.Layouts.layout')

@section('meta_title', 'Add System User | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            {{-- Hero Header --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">{{ !empty($system_user) ? 'Update' : 'Add' }} System User</h2>
                <p class="mb-0">Manage user accounts and permissions</p>
                <a href="{{ url()->previous() }}" 
                   class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                   style="background: #f6b51d; color: #1f2937; border: none;">
                    <i class="mdi mdi-arrow-left me-2"></i> Back
                </a>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-account-plus"></i>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card border-0 shadow-lg rounded-4" 
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-4">
                    <form action="{{ route('system-user.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" id="id" name="id" value="{{ !empty($system_user) ? $system_user->id : '' }}">
                        
                        <div class="row g-3">
                            {{-- Left Column --}}
                            <div class="col-md-8">
                                <div class="row g-3">
                                    {{-- Role --}}
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select rounded-3" id="role" name="role" required
                                                    style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                                <option value="">Select Role</option>
                                                @if(!empty($all_roles))
                                                @foreach($all_roles as $role)
                                                <option value="{{ $role->id }}" {{ !empty($system_user->role_id) && ($system_user->role_id == $role->id) ? 'selected' : '' }}>{{ $role->role_name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <label for="role" style="color: #6267ae;">Role* <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Select the user role"></i></label>
                                            @if($errors->has('role'))
                                            <div class="text-danger small mt-1"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('role')}}</div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Name --}}
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control rounded-3" id="name" name="name" 
                                                   placeholder=" " value="{{ !empty($system_user) ? $system_user->user_name : old('name') }}" required
                                                   style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                            <label for="name" style="color: #6267ae;">Name* <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Enter the user's full name"></i></label>
                                            @if($errors->has('name'))
                                            <div class="text-danger small mt-1"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('name')}}</div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Mobile --}}
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control rounded-3" id="mobile_no" name="mobile_no" 
                                                   placeholder=" " value="{{ !empty($system_user) ? $system_user->mobile_no : old('mobile_no') }}" required
                                                   style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                            <label for="mobile_no" style="color: #6267ae;">Mobile* <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Enter the user's mobile number"></i></label>
                                            @if($errors->has('mobile_no'))
                                            <div class="text-danger small mt-1"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('mobile_no')}}</div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control rounded-3" id="email" name="email" 
                                                   placeholder=" " value="{{ !empty($system_user) ? $system_user->email : old('email') }}" required
                                                   style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                            <label for="email" style="color: #6267ae;">Email* <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Enter the user's email address"></i></label>
                                            <div class="text-danger small mt-1 d-none" id="email_existence_message">
                                                <i class="mdi mdi-alert-circle me-1"></i> This Email has already been taken
                                            </div>
                                            @if($errors->has('email'))
                                            <div class="text-danger small mt-1"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('email')}}</div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Password --}}
                                    @if(empty($system_user->id))
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control rounded-3" id="password" name="password" 
                                                   placeholder=" " required
                                                   style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                            <label for="password" style="color: #6267ae;">Password* <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Enter a secure password"></i></label>
                                            @if($errors->has('password'))
                                            <div class="text-danger small mt-1"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('password')}}</div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Address --}}
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control rounded-3" id="address" name="address" 
                                                      placeholder=" " style="height: 100px; background: #fff; color: #6267ae; border: 1px solid #f6b51d;">{{ !empty($system_user) ? $system_user->address : old('address') }}</textarea>
                                            <label for="address" style="color: #6267ae;">Address <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Enter the user's address"></i></label>
                                            @if($errors->has('address'))
                                            <div class="text-danger small mt-1"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('address')}}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Right Column --}}
                            <div class="col-md-4">
                                <label class="fw-semibold" style="color: #6267ae;">Profile Image</label>
                                <input type="file" data-plugins="dropify" name="user_profile_image_path" 
                                       accept="image/*" data-default-file="{{ !empty($system_user->user_profile_image_path) && Storage::exists($system_user->user_profile_image_path) ? url('/').Storage::url($system_user->user_profile_image_path) : '' }}" />
                                @if($errors->has('user_profile_image_path'))
                                <div class="text-danger small mt-1"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('user_profile_image_path')}}</div>
                                @endif
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="mt-4 d-flex gap-2 justify-content-end">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm px-4" id="submit-btn"
                                    style="background: #6267ae; color: #fff; border: none;">
                                <i class="mdi mdi-content-save me-2"></i> {{ !empty($system_user) ? 'Update' : 'Submit' }}
                            </button>
                            @if(empty($system_user))
                            <button type="reset" class="btn btn-secondary btn-lg rounded-pill shadow-sm px-4"
                                    style="background: #ac7fb6; color: #fff; border: none;">
                                <i class="mdi mdi-refresh me-2"></i> Cancel
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
    .form-floating>.form-select,
    .form-floating>.form-control:focus,
    .form-floating>.form-select:focus {
        height: calc(3.5rem + 2px);
        background: #fff;
        color: #6267ae;
        border: 1px solid #f6b51d;
    }
    .form-floating>label {
        color: #6267ae;
        font-weight: 500;
    }
    .form-control:focus, .form-select:focus {
        border-color: #f6b51d;
        box-shadow: 0 0 0 0.25rem rgba(246, 181, 29, 0.25);
    }
    .dropify-wrapper {
        border-radius: 1rem !important;
        border: 1px dashed #f6b51d;
    }
    .dropify-wrapper:hover {
        background-image: linear-gradient(-45deg, rgba(246, 181, 29, 0.1) 25%, transparent 25%, 
                          transparent 50%, rgba(246, 181, 29, 0.1) 50%, 
                          rgba(246, 181, 29, 0.1) 75%, transparent 75%, transparent);
    }
</style>
@endsection

@section('script')
<script>
    $(".system-user").addClass("menuitem-active");
    $(".system-user-list").addClass("menuitem-active");
</script>

<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize dropify for file input
        $('[data-plugins="dropify"]').dropify({
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Ooops, something wrong happened.'
            }
        });

        // Email existence check
        $("#email").on("keyup", function() {
            $.ajax({
                type: "get",
                url: "{{ url('/admin/system-user/check-user-exist') }}",
                data: {
                    email: $(this).val(),
                    user_id: $("#id").val()
                },
                success: function(response) {
                    if (response.trim() == "true") {
                        $("#submit-btn").attr("disabled", true);
                        $("#email_existence_message").removeClass("d-none");
                    } else {
                        $("#email_existence_message").addClass("d-none");
                        $("#submit-btn").removeAttr("disabled");
                    }
                }
            });
        });
    });
</script>
@endsection