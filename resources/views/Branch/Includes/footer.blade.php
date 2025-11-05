<!-- Footer Start -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <script>
                    document.write(new Date().getFullYear())
                </script> &copy; All rights reserved <a target="_blank" href="https://codepixsolutions.com/">Codepix</a>
            </div>

        </div>
    </div>
</footer>
<!-- end Footer -->

<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title">
            <a href="javascript:void(0);" class="right-bar-toggle float-end">
                <i class="mdi mdi-close"></i>
            </a>
            <h4 class="font-16 m-0 text-white">Theme Customizer</h4>
        </div>

        <!-- Tab panes -->
        <div class="tab-content pt-0">
            <div class="tab-pane active" id="settings-tab" role="tabpanel">
                <div class="p-3">
                    <div class="alert alert-warning" role="alert">
                        <strong>Customize </strong> the overall color scheme, Layout, etc.
                    </div>

                    <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Color Scheme</h6>
                    <div class="form-check form-switch mb-1">
                        <input type="checkbox" class="form-check-input" name="layout-color" value="light" id="light-mode-check" checked />
                        <label class="form-check-label" for="light-mode-check">Light Mode</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input type="checkbox" class="form-check-input" name="layout-color" value="dark" id="dark-mode-check" />
                        <label class="form-check-label" for="dark-mode-check">Dark Mode</label>
                    </div>

                    <!-- Width -->
                    <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Width</h6>
                    <div class="form-check form-switch mb-1">
                        <input type="checkbox" class="form-check-input" name="layout-size" value="fluid" id="fluid" checked />
                        <label class="form-check-label" for="fluid-check">Fluid</label>
                    </div>
                    <div class="form-check form-switch mb-1">
                        <input type="checkbox" class="form-check-input" name="layout-size" value="boxed" id="boxed" />
                        <label class="form-check-label" for="boxed-check">Boxed</label>
                    </div>

                    <!-- Menu positions -->
                    <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Menus (Leftsidebar and Topbar) Positon</h6>

                    <div class="form-check form-switch mb-1">
                        <input type="checkbox" class="form-check-input" name="leftbar-position" value="fixed" id="fixed-check" checked />
                        <label class="form-check-label" for="fixed-check">Fixed</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input type="checkbox" class="form-check-input" name="leftbar-position" value="scrollable" id="scrollable-check" />
                        <label class="form-check-label" for="scrollable-check">Scrollable</label>
                    </div>

                    <!-- Left Sidebar-->
                    <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Left Sidebar Color</h6>

                    <div class="form-check form-switch mb-1">
                        <input type="checkbox" class="form-check-input" name="leftbar-color" value="light" id="light" />
                        <label class="form-check-label" for="light-check">Light</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input type="checkbox" class="form-check-input" name="leftbar-color" value="dark" id="dark" checked />
                        <label class="form-check-label" for="dark-check">Dark</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input type="checkbox" class="form-check-input" name="leftbar-color" value="brand" id="brand" />
                        <label class="form-check-label" for="brand-check">Brand</label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" class="form-check-input" name="leftbar-color" value="gradient" id="gradient" />
                        <label class="form-check-label" for="gradient-check">Gradient</label>
                    </div>

                    <!-- size -->
                    <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Left Sidebar Size</h6>

                    <div class="form-check form-switch mb-1">
                        <input type="checkbox" class="form-check-input" name="leftbar-size" value="default" id="default-size-check" checked />
                        <label class="form-check-label" for="default-size-check">Default</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input type="checkbox" class="form-check-input" name="leftbar-size" value="condensed" id="condensed-check" />
                        <label class="form-check-label" for="condensed-check">Condensed <small>(Extra Small size)</small></label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input type="checkbox" class="form-check-input" name="leftbar-size" value="compact" id="compact-check" />
                        <label class="form-check-label" for="compact-check">Compact <small>(Small size)</small></label>
                    </div>

                    <!-- User info -->
                    <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Sidebar User Info</h6>

                    <div class="form-check form-switch mb-1">
                        <input type="checkbox" class="form-check-input" name="sidebar-user" value="true" id="sidebaruser-check" />
                        <label class="form-check-label" for="sidebaruser-check">Enable</label>
                    </div>


                    <!-- Topbar -->
                    <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Topbar</h6>

                    <div class="form-check form-switch mb-1">
                        <input type="checkbox" class="form-check-input" name="topbar-color" value="dark" id="darktopbar-check" checked />
                        <label class="form-check-label" for="darktopbar-check">Dark</label>
                    </div>

                    <div class="form-check form-switch mb-1">
                        <input type="checkbox" class="form-check-input" name="topbar-color" value="light" id="lighttopbar-check" />
                        <label class="form-check-label" for="lighttopbar-check">Light</label>
                    </div>

                    <div class="d-grid mt-4">
                        <button class="btn btn-primary" id="resetBtn">Reset to Default</button>
                        <a href="https://1.envato.market/admintoadmin" class="btn btn-danger mt-3" target="_blank"><i class="mdi mdi-basket me-1"></i> Purchase Now</a>
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Vendor -->
<script src="{{URL::asset('package_assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/waypoints/lib/jquery.waypoints.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/jquery.counterup/jquery.counterup.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/feather-icons/feather.min.js')}}"></script>

