@extends('auth.layouts.app')

@section('title', 'ورود به سیستم')

@section('content')
    <div class="min-h-screen relative flex flex-col items-center justify-center p-4">
        <div class="glass-effect rounded-3xl shadow-2xl border border-white/20 p-8">
            <!-- Background Decoration -->
            <div class="absolute inset-0 overflow-hidden" style="z-index: -1;">
                <div
                    class="absolute top-0 left-0 w-96 h-96 bg-emerald-100 rounded-full -translate-x-48 -translate-y-48 opacity-50"></div>
                <div
                    class="absolute bottom-0 right-0 w-80 h-80 bg-teal-100 rounded-full translate-x-40 translate-y-40 opacity-30"></div>
                <div
                    class="absolute top-1/2 left-1/2 w-64 h-64 bg-emerald-50 rounded-full -translate-x-32 -translate-y-32 opacity-40"></div>
            </div>

            <!-- Header -->
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl mb-6 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-slate-800 mb-2">ورود به سامانه</h1>
                <p class="text-slate-600">به پنل کاربری خود دسترسی پیدا کنید</p>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <p class="text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Login Form -->
            <form id="loginForm" action="{{ route('login.simurgh.submit') }}" method="POST" class="space-y-6">
                @csrf

                <!-- National ID Field -->
                <div class="space-y-2">
                    <label for="national_id" class="block text-sm font-semibold text-slate-700">
                        کد ملی <span class="text-red-500">*</span>
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input type="text" id="national_id" name="national_id"
                               value="{{ old('national_id') }}"
                               class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400 @error('national_id') border-red-500 bg-red-50 @enderror"
                               placeholder="مثال: ۲۲۸۱۲۳۴۵۶۷"
                               minlength="10" maxlength="10" required>
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
                        شماره همراه <span class="text-red-500">*</span>
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <input type="text" id="phone_number" name="phone_number"
                               value="{{ old('phone_number') }}"
                               class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400 @error('phone_number') border-red-500 bg-red-50 @enderror"
                               placeholder="09123456789" required>
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
                        کد تایید پیامکی <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-stretch gap-3">
                        <!-- Send Code Button -->
                        <button type="button" id="sendCodeBtn"
                                class="flex-shrink-0 px-6 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold rounded-xl hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
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
                                    class="h-5 w-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input type="text" id="code" name="code"
                                   value="{{ old('code') }}"
                                   class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400 disabled:opacity-50 disabled:cursor-not-allowed @error('code') border-red-500 bg-red-50 @enderror"
                                   placeholder="902150" disabled required>
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
                    <button type="submit" id="loginBtn"
                            class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold py-4 px-8 rounded-xl hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                        <div class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            ورود به پنل
                        </div>
                    </button>
                </div>
            </form>

            <!-- Additional Info -->
            <div class="mt-8 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl border border-emerald-100">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-emerald-600 mt-0.5" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-emerald-800 mb-1">راهنمای ورود</h4>
                        <p class="text-sm text-emerald-700 leading-relaxed">
                            کد ملی و شماره همراه ثبت شده را وارد کنید. پس از دریافت کد تایید، به پنل کاربری خود دسترسی
                            پیدا
                            کنید.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            let currentInterval = null;
            let countdownActive = false;

            // Send SMS Code
            $('#sendCodeBtn').on('click', function () {
                if (countdownActive) return;

                const $btn = $(this);
                const $nationalId = $('#national_id');
                const $phoneNumber = $('#phone_number');
                const $codeInput = $('#code');

                // Validate required fields
                if (!$nationalId.val() || !$phoneNumber.val()) {
                    showToast('لطفا کد ملی و شماره همراه را وارد کنید', 'warning');
                    return;
                }

                // Show loading state
                const originalText = $btn.html();
                $btn.prop('disabled', true).html(`
            <div class="flex items-center gap-2">
                <div class="loading-spinner"></div>
                <span>در حال ارسال...</span>
            </div>
        `);

                // Send AJAX request
                $.ajax({
                    url: '{{ route("login.simurgh.send-code") }}',
                    type: 'POST',
                    data: {
                        national_id: $nationalId.val(),
                        phone_number: $phoneNumber.val(),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            showToast(response.message, 'success');
                            startCountdown($btn);
                            $codeInput.prop('disabled', false).focus();
                        } else {
                            showToast(response.message, 'error');
                            $btn.prop('disabled', false).html(originalText);
                        }
                    },
                    error: function (xhr) {
                        const response = xhr.responseJSON;
                        if (response && response.errors) {
                            // Clear previous errors
                            $('.text-red-600').remove();
                            $('input').removeClass('border-red-500 bg-red-50');

                            // Show new errors
                            Object.keys(response.errors).forEach(field => {
                                const $field = $(`#${field}`);
                                $field.addClass('border-red-500 bg-red-50');
                                $field.closest('.space-y-2').append(`
                            <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-medium">${response.errors[field][0]}</span>
                            </div>
                        `);
                            });
                        } else {
                            showToast(response?.message || 'خطا در ارسال کد', 'error');
                        }
                        $btn.prop('disabled', false).html(originalText);
                    }
                });
            });

            // Start countdown timer
            function startCountdown($btn) {
                countdownActive = true;
                let countdown = 60;

                currentInterval = setInterval(function () {
                    countdown--;
                    $btn.html(`${countdown} ثانیه`);

                    if (countdown === 0) {
                        clearInterval(currentInterval);
                        countdownActive = false;
                        $btn.prop('disabled', false).html(`
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        <span>ارسال مجدد</span>
                    </div>
                `);
                    }
                }, 1000);
            }

            // Handle form submission
            $('#loginForm').on('submit', function (e) {
                e.preventDefault();

                const $form = $(this);
                const $submitBtn = $('#loginBtn');
                const originalText = $submitBtn.html();

                // Show loading state
                $submitBtn.prop('disabled', true).html(`
            <div class="flex items-center justify-center gap-2">
                <div class="loading-spinner"></div>
                <span>در حال ورود...</span>
            </div>
        `);

                // Send AJAX request
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function (response) {
                        if (response.success) {
                            showToast(response.message, 'success');
                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 1000);
                        } else {
                            showToast(response.message, 'error');
                            $submitBtn.prop('disabled', false).html(originalText);
                        }
                    },
                    error: function (xhr) {
                        const response = xhr.responseJSON;
                        if (response && response.errors) {
                            // Clear previous errors
                            $('.text-red-600').remove();
                            $('input').removeClass('border-red-500 bg-red-50');

                            // Show new errors
                            Object.keys(response.errors).forEach(field => {
                                const $field = $(`#${field}`);
                                $field.addClass('border-red-500 bg-red-50');
                                $field.closest('.space-y-2').append(`
                            <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-medium">${response.errors[field][0]}</span>
                            </div>
                        `);
                            });
                        } else {
                            showToast(response?.message || 'خطا در ورود', 'error');
                        }
                        $submitBtn.prop('disabled', false).html(originalText);
                    }
                });
            });

            // Input validation and styling
            $('input[required]').on('blur', function () {
                const $input = $(this);
                $input.removeClass('border-red-500 bg-red-50 border-green-500 bg-green-50');

                if (this.checkValidity() && $input.val()) {
                    $input.addClass('border-green-500 bg-green-50');
                } else if ($input.val()) {
                    $input.addClass('border-red-500 bg-red-50');
                }
            });

            // Clean up on page unload
            $(window).on('beforeunload', function () {
                if (currentInterval) {
                    clearInterval(currentInterval);
                }
            });
        });
    </script>
@endpush
