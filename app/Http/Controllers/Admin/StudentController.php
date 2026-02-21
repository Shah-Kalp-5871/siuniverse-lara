<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'institute' => 'required|string',
            'course' => 'required|string',
            'section' => 'required|string',
            'accommodation' => 'nullable|string',
            'campus_location' => 'required|string',
            'current_study_year' => 'required|integer|min:1|max:5',
            'origin' => 'required|in:national,international',
            'gym_choice' => 'nullable|string',
            'branch' => 'nullable|string',
            'mess' => 'nullable|string',
            'country' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $student = Student::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Student registered successfully!',
                'student' => $student
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the student.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'institute' => 'required|string',
            'course' => 'required|string',
            'section' => 'required|string',
            'accommodation' => 'nullable|string',
            'campus_location' => 'required|string',
            'current_study_year' => 'required|integer|min:1|max:5',
            'origin' => 'required|in:national,international',
            'gym_choice' => 'nullable|string',
            'branch' => 'nullable|string',
            'mess' => 'nullable|string',
            'country' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $student->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Student updated successfully!',
                'student' => $student
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the student.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Student $student)
    {
        try {
            $student->delete();
            return response()->json([
                'success' => true,
                'message' => 'Student deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the student.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
