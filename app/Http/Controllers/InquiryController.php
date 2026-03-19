<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Inquiry submission attempt started', $request->all());

        try {
            $validated = $request->validate([
                'stay_id' => 'required|exists:stays,id',
                'user_name' => 'required|string|max:255',
                'user_contact_number' => ['required', 'string', 'regex:/^[6789]\d{9}$/'],
                'visit_date' => 'required|date',
                'visit_time' => 'required|string|max:255',
                'visiting_schedule' => 'required|string|max:255',
            ]);

            Log::info('Inquiry validation passed');

            $inquiry = \App\Models\Inquiry::create($request->all());
            
            Log::info('Inquiry created successfully', ['id' => $inquiry->id]);

            return response()->json([
                'success' => true,
                'message' => 'Your visit request has been submitted successfully! Owner will contact you within 24 hours to confirm your visit.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Inquiry validation fallout', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Inquiry submission error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting your request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
