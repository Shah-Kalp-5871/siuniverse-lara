@extends('layouts.app')

@section('title', 'Login - SIU UNIVERSE')

@section('content')
<div class="flex items-center justify-center min-h-[80vh] bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden relative">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary to-secondary p-8 text-center text-white">
            <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                <i class="fas fa-graduation-cap text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold">Welcome Back</h1>
            <p class="text-blue-100 mt-2">Sign in with your SI University email</p>
            <p class="text-blue-200 text-sm mt-1">(@siu.edu.in domain only)</p>
        </div>

        <!-- Form -->
        <div class="p-8">
            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-6 text-sm flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-6 text-sm flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" onsubmit="return validateForm()">
                @csrf
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">
                        SI University Email Address <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" 
                               id="email" type="email" name="email" 
                               placeholder="username@sitpune.edu.in" 
                               required 
                               oninput="validateEmail()"
                               value="{{ old('email') }}">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Institutional email address only</p>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="password">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" 
                               id="password" type="password" name="password" 
                               placeholder="••••••••" 
                               required>
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none" onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" class="form-checkbox text-primary rounded border-gray-300 focus:ring-primary" name="remember">
                        <span class="ml-2">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-primary hover:text-secondary font-medium">Forgot Password?</a>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-bold py-3 px-4 rounded-lg transition-all transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </button>
                
                <div class="mt-6 text-center">
                    <p class="text-gray-600 text-sm">Don't have an account? <a href="{{ route('signup') }}" class="text-primary font-bold hover:text-secondary">Sign Up</a></p>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 text-center">
            <p class="text-gray-600 text-sm">
                <i class="fas fa-info-circle mr-1"></i>
                SIU, SIT, or SIBM email addresses only
            </p>
            <p class="text-gray-600 text-sm mt-1">
                Need help? <a href="#" class="text-primary font-semibold hover:text-secondary">Contact Support</a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword(id) {
        const field = document.getElementById(id);
        const icon = document.getElementById(id + '-icon');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    function validateEmail() {
        const emailInput = document.getElementById('email');
        const email = emailInput.value.toLowerCase();

        const allowedDomains = @json($allowedDomains);

        if (!email) {
            emailInput.setCustomValidity('');
            return true;
        }

        const parts = email.split('@');
        if (parts.length !== 2) {
            emailInput.setCustomValidity('Invalid email format.');
            emailInput.reportValidity();
            return false;
        }

        const localPart = parts[0];
        const domain = parts[1];

        // Format: name.surname.course-year
        // const formatRegex = /^[a-zA-Z]+\.[a-zA-Z]+\.[a-zA-Z0-9]+-[0-9]+$/;

        // if (!formatRegex.test(localPart) || !allowedDomains.includes(domain)) {
        if (!allowedDomains.includes(domain)) {
            emailInput.setCustomValidity(
                'Please use an authorized institutional email address.'
            );
            emailInput.reportValidity();
            return false;
        }

        emailInput.setCustomValidity('');
        return true;
    }

    function validateForm() {
        return validateEmail();
    }
</script>
@endpush
