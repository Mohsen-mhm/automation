<!-- Modern Logout Button -->
<div>
    <button onclick="confirmLogout()"
            class="group flex items-center justify-center w-full space-x-3 rtl:space-x-reverse px-4 py-3 rounded-xl transition-all duration-200 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 hover:border-red-500/30 text-red-600 hover:text-red-700">
        <div
            class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-red-500 to-red-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
        </div>
        <span
            class="font-medium group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-200">خروج از سیستم</span>
    </button>
</div>

<!-- Logout Confirmation Modal -->
<div id="logoutModal"
     class="fixed inset-0 z-[9999] hidden items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
    <div
        class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform scale-95 transition-all duration-300"
        id="logoutModalContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <div class="flex items-center space-x-3 rtl:space-x-reverse">
                <div
                    class="w-12 h-12 bg-gradient-to-r from-red-500 to-red-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L4.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">تایید خروج</h3>
                    <p class="text-sm text-gray-500">خروج از سیستم</p>
                </div>
            </div>
            <button onclick="closeLogoutModal()"
                    class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <div class="text-center mb-6">
                <p class="text-gray-700 mb-2">آیا مطمئن هستید که می‌خواهید از سیستم خارج شوید؟</p>
                <p class="text-sm text-gray-500">تمام اطلاعات ذخیره نشده از دست خواهد رفت.</p>
            </div>

            <!-- User Info -->
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center">
                        <span class="text-white text-sm font-bold">
                            {{ substr(auth()->user()->getName(), 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ auth()->user()->getName() }}</p>
                        <p class="text-sm text-gray-500">
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
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex items-center justify-end space-x-3 rtl:space-x-reverse p-6 border-t border-gray-200">
            <button onclick="closeLogoutModal()"
                    class="px-6 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 font-medium">
                انصراف
            </button>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                        class="px-6 py-2.5 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-xl transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>خروج از سیستم</span>
                    </div>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmLogout() {
        const modal = document.getElementById('logoutModal');
        const content = document.getElementById('logoutModalContent');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Trigger animations
        requestAnimationFrame(() => {
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        });

        // Disable body scroll
        document.body.style.overflow = 'hidden';

        // Focus management
        const focusableElements = content.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];

        firstElement?.focus();

        // Handle tab navigation
        const handleTabKey = function (e) {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstElement) {
                        e.preventDefault();
                        lastElement?.focus();
                    }
                } else {
                    if (document.activeElement === lastElement) {
                        e.preventDefault();
                        firstElement?.focus();
                    }
                }
            }
        };

        content.addEventListener('keydown', handleTabKey);

        // Store handler to remove later
        modal._tabHandler = handleTabKey;
    }

    function closeLogoutModal() {
        const modal = document.getElementById('logoutModal');
        const content = document.getElementById('logoutModalContent');

        content.classList.remove('scale-100');
        content.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.body.style.overflow = '';

            // Remove tab handler
            if (modal._tabHandler) {
                content.removeEventListener('keydown', modal._tabHandler);
                delete modal._tabHandler;
            }
        }, 300);
    }

    // Close modal on escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('logoutModal');
            if (modal && modal.classList.contains('flex')) {
                closeLogoutModal();
            }
        }
    });

    // Close modal on backdrop click
    document.addEventListener('click', function (e) {
        const modal = document.getElementById('logoutModal');
        if (e.target === modal) {
            closeLogoutModal();
        }
    });
</script>
