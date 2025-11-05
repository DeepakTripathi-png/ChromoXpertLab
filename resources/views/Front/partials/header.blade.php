<header class="bg-white shadow fixed w-full top-0 z-50 h-16 md:h-20">
    <div class="max-w-[1600px] mx-auto flex items-center justify-between px-4 sm:px-6 h-full">

        <!-- Logo -->
        <img src="{{ url('front/images/logo/logo.jpeg') }}" alt="ChromoXpert Logo"
            class="h-9 sm:h-10 md:h-12 object-contain flex-shrink-0">

        <!-- Desktop Menu -->
        <nav class="hidden lg:flex items-center space-x-5 xl:space-x-6 text-sm lg:text-base xl:text-lg tracking-wide">
            <a href="{{ url('/') }}#home" class="nav-link font-semibold hover:text-blue-600">Home</a>
            <a href="{{ url('/') }}#about" class="nav-link font-semibold hover:text-blue-600">About</a>
            <a href="{{ url('/') }}#packages" class="nav-link font-semibold hover:text-blue-600">Tests</a>
            <a href="{{ url('/') }}#services" class="nav-link font-semibold hover:text-blue-600">Services</a>
            <a href="{{ url('/') }}#booking" class="nav-link font-semibold hover:text-blue-600 whitespace-nowrap">How To Book</a>
            <a href="{{ url('/') }}#reviews" class="nav-link font-semibold hover:text-blue-600">Reviews</a>
            <a href="{{ url('/') }}#contact" class="nav-link font-semibold hover:text-blue-600">Contact</a>
        </nav>

        <!-- Right Side (Desktop Only) -->
        <div class="hidden lg:flex items-center space-x-4">
            @if(Auth::check())
                <!-- ✅ Show only when logged in -->
                <a href="{{ url('profile') }}"  class="flex items-center bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-full transition focus:outline-none">
                    <i class="fa-solid fa-user text-lg mr-2"></i>
                    <span class="font-medium text-sm">{{ Auth::user()->name ?? 'User' }}</span>
                </a>

                <!-- Cart Icon -->
                <a href="{{ url('cart') }}" class="relative inline-flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor"
                        class="w-8 h-8 text-gray-800 hover:text-blue-600 transition">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 2.25h1.386c.51 0 .954.34 1.09.832L5.94 7.5h12.12a.75.75 0 0 1 .73.948l-1.8 6a.75.75 0 0 1-.73.552H8.1m0 0L6.48 4.5m1.62 10.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Zm8.25 2.25a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0Z" />
                    </svg>
                    <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[11px] rounded-full px-[5px] py-[1px] shadow-sm">2</span>
                </a>
            @else
                <!-- 🚪 Show only when not logged in -->
                <button class="open-login-btn bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-blue-700 transition">
                    Login
                </button>
            @endif
        </div>

        <!-- Mobile Menu Toggle -->
        <button id="menu-toggle" class="lg:hidden text-gray-800 text-2xl sm:text-3xl leading-none">
        ☰
        </button>
    </div>

    <!-- Mobile Dropdown -->
    <div id="mobile-menu"
        class="hidden lg:hidden absolute left-0 w-full bg-white border-t border-gray-200 z-40 shadow-md"
        style="top:100%;">
        <a href="{{ url('/') }}" class="block py-3 px-6 nav-link">Home</a>
        <a href="{{ url('/') }}#about" class="block py-3 px-6 nav-link">About</a>
        <a href="{{ url('/') }}#packages" class="block py-3 px-6 nav-link">Tests</a>
        <a href="{{ url('/') }}#services" class="block py-3 px-6 nav-link">Services</a>
        <a href="{{ url('/') }}#booking" class="block py-3 px-6 nav-link">How To Book</a>
        <a href="{{ url('/') }}#reviews" class="block py-3 px-6 nav-link">Reviews</a>
        <a href="{{ url('/') }}#contact" class="block py-3 px-6 nav-link">Contact</a>

        <!-- Mobile Profile + Cart -->
        <div class="flex items-center justify-between px-6 py-3 border-t border-gray-200">
            @if(Auth::check())
                <!-- ✅ Profile Link -->
                <a href="{{ url('profile') }}"
                    class="flex items-center bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-full transition focus:outline-none">
                    <i class="fa-solid fa-user text-lg mr-2"></i>
                    <span class="font-medium text-sm">{{ Auth::user()->name ?? 'User' }}</span>
                </a>

                <!-- ✅ Cart Icon -->
                <a href="{{ url('cart') }}" class="relative flex items-center justify-center p-2 hover:bg-gray-100 rounded-full transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor"
                        class="w-7 h-7 text-gray-800 hover:text-blue-600 transition">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 2.25h1.386c.51 0 .954.34 1.09.832L5.94 7.5h12.12a.75.75 0 0 1 .73.948l-1.8 6a.75.75 0 0 1-.73.552H8.1m0 0L6.48 4.5m1.62 10.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Zm8.25 2.25a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0Z" />
                    </svg>
                    <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[11px] rounded-full px-[5px] py-[1px] shadow-sm">2</span>
                </a>
            @else
                <button class="open-login-btn bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-blue-700 transition">
                    Login
                </button>
            @endif
        </div>
    </div>
</header>