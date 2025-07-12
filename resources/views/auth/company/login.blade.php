@extends('auth.layouts.app')

@section('title', 'ورود شرکت‌ها')

@section('content')
    <div class="w-full">
        <div class="min-h-screen relative flex items-start justify-center p-4">
            <div class="relative w-full max-w-md mt-20">
                <!-- Login Card -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/20 p-8 md:p-10">
                    <!-- Background Decoration -->
                    <div class="absolute inset-0 overflow-hidden" style="z-index: -1;">
                        <div class="absolute top-0 left-0 w-96 h-96 bg-emerald-100 rounded-full -translate-x-48 -translate-y-48 opacity-50"></div>
                        <div class="absolute bottom-0 right-0 w-80 h-80 bg-teal-100 rounded-full translate-x-40 translate-y-40 opacity-30"></div>
                        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-emerald-50 rounded-full -translate-x-32 -translate-y-32 opacity-40"></div>
                    </div>

                    <!-- Header -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl mb-6 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-6m-4 0H3m2-16v16m6-16v16"/>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-slate-800 mb-2">ورود شرکت‌ها</h1>
                        <p class="text-slate-600">به پنل مدیریت خود دسترسی پیدا کنید</p>
                    </div>

                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <p class="text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <p class="text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('auth.company.login.post') }}" class="space-y-6">
                        @csrf

                        <!-- National ID Field -->
                        <div class="space-y-2">
                            <label for="national_id" class="block text-sm font-semibold text-slate-700">
                                شناسه ملی شرکت
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input type="text" id="national_id" name="national_id" value="{{ old('national_id') }}"
                                       class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400"
                                       placeholder="مثال: ۱۲۳۴۵۶۷۸۹۱۰" required>
                            </div>
                            @error('national_id')
                            <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-medium">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>

                        <!-- Phone Number Field -->
                        <div class="space-y-2">
                            <label for="phone_number" class="block text-sm font-semibold text-slate-700">
                                شماره همراه رابط
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                                       class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400"
                                       placeholder="09123456789" required>
                            </div>
                            @error('phone_number')
                            <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
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
                                <button type="button" id="sendSmsBtn"
                                        class="flex-shrink-0 px-6 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold rounded-xl hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                        </svg>
                                        <span>ارسال کد</span>
                                    </div>
                                </button>

                                <!-- Code Input -->
                                <div class="relative flex-1 group">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                    <input type="text" id="code" name="code" value="{{ old('code') }}" disabled
                                           class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400 disabled:opacity-50 disabled:cursor-not-allowed"
                                           placeholder="902150" required>
                                </div>
                            </div>
                            @error('code')
                            <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-medium">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold py-4 px-8 rounded-xl hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    ورود به پنل مدیریت
                                </div>
                            </button>
                        </div>
                    </form>

                    <!-- Additional Info -->
                    <div class="mt-8 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl border border-emerald-100">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-emerald-800 mb-1">راهنمای ورود</h4>
                                <p class="text-sm text-emerald-700 leading-relaxed">
                                    ابتدا شناسه ملی شرکت و شماره همراه رابط را وارد کنید، سپس کد تایید ارسالی را دریافت نمایید.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-6">
                    <p class="text-sm text-white/80">
                        مشکل در ورود دارید؟
                        <a href="{{ route('contact.us') }}" class="text-white font-medium hover:text-white/90 transition-colors">تماس با پشتیبانی</a>
                    </p>
                    <p class="text-sm text-white/60 mt-2">
                        هنوز ثبت نام نکرده‌اید؟
                        <a href="{{ route('auth.company.register') }}" class="text-white font-medium hover:text-white/90 transition-colors">ثبت نام کنید</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sendSmsBtn = document.getElementById('sendSmsBtn');
                const codeInput = document.getElementById('code');
                const nationalIdInput = document.getElementById('national_id');
                const phoneNumberInput = document.getElementById('phone_number');

                let countdown = 0;
                let countdownInterval = null;

                sendSmsBtn.addEventListener('click', function() {
                    const nationalId = nationalIdInput.value.trim();
                    const phoneNumber = phoneNumberInput.value.trim();

                    if (!nationalId || !phoneNumber) {
                        alert('لطفاً ابتدا شناسه ملی و شماره همراه را وارد کنید');
                        return;
                    }

                    // Disable button and start loading
                    sendSmsBtn.disabled = true;
                    sendSmsBtn.innerHTML = 'در حال ارسال...';

                    // Send AJAX request
                    fetch('{{ route("auth.company.send-sms") }}', {
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
                                // Enable code input
                                codeInput.disabled = false;
                                codeInput.focus();

                                // Start countdown
                                countdown = 60;
                                countdownInterval = setInterval(() => {
                                    countdown--;
                                    sendSmsBtn.innerHTML = `${countdown} ثانیه`;

                                    if (countdown <= 0) {
                                        clearInterval(countdownInterval);
                                        sendSmsBtn.disabled = false;
                                        sendSmsBtn.innerHTML = 'ارسال مجدد کد';
                                    }
                                }, 1000);

                                alert(data.message);
                            } else {
                                sendSmsBtn.disabled = false;
                                sendSmsBtn.innerHTML = 'ارسال کد';
                                alert(data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            sendSmsBtn.disabled = false;
                            sendSmsBtn.innerHTML = 'ارسال کد';
                            alert('خطا در ارسال درخواست');
                        });
                });
            });
        </script>
    @endpush
@endsection
