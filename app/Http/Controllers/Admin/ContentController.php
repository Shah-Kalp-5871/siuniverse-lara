<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Stay;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index()
    {
        $stays = Stay::latest()->get();
        $amenities = \App\Models\Amenity::all()->pluck('name');
        $rules = \App\Models\RuleRegulation::all()->pluck('name');
        return view('admin.content', compact('stays', 'amenities', 'rules'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|in:PG,Flat',
            'rent' => 'required|integer',
            'image' => 'nullable|image|max:10240', // 10MB
            'link' => 'nullable|url',
            'broker_number' => 'required|string',
            'broker_name' => 'required|string',
            'rules' => 'required|array',
            'amenities' => 'required|array',
            'distance' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();
            
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('stays', 'public');
                $data['image_path'] = $path;
            }

            $stay = Stay::create($data);
            return response()->json([
                'success' => true,
                'message' => 'Stay listed successfully!',
                'stay' => $stay
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while listing the property.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Stay $stay)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|in:PG,Flat',
            'rent' => 'required|integer',
            'image' => 'nullable|image|max:10240',
            'link' => 'nullable|url',
            'broker_number' => 'required|string',
            'broker_name' => 'required|string',
            'rules' => 'required|array',
            'amenities' => 'required|array',
            'distance' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();
            
            if ($request->hasFile('image')) {
                // Delete old image
                if ($stay->image_path) {
                    Storage::disk('public')->delete($stay->image_path);
                }
                $path = $request->file('image')->store('stays', 'public');
                $data['image_path'] = $path;
            }

            $stay->update($data);
            return response()->json([
                'success' => true,
                'message' => 'Stay updated successfully!',
                'stay' => $stay
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the property.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Stay $stay)
    {
        try {
            if ($stay->image_path) {
                Storage::disk('public')->delete($stay->image_path);
            }
            $stay->delete();
            return response()->json([
                'success' => true,
                'message' => 'Stay removed successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while removing the property.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Amenities Management
    public function storeAmenity(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:amenities,name']);
        \App\Models\Amenity::create(['name' => $request->name]);
        return response()->json(['success' => true]);
    }

    public function destroyAmenity(Request $request)
    {
        \App\Models\Amenity::where('name', $request->name)->delete();
        return response()->json(['success' => true]);
    }

    // Rules Management
    public function storeRule(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:rules_regulations,name']);
        \App\Models\RuleRegulation::create(['name' => $request->name]);
        return response()->json(['success' => true]);
    }

    public function destroyRule(Request $request)
    {
        \App\Models\RuleRegulation::where('name', $request->name)->delete();
        return response()->json(['success' => true]);
    }
}
