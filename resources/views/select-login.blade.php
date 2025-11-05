<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChromoXpert - Select Login</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }
        .container {
            text-align: center;
            padding: 40px 30px;
            max-width: 600px;
            width: 100%;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            position: relative;
        }
        .logo {
            font-size: 2.8em;
            font-weight: bold;
            background: linear-gradient(135deg, #7b1fa2 0%, #ab47bc 50%, #ff9800 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
            text-shadow: none;
        }
        .logo sup {
            font-size: 0.4em;
            vertical-align: super;
            background: inherit;
            -webkit-background-clip: inherit;
            -webkit-text-fill-color: transparent;
            background-clip: inherit;
        }
        .title {
            color: #6c757d;
            font-size: 1.4em;
            margin-bottom: 5px;
            font-weight: 500;
        }
        .welcome {
            font-size: 1em;
            margin-bottom: 35px;
            color: #6c757d;
            line-height: 1.4;
        }
        .login-buttons {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            gap: 12px;
            margin-bottom: 20px;
        }
        .login-btn {
            background: linear-gradient(135deg, #7b1fa2 0%, #e91e63 100%);
            color: white;
            border: none;
            padding: 16px 20px;
            font-size: 1em;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(123, 31, 162, 0.3);
            font-weight: 500;
            position: relative;
            overflow: hidden;
            flex: 1;
            min-width: 120px;
        }
        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        .login-btn:hover::before {
            left: 100%;
        }
        .login-btn:hover {
            background: linear-gradient(135deg, #6a1b9a 0%, #c2185b 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(123, 31, 162, 0.4);
        }
        .login-btn:active {
            transform: translateY(0);
        }
        .icon {
            font-size: 1.2em;
        }
        .forgot {
            color: #6c757d;
            text-decoration: none;
            font-size: 0.9em;
            display: inline-block;
        }
        .forgot:hover {
            text-decoration: underline;
        }
        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
                margin: 20px;
                border-radius: 16px;
            }
            .logo {
                font-size: 2.2em;
            }
            .login-buttons {
                flex-direction: column;
            }
            .login-btn {
                min-width: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">ChromoXpert<sup>&reg;</sup></div>
        <div class="title">Select Your Login Portal</div>
        <div class="welcome">Welcome! Please choose the appropriate access portal below!</div>
        <div class="login-buttons">
            <a href="{{url('/admin')}}" class="login-btn">
                <span class="icon">🛡️</span>
                Admin Login
            </a>
            <a href="{{url('/branch-login')}}" class="login-btn">
                <span class="icon">🏢</span>
                Branch Login
            </a>
            <a href="{{url('/doctor-login')}}" class="login-btn">
                <span class="icon">🩺</span>
                Doctor Login
            </a>
        </div>
       
    </div>
</body>
</html>