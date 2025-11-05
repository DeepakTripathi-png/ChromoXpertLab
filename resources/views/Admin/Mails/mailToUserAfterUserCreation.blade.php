@extends('Admin.Layouts.mail_layout')

@section('mail_title')  Project  @endsection

@section('email_content')

    <h2>Congratulation ! You are now the part of WE MARKET RESEARCH as a {{ $mailData['role'] }}</h2>
    <h3><a href="{{ url('/admin') }}">Click Here</a> to Loging To Your Account And Change Password</h3>
    <h4>Your Login Credentials are :-</h4>
    <p>User Name : {{ $mailData['email'] }}</p>
    <p>Password : {{ $mailData['password'] }}</p>
    
@endsection