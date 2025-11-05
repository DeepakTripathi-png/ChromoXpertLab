<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Test;

class TestController extends Controller
{
    public function index()
    {
        try {
            $tests = Test::where('status', 'active')->get();
            return response()->json($tests);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server Error'], 500);
        }
    }
}