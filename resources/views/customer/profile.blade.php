@extends('layouts.app')

@section('title', 'My Profile - SIU UNIVERSE')

@section('content')
@php
    // Fallback to empty object if student not found
    $student = $student ?? new \App\Models\Student();
@endphp

<div class="container mx-auto px-4 py-12 max-w-4xl">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-primary to-secondary p-8 text-white relative">
            <div class="flex flex-col md:flex-row items-center md:items-end space-y-4 md:space-y-0 md:space-x-6">
                <div class="w-24 h-24 bg-white/20 rounded-2xl backdrop-blur-md flex items-center justify-center text-4xl border border-white/30">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold">{{ $student->name ?? 'User Name' }}</h1>
                    <p class="text-blue-100">{{ $student->course ?? 'Course' }} • {{ $student->institute ?? 'Institute' }}</p>
                </div>
            </div>
            <div class="absolute top-8 right-8">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500/20 hover:bg-red-500/40 p-2 rounded-lg backdrop-blur-sm transition-all text-sm border border-red-500/30 text-white">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Personal Details</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-500 uppercase font-bold tracking-wider">Accommodation</span>
                            <span class="text-gray-800 font-semibold">{{ $student->accommodation ?? 'Not set' }}</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-500 uppercase font-bold tracking-wider">Campus Location</span>
                            <span class="text-gray-800 font-semibold">{{ $student->campus_location ?? 'Not set' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-university"></i>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-500 uppercase font-bold tracking-wider">Institute & Section</span>
                            <span class="text-gray-800 font-semibold">{{ $student->institute ?? 'Not set' }} ({{ $student->section ?? 'A' }})</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-500 uppercase font-bold tracking-wider">Year of Study</span>
                            <span class="text-gray-800 font-semibold">Year {{ $student->current_study_year ?? 'Not set' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-500 uppercase font-bold tracking-wider">Gym Preference</span>
                            <span class="text-gray-800 font-semibold">{{ $student->gym_choice ?? 'Not set' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-flag"></i>
                        </div>
                        <div>
                            <span class="block text-xs text-gray-500 uppercase font-bold tracking-wider">Origin</span>
                            <span class="text-gray-800 font-semibold">{{ ($student->country ?? 'India') == 'India' ? 'India' : 'International Student' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100 flex items-start space-x-4">
        <i class="fas fa-info-circle text-blue-500 mt-1"></i>
        <p class="text-sm text-blue-800">
            This information is used to automatically assign you to relevant campus communities. Only students in your institute can see your profile searching by name.
        </p>
    </div>
</div>
@endsection
