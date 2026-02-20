@extends('layouts.app')

@section('title', 'Register - SIU UNIVERSE')

@section('content')
<div class="flex items-center justify-center min-h-[80vh] bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden relative m-4">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary to-secondary p-8 text-center text-white">
            <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                <i class="fas fa-user-plus text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold">Join SIU UNIVERSE</h1>
            <p class="text-blue-100 mt-2">Create your account to connect</p>
        </div>

        <!-- Form Container -->
        <div class="p-8">
            @if (session('error'))
                <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-6 text-sm flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('signup.post') }}" id="signupForm">
                @csrf
                <input type="hidden" name="skip_details" id="skip_details" value="false">
                
                <!-- STEP 1: Email -->
                <div id="step-1">
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">
                            SI Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" 
                                   id="email" type="email" name="email" placeholder="student@siu.edu.in" 
                                   value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <button type="button" onclick="verifyEmailStep()" class="w-full bg-primary hover:bg-secondary text-white font-bold py-3 px-4 rounded-lg transition-all shadow-lg">
                        Continue <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                    <div class="mt-6 text-center">
                        <p class="text-gray-600 text-sm">Already have an account? <a href="{{ route('login') }}" class="text-primary font-bold hover:text-secondary">Login</a></p>
                    </div>
                </div>

                <!-- STEP 2: OTP -->
                <div id="step-2" class="hidden">
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-semibold mb-2" for="otp">
                            Verification Code
                        </label>
                        <p class="text-xs text-gray-500 mb-3">Sent to <span id="display-email" class="font-bold text-gray-700"></span></p>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-400"></i>
                            </div>
                            <input class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors tracking-widest text-lg" 
                                   id="otp" name="otp" type="text" placeholder="Enter 6-digit code" maxlength="6">
                        </div>
                        <p id="otp-error" class="text-red-500 text-xs mt-2 hidden">
                            Invalid OTP. Please check your email.
                        </p>
                    </div>
                    <button type="button" onclick="verifyOtpStep()" class="w-full bg-primary hover:bg-secondary text-white font-bold py-3 px-4 rounded-lg transition-all shadow-lg">
                        Verify Email
                    </button>
                    <div class="mt-4 text-center">
                        <button type="button" onclick="goToStep(1)" class="text-gray-400 text-sm hover:text-gray-600"><i class="fas fa-arrow-left mr-1"></i> Change Email</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function goToStep(step) {
        document.getElementById('step-1').classList.add('hidden');
        document.getElementById('step-2').classList.add('hidden');
        document.getElementById('step-' + step).classList.remove('hidden');
    }

    async function verifyEmailStep() {
        const emailInput = document.getElementById('email');
        const email = emailInput.value;
        const nextBtn = document.querySelector('#step-1 button');
        
        if(email && email.includes('@')) {
            const originalText = nextBtn.innerHTML;
            
            // Domain & Format validation
            const allowedDomains = [
                'saii.siu.edu.in', 'sibmpune.siu.edu.in', 'sscanspune.siu.edu.in', 
                'simcpune.siu.edu.in', 'sidtmpune.siu.edu.in', 'sitpune.siu.edu.in', 
                'ssbfpune.siu.edu.in', 'ssvappune.siu.edu.in', 'sconpune.siu.edu.in', 
                'schspune.siu.edu.in', 'sssspune.siu.edu.in', 'sihspune.siu.edu.in', 
                'smcwpune.siu.edu.in', 'ssodlpune.siu.edu.in', 'stlrcpune.siu.edu.in', 
                'scripune.siu.edu.in'
            ];
            
            const parts = email.split('@');
            if (parts.length !== 2) {
                Swal.fire('Invalid Email', "Please enter a valid email address", 'warning');
                return;
            }

            const localPart = parts[0];
            const domain = parts[1].toLowerCase();
            const formatRegex = /^[a-zA-Z]+\.[a-zA-Z]+\.[a-zA-Z0-9]+-[0-9]+$/;

            if (!formatRegex.test(localPart) || !allowedDomains.includes(domain)) {
                Swal.fire('Restricted Access', "Use format: name.surname.course-year@institute.siu.edu.in", 'warning');
                return;
            }

            nextBtn.disabled = true;
            nextBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';

            try {
                const response = await fetch("{{ route('auth.send-otp') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ email: email })
                });
                
                const data = await response.json();
                
                if(data.success) {
                    document.getElementById('display-email').innerText = email;
                    goToStep(2);
                } else {
                    Swal.fire('Failed', data.message || "Failed to send verification code. Please try again.", 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error', "An error occurred. Please try again.", 'error');
            } finally {
                nextBtn.disabled = false;
                nextBtn.innerHTML = originalText;
            }
        } else {
            Swal.fire('Invalid Email', "Please enter a valid email address", 'warning');
        }
    }

    function verifyOtpStep() {
        const otpInput = document.getElementById('otp');
        const otp = otpInput.value;
        const verifyBtn = document.querySelector('#step-2 button');

        if(otp.length >= 6) {
            verifyBtn.disabled = true;
            verifyBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Verifying...';
            document.getElementById('signupForm').submit();
        } else {
            document.getElementById('otp-error').classList.remove('hidden');
        }
    }

    document.getElementById('otp').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            verifyOtpStep();
        }
    });
</script>
@endpush
