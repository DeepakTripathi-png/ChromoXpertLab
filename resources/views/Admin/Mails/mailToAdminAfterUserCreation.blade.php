@extends('Admin.Layouts.mail_layout')

@section('mail_title')  Project  @endsection

@section('email_content')

    <h1>We Market <span class="staticColor">Research Reports</span> </h1>
    <h3>You have created New User For The Role of {{ $mailData['role'] }}</h3>
    
@endsection