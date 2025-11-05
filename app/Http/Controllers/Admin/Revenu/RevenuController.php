<?php

namespace App\Http\Controllers\Admin\Revenu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RevenuController extends Controller
{
    
    public function index(){
        return view('Admin.revenu.index');
    }


    public function view(){
        return view('Admin.revenu.revenu_view');
    }


}
