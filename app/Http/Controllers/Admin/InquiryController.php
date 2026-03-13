<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = \App\Models\Inquiry::with('stay')->latest()->get();
        return view('admin.inquiries', compact('inquiries'));
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
