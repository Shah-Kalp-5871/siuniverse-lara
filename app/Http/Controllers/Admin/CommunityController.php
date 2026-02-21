<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Community;
use Illuminate\Support\Facades\Validator;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = Community::latest()->get();
        return view('admin.communities', compact('communities'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'invite_link' => 'required|url',
            'status' => 'required|in:Active,Inactive',
            'mess' => 'nullable|string|max:255',
            'gym' => 'nullable|string|max:255',
            'origin' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $community = Community::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'WhatsApp group created successfully!',
                'community' => $community
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the group.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Community $community)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'invite_link' => 'required|url',
            'status' => 'required|in:Active,Inactive',
            'mess' => 'nullable|string|max:255',
            'gym' => 'nullable|string|max:255',
            'origin' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $community->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'WhatsApp group updated successfully!',
                'community' => $community
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the group.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Community $community)
    {
        try {
            $community->delete();
            return response()->json([
                'success' => true,
                'message' => 'WhatsApp group deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the group.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');

        if (!$ids || !is_array($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No IDs provided for deletion.'
            ], 400);
        }

        try {
            Community::whereIn('id', $ids)->delete();
            return response()->json([
                'success' => true,
                'message' => count($ids) . ' WhatsApp groups deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while performing bulk deletion.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
