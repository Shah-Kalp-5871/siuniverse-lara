<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = \App\Models\Inquiry::with('stay')->latest()->get();
        
        // Calculate inquiry counts per stay (only undismissed)
        $notifications = \App\Models\Inquiry::where('is_dismissed', false)
            ->select('stay_id', DB::raw('count(*) as total'))
            ->with('stay')
            ->groupBy('stay_id')
            ->get()
            ->map(function($item) {
                return [
                    'stay_id' => $item->stay_id,
                    'name' => $item->stay->name ?? 'Unknown Stay',
                    'count' => $item->total
                ];
            });

        return view('admin.inquiries', compact('inquiries', 'notifications'));
    }

    public function dismiss(Request $request)
    {
        $request->validate([
            'stay_id' => 'required|exists:stays,id'
        ]);

        try {
            \App\Models\Inquiry::where('stay_id', $request->stay_id)
                ->where('is_dismissed', false)
                ->update(['is_dismissed' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Notifications dismissed!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to dismiss notifications.'
            ], 500);
        }
    }

    public function destroy(\App\Models\Inquiry $inquiry)
    {
        try {
            $inquiry->delete();
            return response()->json([
                'success' => true,
                'message' => 'Inquiry removed successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while removing the inquiry.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
