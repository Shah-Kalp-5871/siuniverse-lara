<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SIU UNIVERSE: Decide online. Meet offline. Verified student communities for SI students since 2026.">
    <meta name="keywords" content="student community, SI University, hostel students, day scholars, PG students, academic resources, professional communities">
    <meta name="author" content="SIU UNIVERSE">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'SIU UNIVERSE - Student Community Platform')</title>

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'SIU UNIVERSE - Student Community Platform')">
    <meta property="og:description" content="Decide online. Meet offline. Verified student communities for SI students since 2026.">
    <meta property="og:image" content="{{ asset('assets/images/og-image.jpg') }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large-image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'SIU UNIVERSE - Student Community Platform')">
    <meta property="twitter:description" content="Decide online. Meet offline. Verified student communities for SI students since 2026.">
    <meta property="twitter:image" content="{{ asset('assets/images/og-image.jpg') }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#1E40AF',
                        accent: '#F59E0B',
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')
</head>
<body class="bg-gray-50 font-sans pb-20 md:pb-0">
    
    @include('partials.header')

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    @include('partials.footer')

    @include('partials.login-modal')
    @include('partials.onboarding-modal')

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/countup.js@2.3.2/dist/countUp.umd.js"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Modal Functions
        function showLoginModal() {
            document.getElementById('loginModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function showOnboardingModal() {
            document.getElementById('onboardingModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLoginModal() {
            document.getElementById('loginModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function closeOnboardingModal() {
            document.getElementById('onboardingModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('click', (event) => {
            const loginModal = document.getElementById('loginModal');
            const onboardingModal = document.getElementById('onboardingModal');
            
            if (event.target === loginModal) closeLoginModal();
            if (event.target === onboardingModal) closeOnboardingModal();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeLoginModal();
                closeOnboardingModal();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
