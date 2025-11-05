@extends('Admin.Layouts.layout')

@section('meta_title', 'General Settings | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            {{-- Hero Header --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">General Settings</h2>
                <p class="mb-0">Manage your contact and social media settings</p>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-cog"></i>
                </div>
            </div>

            <div class="row">
                {{-- Contact Details Card --}}
                <div class="col-md-6">
                    <div class="card border-0 shadow-lg rounded-4 mb-4" 
                         style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                        <div class="card-body p-4">
                            <h4 class="header-title mb-4" style="color: #6267ae;">Contact Details</h4>
                            <form action="{{route('geraral.settings.store')}}" method="post" id="general_settings_contact_form" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{!empty($general_settings->id)?$general_settings->id:''}}">
                                
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3" name="email" id="email" 
                                           placeholder=" " value="{{!empty($general_settings->email) ? $general_settings->email : ''}}" 
                                           style="background: #fff; color: #6267ae; border: 1px solid #f6b51d; text-transform:lowercase;">
                                    <label for="email" style="color: #6267ae;">Email Address <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Enter the contact email address"></i></label>
                                    @if($errors->has('email'))
                                    <span class="text-danger mt-1 d-block"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('email')}}</span>
                                    @endif
                                </div>
                                
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3" name="mobile" id="mobile" 
                                           placeholder=" " value="{{!empty($general_settings->mobile) ? $general_settings->mobile : ''}}"
                                           style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="mobile" style="color: #6267ae;">Mobile No. <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Enter the contact mobile number"></i></label>
                                    @if($errors->has('mobile'))
                                    <span class="text-danger mt-1 d-block"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('mobile')}}</span>
                                    @endif
                                </div>
                                
                                <div class="form-floating mb-4">
                                    <input type="text" class="form-control rounded-3" name="address" id="address" 
                                           placeholder=" " value="{{!empty($general_settings->address) ? $general_settings->address : ''}}"
                                           style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="address" style="color: #6267ae;">Address <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Enter the contact address"></i></label>
                                    @if($errors->has('address'))
                                    <span class="text-danger mt-1 d-block"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('address')}}</span>
                                    @endif
                                </div>

                                <div class="d-flex gap-2 justify-content-end">
                                    <button type="submit" name="contact_settings" id="submit_btn" 
                                            class="btn btn-success btn-lg rounded-pill shadow-sm px-4"
                                            style="background: #6267ae; color: #fff; border: none;">
                                        <i class="mdi mdi-content-save me-2"></i> {{ !empty($general_settings) ? 'Update' : 'Submit' }}
                                    </button>
                                    @if(empty($general_settings)) 
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

                {{-- Social Media Card --}}
                <div class="col-md-6">
                    <div class="card border-0 shadow-lg rounded-4 mb-4" 
                         style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                        <div class="card-body p-4">
                            <h4 class="header-title mb-4" style="color: #6267ae;">Social Media Details</h4>
                            <form action="{{route('geraral.settings.store')}}" method="post" id="general_settings_contact_form" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{!empty($general_settings->id)?$general_settings->id:''}}">
                                
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3" name="facebook_url" id="facebook_url" 
                                           placeholder=" " value="{{!empty($general_settings->facebook_url) ? $general_settings->facebook_url : ''}}"
                                           style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="facebook_url" style="color: #6267ae;">Facebook URL <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Enter the Facebook profile URL"></i></label>
                                    @if($errors->has('facebook_url'))
                                    <span class="text-danger mt-1 d-block"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('facebook_url')}}</span>
                                    @endif
                                </div>
                                
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3" name="linkedin_url" id="linkedin_url" 
                                           placeholder=" " value="{{!empty($general_settings->linkedin_url) ? $general_settings->linkedin_url : ''}}"
                                           style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="linkedin_url" style="color: #6267ae;">LinkedIn URL <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Enter the LinkedIn profile URL"></i></label>
                                    @if($errors->has('linkedin_url'))
                                    <span class="text-danger mt-1 d-block"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('linkedin_url')}}</span>
                                    @endif
                                </div>
                                
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3" name="instagram_url" id="instagram_url" 
                                           placeholder=" " value="{{!empty($general_settings->instagram_url) ? $general_settings->instagram_url : ''}}"
                                           style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="instagram_url" style="color: #6267ae;">Instagram URL <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Enter the Instagram profile URL"></i></label>
                                    @if($errors->has('instagram_url'))
                                    <span class="text-danger mt-1 d-block"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('instagram_url')}}</span>
                                    @endif
                                </div>
                                
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control rounded-3" name="twitter_url" id="twitter_url" 
                                           placeholder=" " value="{{!empty($general_settings->twitter_url) ? $general_settings->twitter_url : ''}}"
                                           style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="twitter_url" style="color: #6267ae;">Twitter URL <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Enter the Twitter profile URL"></i></label>
                                    @if($errors->has('twitter_url'))
                                    <span class="text-danger mt-1 d-block"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('twitter_url')}}</span>
                                    @endif
                                </div>
                                
                                <div class="form-floating mb-4">
                                    <input type="text" class="form-control rounded-3" name="skype_url" id="skype_url" 
                                           placeholder=" " value="{{!empty($general_settings->skype_url) ? $general_settings->skype_url : ''}}"
                                           style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="skype_url" style="color: #6267ae;">Skype URL <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Enter the Skype profile URL"></i></label>
                                    @if($errors->has('skype_url'))
                                    <span class="text-danger mt-1 d-block"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('skype_url')}}</span>
                                    @endif
                                </div>

                                <div class="d-flex gap-2 justify-content-end">
                                    <button type="submit" name="social_media_settings" id="submit_btn" 
                                            class="btn btn-success btn-lg rounded-pill shadow-sm px-4"
                                            style="background: #6267ae; color: #fff; border: none;">
                                        <i class="mdi mdi-content-save me-2"></i> {{ !empty($general_settings) ? 'Update' : 'Submit' }}
                                    </button>
                                    @if(empty($general_settings)) 
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
    </div>
</div>
@endsection

@section('style')
<style>
    .form-floating>.form-control {
        height: calc(3.5rem + 2px);
        background: #fff;
        color: #6267ae;
        border: 1px solid #f6b51d;
    }
    .form-floating>label {
        color: #6267ae;
        font-weight: 500;
    }
    .form-control:focus {
        border-color: #f6b51d;
        box-shadow: 0 0 0 0.25rem rgba(246, 181, 29, 0.25);
    }
</style>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $(".setting").addClass("menuitem-active");
        $(".general-setting").addClass("menuitem-active");

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection