<aside class="w-full lg:w-1/4 mb-6 lg:mb-0">
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
        <!-- Profile Section -->
        <div class="flex items-center gap-4 mb-8">
            <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-2xl shadow-inner">
                N
            </div>
            <div>
                <h2 class="font-semibold text-gray-800 text-lg">Nilesh</h2>
                <p class="text-sm text-gray-500 break-all">nilesh@example.com</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="space-y-2 text-gray-700">
            <!-- My Orders -->
            <a href="{{ url('/profile') }}"
                class="menu-item flex items-center justify-between p-3 rounded-xl transition group">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-bag-shopping text-blue-500 text-lg group-hover:text-blue-600"></i>
                    <span class="font-medium">My Orders</span>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
            </a>

            <!-- Profile Settings with submenu -->
            <div class="bg-gray-50 rounded-xl">
                <button 
                    class="flex items-center justify-between w-full p-3 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition group"
                    onclick="toggleSubmenu('profileSubmenu', this)">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-user-gear text-blue-500 text-lg group-hover:text-blue-600"></i>
                        <span class="font-medium">Profile Settings</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-gray-400 text-xs transition-transform duration-300"
                       id="profileChevron"></i>
                </button>

                <!-- Submenu -->
                <div id="profileSubmenu" class="hidden pl-10 pb-3 space-y-2">
                    <a href="{{ url('edit-profile') }}" class="submenu-item block text-sm text-gray-600 hover:text-blue-600 transition">Edit Profile</a>
                    <a href="{{ url('manage-address') }}" class="submenu-item block text-sm text-gray-600 hover:text-blue-600 transition">Manage Address</a>
                </div>
            </div>

            <!-- Logout -->
            <a href="{{ route('front.userlogout') }}"
                class="menu-item flex items-center justify-between p-3 rounded-xl text-red-500 hover:bg-red-50 hover:text-red-600 transition group">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-right-from-bracket text-lg"></i>
                    <span class="font-medium">Logout</span>
                </div>
            </a>
        </nav>
    </div>
</aside>
