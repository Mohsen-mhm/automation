<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon.png">
    <title>{{ env('APP_NAME', 'سامانه متمرکز گلخانه های برخط کشور ایران') }}</title>

    {{-- Preload critical resources --}}
    <link rel="preload" href="/assets/fonts/Vazir.ttf" as="font" type="font/ttf" crossorigin>
    <link rel="preload" href="/assets/css/flowbite/flowbite.min.css" as="style">
    <link rel="preload" href="/assets/js/tailwind/tailwind.min.js" as="script">

    {{-- Core CSS --}}
    <link rel="stylesheet" href="/assets/css/flowbite/flowbite.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css">

    {{-- Map-specific resources (conditional loading) --}}
    @if (\Illuminate\Support\Facades\Route::currentRouteName() == 'home')
        <link rel="stylesheet" href="/assets/css/leaflet/leaflet.css"/>
        <link rel="stylesheet" href="/assets/css/leaflet/Control.Geocoder.css"/>
        <link rel="stylesheet" href="/assets/css/map.css">

        {{-- Critical CSS for map container to prevent layout shift --}}
        <style>
            #map {
                background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
                position: relative;
                min-height: 700px;
            }

            #map.loading::before {
                content: "";
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 40px;
                height: 40px;
                border: 3px solid #e2e8f0;
                border-top: 3px solid #10b981;
                border-radius: 50%;
                animation: mapSpin 1s linear infinite;
                z-index: 1000;
            }

            @keyframes mapSpin {
                0% { transform: translate(-50%, -50%) rotate(0deg); }
                100% { transform: translate(-50%, -50%) rotate(360deg); }
            }

            .leaflet-container {
                background: transparent;
            }

            .leaflet-container::before {
                display: none;
            }
        </style>
    @endif

    {{-- Sidebar Styles --}}
    <style>
        /* Modern sidebar transitions */
        .sidebar-transition {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.3);
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.5);
        }

        /* Loading states */
        .skeleton {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
        }

        @keyframes skeleton-loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Enhanced focus states */
        .focus-ring:focus {
            outline: 2px solid #10b981;
            outline-offset: 2px;
        }

        /* Backdrop overlay */
        .backdrop-overlay {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }
    </style>

    {{-- Livewire Styles --}}
    @livewireStyles
</head>

<body dir="rtl" class="bg-slate-50 font-sans antialiased">
<x-loader/>

{{-- Main Container --}}
<div class="flex h-screen overflow-hidden"
     x-data="{
            page: 'ecommerce',
            stickyMenu: false,
            sidebarToggleDetail: false,
            selected: '',
            mapLoaded: false,
            showBackdrop: false
         }"
     x-init="
            // Initialize selected from localStorage manually
            const stored = localStorage.getItem('selected');
            if (stored) {
                try {
                    selected = JSON.parse(stored);
                } catch (e) {
                    selected = stored;
                }
            }

            // Watch for changes and save to localStorage
            $watch('selected', value => {
                localStorage.setItem('selected', JSON.stringify(value));
            });

            // Watch for sidebar toggle to show/hide backdrop on mobile
            $watch('sidebarToggle', value => {
                showBackdrop = value && window.innerWidth < 1024;
                if (value && window.innerWidth < 1024) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });

            // Handle window resize
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    showBackdrop = false;
                    document.body.style.overflow = '';
                } else if (sidebarToggle) {
                    showBackdrop = true;
                }
            });
         ">

    {{-- Mobile Backdrop --}}
    <div x-show="showBackdrop"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarToggle = false"
         class="fixed inset-0 z-40 backdrop-overlay lg:hidden"></div>

    {{-- Menu Sidebar --}}
    <livewire:layouts.menu/>

    {{-- Main Content --}}
    <div class="flex flex-1 flex-col overflow-hidden">
        {{ $slot }}
    </div>

    {{-- Details Sidebar --}}
    <livewire:layouts.sidebar/>

    {{-- Toggle Button --}}
    <livewire:layouts.toggle/>
