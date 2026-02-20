<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function index()
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }
        return view('customer.onboarding');
    }

    public function process(Request $request)
    {
        session([
            'onboarding_data' => [
                'accommodation' => $request->input('accommodation'),
                'mess' => $request->input('mess'),
                'campus' => $request->input('campus'),
                'institute' => $request->input('institute'),
                'course' => $request->input('course'),
                'branch' => $request->input('branch'),
                'section' => $request->input('section'),
                'year' => $request->input('year'),
                'gym' => $request->input('gym'),
                'country' => $request->input('country'),
                'international_student' => ($request->input('country') === 'Other'),
            ]
        ]);

        return redirect()->route('dashboard');
    }
}
