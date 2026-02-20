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
        $onboarding = session('onboarding_data');
        $institute = $onboarding['institute'] ?? 'SIT';
        $course = $onboarding['course'] ?? 'B.Tech';

        // Fetch all students to ensure visibility, we can re-apply filtering later
        $students = \App\Models\Student::all();

        return view('customer.discover', compact('students', 'institute', 'course'));
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
