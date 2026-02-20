<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student;

class UserController extends Controller
{
    public function index()
    {
        $students = Student::latest()->get();
        return view('admin.users', compact('students'));
    }
}
