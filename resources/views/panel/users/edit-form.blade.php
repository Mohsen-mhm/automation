<!-- User Edit Form -->
<form id="editUserForm">
    @csrf
    @method('PUT')
    <input type="hidden" name="user_id" value="{{ $user->id }}">

    <!-- User Info Display -->
    <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-xl">
        <div class="flex items-center space-x-3 rtl:space-x-reverse">
            <div
                class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                <span class="text-white text-lg font-bold">
                    {{ substr($user->name, 0, 1) }}
                </span>
            </div>
            <div>
                <h4 class="font-medium text-gray-900">{{ $user->name }}</h4>
                <p class="text-sm text-gray-500">
                    @if($user->roles->isNotEmpty())
                        {{ $user->roles->pluck('title')->implode(' | ') }}
                    @else
                        بدون نقش
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Name Field -->
    <div class="mb-6">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
            نام کاربر
            <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <input type="text"
                   id="name"
                   name="name"
                   value="{{ $user->name }}"
                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                   placeholder="نام کاربر را وارد کنید"
                   required>
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
        </div>
        <p class="mt-2 text-xs text-gray-500">
            نام کامل کاربر را وارد کنید
        </p>
    </div>

    <!-- National ID Field -->
    <div class="mb-6">
        <label for="national_id" class="block text-sm font-medium text-gray-700 mb-2">
            کد ملی / شناسه ملی
            <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <input type="text"
                   id="national_id"
                   name="national_id"
                   value="{{ $user->national_id }}"
                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200 font-mono"
                   placeholder="کد ملی یا شناسه ملی"
                   maxlength="11"
                   required>
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
        <p class="mt-2 text-xs text-gray-500">
            برای اشخاص حقیقی: کد ملی 10 رقمی، برای اشخاص حقوقی: شناسه ملی 11 رقمی
        </p>
    </div>

    <!-- Phone Number Field -->
    <div class="mb-6">
        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">
            شماره تلفن همراه
            <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <input type="tel"
                   id="phone_number"
                   name="phone_number"
                   value="{{ $user->phone_number }}"
                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200 font-mono"
                   placeholder="09xxxxxxxxx"
                   maxlength="11"
                   dir="ltr"
                   required>
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
            </div>
        </div>
        <p class="mt-2 text-xs text-gray-500">
            شماره تلفن همراه معتبر ایران (09xxxxxxxxx)
        </p>
    </div>

    <!-- Status Field -->
    <div class="mb-6">
        <label class="flex items-center space-x-3 rtl:space-x-reverse">
            <input type="checkbox"
                   name="active"
                   value="1"
                   {{ $user->active ? 'checked' : '' }}
                   class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
            <span class="text-sm font-medium text-gray-700">
                کاربر فعال است
            </span>
        </label>
        <p class="mt-2 text-xs text-gray-500 mr-8">
            کاربران غیرفعال نمی‌توانند وارد سیستم شوند
        </p>
    </div>

    <!-- User Roles Display (Read Only) -->
    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
        <h4 class="text-sm font-medium text-blue-900 mb-2 flex items-center">
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m5.586-4H17M7 7h-.586L9 4.414V7a1 1 0 01-1 1zm6-3V1.5a1.5 1.5 0 011.5 1.5V4h4a1 1 0 011 1v8a1 1 0 01-1 1H6a1 1 0 01-1-1V5a1 1 0 011-1h7z"/>
            </svg>
            نقش‌های کاربر
        </h4>
        <div class="space-y-2">
            @if($user->roles->isNotEmpty())
                @foreach($user->roles as $role)
                    <div class="flex items-center justify-between p-2 bg-white rounded-lg border border-blue-200">
                        <span class="text-sm font-medium text-gray-900">{{ $role->title }}</span>
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $role->name }}
                        </span>
                    </div>
                @endforeach
            @else
                <div class="text-center py-4">
                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L4.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                    <p class="text-sm text-gray-500">هیچ نقشی تعریف نشده است</p>
                </div>
            @endif
        </div>
        <p class="mt-3 text-xs text-blue-700">
            برای تغییر نقش‌های کاربر، با مدیر سیستم تماس بگیرید
        </p>
    </div>

    <!-- User Statistics -->
    <div class="mb-6 grid grid-cols-2 gap-4">
        <div class="p-3 bg-gray-50 rounded-lg">
            <div class="text-xs text-gray-500 mb-1">تاریخ عضویت</div>
            <div class="font-medium text-gray-900">
                {{ \Morilog\Jalali\Jalalian::fromDateTime($user->created_at)->toDateString() }}
            </div>
        </div>
        <div class="p-3 bg-gray-50 rounded-lg">
            <div class="text-xs text-gray-500 mb-1">آخرین بروزرسانی</div>
            <div class="font-medium text-gray-900">
                {{ \Morilog\Jalali\Jalalian::fromDateTime($user->updated_at)->toDateString() }}
            </div>
        </div>
    </div>

    <!-- Submit Buttons -->
    <div class="flex justify-end space-x-3 rtl:space-x-reverse pt-4 border-t border-gray-200">
        <button type="button"
                onclick="closeEditModal()"
                class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 font-medium">
            انصراف
        </button>
        <button type="submit"
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            ذخیره تغییرات
            <div class="mr-2 opacity-0 transition-opacity duration-200" id="submitLoading">
                <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
            </div>
        </button>
    </div>
