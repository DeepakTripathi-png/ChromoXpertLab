<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>ChromoXpert | Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{URL::asset('package_assets/images/construction_inventory.png')}}">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap CSS for tooltips -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- third party css -->
    <link href="{{URL::asset('package_assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('package_assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('package_assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('package_assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- App css -->
    <link rel="stylesheet" href="{{URL::asset('package_assets/css/app.min.css')}}"/>
    <link rel="stylesheet" href="{{URL::asset('package_assets/css/style.css')}}"/>

    <!-- icons -->
    <link rel="stylesheet" href="{{URL::asset('package_assets/css/icons.min.css')}}" />

    <!-- Toastr Css -->
    <link rel="stylesheet" href="{{URL::asset('package_assets/libs/toastr/build/toastr.min.css')}}" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .login-container {
            width: 100%;
            max-width: 420px;
            animation: fadeInUp 0.6s ease-in-out;
        }
        
        .login-form {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(14px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
        }
        
        .login-form:hover {
            transform: translateY(-5px);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .login-header .top-strip {
            background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%);
            padding: 12px;
            border-radius: 10px 10px 0 0;
            color: #fff;
            font-size: 22px;
            font-weight: 600;
            text-align: center;
        }
        
        .login-header .logo-container {
            background: #fff;
            padding: 15px;
            margin-bottom: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .login-header .logo-container img {
            max-height: 90px;
            max-width: 100%;
            vertical-align: middle;
        }
        
        .login-header .login-strip {
            background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%);
            padding: 12px;
            border-radius: 0 0 10px 10px;
            color: #fff;
            font-size: 22px;
            font-weight: 600;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
            color: #6267ae;
        }
        
        label::after {
            content: " *";
            color: #cc235e;
        }
        
        .form-control {
            width: 100%;
            height: 45px;
            border-radius: 25px;
            border: 1px solid #f6b51d;
            padding: 0 15px;
            font-size: 15px;
            background: #fff;
            color: #6267ae;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #f6b51d;
            box-shadow: 0 0 0 0.25rem rgba(246, 181, 29, 0.25);
        }
        
        .input-box {
            position: relative;
        }
        
        .input-group-text {
            background: transparent;
            border: none;
            color: #6267ae;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%);
            color: #fff;
            border: none;
            height: 45px;
            width: 100%;
            border-radius: 25px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, #cc235e 0%, #6267ae 100%);
            transform: scale(1.05);
        }
        
        .text-danger {
            color: #cc235e;
            font-size: 13px;
            margin-top: 8px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .text-danger i {
            margin-right: 5px;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tooltip-inner {
            background: #6267ae;
            color: #fff;
        }

        .tooltip .tooltip-arrow::before {
            border-top-color: #6267ae;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-form">
            <div class="login-header">
                <div class="logo-container">
                    <img src="{{URL::asset('package_assets/images/logo.png')}}" alt="ChromoXpert Logo" onerror="this.src='https://via.placeholder.com/150?text=ChromoXpert+Logo';">
                </div>
                <div class="login-strip">Forgot Password</div>
            </div>
            <form action="{{ route('forget.password.post') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="email">Email address <i class="fas fa-info-circle ms-1" data-bs-toggle="tooltip" title="Enter your registered email address"></i></label>
                    <div class="input-box">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input class="form-control" type="email" id="email" name="email" placeholder="Enter your email">
                        </div>
                    </div>
                    @if($errors->has('email'))
                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first('email') }}</span>
                    @endif
                </div>

                <button class="btn-login" type="submit"><i class="fas fa-paper-plane me-2"></i> Send Link</button>
            </form>
        </div>
    </div>

    <!-- Vendor -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ URL::asset('package_assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('package_assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ URL::asset('package_assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ URL::asset('package_assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ URL::asset('package_assets/libs/feather-icons/feather.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ URL::asset('package_assets/js/app.min.js') }}"></script>

    <!-- Toastr Js -->
    <script src="{{ URL::asset('package_assets/libs/toastr/build/toastr.min.js') }}"></script>

    <!-- Custom Js -->
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Trigger fade-in animation on load
            $('.login-container').css('opacity', '0');
            setTimeout(() => {
                $('.login-container').css('opacity', '1');
            }, 100);

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
        });
    </script>
</body>
</html>