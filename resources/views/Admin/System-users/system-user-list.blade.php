@extends('Admin.Layouts.layout')
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
                            <a href="{{url('admin/roles-privileges')}}">
                                <button type="button" class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i> Back</button>
                            </a>
                        </div>
                    </h1>
                </section>
                
                <section class="content" style="padding:5px 0px;">
                    <div class="col-md-12 no-pad">
                        <div class="box box-primary">
                            <div class="box-body">
                                <form action="{{ route('roles-previllages.store') }}" method="post" id="role_previllages">
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
                                                    <!-- Master --> 
                                                    <tr>
                                                        <td class="text-center">3</td>
                                                        <td>Master </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="master_view" class="ccheckbox view" value="master_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'master_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                    </tr>
                                                    <!-- Master Category Page --> 
                                                    <tr>
                                                        <td class="text-center">4</td>
                                                        <td>Master -> Category </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" class="ccheckbox view" id="category_view" value="category_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'category_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" class="ccheckbox add" id="category_add" value="category_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'category_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" class="ccheckbox edit" id="category_edit" value="category_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'category_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" class="ccheckbox deletes" id="category_delete" value="category_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'category_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" class="ccheckbox status" id="category_status_change" value="category_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'category_status_change') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                    </tr>
                                                    <!-- CMS PAGES -->
                                                    <tr>
                                                        <td class="text-center">5</td>
                                                        <td>CMS</td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="cms_view" class="ccheckbox view" value="cms_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'cms_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                    </tr> 
                                                    <!-- CMS Page Content Page --> 
                                                    <tr>
                                                        <td class="text-center">6</td>
                                                        <td>CMS -> Page Content </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="page_content_view" class="ccheckbox view" value="page_content_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'page_content_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                    </tr>   
                                                    <!-- CMS Page Content Home Page --> 
                                                    <tr>
                                                        <td class="text-center">7</td>
                                                        <td>CMS -> Page Content -> Home Page </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="home_page_view" class="ccheckbox view" value="home_page_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'home_page_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="home_page_add" class="ccheckbox add" value="home_page_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'home_page_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="home_page_edit" class="ccheckbox edit" value="home_page_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'home_page_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="home_page_delete" class="ccheckbox deletes" value="home_page_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'home_page_delete') ? 'checked' : '' }}>--}}</td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="home_page_status_change" class="ccheckbox status" value="home_page_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'home_page_status_change') ? 'checked' : '' }}>--}}</td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="home_page_other" class="ccheckbox other" value="home_page_other" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'home_page_other') ? 'checked' : '' }}>--}}</td>
                                                    </tr>   
                                                    <!-- CMS Page Content About Us --> 
                                                    <tr>
                                                        <td class="text-center">8</td>
                                                        <td>CMS -> Page Content -> About Us </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="about_us_view" class="ccheckbox view" value="about_us_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'about_us_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="about_us_add" class="ccheckbox add" value="about_us_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'about_us_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="about_us_edit" class="ccheckbox edit" value="about_us_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'about_us_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="about_us_delete" class="ccheckbox deletes" value="about_us_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'about_us_delete') ? 'checked' : '' }}>--}}</td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="about_us_status_change" class="ccheckbox status" value="about_us_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'about_us_status_change') ? 'checked' : '' }}>--}}</td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="about_us_other" class="ccheckbox other" value="about_us_other" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'about_us_other') ? 'checked' : '' }}>--}}</td>
                                                    </tr>   
                                                    <!-- CMS Page Content Service-consulting --> 
                                                    <tr>
                                                        <td class="text-center">9</td>
                                                        <td>CMS -> Page Content -> Service-consulting </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="service_consulting_view" class="ccheckbox view" value="service_consulting_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'service_consulting_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="service_consulting_add" class="ccheckbox add" value="service_consulting_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'service_consulting_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="service_consulting_edit" class="ccheckbox edit" value="service_consulting_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'service_consulting_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="service_consulting_delete" class="ccheckbox deletes" value="service_consulting_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'service_consulting_delete') ? 'checked' : '' }}>--}}</td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="service_consulting_status_change" class="ccheckbox status" value="service_consulting_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'service_consulting_status_change') ? 'checked' : '' }}>--}}</td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="service_consulting_other" class="ccheckbox other" value="service_consulting_other" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'service_consulting_other') ? 'checked' : '' }}>--}}</td>
                                                    </tr>   
                                                    <!-- CMS Page Content Service-subscription --> 
                                                    <tr>
                                                        <td class="text-center">10</td>
                                                        <td>CMS -> Page Content -> Service-subscription </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="service_subscription_view" class="ccheckbox view" value="service_subscription_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'service_subscription_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="service_subscription_add" class="ccheckbox add" value="service_subscription_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'service_subscription_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="service_subscription_edit" class="ccheckbox edit" value="service_subscription_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'service_subscription_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="service_subscription_delete" class="ccheckbox deletes" value="service_subscription_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'service_subscription_delete') ? 'checked' : '' }}>--}}</td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="service_subscription_status_change" class="ccheckbox status" value="service_subscription_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'service_subscription_status_change') ? 'checked' : '' }}>--}}</td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="service_subscription_other" class="ccheckbox other" value="service_subscription_other" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'service_subscription_other') ? 'checked' : '' }}>--}}</td>
                                                    </tr>   
                                                    <!-- CMS Page Content Custom-research-service --> 
                                                    <tr>
                                                        <td class="text-center">11</td>
                                                        <td>CMS -> Page Content -> Custom-research-service </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="custom_research_service_view" class="ccheckbox view" value="custom_research_service_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'custom_research_service_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="custom_research_service_add" class="ccheckbox add" value="custom_research_service_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'custom_research_service_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="custom_research_service_edit" class="ccheckbox edit" value="custom_research_service_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'custom_research_service_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="custom_research_service_delete" class="ccheckbox deletes" value="custom_research_service_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'custom_research_service_delete') ? 'checked' : '' }}>--}}</td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="custom_research_service_status_change" class="ccheckbox status" value="custom_research_service_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'custom_research_service_status_change') ? 'checked' : '' }}>--}}</td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="custom_research_service_other" class="ccheckbox other" value="custom_research_service_other" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'custom_research_service_other') ? 'checked' : '' }}>--}}</td>
                                                    </tr>   
                                                    <!-- CMS Page Content We Market Client Support --> 
                                                    <tr>
                                                        <td class="text-center">12</td>
                                                        <td>CMS -> Page Content -> We Market Client Support </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="we_market_client_support_view" class="ccheckbox view" value="we_market_client_support_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'we_market_client_support_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="we_market_client_support_add" class="ccheckbox add" value="we_market_client_support_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'we_market_client_support_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="we_market_client_support_edit" class="ccheckbox edit" value="we_market_client_support_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'we_market_client_support_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="we_market_client_support_delete" class="ccheckbox deletes" value="we_market_client_support_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'we_market_client_support_delete') ? 'checked' : '' }}>--}}</td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="we_market_client_support_status_change" class="ccheckbox status" value="we_market_client_support_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'we_market_client_support_status_change') ? 'checked' : '' }}>--}}</td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="we_market_client_support_other" class="ccheckbox other" value="we_market_client_support_other" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'we_market_client_support_other') ? 'checked' : '' }}>--}}</td>
                                                    </tr>   
                                                    <!-- CMS Page Content Research Methodology --> 
                                                    <tr>
                                                        <td class="text-center">13</td>
                                                        <td>CMS -> Page Content -> Research Methodology </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="research_methodology_view" class="ccheckbox view" value="research_methodology_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'research_methodology_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="research_methodology_add" class="ccheckbox add" value="research_methodology_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'research_methodology_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="research_methodology_edit" class="ccheckbox edit" value="research_methodology_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'research_methodology_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="research_methodology_delete" class="ccheckbox deletes" value="research_methodology_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'research_methodology_delete') ? 'checked' : '' }}>--}}</td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="research_methodology_status_change" class="ccheckbox status" value="research_methodology_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'research_methodology_status_change') ? 'checked' : '' }}>--}}</td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="research_methodology_other" class="ccheckbox other" value="research_methodology_other" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'research_methodology_other') ? 'checked' : '' }}>--}}</td>
                                                    </tr>   
                                                    <!-- CMS Testimonials --> 
                                                    <tr>
                                                        <td class="text-center">14</td>
                                                        <td>CMS -> Testimonial </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="testimonials_view" class="ccheckbox view" value="testimonials_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'testimonials_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="testimonials_add" class="ccheckbox add" value="testimonials_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'testimonials_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="testimonials_edit" class="ccheckbox edit" value="testimonials_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'testimonials_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="testimonials_delete" class="ccheckbox deletes" value="testimonials_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'testimonials_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="testimonials_status_change" class="ccheckbox status" value="testimonials_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'testimonials_status_change') ? 'checked' : '' }}></td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="testimonials_other" class="ccheckbox other" value="testimonials_other" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'testimonials_other') ? 'checked' : '' }}>--}}</td>
                                                    </tr>   
                                                    <!-- CMS Privacy Policy --> 
                                                    <tr>
                                                        <td class="text-center">15</td>
                                                        <td>CMS -> Privacy Policy </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="privacy_policy_view" class="ccheckbox view" value="privacy_policy_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'privacy_policy_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="privacy_policy_add" class="ccheckbox add" value="privacy_policy_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'privacy_policy_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="privacy_policy_edit" class="ccheckbox edit" value="privacy_policy_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'privacy_policy_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="privacy_policy_delete" class="ccheckbox deletes" value="privacy_policy_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'privacy_policy_delete') ? 'checked' : '' }}>--}}</td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="privacy_policy_status_change" class="ccheckbox status" value="privacy_policy_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'privacy_policy_status_change') ? 'checked' : '' }}>--}}</td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="privacy_policy_other" class="ccheckbox other" value="privacy_policy_other" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'privacy_policy_other') ? 'checked' : '' }}>--}}</td>
                                                    </tr>   
                                                    <!-- CMS Terms of Use --> 
                                                    <tr>
                                                        <td class="text-center">16</td>
                                                        <td>CMS -> Terms of Use </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="terms_of_use_view" class="ccheckbox view" value="terms_of_use_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'terms_of_use_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="terms_of_use_add" class="ccheckbox add" value="terms_of_use_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'terms_of_use_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="terms_of_use_edit" class="ccheckbox edit" value="terms_of_use_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'terms_of_use_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="terms_of_use_delete" class="ccheckbox deletes" value="terms_of_use_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'terms_of_use_delete') ? 'checked' : '' }}>--}}</td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="terms_of_use_status_change" class="ccheckbox status" value="terms_of_use_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'terms_of_use_status_change') ? 'checked' : '' }}>--}}</td>
                                                        <td class="text-center">{{--<input type="checkbox" name="privileges[]" id="terms_of_use_other" class="ccheckbox other" value="terms_of_use_other" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'terms_of_use_other') ? 'checked' : '' }}>--}}</td>
                                                    </tr>  
                                                    <!-- Media --> 
                                                    <tr>
                                                        <td class="text-center">17</td>
                                                        <td>Media </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="media_view" class="ccheckbox view" value="media_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'media_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                    </tr> 
                                                    <!-- Media Blog/Press Release --> 
                                                    <tr>
                                                        <td class="text-center">18</td>
                                                        <td>Media -> Blog/Press Release </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="blog_press_release_view" class="ccheckbox view" value="blog_press_release_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'blog_press_release_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="blog_press_release_add" class="ccheckbox add" value="blog_press_release_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'blog_press_release_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="blog_press_release_edit" class="ccheckbox edit" value="blog_press_release_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'blog_press_release_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="blog_press_release_delete" class="ccheckbox deletes" value="blog_press_release_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'blog_press_release_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="blog_press_release_status_change" class="ccheckbox status" value="blog_press_release_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'blog_press_release_status_change') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                    </tr>   
                                                    <!-- Media Infographics --> 
                                                    <tr>
                                                        <td class="text-center">19</td>
                                                        <td>Media -> Infographhics </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="infographics_view" class="ccheckbox view" value="infographics_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'infographics_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="infographics_add" class="ccheckbox add" value="infographics_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'infographics_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="infographics_edit" class="ccheckbox edit" value="infographics_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'infographics_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="infographics_delete" class="ccheckbox deletes" value="infographics_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'infographics_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="infographics_status_change" class="ccheckbox status" value="infographics_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'infographics_status_change') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                    </tr>   
                                                    <!-- Publisher/Report --> 
                                                    <tr>
                                                        <td class="text-center">20</td>
                                                        <td>Publisher/Report </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="publisher_report_view"  class="ccheckbox view" value="publisher_report_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'publisher_report_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                    </tr> 
                                                    <!-- Careers --> 
                                                    <tr>
                                                        <td class="text-center">21</td>
                                                        <td>Careers </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="careers_view" class="ccheckbox view" value="careers_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'careers_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="careers_add" class="ccheckbox add" value="careers_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'careers_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="careers_edit" class="ccheckbox edit" value="careers_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'careers_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="careers_delete" class="ccheckbox deletes" value="careers_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'careers_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="careers_status_change" class="ccheckbox status" value="careers_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'careers_status_change') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                    </tr>  
                                                    <!-- All Reports --> 
                                                    <tr>
                                                        <td class="text-center">22</td>
                                                        <td>All Reports </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="report_view" class="ccheckbox view" value="report_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'report_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="report_add" class="ccheckbox add" value="report_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'report_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="report_edit" class="ccheckbox edit" value="report_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'report_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="report_delete" class="ccheckbox deletes" value="report_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'report_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="report_status_change" class="ccheckbox status" value="report_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'report_status_change') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="report_other" class="ccheckbox other" value="report_other" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'report_other') ? 'checked' : '' }}></td>
                                                    </tr>  
                                                    <!-- All Related Reports --> 
                                                    <tr>
                                                        <td class="text-center">22</td>
                                                        <td>Related Reports </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="related_report_view" class="ccheckbox view" value="related_report_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'related_report_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="related_report_add" class="ccheckbox add" value="related_report_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'related_report_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center">{{-- <input type="checkbox" name="privileges[]" id="related_report_edit" class="ccheckbox edit" value="related_report_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'related_report_edit') ? 'checked' : '' }}> --}}</td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="related_report_delete" class="ccheckbox deletes" value="related_report_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'related_report_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="related_report_status_change" class="ccheckbox status" value="related_report_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'related_report_status_change') ? 'checked' : '' }}></td>
                                                        <td class="text-center">{{-- <input type="checkbox" name="privileges[]" id="related_report_other" class="ccheckbox other" value="related_report_other" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'related_report_other') ? 'checked' : '' }}> --}}</td>
                                                    </tr>  
                                                    <!-- Enquiry --> 
                                                    <tr>
                                                        <td class="text-center">23</td>
                                                        <td>Enquiry </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="enquiries_view" class="ccheckbox view" value="enquiries_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'enquiries_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="enquiries_delete" class="ccheckbox deletes" value="enquiries_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'enquiries_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="enquiries_other" class="ccheckbox other" value="enquiries_other" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'enquiries_other') ? 'checked' : '' }}></td>
                                                    </tr>  
                                                    <!-- Payment Transaction Details --> 
                                                    <tr>
                                                        <td class="text-center">24</td>
                                                        <td>Payment Transaction Details </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="payment_transaction_details_view" class="ccheckbox view" value="payment_transaction_details_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'payment_transaction_details_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="payment_transaction_details_delete" class="ccheckbox deletes" value="payment_transaction_details_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'payment_transaction_details_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="payment_transaction_details_other" class="ccheckbox other" value="payment_transaction_details_other" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'payment_transaction_details_other') ? 'checked' : '' }}></td>
                                                    </tr>  
                                                    <!-- Contact Enqiry --> 
                                                    <tr>
                                                        <td class="text-center">25</td>
                                                        <td>Contact Enqiry </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="contact_enquiry_view" class="ccheckbox view" value="contact_enquiry_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'contact_enquiry_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="contact_enquiry_delete" class="ccheckbox deletes" value="contact_enquiry_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'contact_enquiry_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="contact_enquiry_other" class="ccheckbox other" value="contact_enquiry_other" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'contact_enquiry_other') ? 'checked' : '' }}></td>
                                                    </tr>  
                                                    <!-- Career Apllicant --> 
                                                    <tr>
                                                        <td class="text-center">26</td>
                                                        <td>Career Apllicant </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="career_applicant_view" class="ccheckbox view" value="career_applicant_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'career_applicant_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="career_applicant_delete" class="ccheckbox deletes" value="career_applicant_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'career_applicant_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="career_applicant_other" class="ccheckbox other" value="career_applicant_other" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'career_applicant_other') ? 'checked' : '' }}></td>
                                                    </tr>  
                                                    <!-- Subscriber --> 
                                                    <tr>
                                                        <td class="text-center">27</td>
                                                        <td>Subscriber </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="subscriber_view" class="ccheckbox view" value="subscriber_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'subscriber_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="subscriber_delete" class="ccheckbox deletes" value="subscriber_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'subscriber_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                    </tr> 
                                                    <!-- System User --> 
                                                    <tr>
                                                        <td class="text-center">28</td>
                                                        <td>System User </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="system_user_view"  class="ccheckbox view" value="system_user_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'system_user_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                    </tr> 
                                                    <!-- User List --> 
                                                    <tr>
                                                        <td class="text-center">29</td>
                                                        <td>User List </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="user_view" class="ccheckbox view" value="user_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'user_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="user_add" class="ccheckbox add" value="user_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'user_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="user_edit" class="ccheckbox edit" value="user_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'user_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="user_delete" class="ccheckbox deletes" value="user_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'user_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="user_status_change" class="ccheckbox status" value="user_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'user_status_change') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                    </tr> 
                                                    <!-- Role Privileges --> 
                                                    <tr>
                                                        <td class="text-center">30</td>
                                                        <td>Role & Privileges </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="role_privileges_view" class="ccheckbox view" value="role_privileges_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'role_privileges_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="role_privileges_add" class="ccheckbox add" value="role_privileges_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'role_privileges_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="role_privileges_edit" class="ccheckbox edit" value="role_privileges_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'role_privileges_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="role_privileges_delete" class="ccheckbox deletes" value="role_privileges_delete" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'role_privileges_delete') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="role_privileges_status_change" class="ccheckbox status" value="role_privileges_status_change" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'role_privileges_status_change') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                    </tr> 
                                                    <!-- Settings --> 
                                                    <tr>
                                                        <td class="text-center">31</td>
                                                        <td>Settings </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="setting_view"  class="ccheckbox view" value="setting_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'setting_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                    </tr> 
                                                    <!-- General Setting --> 
                                                    <tr>
                                                        <td class="text-center">32</td>
                                                        <td>Settings -> General Settings </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="general_setting_view" class="ccheckbox view" value="general_setting_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'general_setting_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="general_setting_add" class="ccheckbox add" value="general_setting_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'general_setting_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="general_setting_edit" class="ccheckbox edit" value="general_setting_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'general_setting_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                    </tr> 
                                                    <!-- Email Setting --> 
                                                    <tr>
                                                        <td class="text-center">33</td>
                                                        <td>Settings -> Email Settings </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="email_setting_view" class="ccheckbox view" value="email_setting_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'email_setting_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="email_setting_add" class="ccheckbox add" value="email_setting_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'email_setting_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="email_setting_edit" class="ccheckbox edit" value="email_setting_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'email_setting_edit') ? 'checked' : '' }}></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                    </tr> 
                                                    <!-- visual Setting --> 
                                                    <tr>
                                                        <td class="text-center">34</td>
                                                        <td>Settings -> Visual Settings </td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="visual_setting_view" class="ccheckbox view" value="visual_setting_view" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'visual_setting_view') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="visual_setting_add" class="ccheckbox add" value="visual_setting_add" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'visual_setting_add') ? 'checked' : '' }}></td>
                                                        <td class="text-center"><input type="checkbox" name="privileges[]" id="visual_setting_edit" class="ccheckbox edit" value="visual_setting_edit" {{ isset($role_privileges) && !empty($role_privileges->privileges) && str_contains($role_privileges->privileges,'visual_setting_edit') ? 'checked' : '' }}></td>
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
    $(".s_meun").removeClass("active");
    $(".system_user_active").addClass("active");
    $(".roles_privileges_active").addClass("active");
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

    // $('.view').on('change', function(){
    //     $('.view').each(function(){
    //         if($(this).is(":checked")){
    //             $('.all-view').prop('checked',true);
    //         }else{
    //             $('.all-view').prop('checked',false);
    //             return false;
    //         }
    //     })
    // })

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

    // $('.add').on('change', function(){
    //     $('.add').each(function(){
    //         if($(this).is(":checked")){
    //             $('.all-add').prop('checked',true);
    //         }else{
    //             $('.all-add').prop('checked',false);
    //             return false;
    //         }
    //     })
    // })

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

    // $('.edit').on('change', function(){
    //     $('.edit').each(function(){
    //         if($(this).is(":checked")){
    //             $('.all-edit').prop('checked',true);
    //         }else{
    //             $('.all-edit').prop('checked',false);
    //             return false;
    //         }
    //     })
    // })

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

    // $('.delete-privilege').on('change', function(){
    //     $('.delete-privilege').each(function(){
    //         if($(this).is(":checked")){
    //             $('.all-delete').prop('checked',true);
    //         }else{
    //             $('.all-delete').prop('checked',false);
    //             return false;
    //         }
    //     })
    // })

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

    // $('.status').on('change', function(){
    //     $('.status').each(function(){
    //         if($(this).is(":checked")){
    //             $('.all-status').prop('checked',true);
    //         }else{
    //             $('.all-status').prop('checked',false);
    //             return false;
    //         }
    //     })
    // })

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

    // $('.other').on('change', function(){
    //     $('.other').each(function(){
    //         if($(this).is(":checked")){
    //             $('.all-other').prop('checked',true);
    //         }else{
    //             $('.all-other').prop('checked',false);
    //             return false;
    //         }
    //     })
    // })

    // // Select All

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