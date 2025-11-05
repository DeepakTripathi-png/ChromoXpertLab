@extends('Admin.Layouts.layout')

@section('meta_title', 'Add Roles & Privileges | ChromoXpert')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            {{-- Hero Header --}}
            <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden shadow-lg"
                 style="background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%); color: #fff;">
                <h2 class="fw-bold mb-1">Add Roles & Privileges</h2>
                <p class="mb-0">Create or update a role with specific permissions</p>
                <a href="{{ url()->previous() }}" 
                   class="btn btn-light btn-lg mt-3 fw-semibold rounded-pill shadow-sm"
                   style="background: #f6b51d; color: #1f2937; border: none;">
                    <i class="mdi mdi-arrow-left me-2"></i> Back
                </a>
                <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 120px; color: #ac7fb6;">
                    <i class="mdi mdi-shield-account"></i>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card border-0 shadow-lg rounded-4"
                 style="background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);">
                <div class="card-body p-4">
                    <form action="{{ route('roles-privileges.store') }}" method="post">
                        @csrf
                        <input type="hidden" class="form-control" id="id" name="id" value="{{ !empty($role_privileges) ? $role_privileges->id : '' }}">

                        {{-- Role Name --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="role_name" id="role_name" 
                                           class="form-control rounded-3" 
                                           value="{{ !empty($role_privileges->role_name) ? $role_privileges->role_name : old('role_name') }}"
                                           placeholder=" " style="background: #fff; color: #6267ae; border: 1px solid #f6b51d;">
                                    <label for="role_name" style="color: #6267ae;">Role Name* <i class="mdi mdi-information-outline ms-1" data-bs-toggle="tooltip" title="Enter the role name"></i></label>
                                    <span class="text-danger d-none" id="role_existence_message"></span>
                                    @if($errors->has('role_name'))
                                        <span class="text-danger mt-1 d-block"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('role_name')}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Privileges Section --}}
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="fw-bold" style="color: #6267ae;">Privileges</label>
                                @if($errors->has('privileges'))
                                    <span class="text-danger ms-2"><i class="mdi mdi-alert-circle me-1"></i> {{$errors->first('privileges')}}</span>
                                @endif
                                <label style="float:right;">
                                    <span style="padding-right:5px; color: #6267ae;">Select All</span>
                                    <input value="select_all" id="select_all" class="select_all" type="checkbox">
                                </label>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered" id="role-privileges-table">
                                        <thead style="background: linear-gradient(135deg, #ac7fb6 0%, #f6b51d 100%); color: #fff;">
                                            <tr>
                                                <th width="10%" class="text-center">Sr. No.</th>
                                                <th width="30%">Pages</th>
                                                <th width="10%" class="text-center">View</th>
                                                <th width="10%" class="text-center">Add</th>
                                                <th width="10%" class="text-center">Edit</th>
                                                <th width="10%" class="text-center">Delete</th>
                                                <th width="10%" class="text-center">Active/Inactive</th>
                                                <th width="10%" class="text-center">Other</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="fade-in-row">
                                                <td class="text-center">1</td>
                                                <td>Select All</td>
                                                <td class="text-center"><input type="checkbox" class="ccheckbox all-view"></td>
                                                <td class="text-center"><input type="checkbox" class="ccheckbox all-add"></td>
                                                <td class="text-center"><input type="checkbox" class="ccheckbox all-edit"></td>
                                                <td class="text-center"><input type="checkbox" class="ccheckbox all-delete"></td>
                                                <td class="text-center"><input type="checkbox" class="ccheckbox all-status"></td>
                                                <td class="text-center"><input type="checkbox" class="ccheckbox all-other"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">2</td>
                                                <td>Dashboard</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="dashboard_view" class="ccheckbox view" value="dashboard_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'dashboard_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">3</td>
                                                <td>Appointments</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="appointments_view" class="ccheckbox view" value="appointments_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'appointments_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="appointments_add" class="ccheckbox add" value="appointments_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'appointments_add') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="appointments_edit" class="ccheckbox edit" value="appointments_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'appointments_edit') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="appointments_delete" class="ccheckbox deletes" value="appointments_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'appointments_delete') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="appointments_status_change" class="ccheckbox status" value="appointments_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'appointments_status_change') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">4</td>
                                                <td>Reports</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="reports_view" class="ccheckbox view" value="reports_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'reports_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">5</td>
                                                <td>Branches</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="branch_view" class="ccheckbox view" value="branch_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'branch_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="branch_add" class="ccheckbox add" value="branch_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'branch_add') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="branch_edit" class="ccheckbox edit" value="branch_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'branch_edit') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="branch_delete" class="ccheckbox deletes" value="branch_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'branch_delete') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="branch_status_change" class="ccheckbox status" value="branch_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'branch_status_change') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">6</td>
                                                <td>Departments</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="departments_view" class="ccheckbox view" value="departments_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'departments_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="departments_add" class="ccheckbox add" value="departments_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'departments_add') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="departments_edit" class="ccheckbox edit" value="departments_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'departments_edit') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="departments_delete" class="ccheckbox deletes" value="departments_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'departments_delete') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="departments_status_change" class="ccheckbox status" value="departments_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'departments_status_change') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">7</td>
                                                <td>Doctors</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="doctors_view" class="ccheckbox view" value="doctors_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'doctors_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="doctors_add" class="ccheckbox add" value="doctors_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'doctors_add') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="doctors_edit" class="ccheckbox edit" value="doctors_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'doctors_edit') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="doctors_delete" class="ccheckbox deletes" value="doctors_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'doctors_delete') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="doctors_status_change" class="ccheckbox status" value="doctors_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'doctors_status_change') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">8</td>
                                                <td>Doctors >> Internal Doctors</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="internal_doctors_view" class="ccheckbox view" value="internal_doctors_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'internal_doctors_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="internal_doctors_add" class="ccheckbox add" value="internal_doctors_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'internal_doctors_add') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="internal_doctors_edit" class="ccheckbox edit" value="internal_doctors_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'internal_doctors_edit') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="internal_doctors_delete" class="ccheckbox deletes" value="internal_doctors_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'internal_doctors_delete') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="internal_doctors_status_change" class="ccheckbox status" value="internal_doctors_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'internal_doctors_status_change') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">9</td>
                                                <td>Doctors >> Referee Doctors</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="referee_doctors_view" class="ccheckbox view" value="referee_doctors_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'referee_doctors_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="referee_doctors_add" class="ccheckbox add" value="referee_doctors_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'referee_doctors_add') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="referee_doctors_edit" class="ccheckbox edit" value="referee_doctors_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'referee_doctors_edit') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="referee_doctors_delete" class="ccheckbox deletes" value="referee_doctors_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'referee_doctors_delete') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="referee_doctors_status_change" class="ccheckbox status" value="referee_doctors_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'referee_doctors_status_change') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">10</td>
                                                <td>Pet Parent</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="pet_owners_view" class="ccheckbox view" value="pet_owners_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'pet_owners_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="pet_owners_add" class="ccheckbox add" value="pet_owners_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'pet_owners_add') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="pet_owners_edit" class="ccheckbox edit" value="pet_owners_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'pet_owners_edit') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="pet_owners_delete" class="ccheckbox deletes" value="pet_owners_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'pet_owners_delete') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="pet_owners_status_change" class="ccheckbox status" value="pet_owners_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'pet_owners_status_change') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">11</td>
                                                <td>Pets</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="pet_view" class="ccheckbox view" value="pet_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'pet_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="pet_add" class="ccheckbox add" value="pet_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'pet_add') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="pet_edit" class="ccheckbox edit" value="pet_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'pet_edit') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="pet_delete" class="ccheckbox deletes" value="pet_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'pet_delete') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="pet_status_change" class="ccheckbox status" value="pet_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'pet_status_change') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">12</td>
                                                <td>Test</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="test_view" class="ccheckbox view" value="test_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'test_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="test_add" class="ccheckbox add" value="test_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'test_add') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="test_edit" class="ccheckbox edit" value="test_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'test_edit') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="test_delete" class="ccheckbox deletes" value="test_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'test_delete') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="test_status_change" class="ccheckbox status" value="test_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'test_status_change') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">13</td>
                                                <td>Revenue</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="revenue_view" class="ccheckbox view" value="revenue_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'revenue_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">14</td>
                                                <td>System Users</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="system_users_view" class="ccheckbox view" value="system_users_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'system_users_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">15</td>
                                                <td>System Users >> Users</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="user_view" class="ccheckbox view" value="user_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'user_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="user_add" class="ccheckbox add" value="user_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'user_add') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="user_edit" class="ccheckbox edit" value="user_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'user_edit') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="user_delete" class="ccheckbox deletes" value="user_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'user_delete') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="user_status_change" class="ccheckbox status" value="user_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'user_status_change') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">16</td>
                                                <td>System Users >> Role Privileges</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="role_privileges_view" class="ccheckbox view" value="role_privileges_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'role_privileges_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="role_privileges_add" class="ccheckbox add" value="role_privileges_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'role_privileges_add') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="role_privileges_edit" class="ccheckbox edit" value="role_privileges_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'role_privileges_edit') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="role_privileges_delete" class="ccheckbox deletes" value="role_privileges_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'role_privileges_delete') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="role_privileges_status_change" class="ccheckbox status" value="role_privileges_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'role_privileges_status_change') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">17</td>
                                                <td>Settings</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="settings_view" class="ccheckbox view" value="settings_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'settings_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">18</td>
                                                <td>Settings >> General Settings</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="general_setting_view" class="ccheckbox view" value="general_setting_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'general_setting_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="general_setting_add" class="ccheckbox add" value="general_setting_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'general_setting_add') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="general_setting_edit" class="ccheckbox edit" value="general_setting_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'general_setting_edit') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">19</td>
                                                <td>Settings >> Visual Settings</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="visual_setting_view" class="ccheckbox view" value="visual_setting_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'visual_setting_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="visual_setting_add" class="ccheckbox add" value="visual_setting_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'visual_setting_add') ? 'checked' : '' }}></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="visual_setting_edit" class="ccheckbox edit" value="visual_setting_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'visual_setting_edit') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">20</td>
                                                <td>Settings >> Change Password</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="change_password_view" class="ccheckbox view" value="change_password_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'change_password_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="change_password_edit" class="ccheckbox edit" value="change_password_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'change_password_edit') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">21</td>
                                                <td>Notifications</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="notifications_view" class="ccheckbox view" value="notifications_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'notifications_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr class="fade-in-row">
                                                <td class="text-center">22</td>
                                                <td>Logout</td>
                                                <td class="text-center"><input type="checkbox" name="privileges[]" id="logout_view" class="ccheckbox view" value="logout_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges, 'logout_view') ? 'checked' : '' }}></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="mt-4 d-flex gap-2 justify-content-end">
                            <button class="btn btn-success btn-lg rounded-pill shadow-sm px-4" type="submit" id="submit-btn"
                                    style="background: #6267ae; color: #fff; border: none;">
                                <i class="mdi mdi-content-save me-2"></i> {{ !empty($role_privileges) ? 'Update' : 'Submit' }}
                            </button>
                            @if(empty($role_privileges))
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
    .fade-in-row {
        animation: fadeInUp 0.6s ease-in-out;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('script')
<script>
    $(".system-user").addClass("menuitem-active");
    $(".role-privileges").addClass("menuitem-active");
</script>

<script>
    $(document).ready(function(){
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        $('#role-privileges-table tr').each(function(index) {
            $(this).find('td:first').html(index+1);
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("#role_name").on("keyup", function(){
            $.ajax({
                type: "get",
                url: "{{ url('/admin/roles-privileges/check-role-exist') }}",
                data: {
                    role_name: $(this).val(),
                    role_id: $("#id").val()
                },
                success: function(response){
                    if(response.trim() == "true"){
                        $("#submit-btn").attr("disabled", true);
                        $("#role_existence_message").removeClass("d-none");
                        $("#role_existence_message").html("<i class='mdi mdi-alert-circle me-1'></i> This Role has already been taken");
                    } else {
                        $("#role_existence_message").addClass("d-none");
                        $("#role_existence_message").html("");
                        $("#submit-btn").removeAttr("disabled");
                    }
                }
            });
        });
    });
</script>

<script>
    // all view select
    $('.all-view').on('change', function(){
        if($('.all-view').is(":checked")){
            $('.view').each(function(){
                $(this).prop('checked',true);
            });
        }else{
            $('.view').each(function(){
                $(this).prop('checked',false);
            });
        }
    });

    $('.view').on('change', function(){
        $('.view').each(function(){
            if($(this).is(":checked")){
                $('.all-view').prop('checked',true);
            }else{
                $('.all-view').prop('checked',false);
                return false;
            }
        });
    });

    // all add select
    $('.all-add').on('change', function(){
        if($('.all-add').is(":checked")){
            $('.add').each(function(){
                $(this).prop('checked',true);
            });
        }else{
            $('.add').each(function(){
                $(this).prop('checked',false);
            });
        }
    });

    $('.add').on('change', function(){
        $('.add').each(function(){
            if($(this).is(":checked")){
                $('.all-add').prop('checked',true);
            }else{
                $('.all-add').prop('checked',false);
                return false;
            }
        });
    });

    // all edit select
    $('.all-edit').on('change', function(){
        if($('.all-edit').is(":checked")){
            $('.edit').each(function(){
                $(this).prop('checked',true);
            });
        }else{
            $('.edit').each(function(){
                $(this).prop('checked',false);
            });
        }
    });

    $('.edit').on('change', function(){
        $('.edit').each(function(){
            if($(this).is(":checked")){
                $('.all-edit').prop('checked',true);
            }else{
                $('.all-edit').prop('checked',false);
                return false;
            }
        });
    });

    // all deletes select
    $('.all-delete').on('change', function(){
        if($('.all-delete').is(":checked")){
            $('.deletes').each(function(){
                $(this).prop('checked',true);
            });
        }else{
            $('.deletes').each(function(){
                $(this).prop('checked',false);
            });
        }
    });

    $('.deletes').on('change', function(){
        $('.deletes').each(function(){
            if($(this).is(":checked")){
                $('.all-delete').prop('checked',true);
            }else{
                $('.all-delete').prop('checked',false);
                return false;
            }
        });
    });

    // all status select
    $('.all-status').on('change', function(){
        if($('.all-status').is(":checked")){
            $('.status').each(function(){
                $(this).prop('checked',true);
            });
        }else{
            $('.status').each(function(){
                $(this).prop('checked',false);
            });
        }
    });

    $('.status').on('change', function(){
        $('.status').each(function(){
            if($(this).is(":checked")){
                $('.all-status').prop('checked',true);
            }else{
                $('.all-status').prop('checked',false);
                return false;
            }
        });
    });

    // all other select
    $('.all-other').on('change', function(){
        if($('.all-other').is(":checked")){
            $('.other').each(function(){
                $(this).prop('checked',true);
            });
        }else{
            $('.other').each(function(){
                $(this).prop('checked',false);
            });
        }
    });

    $('.other').on('change', function(){
        $('.other').each(function(){
            if($(this).is(":checked")){
                $('.all-other').prop('checked',true);
            }else{
                $('.all-other').prop('checked',false);
                return false;
            }
        });
    });

    // Select All
    $('.select_all').on('change', function(){
        if($('.select_all').is(":checked")){
            $('.ccheckbox').each(function(){
                $(this).prop('checked',true);
            });
        }else{
            $('.ccheckbox').each(function(){
                $(this).prop('checked',false);
            });
        }
    });
</script>
@endsection