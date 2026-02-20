<?php

use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CommunityController as AdminCommunityController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/discover', [HomeController::class, 'discover'])->name('discover');
Route::get('/explore-stays', [HomeController::class, 'exploreStays'])->name('explore-stays');
Route::get('/communities', [HomeController::class, 'communities'])->name('communities');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');
Route::post('/auth/send-otp', [AuthController::class, 'sendOtp'])->name('auth.send-otp');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Onboarding Routes
Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding');
Route::post('/onboarding', [OnboardingController::class, 'process'])->name('onboarding.post');

// Dashboard & Profile
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Admin Routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.post');
    });

    // Authenticated Admin Routes
    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/content', [AdminContentController::class, 'index'])->name('content');
        Route::get('/users', [AdminUserController::class, 'index'])->name('users');
        Route::post('/students', [AdminStudentController::class, 'store'])->name('students.store');
        Route::put('/students/{student}', [AdminStudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{student}', [AdminStudentController::class, 'destroy'])->name('students.destroy');
        Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

        Route::resource('communities', AdminCommunityController::class)->except(['create', 'edit', 'show']);
        Route::resource('stays', AdminContentController::class)->except(['create', 'edit', 'show']);

        // Settings
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
        Route::post('/settings/domains', [\App\Http\Controllers\Admin\SettingsController::class, 'store'])->name('settings.domains.store');
        Route::delete('/settings/domains/{id}', [\App\Http\Controllers\Admin\SettingsController::class, 'destroy'])->name('settings.domains.destroy');
        Route::post('/settings/password', [\App\Http\Controllers\Admin\SettingsController::class, 'updatePassword'])->name('settings.password.update');

        // Dynamic Options
        Route::post('/amenities', [AdminContentController::class, 'storeAmenity'])->name('amenities.store');
        Route::post('/amenities/delete', [AdminContentController::class, 'destroyAmenity'])->name('amenities.destroy');
        Route::post('/rules', [AdminContentController::class, 'storeRule'])->name('rules.store');
        Route::post('/rules/delete', [AdminContentController::class, 'destroyRule'])->name('rules.destroy');
    });
});
