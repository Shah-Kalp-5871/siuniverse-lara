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

    public function exploreStays(Request $request)
    {
        $query = \App\Models\Stay::query();
        $areas = \App\Models\Stay::whereNotNull('area')->distinct()->pluck('area');

        // Check for specific filters. Only one filter working at a time per requirement.
        if ($request->filled('area')) {
            $areas = is_array($request->area) ? $request->area : explode(',', $request->area);
            $query->whereIn('area', $areas);
        } elseif ($request->filled('max_rent')) {
            $query->where(function($q) use ($request) {
                $q->where('single_sharing_rent', '<=', $request->max_rent)
                  ->orWhere('double_sharing_rent', '<=', $request->max_rent)
                  ->orWhere('triple_sharing_rent', '<=', $request->max_rent);
            });
        } elseif ($request->filled('gender')) {
            $genders = is_array($request->gender) ? $request->gender : explode(',', $request->gender);
            $query->whereIn('gender', $genders);
        } elseif ($request->filled('type')) {
            $query->where('type', $request->type);
        } elseif ($request->filled('luxury')) {
            $query->where('is_luxury', true)->orderBy('luxury_order', 'asc');
        } else {
            // Default view: Standard (Non-Luxury) PGs
            $query->where('is_luxury', false)->orderBy('created_at', 'desc');
        }

        $stays = $query->get();

        if ($request->ajax()) {
            return view('customer.partials.stay-listings', compact('stays'))->render();
        }

        return view('customer.explore-stays', compact('stays', 'areas'));
    }

    public function communities()
    {
        return view('customer.communities');
    }
}
