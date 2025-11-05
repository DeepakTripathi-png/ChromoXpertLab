<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404</title>
    <style>
        body{
            margin: 0;
            overflow: hidden;
        }
        .notfound{
            height: 100%;
            width: 100%;
            position: relative;
            margin: 75px 0;
        }
        .notfound .notfound-404 h1 {
            font-family: maven pro,sans-serif;
            color: #a1a1a1d1;
            font-size: 250px;
            margin: 0;
            font-weight: 900;
        }
        .notfound .notfound-404 h1::after {
            content: "";
            position: absolute;
            height: 150px;
            width: 150px;
            background-color: #0d1e67;
            left: -85px;
            top: 45px;
            opacity: 0.5;
            border-radius: 20%;
            transform: rotateZ(38deg);
        }
        .notfound h2 {
            font-family: maven pro,sans-serif;
            font-size: 30px;
            color: #585858;
            font-weight: 900;
            text-transform: uppercase;
            margin: 0;
        }
        .notfound h2::after  {
            content: "";
            position: absolute;
            height: 150px;
            width: 150px;
            background-color: #0d1e67;
            right: -85px;
            bottom: 45px;
            opacity: 0.5;
            border-radius: 20%;
            transform: rotateZ(38deg);
        }
        .notfound a {
            font-family: maven pro,sans-serif;
            font-size: 14px;
            text-decoration: none;
            text-transform: uppercase;
            background: #189cf0;
            display: inline-block;
            padding: 16px 38px;
            border: 2px solid transparent;
            border-radius: 40px;
            color: #fff;
            font-weight: 400;
            -webkit-transition: .2s all;
            transition: .2s all;
        }
        .notfound .notfound-404 {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .notfound .notfound-404-content {
            display: flex;
            flex-direction: column;
            gap: 30px;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="notfound">
        <div class="notfound-404">
            <h1>404</h1>
            <div class="notfound-404-content">
                <h2>We are sorry, Page not found!</h2>
                <a href="{{ url('/admin') }}">Dashboard</a>
            </div>
        </div>
    </div>  
</body>

</html>
