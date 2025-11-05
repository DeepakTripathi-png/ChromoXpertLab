@extends('Branch.Layouts.layout')
@section("content")
<style>
    .content-wrapper {
        min-height: 0 !important;
    }

    table tbody tr td:nth-child(1),
    table tbody tr td:nth-child(2),
    table tbody tr td:nth-child(3),
    {
        text-align: center;
    }

    .scrollable-cell {
        max-height: 100px; /* Adjust the max height as needed */
        overflow: auto;
        white-space: pre-line; /* Preserve line breaks */
    }
</style>

<div class="content-wrapper" style="min-height: 1066px;">
    <section class="content"> 
        <div class="row no-margin">
            <div class="col-md-12 no-pad">
                <section class="content-header">
                    <h1>
                        Roles And Privileges
                        <div class="pull-right">
                            <a href="{{url('branch/roles-privileges')}}">
                                <button type="button" class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i> Back</button>
                            </a>
                        </div>
                    </h1>
                </section>
                
                <section class="content" style="padding:5px 0px;">
                    <div class="col-md-12 no-pad">
                        <div class="box box-primary">
                            <div class="box-body">
                                <form action="{{ route('branch.roles-privileges.store') }}" method="post" id="role_previllages">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="hidden" name="role_id" value="{{ !empty($role_privileges) ? $role_privileges->id : '' }}">
                                            <label for="role">Role Name<span style="color: red;">*</span></label>
                                            <input type="text" name="role_name" id="role_name" class="form-control" value="{{ !empty($role_privileges->role_name) ? $role_privileges->role_name : old('role_name') }}"> 
                                            @if($errors->has('role_name'))
                                                <span class="text-danger"><b>* {{$errors->first('role_name')}}</b></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 no-pad m-t-10">
                                        <div class="col-md-12 no-pad">
                                            <label>Privileges<span style="color: red;">*</span></label>
                                            @if($errors->has('privileges'))
                                                <span class="text-danger"><b>* {{$errors->first('privileges')}}</b></span>
                                            @endif
                                            <label style="float:right;"><span style="padding-right:5px;">Select All</span>
                                                <input value="select_all" id="select_all" class="select_all" type="checkbox">
                                            </label>
                                            <table id="" class="table color-table info-table table-bordered">
                                                <thead>
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

                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td>Select All</td>
                                                        <td class="text-center"><input type="checkbox" class="ccheckbox all-view"></td>
                                                        <td class="text-center"><input type="checkbox" class="ccheckbox all-add"></td>
                                                        <td class="text-center"><input type="checkbox" class="ccheckbox all-edit"></td>
                                                        <td class="text-center"><input type="checkbox" class="ccheckbox all-delete"></td>
                                                        <td class="text-center"><input type="checkbox" class="ccheckbox all-status"></td>
                                                        <td class="text-center"><input type="checkbox" class="ccheckbox all-other"></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="text-center">2</td>
                                                        <td>Dashboard</td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="dashboard_view" class="ccheckbox view" value="dashboard_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'dashboard_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td> 
                                                        <td class="text-center"></td> 
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="text-center">3</td>
                                                        <td>New Registration</td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="new_registration_view" class="ccheckbox view" value="new_registration_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'new_registration_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="new_registration_add" class="ccheckbox add" value="new_registration_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'new_registration_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="new_registration_edit" class="ccheckbox edit" value="new_registration_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'new_registration_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="new_registration_delete" class="ccheckbox deletes" value="new_registration_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'new_registration_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="new_registration_status_change" class="ccheckbox status" value="new_registration_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'new_registration_status_change') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="text-center">4</td>
                                                        <td>Reports</td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="reports_view" class="ccheckbox view" value="reports_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'reports_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="text-center">5</td>
                                                        <td>Pet Parent / Care Of</td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="pet_parent_view" class="ccheckbox view" value="pet_parent_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'pet_parent_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="pet_parent_add" class="ccheckbox add" value="pet_parent_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'pet_parent_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="pet_parent_edit" class="ccheckbox edit" value="pet_parent_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'pet_parent_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="pet_parent_delete" class="ccheckbox deletes" value="pet_parent_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'pet_parent_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="pet_parent_status_change" class="ccheckbox status" value="pet_parent_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'pet_parent_status_change') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="text-center">6</td>
                                                        <td>Pets</td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="pets_view" class="ccheckbox view" value="pets_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'pets_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="pets_add" class="ccheckbox add" value="pets_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'pets_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="pets_edit" class="ccheckbox edit" value="pets_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'pets_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="pets_delete" class="ccheckbox deletes" value="pets_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'pets_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="pets_status_change" class="ccheckbox status" value="pets_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'pets_status_change') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="text-center">7</td>
                                                        <td>Referee Doctors</td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="referee_doctors_view" class="ccheckbox view" value="referee_doctors_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'referee_doctors_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="referee_doctors_add" class="ccheckbox add" value="referee_doctors_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'referee_doctors_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="referee_doctors_edit" class="ccheckbox edit" value="referee_doctors_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'referee_doctors_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="referee_doctors_delete" class="ccheckbox deletes" value="referee_doctors_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'referee_doctors_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="referee_doctors_status_change" class="ccheckbox status" value="referee_doctors_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'referee_doctors_status_change') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="text-center">8</td>
                                                        <td>System Users</td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="system_users_view" class="ccheckbox view" value="system_users_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'system_users_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="text-center">9</td>
                                                        <td>System Users >> Users</td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="users_view" class="ccheckbox view" value="users_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'users_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="users_add" class="ccheckbox add" value="users_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'users_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="users_edit" class="ccheckbox edit" value="users_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'users_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="users_delete" class="ccheckbox deletes" value="users_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'users_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="users_status_change" class="ccheckbox status" value="users_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'users_status_change') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="text-center">10</td>
                                                        <td>System Users >> Role Privileges</td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="role_privileges_view" class="ccheckbox view" value="role_privileges_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'role_privileges_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="role_privileges_add" class="ccheckbox add" value="role_privileges_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'role_privileges_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="role_privileges_edit" class="ccheckbox edit" value="role_privileges_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'role_privileges_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="role_privileges_delete" class="ccheckbox deletes" value="role_privileges_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'role_privileges_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="role_privileges_status_change" class="ccheckbox status" value="role_privileges_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'role_privileges_status_change') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="text-center">11</td>
                                                        <td>Notifications</td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="notifications_view" class="ccheckbox view" value="notifications_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'notifications_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="text-center">12</td>
                                                        <td>Logout</td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="logout_view" class="ccheckbox view" value="logout_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'logout_view') ? 'checked' : '' }}></td>
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
                                    <div class="col-md-12 no-pad">
                                        
                                        <button type="submit" name="btnSubmit" value="submit" class="submit btn btn-success" id="btnSubmit"><i class="fa fa-check-circle"></i> Submit </button>
                                        
                                        <button type="reset" class="btn btn-danger"><i class="fa fa-times-circle" aria-hidden="true"></i> Cancel</button>
                                    
                                    </div> 
                                </form>
                            </div>
                        </div> <!-- End box -->
                    </div>
                </section>
            </div>
        </div>
        <!-- /.row -->
    </section>
</div>
@endsection
@section('script')

<script type="text/javascript">
    $(".system-user").addClass("menuitem-active");
    $(".role-privileges").addClass("menuitem-active");
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
    })

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
    })

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
    })

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
    })

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
    })

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
    })

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
    })
</script>

@endsection