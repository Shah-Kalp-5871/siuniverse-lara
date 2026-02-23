<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $student = \App\Models\Student::find($userId);
        
        return view('customer.profile', compact('student'));
    }
}
