<!-- Login Modal -->
<div id="loginModal" class="fixed inset-0 bg-black/50 z-[60] hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md" onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-primary to-secondary rounded-lg flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Welcome Back</h3>
                            <p class="text-sm text-gray-600">Login to SIU UNIVERSE</p>
                        </div>
                    </div>
                    <button onclick="closeLoginModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-3xl text-gray-600"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Login with Gmail Only</h4>
                    <p class="text-gray-600 text-sm">SI University email required for verification</p>
                </div>
                
                <!-- Login Form (UI Only) -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">University Email</label>
                        <input 
                            type="email" 
                            placeholder="your.id@siuniversity.edu"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                        >
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Password</label>
                        <input 
                            type="password" 
                            placeholder="Enter your password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                        >
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded text-primary focus:ring-primary">
                            <span class="ml-2 text-gray-700 text-sm">Remember me</span>
                        </label>
                        <a href="#" class="text-primary hover:text-secondary text-sm font-medium">Forgot password?</a>
                    </div>
                </div>
                
                <!-- Login Button -->
                <button onclick="handleLogin()" class="w-full bg-gradient-to-r from-primary to-secondary text-white py-4 rounded-xl font-semibold mt-6 hover:shadow-lg transition-all">
                    Login
                </button>
                
                <!-- Divider -->
                <div class="flex items-center my-6">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="mx-4 text-gray-500 text-sm">or continue with</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>
                
                <!-- Demo Login -->
                <div class="text-center">
                    <p class="text-gray-600 text-sm mb-4">For demonstration purposes only:</p>
                    <button onclick="demoLogin()" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-lg font-medium transition-colors">
                        <i class="fas fa-user-graduate mr-2"></i>Demo Login (No Backend)
                    </button>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="p-6 border-t border-gray-200 bg-gray-50 rounded-b-2xl">
                <div class="text-center">
                    <p class="text-gray-600 text-sm">
                        New to SIU UNIVERSE?
                        <button onclick="showOnboardingModal()" class="text-primary hover:text-secondary font-medium ml-1">
                            Start Onboarding
                        </button>
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Conceptual UI only. No real authentication implemented.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function handleLogin() {
        // UI feedback only
        const modal = document.getElementById('loginModal');
        const button = modal.querySelector('button[onclick="handleLogin()"]');
        
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Authenticating...';
        button.disabled = true;
        
        // Simulate API call delay
        setTimeout(() => {
            // Show success message
            button.innerHTML = '<i class="fas fa-check mr-2"></i>Login Successful!';
            button.className = 'w-full bg-green-500 text-white py-4 rounded-xl font-semibold mt-6';
            
            setTimeout(() => {
                closeLoginModal();
                // Show onboarding modal
                showOnboardingModal();
                
                // Reset button
                button.innerHTML = originalText;
                button.className = 'w-full bg-gradient-to-r from-primary to-secondary text-white py-4 rounded-xl font-semibold mt-6 hover:shadow-lg transition-all';
                button.disabled = false;
            }, 1000);
        }, 1500);
    }
    
    function demoLogin() {
        // Simple demo login - just shows onboarding
        closeLoginModal();
        showOnboardingModal();
    }
</script>