<!--Morris Chart-->
<script src="{{URL::asset('package_assets/libs/morris.js06/morris.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/chart.js/Chart.bundle.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/raphael/raphael.min.js')}}"></script>

<!-- Init js -->
<script src="{{URL::asset('package_assets/js/pages/chartjs.init.js')}}"></script>
<script src="{{URL::asset('package_assets/js/pages/morris.init.js')}}"></script>

<!-- App js -->
<script src="{{URL::asset('package_assets/js/app.min.js')}}"></script>

<!-- knob plugin -->
<script src="{{URL::asset('package_assets/libs/jquery-knob/jquery.knob.min.js')}}"></script>

<!-- Dashboar init js-->
<script src="{{URL::asset('package_assets/js/pages/dashboard.init.js')}}"></script>

<!-- App js-->
<script src="{{URL::asset('package_assets/js/pages/datatables.init.js')}}"></script>

<!-- third party js -->
<script src="{{URL::asset('package_assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/datatables.net-select/js/dataTables.select.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
<!-- third party js ends -->

<!-- Plugins js -->
<script src="{{URL::asset('package_assets/libs/dropzone/min/dropzone.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/dropify/js/dropify.min.js')}}"></script>
<script src="{{URL::asset('package_assets/libs/tippy.js/tippy.all.min.js')}}"></script>
<!-- <script src="assets/libs/tippy.js/tippy.all.min.js"></script> -->

<!-- Init js-->
<script src="{{URL::asset('package_assets/js/pages/form-fileuploads.init.js')}}"></script>

<!-- Toaster Js -->
<script src="{{ URL::asset('package_assets/libs/toastr/build/toastr.min.js') }}"></script>

<!-- Common Delete And Status Change Js -->
<script src="{{ URL::asset('branch/Common/common.js') }}"></script>

<!-- Validation Js -->
<script src="{{ URL::asset('package_assets/libs/validation/validate.min.js') }}"></script>

<!-- Summernote Js -->
<script src="{{ URL::asset('package_assets/libs/summernote/summernote.min.js') }}"></script>

<!-- Toaster Code -->
<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
    }

    @if(Session::has('success'))
    toastr.success("{{ Session::get('success') }}");
    @endif

    @if(Session::has('info'))
    toastr.info("{{ Session::get('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.warning("{{ Session::get('warning') }}");
    @endif

    @if(Session::has('error'))
    toastr.error("{{ Session::get('error') }}");
    @endif
</script>

<script>
    function success_toast(title = '', message = '') {
        toastr.success(message);
    }

    function error_toast(title = '', message = '') {
        toastr.error(message);
    }
</script>

@yield('script')
@yield('scripts')