</form>

<script>
    // Real-time input formatting and validation
    document.addEventListener('DOMContentLoaded', function () {
        const nationalIdInput = document.getElementById('national_id');
        const phoneInput = document.getElementById('phone_number');
        const nameInput = document.getElementById('name');

        // National ID formatting
        if (nationalIdInput) {
            nationalIdInput.addEventListener('input', function (e) {
                // Remove non-numeric characters
                let value = e.target.value.replace(/[^0-9]/g, '');
                // Limit to 11 digits
                if (value.length > 11) {
                    value = value.slice(0, 11);
                }
                e.target.value = value;
            });
        }

        // Phone number formatting
        if (phoneInput) {
            phoneInput.addEventListener('input', function (e) {
                // Remove non-numeric characters
                let value = e.target.value.replace(/[^0-9]/g, '');
                // Limit to 11 digits and ensure starts with 09
                if (value.length > 11) {
                    value = value.slice(0, 11);
                }
                if (value.length > 0 && !value.startsWith('09')) {
                    if (value.startsWith('9')) {
                        value = '0' + value;
                    }
                }
                e.target.value = value;
            });
        }

        // Name input validation
        if (nameInput) {
            nameInput.addEventListener('input', function (e) {
                // Remove leading/trailing spaces and multiple spaces
                let value = e.target.value.replace(/\s+/g, ' ').trim();
                e.target.value = value;
            });
        }
    });

    // Form validation before submit
    document.getElementById('editUserForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const name = document.getElementById('name').value.trim();
        const nationalId = document.getElementById('national_id').value.trim();
        const phoneNumber = document.getElementById('phone_number').value.trim();

        // Validate name
        if (name.length < 2) {
            showToast('نام باید حداقل 2 کاراکتر باشد', 'error');
            document.getElementById('name').focus();
            return false;
        }

        // Validate national ID
        if (nationalId.length < 10 || nationalId.length > 11) {
            showToast('کد ملی باید 10 یا 11 رقمی باشد', 'error');
            document.getElementById('national_id').focus();
            return false;
        }

        // Validate phone number
        if (phoneNumber.length !== 11 || !phoneNumber.startsWith('09')) {
            showToast('شماره تلفن باید 11 رقمی و با 09 شروع شود', 'error');
            document.getElementById('phone_number').focus();
            return false;
        }

        // If all validations pass, submit the form
        updateUser();
    });
</script>