</div>

{{-- Core Scripts --}}
<script src="/assets/js/tailwind/tailwind.min.js"></script>
<script src="/assets/js/flowbite/flowbite.min.js"></script>

{{-- Livewire Scripts --}}
@livewireScripts

{{-- Alpine.js with proper loading order --}}
<script>
    // Wait for DOM to be ready before loading Alpine
    document.addEventListener('DOMContentLoaded', function() {
        // Only load Alpine.js if it's not already loaded
        if (typeof window.Alpine === 'undefined') {
            loadAlpineJS();
        } else {
            console.log('Alpine.js already loaded');
        }
    });

    function loadAlpineJS() {
        // Load Alpine.js without the persist plugin first
        const alpineScript = document.createElement('script');
        alpineScript.defer = true;
        alpineScript.src = 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js';
        alpineScript.onload = function() {
            console.log('✓ Alpine.js loaded successfully');
        };
        alpineScript.onerror = function() {
            console.error('Failed to load Alpine.js');
        };
        document.head.appendChild(alpineScript);
    }
</script>

{{-- Map Scripts (conditional loading with proper error handling) --}}
@if (\Illuminate\Support\Facades\Route::currentRouteName() == 'home')
    <script>
        // Global variables to prevent conflicts
        window.mapConfig = {
            initialized: false,
            loading: false,
            error: false
        };

        // Initialize map loading after Alpine is ready
        document.addEventListener('alpine:init', function() {
            initializeMapSequence();
        });

        function initializeMapSequence() {
            if (window.mapConfig.loading || window.mapConfig.initialized) {
                return;
            }

            window.mapConfig.loading = true;
            const mapContainer = document.getElementById('map');

            if (!mapContainer) {
                console.warn('Map container not found');
                return;
            }

            // Add loading class
            mapContainer.classList.add('loading');

            // Load Leaflet first
            loadScript('/assets/js/leaflet/leaflet.js')
                .then(() => {
                    console.log('✓ Leaflet loaded');
                    return loadScript('/assets/js/leaflet/Control.Geocoder.js');
                })
                .then(() => {
                    console.log('✓ Geocoder loaded');

                    // Wait for Livewire to be ready
                    if (typeof Livewire !== 'undefined') {
                        return Promise.resolve();
                    } else {
                        return new Promise(resolve => {
                            document.addEventListener('livewire:init', resolve, { once: true });
                        });
                    }
                })
                .then(() => {
                    console.log('✓ Livewire ready');
                    return loadMapScript();
                })
                .then(() => {
                    console.log('✓ Map initialized successfully');
                    window.mapConfig.initialized = true;
                    mapContainer.classList.remove('loading');
                })
                .catch(error => {
                    console.error('✗ Map initialization failed:', error);
                    window.mapConfig.error = true;
                    mapContainer.classList.remove('loading');
                    showMapError(mapContainer);
                })
                .finally(() => {
                    window.mapConfig.loading = false;
                });
        }

        function loadScript(src) {
            return new Promise((resolve, reject) => {
                // Check if script already exists
                const existingScript = document.querySelector(`script[src="${src}"]`);
                if (existingScript) {
                    existingScript.remove();
                }

                const script = document.createElement('script');
                script.src = src;
                script.onload = resolve;
                script.onerror = () => reject(new Error(`Failed to load ${src}`));
                document.head.appendChild(script);
            });
        }

        function loadMapScript() {
            return new Promise((resolve, reject) => {
                if (typeof L === 'undefined') {
                    reject(new Error('Leaflet not available'));
                    return;
                }

                // Remove existing map script
                const existingMapScript = document.querySelector('script[src*="map.js"]');
                if (existingMapScript) {
                    existingMapScript.remove();
                }

                const script = document.createElement('script');
                script.src = '/assets/js/map.js';
                script.onload = () => {
                    // Give map script a moment to initialize
                    setTimeout(resolve, 100);
                };
                script.onerror = () => reject(new Error('Failed to load map.js'));
                document.head.appendChild(script);
            });
        }

        function showMapError(container) {
            container.innerHTML = `
                    <div class="flex h-full items-center justify-center bg-slate-100 rounded-2xl border-2 border-dashed border-slate-300">
                        <div class="text-center p-8">
                            <svg class="w-16 h-16 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-slate-700 mb-2">خطا در بارگذاری نقشه</h3>
                            <p class="text-slate-500 mb-4">متأسفانه نقشه قابل نمایش نیست</p>
                            <button onclick="location.reload()"
                                    class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors focus-ring">
                                تلاش مجدد
                            </button>
                        </div>
                    </div>
                `;
        }
    </script>
