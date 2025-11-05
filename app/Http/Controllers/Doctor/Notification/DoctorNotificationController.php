<?php

namespace App\Http\Controllers\Doctor\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DoctorNotificationController extends Controller
{
      public  function index(){
          return view('Doctor.Notification.notification');
      }
}
