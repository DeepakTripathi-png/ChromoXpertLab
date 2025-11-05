@extends('Admin.Layouts.layout')

@section('meta_title', 'System User | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            {{-- Hero Header --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">System Users</h2>
                <p class="mb-0">Manage all system users and their permissions</p>
                <a href="{{ url('admin/system-user/add') }}" 
                   class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                   style="background: #f6b51d; color: #1f2937; border: none;">
                    <i class="mdi mdi-plus me-2"></i> Add User
                </a>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-account-group"></i>
                </div>
            </div>

            {{-- Glassmorphic Table Card --}}
            <div class="card border-0 shadow-lg rounded-4"
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table id="cims_data_table" class="table align-middle table-hover">
                            <thead style="background: linear-gradient(135deg, #ac7fb6 0%, #f6b51d 100%); color: #fff;">
                                <tr>
                                    <th>Sr No</th>
                                    <th>Name</th>
                                    <th>Email ID</th>
                                    <th>Role</th>
                                    <th>Mobile No</th>
                                    <th >Status</th>
                                    <th >Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Table body content will be loaded dynamically --}}
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
    .btn-icon {
        border-radius: 50%;
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease-in-out;
    }
    .btn-icon:hover { transform: scale(1.15); }

    .table > thead th {
        border-bottom: none;
        font-weight: 600;
    }
    
    .switch { 
        position: relative; 
        display: inline-block; 
        width: 44px; 
        height: 24px; 
    }
    .switch input { 
        opacity: 0; 
        width: 0; 
        height: 0; 
    }
    .slider {
        position: absolute; 
        cursor: pointer; 
        top: 0; 
        left: 0; 
        right: 0; 
        bottom: 0;
        background-color: #ccc; 
        transition: .4s; 
        border-radius: 24px;
    }
    .slider:before {
        position: absolute; 
        content: ""; 
        height: 18px; 
        width: 18px; 
        left: 3px; 
        bottom: 3px;
        background-color: white; 
        transition: .4s; 
        border-radius: 50%;
    }
    input:checked + .slider {
        background: linear-gradient(135deg, #6267ae 0%, #f6b51d 100%);
        box-shadow: 0 0 10px #f6b51d;
    }
    input:checked + .slider:before { 
        transform: translateX(20px); 
    }
</style>
@endsection

@section('script')
<script src="{{ URL::asset('admin_panel/controller_js/cn_system_user.js')}}"></script>
@endsection
