@extends('layouts.admin')

@section('title', 'Dashboard - SIU Admin')

@section('content')
<!-- Header -->
<header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 space-y-4 md:space-y-0">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Operational Overview</h1>
        <p class="text-slate-500 text-sm italic">Welcome back, Administrator.</p>
    </div>
    <div class="flex items-center space-x-4 w-full md:w-auto justify-between md:justify-end">
        <button class="bg-white p-2.5 rounded-xl border border-slate-200 text-slate-500 hover:text-slate-800 transition-all shadow-sm">
            <i class="fas fa-bell"></i>
        </button>
        <div class="h-10 w-px bg-slate-200 mx-2 hidden md:block"></div>
        <div class="flex items-center space-x-3 bg-white p-1.5 pr-4 rounded-xl border border-slate-200 shadow-sm">
            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs capitalize">
                {{ substr(Auth::guard('admin')->user()->username ?? 'A', 0, 1) }}
            </div>
            <span class="text-sm font-semibold text-slate-700">{{ Auth::guard('admin')->user()->username ?? 'Admin' }}</span>
        </div>
    </div>
</header>


<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <!-- Total Students -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                <i class="fas fa-users text-xl"></i>
            </div>
            <span class="text-xs font-bold text-green-500 bg-green-50 px-2 py-1 rounded-lg">Real-time</span>
        </div>
        <h3 class="text-slate-500 text-sm font-medium">Total Students</h3>
        <p class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($totalStudents) }}</p>
    </div>

    <!-- Active Communities -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition-all duration-300">
                <i class="fab fa-whatsapp text-xl"></i>
            </div>
            <span class="text-xs font-bold text-green-500 bg-green-50 px-2 py-1 rounded-lg">Active</span>
        </div>
        <h3 class="text-slate-500 text-sm font-medium">Verified Groups</h3>
        <p class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($totalGroups) }}</p>
    </div>

    <!-- Explore Stays -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-all duration-300">
                <i class="fas fa-home text-xl"></i>
            </div>
            <span class="text-xs font-bold text-purple-500 bg-purple-50 px-2 py-1 rounded-lg">Live</span>
        </div>
        <h3 class="text-slate-500 text-sm font-medium">Stays Active</h3>
        <p class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($totalStays) }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Recent Activity -->
    <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center">
            <h2 class="font-bold text-slate-800 text-lg">System Audit Log</h2>
            <p class="text-slate-400 text-xs">Latest updates from the platform</p>
        </div>
        <div class="p-6">
            <div class="space-y-6">
                @forelse($activities as $activity)
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-xl {{ $activity['type'] == 'student' ? 'bg-blue-50 text-blue-600' : ($activity['type'] == 'group' ? 'bg-green-50 text-green-600' : 'bg-purple-50 text-purple-600') }} flex items-center justify-center font-bold text-xs uppercase">
                            <i class="fas {{ $activity['type'] == 'student' ? 'fa-user' : ($activity['type'] == 'group' ? 'fab fa-whatsapp' : 'fa-home') }}"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $activity['user'] }}</p>
                            <p class="text-xs text-slate-500">{{ $activity['action'] }}</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-md">{{ $activity['time']->diffForHumans() }}</span>
                </div>
                @empty
                <div class="text-center py-10">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <i class="fas fa-clipboard-list text-2xl"></i>
                    </div>
                    <p class="text-slate-500 text-sm italic">No recent system activity found.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <h2 class="font-bold text-slate-800 text-lg mb-6">Quick Actions</h2>
        <div class="grid grid-cols-1 gap-4">
            <a href="{{ route('admin.communities.index') }}" class="flex items-center space-x-4 p-4 rounded-2xl bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition-all group w-full">
                <div class="w-10 h-10 bg-white/50 rounded-xl flex items-center justify-center group-hover:bg-white/20">
                    <i class="fas fa-plus"></i>
                </div>
                <span class="font-bold">Add New Community</span>
            </a>
            <a href="{{ route('admin.users') }}" class="flex items-center space-x-4 p-4 rounded-2xl bg-slate-50 text-slate-700 hover:bg-slate-800 hover:text-white transition-all group w-full">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center group-hover:bg-white/20">
                    <i class="fas fa-user-plus"></i>
                </div>
                <span class="font-bold">Register Student</span>
            </a>
            <a href="{{ route('admin.content') }}" class="flex items-center space-x-4 p-4 rounded-2xl bg-slate-50 text-slate-700 hover:bg-slate-800 hover:text-white transition-all group w-full">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center group-hover:bg-white/20">
                    <i class="fas fa-house-user"></i>
                </div>
                <span class="font-bold">Manage Stays</span>
            </a>
        </div>

        <div class="mt-8 bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-6 text-white overflow-hidden relative">
            <div class="relative z-10">
                <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold mb-2">Notice</p>
                <h3 class="font-bold mb-2">Summer 2026 Batch</h3>
                <p class="text-xs text-slate-400 leading-relaxed">Update the onboarding flow for upcoming SIT batch onboarding scheduled for May.</p>
            </div>
            <i class="fas fa-graduation-cap absolute -bottom-4 -right-4 text-white/5 text-8xl transform -rotate-12"></i>
        </div>
    </div>
</div>
@endsection
