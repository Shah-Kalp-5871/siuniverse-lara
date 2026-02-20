<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AllowedDomain;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $allowedDomains = AllowedDomain::latest()->get();
        return view('admin.settings', compact('allowedDomains'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'domain' => 'required|string|unique:allowed_domains,domain'
        ]);

        AllowedDomain::create([
            'domain' => strtolower($request->domain)
        ]);

        return response()->json(['success' => true, 'message' => 'Domain added successfully']);
    }

    public function destroy($id)
    {
        $domain = AllowedDomain::findOrFail($id);
        $domain->delete();

        return response()->json(['success' => true, 'message' => 'Domain removed successfully']);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $admin = \Illuminate\Support\Facades\Auth::guard('admin')->user();

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $admin->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password provided is incorrect.'
            ], 422);
        }

        $admin->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
        $admin->save();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully. Please use your new password for next login.'
        ]);
    }
}
