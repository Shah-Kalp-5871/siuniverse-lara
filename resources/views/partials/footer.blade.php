<footer class="bg-gray-900 text-white mt-20">
    <div class="container mx-auto px-4 py-12">
        <div class="grid md:grid-cols-4 gap-8">
            <!-- Logo and Description -->
            <div class="md:col-span-2">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-r from-primary to-accent rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <span class="text-2xl font-bold">SIU UNIVERSE</span>
                </div>
                <p class="text-gray-400 mb-4">
                    Established in 2026. A verified student community platform for SI University students.
                </p>
                <div class="bg-gray-800 rounded-lg p-4 mb-4">
                    <p class="text-accent font-semibold mb-2">Core Philosophy:</p>
                    <p class="text-gray-300">"Empowering SIU students to organize, collaborate, and grow together. A focused space for a purposeful student life."</p>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                    <li><a href="{{ route('discover') }}" class="text-gray-400 hover:text-white transition-colors">Discover</a></li>

                    <li><a href="{{ route('communities') }}" class="text-gray-400 hover:text-white transition-colors">Professional Communities</a></li>
                </ul>
            </div>

            <!-- Rules -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Important Rules</h3>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-accent mt-1 mr-2"></i>
                        <span>Predefined communities only</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-accent mt-1 mr-2"></i>
                        <span>No auto-creation of communities</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-accent mt-1 mr-2"></i>
                        <span>WhatsApp groups for planning only</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-accent mt-1 mr-2"></i>
                        <span>No in-app chat system</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-800 mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    © 2026 SIU UNIVERSE. All rights reserved.
                </p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-instagram text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-twitter text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-linkedin text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
