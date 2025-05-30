<div class="w-full">
    <div class="min-h-screen relative flex items-start justify-center p-4">
        <div class="relative w-full">
            <!-- Login Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/20 p-8 md:p-10">
                <!-- Background Decoration -->
                <div class="absolute inset-0 overflow-hidden" style="z-index: -1;">
                    <div
                        class="absolute top-0 left-0 w-96 h-96 bg-blue-100 rounded-full -translate-x-48 -translate-y-48 opacity-50"></div>
                    <div
                        class="absolute bottom-0 right-0 w-80 h-80 bg-indigo-100 rounded-full translate-x-40 translate-y-40 opacity-30"></div>
                    <div
                        class="absolute top-1/2 left-1/2 w-64 h-64 bg-blue-50 rounded-full -translate-x-32 -translate-y-32 opacity-40"></div>
                </div>

                <!-- Header -->
                <div class="text-center mb-8">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl mb-6 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-slate-800 mb-2">ورود کاربران سازمانی</h1>
                    <p class="text-slate-600">به سامانه مدیریت سازمانی دسترسی پیدا کنید</p>
                </div>

                <!-- Login Form -->
                <form wire:submit="login" class="space-y-6">
                    <!-- National ID Field -->
                    <div class="space-y-2">
                        <label for="national_id" class="block text-sm font-semibold text-slate-700">
                            کد ملی
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <input
                                type="text"
                                id="national_id"
                                wire:model.live="national_id"
                                class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400"
                                placeholder="مثال: ۲۲۸۱۲۳۴۵۶۷"
                                minlength="10"
                                maxlength="10"
                                required>
                        </div>
                        @error('national_id')
                        <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-medium">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>

                    <!-- Phone Number Field -->
                    <div class="space-y-2">
                        <label for="phone_number" class="block text-sm font-semibold text-slate-700">
                            شماره همراه
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <input
                                type="text"
                                id="phone_number"
                                wire:model.live="phone_number"
                                class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400"
                                placeholder="09123456789"
                                required>
                        </div>
                        @error('phone_number')
                        <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-medium">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>

                    <!-- Verification Code Field -->
                    <div class="space-y-2" wire:ignore.self>
                        <label for="code-input" class="block text-sm font-semibold text-slate-700">
                            کد تایید پیامکی
                        </label>
                        <div class="flex items-stretch gap-3" wire:ignore>
                            <!-- Send Code Button -->
                            <button
                                type="button"
                                onclick="sendCode(this)"
                                data-processing="false"
                                class="flex-shrink-0 px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    <span>ارسال کد</span>
                                </div>
                            </button>

                            <!-- Code Input -->
                            <div class="relative flex-1 group">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg
                                        class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    id="code-input"
                                    wire:model.blur="code"
                                    class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400 disabled:opacity-50 disabled:cursor-not-allowed"
                                    placeholder="902150"
                                    disabled
                                    required>
                            </div>
                        </div>
                        @error('code')
                        <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-medium">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-4 px-8 rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                ورود به پنل سازمانی
                            </div>
                        </button>
                    </div>
                </form>

                <!-- Additional Info -->
                <div class="mt-8 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-800 mb-1">راهنمای ورود کاربران سازمانی</h4>
                            <p class="text-sm text-blue-700 leading-relaxed">
                                کد ملی و شماره همراه تأیید شده در سازمان را وارد کنید. پس از دریافت کد تایید، به پنل
                                سازمانی خود دسترسی پیدا کنید.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-sm text-slate-500">
                    مشکل در ورود دارید؟
                    <a href="{{ route('contact.us') }}"
                       class="text-blue-600 hover:text-blue-700 font-medium transition-colors">تماس با پشتیبانی</a>
                </p>
            </div>
        </div>

        <!-- Enhanced Styles -->
        <style>
            /* Custom focus styles */
            .group:focus-within .group-focus-within\:text-blue-500 {
                color: #3b82f6;
            }

            /* Enhanced form validation styles */
            input:invalid:not(:focus):not(:placeholder-shown) {
                border-color: #ef4444;
                background-color: #fef2f2;
            }

            input:valid:not(:focus):not(:placeholder-shown) {
                border-color: #10b981;
                background-color: #f0fdf4;
            }

            /* Loading animation for button */
            .loading {
                position: relative;
                overflow: hidden;
            }

            .loading::after {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                animation: loading 1.5s infinite;
            }

            @keyframes loading {
                0% {
                    left: -100%;
                }
                100% {
                    left: 100%;
                }
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

            /* Responsive adjustments */
            @media (max-width: 640px) {
                .flex-shrink-0 {
                    min-width: auto;
                }
            }
        </style>

        <!-- Enhanced JavaScript -->
        <script>
            // Global variables to track state
            let currentInterval = null;
            let currentButton = null;
            let originalContent = '';

            // Set up Livewire event listeners only once
            document.addEventListener('DOMContentLoaded', function () {
                Livewire.on('start-interval', () => {
                    if (!currentButton) return;

                    let countdown = 60;
                    const codeEl = document.querySelector('#code-input');

                    // Clear any existing interval first
                    if (currentInterval) {
                        clearInterval(currentInterval);
                    }

                    currentInterval = setInterval(() => {
                        countdown--;
                        currentButton.innerHTML = countdown + ' ثانیه';
                        currentButton.disabled = true; // Keep disabled during countdown

                        // Enable code input only once when countdown starts
                        if (countdown === 59 && codeEl) {
                            codeEl.classList.remove('opacity-75');
                            codeEl.removeAttribute('disabled');
                        }

                        if (countdown === 0) {
                            clearInterval(currentInterval);
                            currentInterval = null;
                            currentButton.innerHTML = 'ارسال مجدد کد';
                            currentButton.disabled = false;
                            currentButton.style.opacity = '';
                            currentButton.style.cursor = '';
                            currentButton.dataset.processing = 'false';
                            currentButton = null;
                        }
                    }, 1000);
                });

                // Handle SMS send failure
                Livewire.on('sms-send-failed', () => {
                    if (!currentButton) return;

                    if (currentInterval) {
                        clearInterval(currentInterval);
                        currentInterval = null;
                    }

                    currentButton.innerHTML = originalContent;
                    currentButton.disabled = false;
                    currentButton.style.opacity = '';
                    currentButton.style.cursor = '';
                    currentButton.dataset.processing = 'false';
                    currentButton = null;
                });
                const inputs = document.querySelectorAll('input[required]');

                inputs.forEach(input => {
                    input.addEventListener('blur', function () {
                        if (this.checkValidity()) {
                            this.classList.add('valid');
                            this.classList.remove('invalid');
                        } else {
                            this.classList.add('invalid');
                            this.classList.remove('valid');
                        }
                    });

                    input.addEventListener('input', function () {
                        if (this.value && this.checkValidity()) {
                            this.classList.add('valid');
                            this.classList.remove('invalid');
                        }
                    });
                });
            });

            function sendCode(button) {
                // Prevent multiple clicks by checking if already processing
                if (button.dataset.processing === 'true') {
                    return;
                }

                // Store references globally
                currentButton = button;
                originalContent = button.innerHTML;

                // Mark as processing and disable button
                button.dataset.processing = 'true';
                button.disabled = true;
                button.style.opacity = '0.6';
                button.style.cursor = 'not-allowed';
                button.innerHTML = 'در حال ارسال...';

                Livewire.dispatch('send-sms');
            }
        </script>
    </div>
</div>
