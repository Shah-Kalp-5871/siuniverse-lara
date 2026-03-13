<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'stay_id' => 'required|exists:stays,id',
            'user_name' => 'required|string|max:255',
            'user_contact_number' => 'required|string|max:15',
            'visit_date' => 'required|date',
            'visit_time' => 'required|string|max:255',
            'visiting_schedule' => 'required|string|max:255',
        ]);

        try {
            \App\Models\Inquiry::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Your visit request has been submitted successfully! Owner will contact you within 24 hours to confirm your visit.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting your request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
