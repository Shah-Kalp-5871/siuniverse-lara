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
            \Log::warning('Onboarding attempted with no email in session.');
            return redirect()->route('signup')->with('error', 'Session expired. Please sign up again.');
        }

        // handle origin
        $origin = ($request->input('country') === 'India') ? 'national' : 'international';

        // validate required onboarding inputs including password
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'accommodation' => ['required', 'string'],
            'campus' => ['required', 'string'],
            'institute' => ['required', 'string'],
            'course' => ['required', 'string'],
            'section' => ['required', 'string'],
            'year' => ['required', 'integer'],
            'country' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            // Find or create student — saves ALL onboarding data to DB
            $student = \App\Models\Student::updateOrCreate(
                ['email' => $email],
                [
                    'name'               => $request->input('name') ?? 'Student',
                    // hash password before storing
                    'password'           => \Illuminate\Support\Facades\Hash::make($request->input('password')),
                    'institute'          => $request->input('institute'),
                    'course'             => $request->input('course'),
                    'branch'             => $request->input('branch'),
                    'section'            => $request->input('section'),
                    'current_study_year' => $request->input('year'),
                    'accommodation'      => $request->input('accommodation'),
                    'mess'               => $request->input('mess'),
                    'campus_location'    => $request->input('campus'),
                    'gym_choice'         => $request->input('gym'),
                    'origin'             => $origin,
                    'country'            => $request->input('country'),
                    'datestamp'          => now(),
                ]
            );
            // Update session with real student DB id and name
            session([
                'user_id'        => $student->id,
                'user_name'      => $student->name,
                'onboarding_data' => [
                    'accommodation'        => $request->input('accommodation'),
                    'mess'                 => $request->input('mess'),
                    'campus'               => $request->input('campus'),
                    'institute'            => $request->input('institute'),
                    'course'               => $request->input('course'),
                    'branch'               => $request->input('branch'),
                    'section'              => $request->input('section'),
                    'year'                 => $request->input('year'),
                    'gym'                  => $request->input('gym'),
                    'country'              => $request->input('country'),
                    'international_student' => ($request->input('country') === 'Other'),
                ]
            ]);

            \Log::info("Onboarding complete for: {$email} (Student ID: {$student->id})");

        } catch (\Exception $e) {
            \Log::error("Onboarding DB save failed for {$email}: " . $e->getMessage());
            return back()->with('error', 'Something went wrong saving your data. Please try again.');
        }

        return redirect()->route('dashboard');
    }
}
