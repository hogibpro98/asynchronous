<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;

class DemoController extends Controller
{
    protected function showDemo()
    {
        return view('demo.index');
    }
}
