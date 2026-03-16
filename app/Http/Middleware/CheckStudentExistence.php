<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStudentExistence
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Don't check for admin routes (starting with admin/)
        if ($request->is('admin') || $request->is('admin/*')) {
            return $next($request);
        }

        if (session('user_id') && session('email')) {
            $student = \App\Models\Student::where('email', session('email'))->exists();
            
            if (!$student) {
                session()->flush();
                return redirect()->route('signup')->with('error', 'Your account no longer exists. Please sign up again.');
            }
        }

        return $next($request);
    }
}
