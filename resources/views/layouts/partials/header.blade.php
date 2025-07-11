<header class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 transition-all duration-300">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Logo and Title -->
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <a href="{{ route('home') }}"
                   class="flex items-center space-x-3 rtl:space-x-reverse group transition-transform duration-200 hover:scale-105">
                    <div class="relative">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-xl blur opacity-75 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative bg-gradient-to-r from-emerald-600 to-teal-600 p-2 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-width="2"
                                      d="M7.24 7.194a24.16 24.16 0 0 1 3.72-3.062m0 0c3.443-2.277 6.732-2.969 8.24-1.46 2.054 2.053.03 7.407-4.522 11.959-4.552 4.551-9.906 6.576-11.96 4.522C1.223 17.658 1.89 14.412 4.121 11m6.838-6.868c-3.443-2.277-6.732-2.969-8.24-1.46-2.054 2.053-.03 7.407 4.522 11.959m3.718-10.499a24.16 24.16 0 0 1 3.719 3.062M17.798 11c2.23 3.412 2.898 6.658 1.402 8.153-1.502 1.503-4.771.822-8.2-1.433m1-6.808a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                            سامانه متمرکز گلخانه‌های برخط
                        </h1>
                        <p class="text-sm text-gray-500">مدیریت هوشمند گلخانه‌ها</p>
                    </div>
                </a>
            </div>

            <!-- Center - Search Bar (Hidden on mobile) -->
            <div class="hidden lg:flex flex-1 max-w-lg mx-8">
            </div>

            <!-- Right Side - Actions -->
            <div class="flex items-center space-x-4 rtl:space-x-reverse">

                <!-- User Profile Dropdown -->
                <div class="relative">
                    <button onclick="toggleUserMenu()"
                            class="flex items-center space-x-3 rtl:space-x-reverse p-1.5 rounded-xl hover:bg-gray-100 transition-colors duration-200 group">
                        <div
                            class="w-8 h-8 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-lg flex items-center justify-center">
                            <span class="text-white text-sm font-medium">
                                {{ substr(auth()->user()->getName(), 0, 1) }}
                            </span>
                        </div>
                        <div class="hidden md:block text-right">
                            <p class="text-sm font-medium text-gray-900">
                                {{ auth()->user()->getName() }}
                            </p>
                            <p class="text-xs text-gray-500">
                                @if(auth()->user()->hasRole(\App\Models\Role::ADMIN_ROLE))
                                    مدیر سیستم
                                @elseif(auth()->user()->hasRole(\App\Models\Role::COMPANY_ROLE))
                                    نماینده شرکت
                                @elseif(auth()->user()->hasRole(\App\Models\Role::GREENHOUSE_ROLE))
                                    مالک گلخانه
                                @else
                                    کاربر سازمانی
                                @endif
                            </p>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-colors duration-200"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- User Dropdown Menu -->
                    <div id="userDropdown"
                         class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 z-50">
                        <div class="p-4 border-b border-gray-200">
                            <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-lg flex items-center justify-center">
                                    <span class="text-white font-medium">
                                        {{ substr(auth()->user()->getName(), 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ auth()->user()->getName() }}</p>
                                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="py-2">
                            @can(\App\Models\Permission::PROFILE_INDEX)
                                <a href="{{ route('panel.profile.index') }}"
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    <svg class="w-4 h-4 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    پروفایل
                                </a>
                            @endcan

                            <div class="border-t border-gray-200 my-2"></div>

                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit"
                                        class="flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-red-50 transition-colors duration-200">
                                    <svg class="w-4 h-4 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    خروج از سیستم
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile Toggle -->
                @include('layouts.partials.mobile-toggle')
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Theme toggle functionality
        const themeToggle = document.getElementById('themeToggle');
        const htmlElement = document.documentElement;

        // Check for saved theme preference or default to light mode
        const savedTheme = localStorage.getItem('theme') || 'light';
        htmlElement.classList.toggle('dark', savedTheme === 'dark');

        themeToggle?.addEventListener('click', function () {
            const isDark = htmlElement.classList.contains('dark');
            htmlElement.classList.toggle('dark', !isDark);
            localStorage.setItem('theme', !isDark ? 'dark' : 'light');
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function (e) {
            // Close notifications dropdown
            const notificationsDropdown = document.getElementById('notificationsDropdown');
            const notificationsButton = e.target.closest('[onclick="toggleNotifications()"]');
            if (!notificationsButton && !notificationsDropdown?.contains(e.target)) {
                notificationsDropdown?.classList.add('hidden');
            }

            // Close user dropdown
            const userDropdown = document.getElementById('userDropdown');
            const userButton = e.target.closest('[onclick="toggleUserMenu()"]');
            if (!userButton && !userDropdown?.contains(e.target)) {
                userDropdown?.classList.add('hidden');
            }
        });
    });

    function toggleNotifications() {
        const dropdown = document.getElementById('notificationsDropdown');
        dropdown.classList.toggle('hidden');

        // Close user dropdown if open
        document.getElementById('userDropdown').classList.add('hidden');
    }

    function toggleUserMenu() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('hidden');

        // Close notifications dropdown if open
        document.getElementById('notificationsDropdown').classList.add('hidden');
    }
</script>
