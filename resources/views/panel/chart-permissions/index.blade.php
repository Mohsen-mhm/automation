{{-- resources/views/panel/chart-permissions/index.blade.php --}}
@extends('layouts.app')

@section('title', 'مدیریت دسترسی نمودارها')

@section('content')
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center ml-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        مدیریت دسترسی نمودارها
                    </h1>
                    <p class="text-gray-600 mt-1">تعیین نمودارهای قابل نمایش برای هر نقش کاربری</p>
                </div>
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    <button onclick="saveAllPermissions()"
                            class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        ذخیره تغییرات
                    </button>
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">نقش مدیر</p>
                        <p class="text-lg font-bold">همه نمودارها</p>
                        <p class="text-blue-200 text-xs mt-1">دسترسی کامل</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium">نقش شرکت</p>
                        <p class="text-lg font-bold" id="companyChartsCount">-</p>
                        <p class="text-emerald-200 text-xs mt-1">نمودار فعال</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-amber-500 to-amber-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-100 text-sm font-medium">نقش گلخانه</p>
                        <p class="text-lg font-bold" id="greenhouseChartsCount">-</p>
                        <p class="text-amber-200 text-xs mt-1">نمودار فعال</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.242 7.194a24.16 24.16 0 0 1 3.72-3.062m0 0c3.443-2.277 6.732-2.969 8.24-1.46 2.054 2.053.03 7.407-4.522 11.959-4.552 4.551-9.906 6.576-11.96 4.522C1.223 17.658 1.89 14.412 4.121 11m6.838-6.868c-3.443-2.277-6.732-2.969-8.24-1.46-2.054 2.053-.03 7.407 4.522 11.959m3.718-10.499a24.16 24.16 0 0 1 3.719 3.062M17.798 11c2.23 3.412 2.898 6.658 1.402 8.153-1.502 1.503-4.771.822-8.2-1.433m1-6.808a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">نقش سازمانی</p>
                        <p class="text-lg font-bold" id="organizationChartsCount">-</p>
                        <p class="text-purple-200 text-xs mt-1">نمودار فعال</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Permissions Table -->
        @foreach($categories as $categoryKey => $categoryName)
            @if($chartPermissions->has($categoryKey))
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center ml-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            {{ $categoryName }}
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    نام نمودار
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center justify-center space-x-2 rtl:space-x-reverse">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <span>شرکت</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center justify-center space-x-2 rtl:space-x-reverse">
                                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.242 7.194a24.16 24.16 0 0 1 3.72-3.062m0 0c3.443-2.277 6.732-2.969 8.24-1.46 2.054 2.053.03 7.407-4.522 11.959-4.552 4.551-9.906 6.576-11.96 4.522C1.223 17.658 1.89 14.412 4.121 11m6.838-6.868c-3.443-2.277-6.732-2.969-8.24-1.46-2.054 2.053-.03 7.407 4.522 11.959m3.718-10.499a24.16 24.16 0 0 1 3.719 3.062M17.798 11c2.23 3.412 2.898 6.658 1.402 8.153-1.502 1.503-4.771.822-8.2-1.433m1-6.808a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/>
                                        </svg>
                                        <span>گلخانه</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center justify-center space-x-2 rtl:space-x-reverse">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <span>سازمانی</span>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($chartPermissions[$categoryKey] as $permission)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full ml-3"></div>
                                            <span class="text-sm font-medium text-gray-900">{{ $permission->chart_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox"
                                                   class="chart-permission-toggle w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500 focus:ring-2"
                                                   data-chart="{{ $permission->chart_key }}"
                                                   data-role="company"
                                                {{ $permission->company_visible ? 'checked' : '' }}>
                                        </label>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox"
                                                   class="chart-permission-toggle w-4 h-4 text-amber-600 bg-gray-100 border-gray-300 rounded focus:ring-amber-500 focus:ring-2"
                                                   data-chart="{{ $permission->chart_key }}"
                                                   data-role="greenhouse"
                                                {{ $permission->greenhouse_visible ? 'checked' : '' }}>
                                        </label>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox"
                                                   class="chart-permission-toggle w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500 focus:ring-2"
                                                   data-chart="{{ $permission->chart_key }}"
                                                   data-role="organization"
                                                {{ $permission->organization_visible ? 'checked' : '' }}>
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endforeach

        <!-- Bulk Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">عملیات گروهی</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">شرکت‌ها</label>
                    <div class="space-y-2">
                        <button onclick="toggleAllForRole('company', true)"
                                class="w-full px-4 py-2 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg transition-colors duration-200 text-sm">
                            فعال کردن همه
                        </button>
                        <button onclick="toggleAllForRole('company', false)"
                                class="w-full px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors duration-200 text-sm">
                            غیرفعال کردن همه
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">گلخانه‌ها</label>
                    <div class="space-y-2">
                        <button onclick="toggleAllForRole('greenhouse', true)"
                                class="w-full px-4 py-2 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg transition-colors duration-200 text-sm">
                            فعال کردن همه
                        </button>
                        <button onclick="toggleAllForRole('greenhouse', false)"
                                class="w-full px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors duration-200 text-sm">
                            غیرفعال کردن همه
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">کاربران سازمانی</label>
                    <div class="space-y-2">
                        <button onclick="toggleAllForRole('organization', true)"
                                class="w-full px-4 py-2 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg transition-colors duration-200 text-sm">
                            فعال کردن همه
                        </button>
                        <button onclick="toggleAllForRole('organization', false)"
                                class="w-full px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors duration-200 text-sm">
                            غیرفعال کردن همه
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            updateRoleCounts();

            // Bind individual toggle events
            document.querySelectorAll('.chart-permission-toggle').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateRoleCounts();
                });
            });
        });

        function updateRoleCounts() {
            const companyCount = document.querySelectorAll('input[data-role="company"]:checked').length;
            const greenhouseCount = document.querySelectorAll('input[data-role="greenhouse"]:checked').length;
            const organizationCount = document.querySelectorAll('input[data-role="organization"]:checked').length;

            document.getElementById('companyChartsCount').textContent = companyCount;
            document.getElementById('greenhouseChartsCount').textContent = greenhouseCount;
            document.getElementById('organizationChartsCount').textContent = organizationCount;
        }

        function toggleAllForRole(role, enabled) {
            document.querySelectorAll(`input[data-role="${role}"]`).forEach(checkbox => {
                checkbox.checked = enabled;
            });
            updateRoleCounts();
        }

        function saveAllPermissions() {
            const permissions = {};

            document.querySelectorAll('.chart-permission-toggle').forEach(checkbox => {
                const chartKey = checkbox.dataset.chart;
                const role = checkbox.dataset.role;
                const isChecked = checkbox.checked;

                if (!permissions[chartKey]) {
                    permissions[chartKey] = {};
                }
                permissions[chartKey][role] = isChecked;
            });

            // Show loading
            const saveButton = event.target;
            const originalText = saveButton.innerHTML;
            saveButton.disabled = true;
            saveButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                در حال ذخیره...
            `;

            // Send AJAX request
            fetch('{{ route("panel.chart-permissions.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    permissions: permissions
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');
                    } else {
                        showToast(data.message || 'خطا در ذخیره تنظیمات', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('خطا در ارتباط با سرور', 'error');
                })
                .finally(() => {
                    saveButton.disabled = false;
                    saveButton.innerHTML = originalText;
                });
        }

        function showToast(message, type = 'info') {
            const toastId = 'toast_' + Date.now();
            const iconMap = {
                success: '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>',
                error: '<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>',
                info: '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>'
            };

            const colorMap = {
                success: 'text-green-500 bg-green-100',
                error: 'text-red-500 bg-red-100',
                info: 'text-blue-500 bg-blue-100'
            };

            const toast = document.createElement('div');
            toast.id = toastId;
            toast.className = `fixed bottom-5 left-5 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow-lg transform translate-x-full transition-all duration-300 border-l-4 ${type === 'success' ? 'border-green-500' : type === 'error' ? 'border-red-500' : 'border-blue-500'}`;

            toast.innerHTML = `
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg ${colorMap[type]}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        ${iconMap[type]}
                    </svg>
                </div>
                <div class="mr-3 text-sm font-normal">${message}</div>
                <button type="button" onclick="removeToast('${toastId}')" class="mr-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;

            document.body.appendChild(toast);
            setTimeout(() => toast.classList.remove('translate-x-full'), 100);
            setTimeout(() => removeToast(toastId), 5000);
        }

        function removeToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.add('translate-x-full');
                setTimeout(() => toast.remove(), 300);
            }
        }
    </script>
@endpush
