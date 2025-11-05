<!DOCTYPE html>
<html>
<head>
    <title>@yield('mail_title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">
        body {
            font-family: 'Poppins', sans-serif;
            color: #444444;
        }
        .social-links a img{
            height: 25px;
        }
    </style>
    @yield('email_css')
</head>

@php
$general_setting = App\Models\Master\General_setting::get()->first();
@endphp
<body style="background: #f1f1f1; margin: 0px auto; padding: 0px;font-family: 'Poppins', sans-serif;">
    <div style="background-color: #fff; margin: 0px auto; max-width: 800px; height: auto;overflow: hidden;">

        <div class="header-logo" style="width: 100%;padding: 10px 40px;background: #3284f547;">
            @php
                $logo_image = App\Models\Master\Visual_setting::where('status','active')->select('logo_email_image_path','logo_email_image_name')->first();
            @endphp 
            <img src="{{ !empty($logo_image->logo_email_image_path) && Storage::exists($logo_image->logo_email_image_path) ? url('/').Storage::url($logo_image->logo_email_image_path) : URL::asset('admin_panel/commonarea/dist/img/default.png') }}" alt="{{ !empty($logo_image->logo_email_image_name) ? $logo_image->logo_image_name : 'Logo Image' }}" style="max-width: 160px; max-height: 160px;">
        </div>

        <div class="" style="padding: 40px 40px 3px;">
            @yield('email_content')
        </div>

        <div style="width: 100%;background: #3284f547;background-repeat: no-repeat;height: auto;">
            <table style="width: 100%; align-items: middle">
                <tr>
                    <td style="padding: 15px 0px;">
                        <div class="website-link">
                            <a target="blank" href="{{ url('/') }}">www.wemarketresearch.com</a>
                        </div>
                    </td>
                    <td style="padding: 15px 0px;">
                        <div class="social-links">
                            <table style="float:right">
                                <tr>
                                    <td>
                                        <center>
                                        <a href="mailto:{{ !empty($general_setting->email) ? $general_setting->email : '' }}" target="blank">
                                            <img src="{{asset('front/images/new-images/mail/gmail.png') }}" alt="">
                                        </a>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                        <a href="{{ !empty($general_setting->facebook_url) ? $general_setting->facebook_url : '' }}" target="blank">
                                            <img src="{{asset('front/images/new-images/mail/facebook.png') }}" alt="">
                                        </a>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                        <a href="{{ !empty($general_setting->instagram_url) ? $general_setting->instagram_url : '' }}" target="blank">
                                            <img src="{{asset('front/images/new-images/mail/instagram.png') }}" alt="">
                                        </a>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                        <a href="{{ !empty($general_setting->twitter_url) ? $general_setting->twitter_url : '' }}" target="blank">
                                            <img src="{{asset('front/images/new-images/mail/twitter.png') }}" alt="">
                                        </a>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                        <a href="{{ !empty($general_setting->linkedin_url) ? $general_setting->linkedin_url : '' }}" target="blank">
                                            <img src="{{asset('front/images/new-images/mail/linkedin.png') }}" alt="">
                                        </a>
                                        </center>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
