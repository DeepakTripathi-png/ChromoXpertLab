<?php

namespace App\Http\Controllers\Admin\NotFoundController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotFoundController extends Controller
{
    public function index(){
        return view('Admin.NotFounds.404-not-found');
    }
}
