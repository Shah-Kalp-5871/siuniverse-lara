<nav class="fixed w-full bg-white shadow-sm z-50 top-0">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-gradient-to-r from-primary to-secondary rounded-lg flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-white text-sm"></i>
                </div>
                <span class="text-xl font-bold text-gray-800">SIU UNIVERSE</span>
                <span class="text-xs bg-accent text-white px-2 py-1 rounded-full">Est. 2026</span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary transition-colors {{ request()->routeIs('home') ? 'text-primary font-semibold' : 'font-medium' }}">
                    Home
                </a>
                <a href="{{ route('discover') }}" class="text-gray-600 hover:text-primary transition-colors {{ request()->routeIs('discover') ? 'text-primary font-semibold' : 'font-medium' }}">
                    Discover
                </a>
                <a href="{{ route('explore-stays') }}" class="text-gray-600 hover:text-primary transition-colors {{ request()->routeIs('explore-stays') ? 'text-primary font-semibold' : 'font-medium' }}">
                    Explore Stays
                </a>
                <a href="{{ route('communities') }}" class="text-gray-600 hover:text-primary transition-colors {{ request()->routeIs('communities') ? 'text-primary font-semibold' : 'font-medium' }}">
                    Professional
                </a>
                
                <!-- Login Button / Profile Icon -->
                @auth
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('profile') }}" class="text-gray-600 hover:text-primary transition-colors flex items-center">
                            <i class="fas fa-user-circle text-2xl"></i>
                        </a>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-secondary transition-colors font-medium">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Account Link (Bottom) -->
<div class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 z-50 px-6 py-3 flex justify-between items-center shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
    <a href="{{ route('home') }}" class="flex flex-col items-center space-y-1 {{ request()->routeIs('home') ? 'text-primary' : 'text-gray-400 hover:text-gray-600' }}">
        <i class="fas fa-home text-xl"></i>
        <span class="text-xs font-medium">Home</span>
    </a>
    <a href="{{ route('discover') }}" class="flex flex-col items-center space-y-1 {{ request()->routeIs('discover') ? 'text-primary' : 'text-gray-400 hover:text-gray-600' }}">
        <i class="fas fa-search text-xl"></i>
        <span class="text-xs font-medium">Discover</span>
    </a>
    <a href="{{ route('explore-stays') }}" class="flex flex-col items-center space-y-1 {{ request()->routeIs('explore-stays') ? 'text-primary' : 'text-gray-400 hover:text-gray-600' }}">
        <i class="fas fa-house-user text-xl"></i>
        <span class="text-xs font-medium">Explore Stays</span>
    </a>
    <a href="{{ route('communities') }}" class="flex flex-col items-center space-y-1 {{ request()->routeIs('communities') ? 'text-primary' : 'text-gray-400 hover:text-gray-600' }}">
        <i class="fas fa-briefcase text-xl"></i>
        <span class="text-xs font-medium">Professional</span>
    </a>
    
    @auth
        <a href="{{ route('profile') }}" class="flex flex-col items-center space-y-1 {{ request()->routeIs('profile') ? 'text-primary' : 'text-gray-400' }}">
            <i class="fas fa-user-circle text-xl"></i>
            <span class="text-xs font-medium">Profile</span>
        </a>
    @else
        <a href="{{ route('login') }}" class="flex flex-col items-center space-y-1 text-gray-400">
            <i class="fas fa-user-circle text-xl"></i>
            <span class="text-xs font-medium">Login</span>
        </a>
    @endauth
</div>
