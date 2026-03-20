<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminOtpMail;
use App\Models\Admin;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            // Generate OTP
            $otp = rand(100000, 999999);
            
            // Store in Cache: 5 mins tying it to the email
            Cache::put('admin_otp_'.$admin->email, $otp, now()->addMinutes(5));
            
            // Send Email
            Mail::to($admin->email)->send(new AdminOtpMail($otp));

            // Set session for next step
            $request->session()->put('admin_login_email', $admin->email);

            return redirect()->route('admin.login.verify');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    public function showVerifyOtp(Request $request)
    {
        if (!$request->session()->has('admin_login_email')) {
            return redirect()->route('admin.login');
        }
        return view('admin.auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $email = $request->session()->get('admin_login_email');
        if (!$email) {
            return redirect()->route('admin.login')->with('error', 'Session expired. Please login again.');
        }

        $cachedOtp = Cache::get('admin_otp_'.$email);

        if ($cachedOtp && $cachedOtp == $request->otp) {
            $admin = Admin::where('email', $email)->first();
            
            if ($admin) {
                Auth::guard('admin')->login($admin);
                Cache::forget('admin_otp_'.$email);
                $request->session()->forget('admin_login_email');
                $request->session()->regenerate();
                
                return redirect()->intended(route('admin.dashboard'));
            }
        }

        return back()->with('error', 'Invalid or expired OTP.');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