@endif

{{-- Custom Scripts with proper loading --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize custom scripts after DOM is ready
        initializeCustomFeatures();
    });

    function initializeCustomFeatures() {
        // Enhanced error handling
        window.addEventListener('error', function(e) {
            // Only log relevant errors, suppress performance errors
            if (e.message && !e.message.includes('performance') && !e.message.includes('ResizeObserver')) {
                console.debug('Error caught:', e.message);
            }

            // Don't let errors break the page
            e.preventDefault();
            return false;
        });

        // Handle unhandled promise rejections
        window.addEventListener('unhandledrejection', function(e) {
            console.debug('Promise rejection caught:', e.reason);
            e.preventDefault();
        });

        // Load custom.js safely
        if (typeof Livewire !== 'undefined') {
            loadCustomScript();
        } else {
            document.addEventListener('livewire:init', loadCustomScript);
        }
    }

    function loadCustomScript() {
        const script = document.createElement('script');
        script.src = '/assets/js/custom.js';
        script.onload = function() {
            console.log('✓ Custom scripts loaded');
        };
        script.onerror = function() {
            console.debug('Custom script not available');
        };
        document.head.appendChild(script);
    }

    // Safe performance monitoring
    window.addEventListener('load', function() {
        try {
            if (window.performance && window.performance.getEntriesByType) {
                const perfData = window.performance.getEntriesByType('navigation')[0];
                if (perfData && perfData.loadEventEnd && perfData.fetchStart) {
                    const loadTime = Math.round(perfData.loadEventEnd - perfData.fetchStart);
                    console.log(`⚡ Page loaded in ${loadTime}ms`);
                }
            }
        } catch (e) {
            // Silently handle performance API errors
        }
    });

    // Alpine.js initialization
    document.addEventListener('alpine:init', () => {
        console.log('✓ Alpine.js initialized');
    });

    // Utility functions
    window.utils = {
        debounce: function(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        },

        throttle: function(func, limit) {
            let inThrottle;
            return function() {
                const args = arguments;
                const context = this;
                if (!inThrottle) {
                    func.apply(context, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            };
        },

        formatNumber: function(num) {
            try {
                return new Intl.NumberFormat('fa-IR').format(num);
            } catch (e) {
                return num.toString();
            }
        },

        toPersianDigits: function(str) {
            const persianDigits = '۰۱۲۳۴۵۶۷۸۹';
            const englishDigits = '0123456789';

            return str.toString().replace(/[0-9]/g, (digit) => {
                return persianDigits[englishDigits.indexOf(digit)];
            });
        },

        showNotification: function(message, type = 'info') {
            // Simple notification system
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white transition-all duration-300 transform translate-x-full`;

            switch (type) {
                case 'success':
                    notification.className += ' bg-emerald-500';
                    break;
                case 'error':
                    notification.className += ' bg-red-500';
                    break;
                case 'warning':
                    notification.className += ' bg-amber-500';
                    break;
                default:
                    notification.className += ' bg-blue-500';
            }

            notification.innerHTML = `
                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>${message}</span>
                        <button onclick="this.parentElement.parentElement.remove()" class="mr-2 hover:opacity-75">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                `;

            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Auto remove after 5 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 300);
            }, 5000);
        }
    };

    // Make utilities globally available
    window.showNotification = window.utils.showNotification;
</script>
</body>

</html>
