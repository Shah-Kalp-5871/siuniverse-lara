<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\Community;
use App\Models\Stay;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalGroups = Community::count();
        $totalStays = Stay::count();

        // Fetch recent activities
        $recentStudents = Student::latest()->take(5)->get()->map(function($item) {
            return [
                'user' => $item->name,
                'action' => 'registered as a new student',
                'time' => $item->created_at,
                'type' => 'student'
            ];
        });

        $recentGroups = Community::latest()->take(5)->get()->map(function($item) {
            return [
                'user' => 'Admin',
                'action' => "created \"{$item->name}\" group",
                'time' => $item->created_at,
                'type' => 'group'
            ];
        });

        $recentStays = Stay::latest()->take(5)->get()->map(function($item) {
            return [
                'user' => $item->broker_name ?? 'Admin',
                'action' => "listed property \"{$item->name}\"",
                'time' => $item->created_at,
                'type' => 'stay'
            ];
        });

        $activities = $recentStudents->concat($recentGroups)->concat($recentStays)
            ->sortByDesc('time')
            ->take(8);

        return view('admin.dashboard', compact('totalStudents', 'totalGroups', 'totalStays', 'activities'));
    }
}
