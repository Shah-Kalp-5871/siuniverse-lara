<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class AuthController extends Controller
{
    public function showLogin()
    {
        $allowedDomains = \App\Models\AllowedDomain::all()->pluck('domain')->toArray();
        return view('auth.login', compact('allowedDomains'));
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

        if ($password === 'password') {
            session(['user_id' => 1, 'user_name' => explode('.', $local_part)[0]]);
            return redirect()->intended(route('home'));
        }

        return back()->with('error', "Invalid credentials. Use 'password' for testing.")->withInput();
    }

    public function showSignup()
    {
        $allowedDomains = \App\Models\AllowedDomain::all()->pluck('domain')->toArray();
        return view('auth.signup', compact('allowedDomains'));
    }

    public function signup(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');

        // Check expiry first
        $expiresAt = session('otp_expires_at');
        if (!$expiresAt || now()->isAfter($expiresAt)) {
            session()->forget(['verification_otp', 'otp_expires_at']);
            return back()->with('error', "Verification code has expired. Please request a new one.")->withInput();
        }

        if ($otp && session('verification_otp') == $otp) {
            session([
                'user_id'  => rand(10, 1000),
                'user_name' => "Student",
                'email'    => $email
            ]);
            session()->forget(['verification_otp', 'otp_expires_at']);
            return redirect()->route('onboarding');
        }

        return back()->with('error', "Invalid verification code. Please try again.")->withInput();
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

        // Check if this email is already registered
        if (\App\Models\Student::where('email', $email)->exists()) {
            return response()->json([
                'success'            => false,
                'already_registered' => true,
                'message'            => "This email is already registered. Redirecting you to login...",
            ], 409);
        }

        // Generate a cryptographically random 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store OTP + expiry (5 minutes) in session
        session([
            'verification_otp'  => $otp,
            'otp_expires_at'    => now()->addMinutes(5),
        ]);

        // Send OTP email via Gmail SMTP
        try {
            Mail::to($email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            \Log::error('OTP mail failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send verification email. Please check your email address and try again.',
            ], 500);
        }
        
        return response()->json(['success' => true]);
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
