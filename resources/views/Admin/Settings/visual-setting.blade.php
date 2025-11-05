@extends('Admin.Layouts.layout')

@section('meta_title', 'Visual Settings | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            {{-- Hero Header --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Visual Settings</h2>
                <p class="mb-0">Manage your logo and branding assets</p>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-palette"></i>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card border-0 shadow-lg rounded-4" 
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-4">
                    <form action="{{ route('visual.settings.store') }}" method="post" id="visual_settings_form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id" name="id" value="{{ !empty($visual_settings->id) ? $visual_settings->id : '' }}">
                        
                        <div class="row">
                            {{-- Full Logo --}}
                            <div class="col-lg-3 mb-4">
                                <div class="dropify-wrapper rounded-4 overflow-hidden shadow-sm"
                                     style="border: 1px solid #f6b51d;">
                                    <input type="file" data-plugins="dropify" name="logo_image_path" size="40" accept="image/*" 
                                           data-default-file="{{ !empty($visual_settings->logo_image_path) && Storage::exists($visual_settings->logo_image_path) ? url('/').Storage::url($visual_settings->logo_image_path) : '' }}" 
                                           alt="{{ !empty($visual_settings->logo_image_name) ? $visual_settings->logo_image_name : '' }}"
                                           data-height="150" />
                                </div>
                                <p class="text-center mt-2 mb-0 fw-semibold" style="color: #6267ae;">
                                    Full Logo (with text) 
                                    <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Upload the full logo with text (recommended: 300x100px)"></i>
                                </p>
                                @if($errors->has('logo_image_path'))
                                <span class="text-danger d-block text-center mt-1"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('logo_image_path')}}</span>
                                @endif
                            </div>
                            
                            {{-- Mini Logo --}}
                            <div class="col-lg-3 mb-4">
                                <div class="dropify-wrapper rounded-4 overflow-hidden shadow-sm"
                                     style="border: 1px solid #f6b51d;">
                                    <input type="file" data-plugins="dropify" name="mini_logo_image_path" size="40" accept="image/*" 
                                           data-default-file="{{ !empty($visual_settings->mini_logo_image_path) && Storage::exists($visual_settings->mini_logo_image_path) ? url('/').Storage::url($visual_settings->mini_logo_image_path) : '' }}" 
                                           alt="{{ !empty($visual_settings->mini_logo_image_path) ? $visual_settings->mini_logo_image_path : '' }}"
                                           data-height="150" />
                                </div>
                                <p class="text-center mt-2 mb-0 fw-semibold" style="color: #6267ae;">
                                    Mini Logo (without text) 
                                    <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Upload the mini logo without text (recommended: 100x100px)"></i>
                                </p>
                                @if($errors->has('mini_logo_image_path'))
                                <span class="text-danger d-block text-center mt-1"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('mini_logo_image_path')}}</span>
                                @endif
                            </div>
                            
                            {{-- Favicon --}}
                            <div class="col-lg-3 mb-4">
                                <div class="dropify-wrapper rounded-4 overflow-hidden shadow-sm"
                                     style="border: 1px solid #f6b51d;">
                                    <input type="file" data-plugins="dropify" name="favicon_image_path" size="40" accept="image/*" 
                                           data-default-file="{{ !empty($visual_settings->favicon_image_path) && Storage::exists($visual_settings->favicon_image_path) ? url('/').Storage::url($visual_settings->favicon_image_path) : '' }}" 
                                           alt="{{ !empty($visual_settings->favicon_image_path) ? $visual_settings->favicon_image_path : '' }}"
                                           data-height="150" />
                                </div>
                                <p class="text-center mt-2 mb-0 fw-semibold" style="color: #6267ae;">
                                    Favicon (browser tab) 
                                    <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Upload the favicon for browser tabs (recommended: 32x32px)"></i>
                                </p>
                                @if($errors->has('favicon_image_path'))
                                <span class="text-danger d-block text-center mt-1"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('favicon_image_path')}}</span>
                                @endif
                            </div>
                            
                            {{-- Email Logo --}}
                            <div class="col-lg-3 mb-4">
                                <div class="dropify-wrapper rounded-4 overflow-hidden shadow-sm"
                                     style="border: 1px solid #f6b51d;">
                                    <input type="file" data-plugins="dropify" name="logo_email_image_path" size="40" accept="image/*" 
                                           data-default-file="{{ !empty($visual_settings->logo_email_image_path) && Storage::exists($visual_settings->logo_email_image_path) ? url('/').Storage::url($visual_settings->logo_email_image_path) : '' }}" 
                                           alt="{{ !empty($visual_settings->logo_email_image_path) ? $visual_settings->logo_email_image_path : '' }}"
                                           data-height="150" />
                                </div>
                                <p class="text-center mt-2 mb-0 fw-semibold" style="color: #6267ae;">
                                    Email Logo 
                                    <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Upload the logo for email templates (recommended: 200x60px)"></i>
                                </p>
                                @if($errors->has('logo_email_image_path'))
                                <span class="text-danger d-block text-center mt-1"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('logo_email_image_path')}}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2 justify-content-end mt-2">
                            <button class="btn btn-success btn-lg rounded-pill shadow-sm px-4" type="submit"
                                    style="background: #6267ae; color: #fff; border: none;">
                                <i class="mdi mdi-content-save me-2"></i> {{ !empty($visual_settings) ? 'Update' : 'Submit' }}
                            </button>
                            @if(empty($visual_settings))
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
    .dropify-wrapper {
        border: 1px solid #f6b51d;
        background: #fff;
    }
    .dropify-wrapper .dropify-message p {
        color: #6267ae;
    }
    .dropify-wrapper .dropify-preview .dropify-infos {
        background: rgba(255, 255, 255, 0.9);
    }
    .dropify-wrapper .dropify-preview .dropify-infos .dropify-infos-inner p {
        color: #6267ae;
    }
    .dropify-wrapper:hover {
        background: rgba(246, 181, 29, 0.1);
    }
    .dropify-wrapper .dropify-clear {
        border: 1px solid #f6b51d;
        color: #6267ae;
    }
</style>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $(".setting").addClass("menuitem-active");
        $(".visual-setting").addClass("menuitem-active");

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize Dropify
        $('.dropify').dropify();
    });
</script>
@endsection
