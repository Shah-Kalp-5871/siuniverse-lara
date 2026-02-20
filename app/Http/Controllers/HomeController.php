<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('customer.index');
    }

    public function discover()
    {
        return view('customer.discover');
    }

    public function exploreStays()
    {
        return view('customer.explore-stays');
    }

    public function communities()
    {
        return view('customer.communities');
    }
}
