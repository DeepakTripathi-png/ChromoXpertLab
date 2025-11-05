
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('meta_title')</title> 
    @include('Branch.Includes.header')

    @yield('css')
</head>
<body class="loading" data-layout-color="light" data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light" data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>
<input type="hidden" value="{{url('/')}}" id="base_url"/>      
<div id="wrapper">
        @include('Branch.Includes.navbar')
        @yield('content')
    </div>
    @include('Branch.Includes.footer')
    @yield('scripts')
</body>
</html>