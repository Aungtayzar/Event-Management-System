<nav class="bg-white shadow-md">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo/Brand -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-700">Event Platform</a>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center -mr-2 sm:hidden">
                <button type="button" id="mobile-menu-button"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <svg id="menu-closed-icon" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Icon when menu is open -->
                    <svg id="menu-open-icon" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Desktop menu -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                <!-- Always visible -->
                <a href="{{ route('home') }}"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition duration-150">
                    Home
                </a>

                @auth
                <span class="text-sm font-medium text-gray-700">Welcome, {{ Auth::user()->name }}</span>

                <a href="{{ route('events.index') }}"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition duration-150">
                    <i class="fas fa-tachometer-alt mr-1"></i>Find Event
                </a>

                @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition duration-150">
                    <i class="fas fa-tachometer-alt mr-1"></i>Admin Dashboard
                </a>
                <a href="{{ route('admin.bookings.index') }}"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition duration-150">
                    <i class="fas fa-cog mr-1"></i>Manage Bookings
                </a>
                @endif

                @if(Auth::user()->isOrganizer())
                <a href="{{ route('organizer.dashboard') }}"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition duration-150">
                    <i class="fas fa-tachometer-alt mr-1"></i>Organizer Dashboard
                </a>
                @endif

                <a href="{{ route('bookings.index') }}"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition duration-150">
                    <i class="fas fa-ticket-alt mr-1"></i>My Bookings
                </a>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="text-sm font-medium text-red-600 hover:text-red-800 transition duration-150">
                        <i class="fas fa-sign-out-alt mr-1"></i>Logout
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition duration-150">
                    <i class="fas fa-sign-in-alt mr-1"></i>Login
                </a>
                <a href="{{ route('register') }}"
                    class="text-sm font-medium bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md transition duration-150">
                    <i class="fas fa-user-plus mr-1"></i>Register
                </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state -->
    <div id="mobile-menu" class="sm:hidden hidden">
        <div class="pt-2 pb-3 space-y-1 border-t border-gray-200">
            @auth
            <div class="px-4 py-2 text-base font-medium text-gray-700">Welcome, {{ Auth::user()->name }}</div>

            @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}"
                class="block px-4 py-2 text-base font-medium text-indigo-700 hover:bg-gray-50">
                <i class="fas fa-tachometer-alt mr-2"></i>Admin Dashboard
            </a>
            <a href="{{ route('admin.bookings.index') }}"
                class="block px-4 py-2 text-base font-medium text-indigo-700 hover:bg-gray-50">
                <i class="fas fa-cog mr-2"></i>Manage Bookings
            </a>
            @endif

            @if(Auth::user()->isOrganizer())
            <a href="{{ route('organizer.dashboard') }}"
                class="block px-4 py-2 text-base font-medium text-indigo-700 hover:bg-gray-50">
                <i class="fas fa-tachometer-alt mr-2"></i>Organizer Dashboard
            </a>
            @endif

            <a href="{{ route('bookings.index') }}"
                class="block px-4 py-2 text-base font-medium text-indigo-700 hover:bg-gray-50">
                <i class="fas fa-ticket-alt mr-2"></i>My Bookings
            </a>

            <form action="{{ route('logout') }}" method="POST" class="block">
                @csrf
                <button type="submit"
                    class="w-full text-left px-4 py-2 text-base font-medium text-red-600 hover:bg-gray-50">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </button>
            </form>
            @else
            <a href="{{ route('login') }}"
                class="block px-4 py-2 text-base font-medium text-indigo-700 hover:bg-gray-50">
                <i class="fas fa-sign-in-alt mr-2"></i>Login
            </a>
            <a href="{{ route('register') }}"
                class="block px-4 py-2 text-base font-medium text-indigo-700 hover:bg-gray-50">
                <i class="fas fa-user-plus mr-2"></i>Register
            </a>
            @endauth
        </div>
    </div>
</nav>

<script>
    // Toggle mobile menu
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        const menuClosedIcon = document.getElementById('menu-closed-icon');
        const menuOpenIcon = document.getElementById('menu-open-icon');
        
        mobileMenu.classList.toggle('hidden');
        menuClosedIcon.classList.toggle('hidden');
        menuOpenIcon.classList.toggle('hidden');
    });
</script>