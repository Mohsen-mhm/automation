<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="/assets/img/favicon.png">
    <title>@yield('title', env('APP_NAME', 'سامانه متمرکز گلخانه‌های برخط کشور ایران'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="/assets/fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="/assets/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/flowbite/flowbite.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css">

    @stack('styles')

    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        .glass-effect {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #f3f3f3 100%);
        }

        .modern-shadow {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        /* Loading spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Toast notification styles */
        .toast {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }

        .toast.show {
            transform: translateX(0);
        }

        /* Enhanced form validation styles */
        input:invalid:not(:focus):not(:placeholder-shown),
        select:invalid:not(:focus) {
            border-color: #ef4444;
            background-color: #fef2f2;
        }

        input:valid:not(:focus):not(:placeholder-shown),
        select:valid:not(:focus) {
            border-color: #10b981;
            background-color: #f0fdf4;
        }

        /* Custom focus styles for different sections */
        .group:focus-within .group-focus-within\:text-green-500 {
            color: #10b981;
        }

        .group:focus-within .group-focus-within\:text-blue-500 {
            color: #3b82f6;
        }

        .group:focus-within .group-focus-within\:text-purple-500 {
            color: #8b5cf6;
        }

        /* Smooth transitions */
        * {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* File input styling */
        input[type="file"]::file-selector-button {
            margin-right: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: none;
            font-size: 0.875rem;
            font-weight: 500;
            background-color: rgb(240 253 244);
            color: rgb(21 128 61);
            cursor: pointer;
            transition: background-color 150ms ease;
        }

        input[type="file"]::file-selector-button:hover {
            background-color: rgb(220 252 231);
        }

        /* Page transition animations */
        .page-enter {
            animation: pageSlideIn 0.3s ease-out;
        }

        @keyframes pageSlideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Button hover effects */
        .btn-hover-scale {
            transition: transform 0.2s ease;
        }

        .btn-hover-scale:hover {
            transform: scale(1.02);
        }

        /* Modern card styles */
        .modern-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #10b981, #059669);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Custom radio and checkbox styles */
        input[type="radio"]:checked,
        input[type="checkbox"]:checked {
            background-color: #10b981;
            border-color: #10b981;
        }

        input[type="radio"]:focus,
        input[type="checkbox"]:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: none;
        }

        .loading-overlay.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Ripple effect */
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Form step indicators */
        .step-indicator {
            position: relative;
        }

        .step-indicator::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 100%;
            width: 100px;
            height: 2px;
            background: linear-gradient(to right, #10b981, #d1d5db);
            transform: translateY(-50%);
        }

        .step-indicator:last-child::after {
            display: none;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .text-4xl {
                font-size: 2rem;
            }

            .p-12 {
                padding: 2rem;
            }
        }

        /* Auth layout specific styles */
        .auth-bg {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 25%, #d1fae5 50%, #a7f3d0 75%, #6ee7b7 100%);
            min-height: 100vh;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Panel layout specific styles */
        .panel-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }

        /* Success/Error message animations */
        .alert-slide-in {
            animation: alertSlideIn 0.5s ease-out;
        }

        @keyframes alertSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Floating labels */
        .floating-label {
            position: relative;
        }

        .floating-label input:focus + label,
        .floating-label input:not(:placeholder-shown) + label {
            transform: translateY(-1.5rem) scale(0.85);
            color: #10b981;
        }

        .floating-label label {
            position: absolute;
            top: 1rem;
            right: 1rem;
            transition: all 0.3s ease;
            pointer-events: none;
            color: #6b7280;
        }
    </style>
</head>

<body dir="rtl" class="bg-gray-50 transition-colors duration-300">
<!-- Loading Component -->
@include('components.loader')

<!-- Check if user is authenticated and show appropriate layout -->
@auth
    <!-- Header -->
    @include('layouts.partials.header')

    <!-- Main Layout -->
    <div class="flex min-h-screen pt-16">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay"
             class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 opacity-0 invisible transition-all duration-300 md:hidden">
        </div>

        <!-- Main Content -->
        <main class="flex-1 overflow-hidden">
            <div class="h-full overflow-y-auto md:mr-72">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl alert-slide-in">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 ml-3" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 13l4 4L19 7"/>
                                </svg>
                                <p class="text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl alert-slide-in">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-600 ml-3" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <p class="text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl alert-slide-in">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-red-600 ml-3 mt-0.5" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h4 class="text-red-800 font-medium mb-2">خطاهای فرم:</h4>
                                    <ul class="text-red-700 text-sm space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Page Content -->
                    <div class="page-enter">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
@else
    <!-- Guest Layout for Auth Pages -->
    <div class="auth-bg">
        <!-- Flash Messages for Guest -->
        @if(session('success'))
            <div
                class="fixed top-4 right-4 z-50 p-4 bg-green-50 border border-green-200 rounded-xl shadow-lg alert-slide-in max-w-md">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div
                class="fixed top-4 right-4 z-50 p-4 bg-red-50 border border-red-200 rounded-xl shadow-lg alert-slide-in max-w-md">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-600 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <p class="text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Guest Content -->
        <div class="page-enter">
            @yield('content')
        </div>
    </div>
@endauth

<!-- Toast Container -->
<div id="toastContainer" class="fixed bottom-4 left-4 z-50 space-y-3"></div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay">
    <div class="text-center">
        <div
            class="w-16 h-16 border-4 border-green-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
        <p class="text-gray-600 font-medium">در حال پردازش...</p>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/assets/js/tailwind/tailwind.min.js"></script>
<script src="/assets/js/flowbite/flowbite.min.js"></script>
<script src="/assets/js/custom.js"></script>

@stack('scripts')

<script>
    // Modern interactions and utilities
    document.addEventListener('DOMContentLoaded', function () {
        // Smooth page transitions
        document.body.style.opacity = '0';
        document.body.style.transition = 'opacity 0.3s ease-in-out';
        setTimeout(() => {
            document.body.style.opacity = '1';
        }, 100);

        // Auto-hide flash messages
        setTimeout(() => {
            const flashMessages = document.querySelectorAll('.alert-slide-in');
            flashMessages.forEach(message => {
                message.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                message.style.opacity = '0';
                message.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    message.remove();
                }, 500);
            });
        }, 5000);

        // Form validation enhancement
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function (e) {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn && !submitBtn.disabled) {
                    submitBtn.disabled = true;

                    // Add loading spinner
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<span class="loading-spinner ml-2"></span>' + originalText;

                    // Re-enable after 10 seconds as fallback
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 10000);
                }
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add ripple effect to buttons
        document.querySelectorAll('button, .btn').forEach(button => {
            button.addEventListener('click', function (e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Enhanced form input validation
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function () {
                if (this.hasAttribute('required') && !this.value) {
                    this.classList.add('border-red-500', 'bg-red-50');
                    this.classList.remove('border-green-500', 'bg-green-50');
                } else if (this.checkValidity()) {
                    this.classList.add('border-green-500', 'bg-green-50');
                    this.classList.remove('border-red-500', 'bg-red-50');
                }
            });

            input.addEventListener('input', function () {
                if (this.classList.contains('border-red-500') && this.value) {
                    this.classList.remove('border-red-500', 'bg-red-50');
                    this.classList.add('border-gray-300');
                }
            });
        });
    });

    // Toast notification function
    function showToast(message, type = 'info', duration = 5000) {
        const container = document.getElementById('toastContainer');
        const toastId = 'toast_' + Date.now();

        const iconMap = {
            success: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>',
            error: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>',
            warning: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
            info: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>'
        };

        const colorMap = {
            success: 'text-green-500 bg-green-100 border-green-500',
            error: 'text-red-500 bg-red-100 border-red-500',
            warning: 'text-yellow-500 bg-yellow-100 border-yellow-500',
            info: 'text-blue-500 bg-blue-100 border-blue-500'
        };

        const toast = document.createElement('div');
        toast.id = toastId;
        toast.className = `toast flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow-lg transform translate-x-full transition-all duration-300 border-l-4 ${colorMap[type] || colorMap.info}`;

        toast.innerHTML = `
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg ${colorMap[type] || colorMap.info}">
                    ${iconMap[type] || iconMap.info}
                </div>
                <div class="mr-3 text-sm font-normal text-gray-900">${message}</div>
                <button type="button" class="mr-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8" onclick="removeToast('${toastId}')">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;

        container.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.classList.add('show');
            toast.classList.remove('translate-x-full');
        }, 100);

        // Auto remove
        setTimeout(() => {
            removeToast(toastId);
        }, duration);
    }

    function removeToast(toastId) {
        const toast = document.getElementById(toastId);
        if (toast) {
            toast.classList.remove('show');
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }
    }

    // Show/Hide loading overlay
    function showLoading() {
        document.getElementById('loadingOverlay').classList.add('show');
    }

    function hideLoading() {
        document.getElementById('loadingOverlay').classList.remove('show');
    }

    // Global AJAX setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Handle AJAX errors globally
    $(document).ajaxError(function (event, xhr, settings) {
        hideLoading();

        if (xhr.status === 422) {
            // Validation errors
            const errors = xhr.responseJSON?.errors;
            if (errors) {
                Object.values(errors).forEach(errorArray => {
                    errorArray.forEach(error => {
                        showToast(error, 'error');
                    });
                });
            }
        } else if (xhr.status === 403) {
            showToast('شما مجوز دسترسی به این بخش را ندارید.', 'error');
        } else if (xhr.status === 500) {
            showToast('خطای داخلی سرور. لطفا مجددا تلاش کنید.', 'error');
        } else {
            showToast('خطا در ارتباط با سرور.', 'error');
        }
    });

    // Add CSRF token to meta if not present
    if (!$('meta[name="csrf-token"]').attr('content')) {
        $('head').append('<meta name="csrf-token" content="{{ csrf_token() }}">');
    }
</script>
</body>
</html>
