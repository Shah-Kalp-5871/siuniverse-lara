<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if (!session('user_id')) {
            return redirect()->route('signup');
        }

        $email = session('email');
        $student = $email ? \App\Models\Student::where('email', $email)->first() : null;

        if (!$student) {
            // If no student profile found (e.g. testing or session cleared), return empty
            return view('customer.index', ['communities' => collect()]);
        }

        $acc = $student->accommodation;
        $origin = $student->origin; // 'national' or 'international'

        // Map student values to community categories
        $accCategory = match($acc) {
            'PG / Flat' => 'PG/Flats',
            'Day Scholar' => 'Day Scholars',
            'Hostel' => 'Hostel',
            default => $acc
        };

        $communities = \App\Models\Community::where('status', 'Active')
            ->where(function($query) use ($accCategory, $origin, $student) {
                // 1. Match by Accommodation Category
                $query->where(function($q) use ($accCategory, $student) {
                    $q->where('category', $accCategory);
                    
                    // Special filtering for Hostel (Mess specific groups)
                    if ($accCategory === 'Hostel') {
                        $q->where(function($sq) use ($student) {
                            $sq->where(function($ssq) use ($student) {
                                // Specific Mess group
                                if ($student->mess) {
                                    $ssq->where('mess', $student->mess);
                                } else {
                                    $ssq->whereRaw('1 = 0');
                                }
                            })
                            ->orWhere(function($ssq) {
                                // General Hostel group (no mess specified)
                                $ssq->whereNull('mess');
                            });
                        });
                    }
                });

                // 2. OR Match International Group (for International students)
                if ($origin === 'international') {
                    $query->orWhere('category', 'International');
                }
            })
            ->get();

        return view('customer.index', compact('communities', 'student'));
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
        $stays = \App\Models\Stay::latest()->get();
        return view('customer.explore-stays', compact('stays'));
    }

    public function communities()
    {
        return view('customer.communities');
    }
}
