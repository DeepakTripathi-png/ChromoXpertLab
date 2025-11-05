<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('Admin.Dashboard.index');
    }


    public function doctorDashboard(){
        return view('Admin.Dashboard.doctor-dashboard');
    }
}
