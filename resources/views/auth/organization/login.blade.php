@extends('auth.layouts.app')

@section('title', 'ورود کاربران سازمانی')

@section('content')
    <div class="min-h-screen relative flex items-start justify-center p-4">
        <div class="relative w-full max-w-md">
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

                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 13l4 4L19 7"/>
                            </svg>
                            <p class="text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <p class="text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('login.organization.submit') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- National ID Field -->
                    <div class="space-y-2">
                        <label for="national_id" class="block text-sm font-semibold text-slate-700">
                            کد ملی
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <svg
                                    class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <input
                                type="text"
                                id="national_id"
                                name="national_id"
                                value="{{ old('national_id') }}"
                                class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400 @error('national_id') border-red-500 bg-red-50 @enderror"
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
                                <svg
                                    class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"
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
                                class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400 @error('phone_number') border-red-500 bg-red-50 @enderror"
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
                                id="sendCodeBtn"
                                onclick="sendCode()"
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
                                    id="code"
                                    name="code"
                                    value="{{ old('code') }}"
                                    class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400 disabled:opacity-50 disabled:cursor-not-allowed @error('code') border-red-500 bg-red-50 @enderror"
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
                <p class="text-sm text-slate-600">
                    مشکل در ورود دارید؟
                    <a href="{{ route('contact.us') }}"
                       class="text-blue-600 font-medium hover:text-blue-600/90 transition-colors">تماس با پشتیبانی</a>
                </p>
                <p class="text-sm text-slate-600 mt-2">
                    هنوز ثبت نام نکرده‌اید؟
                    <a href="{{ route('auth.company.register') }}"
                       class="text-blue-600 font-medium hover:text-blue-600/90 transition-colors">ثبت نام کنید</a>
                </p>
                <p class="text-sm text-slate-600 mt-2">
                    <a href="{{ route('home') }}"
                       class="text-blue-600 font-medium hover:text-blue-600/90 transition-colors">بازگشت به صفحه
                        اصلی</a>
                </p>
            </div>
        </div>

        <!-- JavaScript -->
        <script>
            let currentInterval = null;
            let isProcessing = false;

            function sendCode() {
                if (isProcessing) return;

                const nationalId = document.getElementById('national_id').value;
                const phoneNumber = document.getElementById('phone_number').value;
                const sendBtn = document.getElementById('sendCodeBtn');
                const codeInput = document.getElementById('code');

                if (!nationalId || !phoneNumber) {
                    showToast('لطفا کد ملی و شماره همراه را وارد کنید', 'error');
                    return;
                }

                isProcessing = true;
                const originalText = sendBtn.innerHTML;
                sendBtn.innerHTML = 'در حال ارسال...';
                sendBtn.disabled = true;

                fetch('{{ route("login.organization.send-sms") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        national_id: nationalId,
                        phone_number: phoneNumber
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
                        console.error('Error:', error);
                        showToast('خطا در ارسال کد', 'error');
                        resetButton();
                    });

                function resetButton() {
                    sendBtn.innerHTML = originalText;
                    sendBtn.disabled = false;
                    isProcessing = false;
                }

                function startCountdown() {
                    let countdown = 60;
                    sendBtn.innerHTML = countdown + ' ثانیه';

                    currentInterval = setInterval(() => {
                        countdown--;
                        sendBtn.innerHTML = countdown + ' ثانیه';

                        if (countdown === 0) {
                            clearInterval(currentInterval);
                            sendBtn.innerHTML = 'ارسال مجدد کد';
                            sendBtn.disabled = false;
                            isProcessing = false;
                        }
                    }, 1000);
                }
            }

            function showToast(message, type = 'info') {
                // Create toast notification
                const toast = document.createElement('div');
                toast.className = `fixed top-4 right-4 z-50 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow-lg border-l-4 ${type === 'success' ? 'border-green-500' : 'border-red-500'} transform translate-x-full transition-all duration-300`;

                const iconColor = type === 'success' ? 'text-green-500' : 'text-red-500';
                const bgColor = type === 'success' ? 'bg-green-100' : 'bg-red-100';

                toast.innerHTML = `
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg ${bgColor}">
                        <svg class="w-5 h-5 ${iconColor}" fill="currentColor" viewBox="0 0 20 20">
                            ${type === 'success'
                    ? '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>'
                    : '<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>'
                }
                        </svg>
                    </div>
                    <div class="mr-3 text-sm font-normal">${message}</div>
                `;

                document.body.appendChild(toast);
                setTimeout(() => toast.classList.remove('translate-x-full'), 100);
                setTimeout(() => {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => toast.remove(), 300);
                }, 5000);
            }

            // Add CSRF token to meta
            if (!document.querySelector('meta[name="csrf-token"]')) {
                const meta = document.createElement('meta');
                meta.name = 'csrf-token';
                meta.content = '{{ csrf_token() }}';
                document.head.appendChild(meta);
            }
        </script>
    </div>
@endsection
