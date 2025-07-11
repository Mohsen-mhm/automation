@extends('layouts.app')

@section('title', 'تنظیمات محدوده‌ها')

@section('content')
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center ml-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L4.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        تنظیمات محدوده‌ها
                    </h1>
                    <p class="text-gray-600 mt-1">تنظیم محدوده‌های هشدار برای پارامترهای محیطی
                        گلخانه {{ $greenhouse->name }}</p>
                </div>
            </div>
        </div>

        <!-- Alert Configuration Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-red-500 px-6 py-4 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-5 5v-5zM8.5 14c-.828 0-1.5-.895-1.5-2s.672-2 1.5-2 1.5.895 1.5 2-.672 2-1.5 2zM12 6.5c-.828 0-1.5-.895-1.5-2s.672-2 1.5-2 1.5.895 1.5 2-.672 2-1.5 2z"/>
                    </svg>
                    تنظیم محدوده‌های هشدار
                </h3>
            </div>

            <div class="p-6">
                @include('panel.alerts.form', [
                    'action' => route('panel.alerts.store'),
                    'method' => 'POST',
                    'alert' => $alert,
                    'isAdmin' => false
                ])
            </div>
        </div>

        <!-- Current Settings Display -->
        @if($alert && ($alert->lux_active || $alert->temp_active || $alert->wind_active || $alert->humidity_active))
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 text-emerald-600 ml-2" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        تنظیمات فعلی
                    </h3>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @if($alert->lux_active)
                            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                    <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 5V3m0 18v-2M7 7 5.7 5.7m12.8 12.8L17 17M5 12H3m18 0h-2M7 17l-1.4 1.4M18.4 5.6 17 7.1M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">روشنایی</h4>
                                        <p class="text-sm text-gray-600">{{ $alert->min_lux }} - {{ $alert->max_lux }}
                                            لوکس</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($alert->temp_active)
                            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                    <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M18.1 17.6A7.2 7.2 0 0 1 12 21a6.6 6.6 0 0 1-5.8-3c-2.7-4.6.3-8.8.9-9.7A4.4 4.4 0 0 0 8 4c1.3 1 6.4 3.3 5.5 10.6 1.5-1.1 2.7-3 2.9-6.2 1.4 1 4 5.5 1.7 9.2Z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">دما</h4>
                                        <p class="text-sm text-gray-600">{{ $alert->min_temp }} - {{ $alert->max_temp }}
                                            °C</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($alert->wind_active)
                            <div class="bg-sky-50 border border-sky-200 rounded-xl p-4">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                    <div class="w-10 h-10 bg-sky-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M11.8 5.7A4.8 4.8 0 0 0 7 10a3.4 3.4 0 0 1 2.7-1.7c1.7 0 3 2 3.8 2.6a5.7 5.7 0 0 0 5.4 1c2-.7 2.9-3 3.1-4-1 1.4-2.4 2.2-4.3 1.2-1.2-.6-2.1-3.4-6-3.3Zm-5 6.3A4.8 4.8 0 0 0 2 16.2a3.4 3.4 0 0 1 2.7-1.7c1.7 0 3 2 3.8 2.6a5.7 5.7 0 0 0 5.4.9c2-.7 3-2.9 3.1-4-1 1.4-2.4 2.3-4.2 1.3-1.3-.7-2.2-3.4-6-3.3Z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">سرعت باد</h4>
                                        <p class="text-sm text-gray-600">{{ $alert->min_wind }} - {{ $alert->max_wind }}
                                            km/h</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($alert->humidity_active)
                            <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-width="2"
                                                  d="M4.4 7.7c2 .5 2.4 2.8 3.2 3.8 1 1.4 2 1.3 3.2 2.7 1.8 2.3 1.3 5.7 1.3 6.7M20 15h-1a4 4 0 0 0-4 4v1M8.6 4c0 .8.1 1.9 1.5 2.6 1.4.7 3 .3 3 2.3 0 .3 0 2 1.9 2 2 0 2-1.7 2-2 0-.6.5-.9 1.2-.9H20m1 4a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">رطوبت</h4>
                                        <p class="text-sm text-gray-600">{{ $alert->min_humidity }}
                                            - {{ $alert->max_humidity }}%</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .parameter-card {
            transition: all 0.3s ease;
        }

        .parameter-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .parameter-card.active {
            border-color: rgb(var(--color-primary));
            background-color: rgb(var(--color-primary) / 0.05);
        }

        .range-input:focus {
            ring-width: 2px;
            ring-color: rgb(var(--color-primary));
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize form interactions
            initializeAlertForm();
        });

        function initializeAlertForm() {
            // Handle checkbox changes
            const checkboxes = document.querySelectorAll('input[type="checkbox"][data-parameter]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    toggleParameterInputs(this.dataset.parameter, this.checked);
                });

                // Initialize state
                toggleParameterInputs(checkbox.dataset.parameter, checkbox.checked);
            });
        }

        function toggleParameterInputs(parameter, isActive) {
            const inputs = document.querySelectorAll(`input[data-parameter="${parameter}"]`);
            const card = document.querySelector(`[data-card="${parameter}"]`);

            inputs.forEach(input => {
                if (input.type !== 'checkbox') {
                    input.disabled = !isActive;
                    if (!isActive) {
                        input.value = '';
                    }
                }
            });

            if (card) {
                card.classList.toggle('active', isActive);
            }
        }

        // Form submission with validation
        document.getElementById('alertForm')?.addEventListener('submit', function (e) {
            e.preventDefault();

            if (validateForm()) {
                submitForm(this);
            }
        });

        function validateForm() {
            const errors = [];

            // Check each active parameter
            ['lux', 'temp', 'wind', 'humidity'].forEach(param => {
                const checkbox = document.querySelector(`input[name="${param}_active"]`);
                if (checkbox && checkbox.checked) {
                    const minInput = document.querySelector(`input[name="min_${param}"]`);
                    const maxInput = document.querySelector(`input[name="max_${param}"]`);

                    if (!minInput.value || !maxInput.value) {
                        errors.push(`برای ${getParameterName(param)}، هر دو مقدار حداقل و حداکثر الزامی است.`);
                    } else if (parseFloat(minInput.value) >= parseFloat(maxInput.value)) {
                        errors.push(`برای ${getParameterName(param)}، مقدار حداکثر باید بزرگتر از حداقل باشد.`);
                    }
                }
            });

            if (errors.length > 0) {
                errors.forEach(error => showToast(error, 'error'));
                return false;
            }

            return true;
        }

        function getParameterName(param) {
            const names = {
                'lux': 'روشنایی',
                'temp': 'دما',
                'wind': 'سرعت باد',
                'humidity': 'رطوبت'
            };
            return names[param] || param;
        }

        function submitForm(form) {
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                در حال ذخیره...
            `;

            // Submit form
            fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');
                        // Optionally reload page to show updated settings
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        throw new Error(data.message || 'خطا در ذخیره اطلاعات');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast(error.message || 'خطا در ذخیره اطلاعات', 'error');
                })
                .finally(() => {
                    // Reset button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
        }

        // Toast notification function (reuse from companies)
        function showToast(message, type = 'info') {
            // Implementation same as companies module
            if (typeof window.showToast === 'function') {
                window.showToast(message, type);
            } else {
                alert(message); // Fallback
            }
        }
    </script>
@endpush
