<!-- Modern Loader Component -->
<div id="globalLoader" class="fixed inset-0 z-[9999] flex items-center justify-center bg-white transition-opacity duration-500">
    <div class="text-center">
        <!-- Main Logo Animation -->
        <div class="relative mb-8">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-3xl blur-xl opacity-30 animate-pulse"></div>
            <div class="relative bg-gradient-to-r from-emerald-500 to-teal-600 p-6 rounded-3xl shadow-2xl">
                <svg class="w-16 h-16 text-white animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2"
                          d="M7.24 7.194a24.16 24.16 0 0 1 3.72-3.062m0 0c3.443-2.277 6.732-2.969 8.24-1.46 2.054 2.053.03 7.407-4.522 11.959-4.552 4.551-9.906 6.576-11.96 4.522C1.223 17.658 1.89 14.412 4.121 11m6.838-6.868c-3.443-2.277-6.732-2.969-8.24-1.46-2.054 2.053-.03 7.407 4.522 11.959m3.718-10.499a24.16 24.16 0 0 1 3.719 3.062M17.798 11c2.23 3.412 2.898 6.658 1.402 8.153-1.502 1.503-4.771.822-8.2-1.433m1-6.808a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/>
                </svg>
            </div>
        </div>

        <!-- Loading Text -->
        <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent mb-3">
            سامانه متمرکز گلخانه‌های برخط
        </h2>
        <p class="text-gray-600 mb-8 max-w-md mx-auto">
            در حال بارگذاری سیستم مدیریت هوشمند گلخانه‌ها...
        </p>

        <!-- Loading Bar -->
        <div class="w-80 max-w-full mx-auto">
            <div class="h-2 bg-gray-200 rounded-full overflow-hidden shadow-inner">
                <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full loading-bar shadow-sm"></div>
            </div>
            <div class="flex justify-between text-xs text-gray-500 mt-2">
                <span>بارگذاری...</span>
                <span id="loadingPercentage">0%</span>
            </div>
        </div>

        <!-- Loading Dots -->
        <div class="flex justify-center space-x-1 rtl:space-x-reverse mt-8">
            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
        </div>

        <!-- Status Messages -->
        <div class="mt-6 h-5">
            <p id="loadingStatus" class="text-sm text-gray-500 transition-opacity duration-300">
                آماده‌سازی سیستم...
            </p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.getElementById('globalLoader');
        const loadingBar = document.querySelector('.loading-bar');
        const loadingPercentage = document.getElementById('loadingPercentage');
        const loadingStatus = document.getElementById('loadingStatus');

        let progress = 0;
        const statusMessages = [
            'آماده‌سازی سیستم...',
            'بارگذاری ماژول‌ها...',
            'اتصال به پایگاه داده...',
            'تایید احراز هویت...',
            'بارگذاری رابط کاربری...',
            'تکمیل بارگذاری...'
        ];

        function updateProgress() {
            if (progress < 100) {
                progress += Math.random() * 15 + 5;
                if (progress > 100) progress = 100;

                loadingBar.style.width = progress + '%';
                loadingPercentage.textContent = Math.round(progress) + '%';

                // Update status message
                const messageIndex = Math.min(Math.floor(progress / 20), statusMessages.length - 1);
                loadingStatus.textContent = statusMessages[messageIndex];

                if (progress < 100) {
                    setTimeout(updateProgress, Math.random() * 200 + 100);
                } else {
                    // Hide loader after completion
                    setTimeout(() => {
                        loader.style.opacity = '0';
                        setTimeout(() => {
                            loader.style.display = 'none';
                        }, 500);
                    }, 500);
                }
            }
        }

        // Start loading animation
        setTimeout(updateProgress, 500);

        // Hide loader when page is fully loaded
        window.addEventListener('load', function() {
            setTimeout(() => {
                progress = 100;
                loadingBar.style.width = '100%';
                loadingPercentage.textContent = '100%';
                loadingStatus.textContent = 'تکمیل شد!';

                setTimeout(() => {
                    loader.style.opacity = '0';
                    setTimeout(() => {
                        loader.style.display = 'none';
                    }, 500);
                }, 300);
            }, 200);
        });

        // Prevent loader from staying too long
        setTimeout(() => {
            if (loader.style.display !== 'none') {
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 500);
            }
        }, 5000);
    });
</script>

<style>
    .loading-bar {
        width: 0%;
        transition: width 0.3s ease-out;
        background: linear-gradient(90deg, #10b981, #14b8a6);
        position: relative;
        overflow: hidden;
    }

    .loading-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .animate-spin-slow {
        animation: spin-slow 3s linear infinite;
    }
</style>
