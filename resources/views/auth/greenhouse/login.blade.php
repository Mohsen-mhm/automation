@extends('auth.layouts.app')

@section('title', 'ورود گلخانه‌داران')

@section('content')
    <div class="min-h-screen relative flex items-start justify-center p-4">
        <div class="relative w-full max-w-md">
            <!-- Login Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/20 p-8 md:p-10">
                <!-- Background Decoration -->
                <div class="absolute inset-0 overflow-hidden" style="z-index: -1;">
                    <div
                        class="absolute top-0 left-0 w-96 h-96 bg-green-100 rounded-full -translate-x-48 -translate-y-48 opacity-50"></div>
                    <div
                        class="absolute bottom-0 right-0 w-80 h-80 bg-emerald-100 rounded-full translate-x-40 translate-y-40 opacity-30"></div>
                    <div
                        class="absolute top-1/2 left-1/2 w-64 h-64 bg-green-50 rounded-full -translate-x-32 -translate-y-32 opacity-40"></div>
                </div>

                <!-- Header -->
                <div class="text-center mb-8">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl mb-6 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-slate-800 mb-2">ورود گلخانه‌داران</h1>
                    <p class="text-slate-600">به سامانه مدیریت گلخانه خود وارد شوید</p>
                </div>

                <!-- Login Form -->
                <form id="loginForm" method="POST" action="{{ route('login.greenhouse') }}" class="space-y-6">
                    @csrf

                    <!-- License Number Field -->
                    <div class="space-y-2">
                        <label for="licence_number" class="block text-sm font-semibold text-slate-700">
                            شماره پروانه گلخانه
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-green-500 transition-colors"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                </svg>
                            </div>
                            <input
                                type="text"
                                id="licence_number"
                                name="licence_number"
                                value="{{ old('licence_number') }}"
                                class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400 @error('licence_number') border-red-500 bg-red-50 @enderror"
                                placeholder="مثال: ۱۱/۲۲/۱۱۲۲"
                                required>
                        </div>
                        @error('licence_number')
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
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-green-500 transition-colors"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <input
                                type="text"
                                id="phone_number"
                                name="phone_number"
                                value="{{ old('phone_number') }}"
                                class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400 @error('phone_number') border-red-500 bg-red-50 @enderror"
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
                    <div class="space-y-2">
                        <label for="code" class="block text-sm font-semibold text-slate-700">
                            کد تایید پیامکی
                        </label>
                        <div class="flex items-stretch gap-3">
                            <!-- Send Code Button -->
                            <button
                                type="button"
                                id="sendSmsBtn"
                                class="flex-shrink-0 px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-xl hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-300 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl">
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
                                        class="h-5 w-5 text-slate-400 group-focus-within:text-green-500 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    id="code"
                                    name="code"
                                    value="{{ old('code') }}"
                                    class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400 @error('code') border-red-500 bg-red-50 @enderror"
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
                            class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold py-4 px-8 rounded-xl hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-300 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                ورود به پنل گلخانه
                            </div>
                        </button>
                    </div>
                </form>

                <!-- Additional Info -->
                <div class="mt-8 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-100">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600 mt-0.5" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-green-800 mb-1">راهنمای ورود گلخانه‌داران</h4>
                            <p class="text-sm text-green-700 leading-relaxed">
                                شماره پروانه و شماره همراه ثبت شده در سامانه را وارد کنید. پس از دریافت کد تایید، وارد
                                پنل مدیریت گلخانه خود شوید.
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
                       class="text-green-600 hover:text-green-700 font-medium transition-colors">تماس با پشتیبانی</a>
                </p>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sendSmsBtn = document.getElementById('sendSmsBtn');
            const codeInput = document.getElementById('code');
            const licenceInput = document.getElementById('licence_number');
            const phoneInput = document.getElementById('phone_number');
            let currentInterval = null;

            sendSmsBtn.addEventListener('click', function () {
                if (!licenceInput.value || !phoneInput.value) {
                    showToast('لطفاً شماره پروانه و شماره همراه را وارد کنید', 'error');
                    return;
                }

                // Disable button and show loading
                sendSmsBtn.disabled = true;
                sendSmsBtn.innerHTML = 'در حال ارسال...';

                // Send SMS request
                fetch('{{ route("login.greenhouse.send-sms") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        licence_number: licenceInput.value,
                        phone_number: phoneInput.value
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message, 'success');
                            startCountdown();
                            codeInput.disabled = false;
                            codeInput.focus();
                        } else {
                            showToast(data.message, 'error');
                            resetButton();
                        }
                    })
                    .catch(error => {
                        showToast('خطا در ارسال کد', 'error');
                        resetButton();
                    });
            });

            function startCountdown() {
                let countdown = 60;

                currentInterval = setInterval(() => {
                    countdown--;
                    sendSmsBtn.innerHTML = countdown + ' ثانیه';

                    if (countdown === 0) {
                        clearInterval(currentInterval);
                        resetButton();
                    }
                }, 1000);
            }

            function resetButton() {
                sendSmsBtn.disabled = false;
                sendSmsBtn.innerHTML = `
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                <span>ارسال مجدد کد</span>
            </div>
        `;
            }

            function showToast(message, type = 'info') {
                // Simple toast notification
                const toast = document.createElement('div');
                toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white ${
                    type === 'success' ? 'bg-green-500' :
                        type === 'error' ? 'bg-red-500' : 'bg-blue-500'
                }`;
                toast.textContent = message;

                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.remove();
                }, 5000);
            }
        });
    </script>
@endpush
