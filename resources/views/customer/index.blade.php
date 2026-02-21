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
    $student_acc = $student->accommodation ?? '';
    $student_campus = $student->campus_location ?? 'Campus';
    $student_mess = $student->mess ?? '';
@endphp

<!-- Communities Section -->
<section class="pt-10 pb-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Your Communities</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Based on your profile, here are the groups you belong to.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($communities as $community)
                @php
                    // Determine icons and colors based on category/origin
                    $icon = 'fas fa-users';
                    $colorClass = 'border-slate-400';
                    $bgColor = 'bg-slate-100';
                    $textColor = 'text-slate-600';
                    $tag = strtoupper($community->category);

                    if ($community->origin === 'International') {
                        $icon = 'fas fa-globe-americas';
                        $colorClass = 'border-purple-500';
                        $bgColor = 'bg-purple-100';
                        $textColor = 'text-purple-600';
                        $tag = 'CAMPUS-WIDE';
                    } elseif ($community->category === 'PG/Flats') {
                        $icon = 'fas fa-home';
                        $colorClass = 'border-green-500';
                        $bgColor = 'bg-green-100';
                        $textColor = 'text-green-600';
                        $tag = 'ACCOMMODATION';
                    } elseif ($community->category === 'Day Scholars') {
                        $icon = 'fas fa-bus';
                        $colorClass = 'border-blue-400';
                        $bgColor = 'bg-blue-50';
                        $textColor = 'text-blue-500';
                        $tag = 'ACCOMMODATION';
                    } elseif ($community->category === 'Hostel') {
                        if ($community->mess) {
                            $icon = 'fas fa-utensils';
                            $colorClass = 'border-orange-500';
                            $bgColor = 'bg-orange-100';
                            $textColor = 'text-orange-600';
                            $tag = strtoupper($student_campus) . ' MESS';
                        } elseif ($community->gym) {
                            $icon = 'fas fa-dumbbell';
                            $colorClass = 'border-blue-500';
                            $bgColor = 'bg-blue-100';
                            $textColor = 'text-blue-600';
                            $tag = 'FITNESS';
                        } else {
                            $icon = 'fas fa-hotel';
                            $colorClass = 'border-red-500';
                            $bgColor = 'bg-red-100';
                            $textColor = 'text-red-600';
                            $tag = 'HOSTEL';
                        }
                    }
                @endphp

                <div class="h-full bg-white rounded-2xl shadow-lg p-6 border-l-4 {{ $colorClass }} hover:shadow-xl transition-all flex flex-col" data-aos="fade-up">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 {{ $bgColor }} {{ $textColor }} rounded-xl flex items-center justify-center">
                            <i class="{{ $icon }} text-xl"></i>
                        </div>
                        <span class="text-xs font-bold {{ $textColor }} {{ $bgColor }} px-2 py-1 rounded">{{ $tag }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $community->name }}</h3>
                    <p class="text-gray-500 text-sm mb-4">
                        @if($community->origin === 'International')
                            Support and communication for all international students on campus.
                        @elseif($community->category === 'PG/Flats')
                            Campus-wide group for students living in PGs and flats.
                        @elseif($community->category === 'Day Scholars')
                            Connect with fellow students who commute from home.
                        @elseif($community->mess)
                            Report issues, discuss menus, and manage crowd for {{ $community->mess }}.
                        @elseif($community->gym)
                            Connect with fellow student athletes at the {{ $community->gym }}.
                        @else
                            Official community for {{ $community->category }} students.
                        @endif
                    </p>
                    
                    <ul class="space-y-4 mb-6 text-gray-700 text-sm">
                        @if($community->origin === 'International')
                            <li class="flex items-center"><i class="fas fa-passport {{ $textColor }} mr-2"></i>Visa & documentation guidance</li>
                            <li class="flex items-center"><i class="fas fa-hands-helping {{ $textColor }} mr-2"></i>Cultural support & local guidance</li>
                        @elseif($community->category === 'PG/Flats')
                            <li class="flex items-center"><i class="fas fa-door-open {{ $textColor }} mr-2"></i>Room availability updates</li>
                            <li class="flex items-center"><i class="fas fa-user-tie {{ $textColor }} mr-2"></i>Owner/broker contact</li>
                        @elseif($community->category === 'Day Scholars')
                            <li class="flex items-center"><i class="fas fa-route {{ $textColor }} mr-2"></i>Smart commute coordination</li>
                            <li class="flex items-center"><i class="fas fa-users {{ $textColor }} mr-2"></i>Local networking & meetups</li>
                        @elseif($community->mess)
                            <li class="flex items-center"><i class="fas fa-exclamation-triangle {{ $textColor }} mr-2"></i>Raise food quality concerns</li>
                            <li class="flex items-center"><i class="fas fa-vote-yea {{ $textColor }} mr-2"></i>Vote for menu improvements</li>
                        @elseif($community->gym)
                            <li class="flex items-center"><i class="fas fa-dumbbell {{ $textColor }} mr-2"></i>Share daily workout routines</li>
                            <li class="flex items-center"><i class="fas fa-chart-line {{ $textColor }} mr-2"></i>Track progress & transformations</li>
                        @else
                            <li class="flex items-center"><i class="fas fa-bullhorn {{ $textColor }} mr-2"></i>Important announcements</li>
                            <li class="flex items-center"><i class="fas fa-comments {{ $textColor }} mr-2"></i>Peer-to-peer discussions</li>
                        @endif
                    </ul>

                    <div class="mt-auto">
                        <a href="{{ $community->invite_link }}" target="_blank" class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl font-bold transition-all shadow-md hover:shadow-lg flex items-center justify-center">
                            <i class="fab fa-whatsapp mr-2"></i> Join Group
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12" data-aos="fade-up">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Groups are not found</h3>
                    <p class="text-gray-500 mt-2">No active communities match your profile at the moment.</p>
                </div>
            @endforelse
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
