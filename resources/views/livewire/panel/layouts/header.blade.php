<header
    class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 transition-all duration-300">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Logo and Title -->
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <a href="{{ route('panel.home') }}"
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


            <!-- Mobile Toggle -->
            <livewire:panel.layouts.toggle/>
        </div>
    </div>
</header>
