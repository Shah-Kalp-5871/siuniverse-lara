@extends('layouts.app')

@section('title', 'SIU UNIVERSE - Student Community Platform')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-primary/10 via-white to-accent/10">
    <div class="container mx-auto px-4 pt-20 pb-10">
        <div class="grid md:grid-cols-2 gap-10 items-center ">
             <div data-aos="fade-right"> 
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                    Welcome to 
                    <span class="text-primary">SIU UNIVERSE</span>
                </h1>
                <p class="text-gray-600 text-lg mb-8">
                    <span id="typed-text" class="text-secondary font-semibold"></span>
                </p>
                <div class="bg-yellow-50 border-l-4 border-accent p-4 mb-8">
                    <p class="text-gray-800 font-bold mb-2">Core Philosophy:</p>
                    <p class="text-gray-700">"Empowering SIU students to organize, collaborate, and grow together. A focused space for a purposeful student life."</p>
                </div> 
             </div> 
        </div>
    </div>
</section>

@php
    $p = session('onboarding_data');
    $acc = $p['accommodation'] ?? '';
    $campus = $p['campus'] ?? '';
    $gym = $p['gym'] ?? '';
    $is_intl = $p['international_student'] ?? false;
@endphp

<!-- Communities Section -->
<section class="pt-10 pb-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Your Communities</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Based on your profile, here are the groups you belong to.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- 1. International Students Community -->
            @if ($is_intl)
            <div class="h-full bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition-all flex flex-col">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-globe-americas text-xl"></i>
                    </div>
                    <span class="text-xs font-bold text-purple-600 bg-purple-50 px-2 py-1 rounded">CAMPUS-WIDE</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">International Students Comm.</h3>
                <p class="text-gray-500 text-sm mb-4">Support and communication for all international students on campus.</p>
                
                <ul class="space-y-4 mb-6 text-gray-700 text-sm">
                    <li class="flex items-center"><i class="fas fa-passport text-purple-500 mr-2"></i>Visa & documentation guidance</li>
                    <li class="flex items-center"><i class="fas fa-plane-arrival text-purple-500 mr-2"></i>Airport pickup & arrival help</li>
                    <li class="flex items-center"><i class="fas fa-hands-helping text-purple-500 mr-2"></i>Cultural support & local guidance</li>
                    <li class="flex items-center"><i class="fas fa-university text-purple-500 mr-2"></i>Opening a bank account</li>
                </ul>

                <div class="mt-auto">
                    <button class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl font-bold transition-all shadow-md hover:shadow-lg">
                        <i class="fab fa-whatsapp mr-2"></i> Join Group
                    </button>
                </div>
            </div>
            @endif

            <!-- 2a. Flat/PG Community -->
            @if ($acc === 'PG / Flat')
                <div class="h-full bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-all flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-home text-xl"></i>
                        </div>
                        <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded">ACCOMMODATION</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Flat/PG Community</h3>
                    <p class="text-gray-500 text-sm mb-4">Campus-wide group for students living in PGs and flats.</p>
                    
                    <ul class="space-y-4 mb-6 text-gray-700 text-sm">
                        <li class="flex items-center"><i class="fas fa-door-open text-green-500 mr-2"></i>Room availability updates</li>
                        <li class="flex items-center"><i class="fas fa-file-invoice-dollar text-green-500 mr-2"></i>Rent & utility discussions</li>
                        <li class="flex items-center"><i class="fas fa-user-tie text-green-500 mr-2"></i>Owner/broker contact</li>
                    </ul>

                    <div class="mt-auto">
                        <button class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl font-bold transition-all shadow-md hover:shadow-lg">
                            <i class="fab fa-whatsapp mr-2"></i> Join Group
                        </button>
                    </div>
                </div>
            @endif

            <!-- 2b. Day Scholar Community -->
            @if ($acc === 'Day Scholar')
                <div class="h-full bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-400 hover:shadow-xl transition-all flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-bus text-xl"></i>
                        </div>
                        <span class="text-xs font-bold text-blue-500 bg-blue-50 px-2 py-1 rounded">ACCOMMODATION</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Day Scholar Community</h3>
                    <p class="text-gray-500 text-sm mb-4">Connect with fellow students who commute from home.</p>
                    
                    <ul class="space-y-4 mb-6 text-gray-700 text-sm">
                        <li class="flex items-center"><i class="fas fa-route text-blue-400 mr-2"></i>Smart commute coordination</li>
                        <li class="flex items-center"><i class="fas fa-clock text-blue-400 mr-2"></i>Real-time transport updates</li>
                        <li class="flex items-center"><i class="fas fa-city text-blue-400 mr-2"></i>Connect with Pune day scholars</li>
                        <li class="flex items-center"><i class="fas fa-users text-blue-400 mr-2"></i>Local networking & meetups</li>
                    </ul>

                    <div class="mt-auto">
                        <button class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl font-bold transition-all shadow-md hover:shadow-lg">
                            <i class="fab fa-whatsapp mr-2"></i> Join Group
                        </button>
                    </div>
                </div>
            @endif

            <!-- 3. Mess Communities (Hostel Only) -->
            @if ($acc === 'Hostel')
                <!-- Student Mess Community -->
                <div class="h-full bg-white rounded-2xl shadow-lg p-6 border-l-4 border-orange-500 hover:shadow-xl transition-all flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-utensils text-xl"></i>
                        </div>
                        <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded">{{ strtoupper($campus) }} MESS</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Student Mess Community</h3>
                    <p class="text-gray-500 text-sm mb-4">Report issues, discuss menus, and manage crowd for {{ $p['mess'] ?? 'Mess' }}.</p>
                    
                    <ul class="space-y-4 mb-6 text-gray-700 text-sm">
                        <li class="flex items-center"><i class="fas fa-exclamation-triangle text-orange-500 mr-2"></i>Raise food quality concerns collectively</li>
                        <li class="flex items-center"><i class="fas fa-vote-yea text-orange-500 mr-2"></i>Vote for weekly menu improvements</li>
                        <li class="flex items-center"><i class="fas fa-comment-dots text-orange-500 mr-2"></i>Feedback system for better hygiene & taste</li>
                    </ul>

                    <div class="mt-auto">
                        <button class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl font-bold transition-all shadow-md hover:shadow-lg">
                            <i class="fab fa-whatsapp mr-2"></i> Join Group
                        </button>
                    </div>
                </div>

                <!-- Mess Management (Only for specific location structure) -->
                @if ($campus === 'Hill Base' && ($p['mess'] ?? '') === 'Viola Mess')
                <div class="h-full bg-white rounded-2xl shadow-lg p-6 border-l-4 border-red-500 hover:shadow-xl transition-all flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-shield text-xl"></i>
                        </div>
                        <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded">MANAGEMENT</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Mess Management</h3>
                    <p class="text-gray-500 text-sm mb-6">Heads, Owners, and Admin for Viola Mess management.</p>
                    <div class="mt-auto">
                        <button class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl font-bold transition-all shadow-md hover:shadow-lg">
                            <i class="fab fa-whatsapp mr-2"></i> Join Admin Group
                        </button>
                    </div>
                </div>
                @endif

                <!-- 4. Gym Community (Hostel Only) -->
                @if ($gym !== 'no gym')
                <div class="h-full bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-dumbbell text-xl"></i>
                        </div>
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded">FITNESS</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $gym }} Community</h3>
                    <p class="text-gray-500 text-sm mb-4">Connect with fellow student athletes at the {{ $gym }}.</p>
                    
                    <ul class="space-y-4 mb-6 text-gray-700 text-sm">
                        <li class="flex items-center"><i class="fas fa-dumbbell text-blue-500 mr-2"></i>Share daily workout routines</li>
                        <li class="flex items-center"><i class="fas fa-bullseye text-blue-500 mr-2"></i>Mention target muscle group</li>
                        <li class="flex items-center"><i class="fas fa-chart-line text-blue-500 mr-2"></i>Track progress & transformations</li>
                        <li class="flex items-center"><i class="fas fa-apple-alt text-blue-500 mr-2"></i>Diet & supplement discussions</li>
                    </ul>

                    <div class="mt-auto">
                        <button class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl font-bold transition-all shadow-md hover:shadow-lg">
                            <i class="fab fa-whatsapp mr-2"></i> Join Gym Group
                        </button>
                    </div>
                </div>
                @endif
            @endif

        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">How SIU UNIVERSE Works</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Simple, focused, and effective community platform</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center" data-aos="fade-up" data-aos-delay="0">
                <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-user-check text-primary text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">1. Verified Onboarding</h3>
                <p class="text-gray-600">Select your accommodation type and institute. Strict separation enforced.</p>
            </div>
            
            <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="w-20 h-20 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-users text-secondary text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">2. Join Communities</h3>
                <p class="text-gray-600">Access predefined communities based on your profile. No random creation.</p>
            </div>
            
            <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="w-20 h-20 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fab fa-whatsapp text-accent text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">3. Plan & Meet Offline</h3>
                <p class="text-gray-600">Use WhatsApp groups only for planning. Meet in person for real interactions.</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Initialize Typed.js
    document.addEventListener('DOMContentLoaded', function() {
        // Typed text animation
        new Typed('#typed-text', {
            strings: [
                'Decide online. Meet offline.',
                'Verified student communities.',
                'No random chatting.',
                'WhatsApp groups for planning only.'
            ],
            typeSpeed: 50,
            backSpeed: 30,
            loop: true
        });

        // Initialize counters (if any count-up class exists in html)
        const counters = document.querySelectorAll('.count-up');
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-count'));
            const countUp = new CountUp(counter, target, {
                duration: 2,
                separator: ','
            });
            countUp.start();
        });

        // Animate cards on hover with anime.js
        const cards = document.querySelectorAll('.bg-white.rounded-2xl');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                anime({
                    targets: card,
                    scale: 1.02,
                    duration: 300,
                    easing: 'easeOutCubic'
                });
            });
            card.addEventListener('mouseleave', () => {
                anime({
                    targets: card,
                    scale: 1,
                    duration: 300,
                    easing: 'easeOutCubic'
                });
            });
        });
    });
</script>
@endpush
