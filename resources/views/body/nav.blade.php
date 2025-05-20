<nav class="fixed top-0 w-full gradient-bg text-white shadow-xl z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <i class="fas fa-user-tie text-2xl mr-2"></i>
                <span class="text-xl font-bold">HR System</span>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('dashboard') }}" class="hover:text-red-300 transition-colors flex items-center">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <a href="#" class="hover:text-red-300 transition-colors flex items-center">
                    <i class="fas fa-users mr-2"></i>Employees
                </a>
                <a href="#" class="hover:text-red-300 transition-colors flex items-center">
                    <i class="fas fa-calendar-check mr-2"></i>Attendance
                </a>
                <a href="{{ route('vacation-request') }}" class="hover:text-red-300 transition-colors flex items-center">
                    <i class="fas fa-umbrella-beach mr-2"></i>Vacation Request
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hover:text-red-300 transition-colors flex items-center">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button onclick="toggleMobileMenu()" class="text-white focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu absolute left-0 right-0 gradient-bg md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-700 transition-colors duration-300 flex items-center">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-700 transition-colors duration-300 flex items-center">
                    <i class="fas fa-users mr-2"></i>Employees
                </a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-700 transition-colors duration-300 flex items-center">
                    <i class="fas fa-calendar-check mr-2"></i>Attendance
                </a>
                <a href="{{ route('vacation-request') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-700 transition-colors duration-300 flex items-center">
                    <i class="fas fa-umbrella-beach mr-2"></i>Vacation Request
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium hover:bg-blue-700 transition-colors duration-300 flex items-center">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>