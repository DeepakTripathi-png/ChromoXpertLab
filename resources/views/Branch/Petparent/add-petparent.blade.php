@extends('Branch.Layouts.layout')

@section('meta_title', 'Add Pet Parent | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            {{-- Hero Header --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Add Pet Parent</h2>
                <p class="mb-0">Register new pet parent information</p>
                <a href="{{ url()->previous() }}" 
                   class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                   style="background: #F6B51D; color: black; border: 1px solid #6267ae;">
                    <i class="mdi mdi-arrow-left me-2"></i> Back
                </a>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-paw"></i>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card border-0 shadow-lg rounded-4" 
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-4">

                  <form action="{{ route('branch.petparent.store') }}" method="post">
                        @csrf
                        <input type="hidden" class="form-control" id="id" name="id" value="{{ $petparent->id ?? '' }}">

                        <div class="row g-3">
                            {{-- Name --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control rounded-3" id="name" name="name"
                                        value="{{ old('name', $petparent->name ?? '') }}"
                                        placeholder=" ">
                                    <label for="name" style="color: #6267ae;">Name*</label>
                                    @if($errors->has('name'))
                                    <div class="text-danger small mt-1">
                                        <i class="mdi mdi-alert-circle me-1"></i> {{ $errors->first('name') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Gender --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select rounded-3" id="gender" name="gender">
                                        <option value="">Select Gender</option>
                                        <option value="Male"   {{ old('gender', $petparent->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender', $petparent->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other"  {{ old('gender', $petparent->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
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
                                        value="{{ old('email', $petparent->email ?? '') }}"
                                        placeholder=" ">
                                    <label for="email" style="color: #6267ae;">Email*</label>
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

                            {{-- Phone Number --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" class="form-control rounded-3" id="mobile" name="mobile"
                                        value="{{ old('mobile', $petparent->mobile ?? '') }}"
                                        placeholder=" ">
                                    <label for="mobile" style="color: #6267ae;">Mobile*</label>
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
                                            placeholder=" " style="height: 100px">{{ old('address', $petparent->address ?? '') }}</textarea>
                                    <label for="address" style="color: #6267ae;">Address</label>
                                    @if($errors->has('address'))
                                    <div class="text-danger small mt-1">
                                        <i class="mdi mdi-alert-circle me-1"></i> {{ $errors->first('address') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm px-4" id="submit-btn"
                                    style="background: #fff; color: #6267ae; border: 1px solid #6267ae;">
                                <i class="mdi mdi-content-save me-2"></i> {{ !empty($petparent) ? 'Update' : 'Submit' }}
                            </button>
                            @if(empty($petparent))
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
    .form-floating>.form-select,
    .form-floating>.form-control:focus,
    .form-floating>.form-select:focus {
        height: calc(3.5rem + 2px);
        background: rgba(255,255,255,0.9);
    }
    .form-floating>label {
        color: #6267ae;
        font-weight: 500;
    }
    .form-control:focus, .form-select:focus {
        border-color: #f6b51d;
        box-shadow: 0 0 0 0.25rem rgba(246, 181, 29, 0.25);
    }
</style>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Activate menu item
        $(".system-user").addClass("menuitem-active");
        $(".system-user-list").addClass("menuitem-active");

        // Email existence check
        $("#email").on("keyup", function() {
            $.ajax({
                type: "get",
                url: "{{ url('/branch/system-user/check-user-exist') }}",
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