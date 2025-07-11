<!-- String Configuration Edit Form -->
<form id="editConfigForm" data-config-type="string">
    @csrf
    @method('PUT')
    <input type="hidden" name="config_id" value="{{ $config->id }}">

    <!-- Title Field (Read Only) -->
    <div class="mb-6">
        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
            عنوان
        </label>
        <input type="text"
               id="title"
               name="title"
               value="{{ $config->title }}"
               class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 text-gray-600 transition-all duration-200"
               readonly>
    </div>

    <!-- Value Field -->
    <div class="mb-6">
        <label for="value" class="block text-sm font-medium text-gray-700 mb-2">
            مقدار
            <span class="text-xs text-gray-500">(مقدار پیکربندی)</span>
        </label>
        <div class="relative">
            <input type="text"
                   id="value"
                   name="value"
                   value="{{ $string_value }}"
                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white text-gray-900 transition-all duration-200"
                   placeholder="مقدار پیکربندی را وارد کنید">
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
        <p class="mt-2 text-xs text-gray-500">
            این مقدار برای پیکربندی سیستم استفاده می‌شود
        </p>
    </div>

    <!-- Configuration Preview -->
    <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-xl">
        <h4 class="text-sm font-medium text-gray-700 mb-2 flex items-center">
            <svg class="w-4 h-4 ml-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            پیش‌نمایش پیکربندی
        </h4>
        <div class="space-y-2 text-sm">
            <div class="flex items-center justify-between">
                <span class="text-gray-600">عنوان:</span>
                <span class="font-medium text-gray-900">{{ $config->title }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-gray-600">نوع:</span>
                <span
                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    متنی
                </span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-gray-600">مقدار فعلی:</span>
                <span class="font-mono text-gray-900 bg-white px-2 py-1 rounded border max-w-xs truncate"
                      title="{{ $string_value }}">
                    {{ $string_value }}
                </span>
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
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            اعمال تغییرات
            <div class="mr-2 opacity-0 transition-opacity duration-200" id="submitLoading">
                <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
            </div>
        </button>
    </div>
</form>

<script>
    // Real-time preview update
    document.getElementById('value').addEventListener('input', function () {
        const previewValue = document.querySelector('.font-mono.text-gray-900');
        if (previewValue) {
            const newValue = this.value || 'خالی';
            previewValue.textContent = newValue;
            previewValue.setAttribute('title', newValue);
        }
    });

    // Form validation
    document.getElementById('editConfigForm').addEventListener('submit', function (e) {
        const valueInput = document.getElementById('value');

        // Validate required value
        if (!valueInput.value.trim()) {
            e.preventDefault();
            showToast('مقدار پیکربندی الزامی است', 'error');
            valueInput.focus();
            return false;
        }
    });
</script>
