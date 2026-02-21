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
        $email = session('email');
        if (!$email) {
            return redirect()->route('signup');
        }

        // Handle Origin
        $origin = ($request->input('country') === 'India') ? 'national' : 'international';

        // Find or create student
        $student = \App\Models\Student::updateOrCreate(
            ['email' => $email],
            [
                'name' => $request->input('name') ?? 'Student',
                'institute' => $request->input('institute'),
                'course' => $request->input('course'),
                'branch' => $request->input('branch'),
                'section' => $request->input('section'),
                'current_study_year' => $request->input('year'),
                'accommodation' => $request->input('accommodation'),
                'mess' => $request->input('mess'),
                'campus_location' => $request->input('campus'),
                'gym_choice' => $request->input('gym'),
                'origin' => $origin,
                'country' => $request->input('country'),
                'datestamp' => now(),
            ]
        );

        session([
            'user_name' => $student->name,
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

        return redirect()->route('home'); // Redirect to home after onboarding
    }
}
