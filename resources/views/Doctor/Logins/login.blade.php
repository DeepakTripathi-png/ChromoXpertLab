<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Branch Login | ChromoXpert</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap CSS for tooltips -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        
        .login-header .logo-container {
            background: #fff;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        
        .login-header .logo-container img {
            max-height: 50px;
            max-width: 100%;
            vertical-align: middle;
        }
        
        .login-title {
            color: #6267ae;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .login-subtitle {
            color: #cc235e;
            font-size: 14px;
            font-weight: 500;
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
        
        .pass-show {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6267ae;
            transition: color 0.3s ease;
        }
        
        .pass-show:hover {
            color: #f6b51d;
        }
        
        .remember-forgot-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 26px;
            margin-right: 10px;
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
            border-radius: 26px;
        }
        
        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: #fff;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .slider {
            background: linear-gradient(135deg, #6267ae 0%, #cc235e 100%);
            box-shadow: 0 0 10px rgba(98, 103, 174, 0.5);
        }
        
        input:checked + .slider:before {
            transform: translateX(22px);
        }
        
        .forgot-password a {
            color: #6267ae;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .forgot-password a:hover {
            color: #f6b51d;
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
                    <img src="{{ asset('/package_assets/images/logo.png') }}" alt="ChromoXpert Logo" onerror="this.src='https://via.placeholder.com/150?text=ChromoXpert+Logo';">
                </div>
                <h1 class="login-title">Doctor Login</h1>
            </div>
            <form action="{{ route('doctor.login.post') }}" method="post" id="loginForm">
                @csrf
                <div class="form-group">
                    <label for="email">Email <i class="fas fa-info-circle ms-1" data-bs-toggle="tooltip" title="Enter your registered email address"></i></label>
                    <input class="form-control" type="email" id="email" name="email" placeholder="admin@gmail.com" value="{{ old('email', 'admin@gmail.com') }}">
                    @if($errors->has('email'))
                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password">Password <i class="fas fa-info-circle ms-1" data-bs-toggle="tooltip" title="Enter your password"></i></label>
                    <div class="input-box">
                        <input class="form-control" type="password" id="password" name="password" placeholder="12345678" value="12345678">
                        <div class="pass-show"><i class="fas fa-eye"></i></div>
                    </div>
                    @if($errors->has('password'))
                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first('password') }}</span>
                    @endif
                </div>

                <div class="remember-forgot-row">
                    <div class="remember-me">
                        <label class="switch">
                            <input type="checkbox" id="remember" name="remember">
                            <span class="slider"></span>
                        </label>
                        <label for="remember">Remember Me <i class="fas fa-info-circle ms-1" data-bs-toggle="tooltip" title="Keep me logged in on this device"></i></label>
                    </div>
                    <div class="forgot-password">
                        <a href="{{ url('/forget-password') }}">Forgot Password?</a>
                    </div>
                </div>

                <button class="btn-login" type="submit">Login to Doctor</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Password visibility toggle
            $('.pass-show').on('click', function() {
                const passwordInput = $(this).prev('input');
                const icon = $(this).find('i');
                
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Trigger fade-in animation on load
            $('.login-container').css('opacity', '0');
            setTimeout(() => {
                $('.login-container').css('opacity', '1');
            }, 100);
        });
    </script>
</body>
</html>
