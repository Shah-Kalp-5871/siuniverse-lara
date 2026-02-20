<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Dashboard - SIU UNIVERSE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-text {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-4xl w-full bg-white rounded-3xl shadow-xl overflow-hidden animate-fade-in relative">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500"></div>
        
        <div class="grid md:grid-cols-2">
            <!-- Left Side: Content -->
            <div class="p-8 md:p-12 flex flex-col justify-center">
                <div class="mb-6">
                    <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold uppercase tracking-wider mb-4">
                        <i class="fas fa-check-circle mr-1"></i> Setup Complete
                    </span>
                    <h1 class="text-4xl font-bold text-slate-900 mb-2">Welcome, <br><span class="gradient-text">{{ session('user_name', 'Student') }}!</span></h1>
                    <p class="text-slate-500 text-lg">You're all set to explore SIU UNIVERSE.</p>
                </div>

                <div class="space-y-4 mb-8">
                    <div class="flex items-center space-x-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-bold">Profile Created</p>
                            @php
                                $onboarding = session('onboarding_data', []);
                            @endphp
                            <p class="font-bold text-slate-800">{{ $onboarding['course'] ?? 'Course' }} • {{ $onboarding['institute'] ?? 'Institute' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center text-xl">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-bold">Communities</p>
                            <p class="font-bold text-slate-800">Verified & Ready to Join</p>
                        </div>
                    </div>
                </div>

                <a href="{{ route('home') }}" class="inline-flex items-center justify-center w-full bg-slate-900 text-white py-4 rounded-xl font-bold text-lg hover:bg-slate-800 transition-all transform hover:-translate-y-1 shadow-lg shadow-slate-900/20 group">
                    Go to Home Feed 
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <!-- Right Side: Graphic/Visual -->
            <div class="bg-slate-50 p-12 hidden md:flex flex-col items-center justify-center relative overflow-hidden">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 24px 24px;"></div>
                
                <div class="relative z-10 text-center">
                    <div class="w-24 h-24 bg-white rounded-full shadow-xl flex items-center justify-center mx-auto mb-6 animate-bounce-slow">
                        <i class="fas fa-rocket text-4xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Ready for Lift Off?</h3>
                    <p class="text-slate-500 text-sm max-w-xs mx-auto">Connect with your peers, discover resources, and join the community conversation.</p>
                </div>

                <!-- Decorative Circles -->
                <div class="absolute top-10 right-10 w-32 h-32 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                <div class="absolute bottom-10 left-10 w-32 h-32 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
            </div>
        </div>
    </div>

    <script>
        // Trigger confetti on load
        window.addEventListener('load', () => {
            const count = 200;
            const defaults = {
                origin: { y: 0.7 }
            };

            function fire(particleRatio, opts) {
                confetti(Object.assign({}, defaults, opts, {
                    particleCount: Math.floor(count * particleRatio)
                }));
            }

            fire(0.25, { spread: 26, startVelocity: 55, });
            fire(0.2, { spread: 60, });
            fire(0.35, { spread: 100, decay: 0.91, scalar: 0.8 });
            fire(0.1, { spread: 120, startVelocity: 25, decay: 0.92, scalar: 1.2 });
            fire(0.1, { spread: 120, startVelocity: 45, });
        });

        // Add custom animation classes
        document.head.insertAdjacentHTML('beforeend', `
            <style>
                @keyframes blob {
                    0% { transform: translate(0px, 0px) scale(1); }
                    33% { transform: translate(30px, -50px) scale(1.1); }
                    66% { transform: translate(-20px, 20px) scale(0.9); }
                    100% { transform: translate(0px, 0px) scale(1); }
                }
                .animate-blob { animation: blob 7s infinite; }
                .animation-delay-2000 { animation-delay: 2s; }
                .animate-fade-in { animation: fadeIn 0.8s ease-out; }
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
            </style>
        `);
    </script>
</body>
</html>
