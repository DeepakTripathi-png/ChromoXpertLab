@extends('Admin.Layouts.layout')

@section('meta_title', 'Change Password | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            {{-- Hero Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                         style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                        <h2 class="fw-bold mb-1">Change Password</h2>
                        <p class="mb-0">Update your account password</p>
                        <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                            <i class="mdi mdi-key"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                    <i class="mdi mdi-alert-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card border-0 shadow-lg rounded-4" 
                         style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                        <div class="card-body p-4">
                            <form action="{{ route('change.password.post') }}" method="post" id="changePasswordForm">
                                @csrf
                                
                                {{-- Old Password --}}
                                <div class="mb-3">
                                    <label for="old_password" class="form-label fw-semibold" style="color: #6267ae;">
                                        Old Password 
                                        <i class="mdi mdi-information-outline ms-1" 
                                           data-bs-toggle="tooltip" 
                                           title="Enter your current password"></i>
                                    </label>
                                    <div class="position-relative">
                                        <input type="password" name="old_password" id="old_password" 
                                               class="form-control rounded-3 @error('old_password') is-invalid @enderror" 
                                               placeholder="Enter old password"
                                               style="background: #fff; color: #6267ae; border: 1px solid #f6b51d; padding-right: 45px; height: 50px;"
                                               required>
                                        <button type="button" class="btn pass-toggle position-absolute border-0 bg-transparent"
                                                style="right: 12px; top: 50%; transform: translateY(-50%); color: #6267ae;"
                                                data-target="old_password">
                                            <i class="mdi mdi-eye-outline" style="font-size: 1.2rem;"></i>
                                        </button>
                                    </div>
                                    @error('old_password')
                                        <div class="invalid-feedback d-block mt-1">
                                            <i class="mdi mdi-alert-circle me-1"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                {{-- New Password --}}
                                <div class="mb-3">
                                    <label for="new_password" class="form-label fw-semibold" style="color: #6267ae;">
                                        New Password 
                                        <i class="mdi mdi-information-outline ms-1" 
                                           data-bs-toggle="tooltip" 
                                           title="Enter your new password (min 8 characters)"></i>
                                    </label>
                                    <div class="position-relative">
                                        <input type="password" name="new_password" id="new_password" 
                                               class="form-control rounded-3 @error('new_password') is-invalid @enderror" 
                                               placeholder="Enter new password"
                                               style="background: #fff; color: #6267ae; border: 1px solid #f6b51d; padding-right: 45px; height: 50px;"
                                               required>
                                        <button type="button" class="btn pass-toggle position-absolute border-0 bg-transparent"
                                                style="right: 12px; top: 50%; transform: translateY(-50%); color: #6267ae;"
                                                data-target="new_password">
                                            <i class="mdi mdi-eye-outline" style="font-size: 1.2rem;"></i>
                                        </button>
                                    </div>
                                    @error('new_password')
                                        <div class="invalid-feedback d-block mt-1">
                                            <i class="mdi mdi-alert-circle me-1"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                {{-- Confirm Password --}}
                                <div class="mb-4">
                                    <label for="confirm_password" class="form-label fw-semibold" style="color: #6267ae;">
                                        Confirm Password 
                                        <i class="mdi mdi-information-outline ms-1" 
                                           data-bs-toggle="tooltip" 
                                           title="Confirm your new password"></i>
                                    </label>
                                    <div class="position-relative">
                                        <input type="password" name="new_password_confirmation" id="confirm_password" 
                                               class="form-control rounded-3 @error('new_password_confirmation') is-invalid @enderror" 
                                               placeholder="Confirm new password"
                                               style="background: #fff; color: #6267ae; border: 1px solid #f6b51d; padding-right: 45px; height: 50px;"
                                               required>
                                        <button type="button" class="btn pass-toggle position-absolute border-0 bg-transparent"
                                                style="right: 12px; top: 50%; transform: translateY(-50%); color: #6267ae;"
                                                data-target="confirm_password">
                                            <i class="mdi mdi-eye-outline" style="font-size: 1.2rem;"></i>
                                        </button>
                                    </div>
                                    @error('new_password_confirmation')
                                        <div class="invalid-feedback d-block mt-1">
                                            <i class="mdi mdi-alert-circle me-1"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                {{-- Buttons --}}
                                <div class="d-flex gap-2 mt-4 justify-content-end">
                                    <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm px-4"
                                            style="background: #6267ae; color: #fff; border: none;">
                                        <i class="mdi mdi-content-save me-2"></i> Submit
                                    </button>
                                    <button type="reset" class="btn btn-secondary btn-lg rounded-pill shadow-sm px-4"
                                            style="background: #ac7fb6; color: #fff; border: none;">
                                        <i class="mdi mdi-refresh me-2"></i> Cancel
                                    </button>
                                </div>
                            </form>
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
    .form-control {
        background: #fff;
        color: #6267ae;
        border: 1px solid #f6b51d;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #f6b51d;
        box-shadow: 0 0 0 0.25rem rgba(246, 181, 29, 0.25);
        background: #fff;
        color: #6267ae;
    }
    
    .form-label {
        color: #6267ae;
        font-weight: 500;
        margin-bottom: 8px;
    }
    
    .is-invalid {
        border-color: #dc3545 !important;
    }
    
    .is-invalid:focus {
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
    }
    
    /* Password toggle button styles */
    .pass-toggle {
        z-index: 5;
        outline: none !important;
        box-shadow: none !important;
    }
    
    .pass-toggle:hover {
        color: #cc235e !important;
        background: transparent !important;
    }
    
    .pass-toggle:focus {
        outline: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }
    
    .pass-toggle:active {
        transform: translateY(-50%) scale(0.95) !important;
    }
    
    /* Ensure proper spacing */
    .position-relative .form-control {
        padding-right: 45px !important;
    }
</style>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $(".setting").addClass("menuitem-active");
        $(".change-password").addClass("menuitem-active");

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Password show/hide functionality
        $(".pass-toggle").on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var targetId = $(this).data('target');
            var passwordInput = $("#" + targetId);
            var icon = $(this).find('i');

            if (passwordInput.attr("type") === "password") {
                passwordInput.attr("type", "text");
                icon.removeClass("mdi-eye-outline").addClass("mdi-eye-off-outline");
                $(this).blur(); // Remove focus to prevent any styling issues
            } else {
                passwordInput.attr("type", "password");
                icon.removeClass("mdi-eye-off-outline").addClass("mdi-eye-outline");
                $(this).blur(); // Remove focus to prevent any styling issues
            }
        });

        // Reset form functionality
        $("button[type='reset']").on('click', function(e) {
            e.preventDefault();
            
            // Reset all password fields to type="password"
            $('input[name="old_password"], input[name="new_password"], input[name="new_password_confirmation"]').each(function() {
                $(this).attr('type', 'password');
            });
            
            // Reset all eye icons
            $(".pass-toggle i").removeClass("mdi-eye-off-outline").addClass("mdi-eye-outline");
            
            // Clear form values
            document.getElementById("changePasswordForm").reset();
            
            // Remove validation classes
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').hide();
        });

        // Add focus styles for better UX
        $('.form-control').on('focus', function() {
            $(this).parent().find('.pass-toggle').css('color', '#cc235e');
        });
        
        $('.form-control').on('blur', function() {
            $(this).parent().find('.pass-toggle').css('color', '#6267ae');
        });
    });
</script>
@endsection