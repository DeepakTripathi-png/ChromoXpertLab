

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ !empty(App\Helpers\Helpers\Helper::getVisualImages()->favicon_image_path) && Storage::exists(App\Helpers\Helpers\Helper::getVisualImages()->favicon_image_path) ? url('/').Storage::url(App\Helpers\Helpers\Helper::getVisualImages()->favicon_image_path) : URL::asset('package_assets/images/construction_inventory_old.png') }}">

    <!-- third party css -->
    <link href="{{URL::asset('package_assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('package_assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('package_assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('package_assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- App css -->
    <link href="{{URL::asset('package_assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{URL::asset('package_assets/css/style.css')}}" rel="stylesheet" type="text/css" id="style" />
    <link href="{{URL::asset('package_assets/css/common.css')}}" rel="stylesheet" type="text/css" id="style" />

    <!-- icons -->
    <link href="{{URL::asset('package_assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Plugins css -->
    <link href="{{URL::asset('package_assets/libs/dropzone/min/dropzone.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('package_assets/libs/dropify/css/dropify.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Toastr Css -->
    <link rel="stylesheet" href="{{URL::asset('package_assets/libs/toastr/build/toastr.min.css')}}" />
   
    <!-- summer note Css -->
    <link rel="stylesheet" href="{{URL::asset('package_assets/libs/summernote/summernote.min.css')}}" />


