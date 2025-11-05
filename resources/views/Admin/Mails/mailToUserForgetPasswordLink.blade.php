@extends('Admin.Layouts.mail_layout')

@section('mail_title')  Change Password  @endsection

@section('email_content')

    <div style="width: 100%; display: block; margin-bottom: 10px;">
        <div style="font-size: 25px;color: #000;font-weight: 900;">
            <p>We Market Research Change Password</p>
        </div>
    </div>
    <div style="width: 100%; margin-bottom: 30px;">
        <div style="font-size: 16px; color: #000;">
            <h3>
                <p><a href="{{ url('reset-password/'.$mailData['token']) }}">Click Here</a> to change the password</p>
            </h3>
        </div>
    </div>

@endsection