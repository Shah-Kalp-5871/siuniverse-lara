<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $email_parts = explode('@', $email);
        if (count($email_parts) !== 2) {
            return back()->with('error', "Invalid email format.")->withInput();
        }

        $local_part = $email_parts[0];
        $domain_part = strtolower($email_parts[1]);

        // Check if domain is allowed
        if (!\App\Models\AllowedDomain::where('domain', $domain_part)->exists()) {
             return back()->with('error', "Access restricted to valid institute domains.")->withInput();
        }

        // Regex for name.surname.course-year
        $format_regex = '/^[a-zA-Z]+\.[a-zA-Z]+\.[a-zA-Z0-9]+-[0-9]+$/';

        if (!preg_match($format_regex, $local_part)) {
            return back()->with('error', "Email must be in format: student.surname.course-year@institute.siu.edu.in")->withInput();
        }

        if ($password === 'password') {
            session(['user_id' => 1, 'user_name' => explode('.', $local_part)[0]]);
            return redirect()->intended(route('home'));
        }

        return back()->with('error', "Invalid credentials. Use 'password' for testing.")->withInput();
    }

    public function showSignup()
    {
        return view('auth.signup');
    }

    public function signup(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');

        if ($otp && session('verification_otp') == $otp) {
            session([
                'user_id' => rand(10, 1000),
                'user_name' => "Student",
                'email' => $email
            ]);
            
            session()->forget('verification_otp');
            return redirect()->route('onboarding');
        }

        return back()->with('error', "Invalid or expired verification code.")->withInput();
    }

    public function sendOtp(Request $request)
    {
        $email = $request->input('email');
        
        $email_parts = explode('@', $email);
        if (count($email_parts) !== 2) {
            return response()->json(['success' => false, 'message' => "Invalid email format."], 422);
        }

        $local_part = $email_parts[0];
        $domain_part = strtolower($email_parts[1]);
        
        // Check if domain is allowed
        if (!\App\Models\AllowedDomain::where('domain', $domain_part)->exists()) {
            return response()->json([
                'success' => false, 
                'message' => "This email domain is not authorized for registration."
            ], 422);
        }

        $format_regex = '/^[a-zA-Z]+\.[a-zA-Z]+\.[a-zA-Z0-9]+-[0-9]+$/';

        if (!preg_match($format_regex, $local_part)) {
            return response()->json([
                'success' => false, 
                'message' => "Use format: name.surname.course-year@institute.siu.edu.in"
            ], 422);
        }

        $otp = '123456'; // Dummy OTP for static migration
        session(['verification_otp' => $otp]);
        
        return response()->json(['success' => true]);
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
