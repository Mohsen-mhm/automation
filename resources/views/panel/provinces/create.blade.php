<!-- Province Create Form -->
<form id="provinceForm">
    @csrf

    <!-- Name Field -->
    <div class="mb-6">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
            نام استان <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <input type="text"
                   id="name"
                   name="name"
                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                   placeholder="نام استان را وارد کنید"
                   required>
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
            </div>
        </div>
        <p class="mt-2 text-xs text-gray-500">
            نام استان باید منحصر به فرد باشد
        </p>
    </div>

    <!-- Sort Order Field -->
    <div class="mb-6">
        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
            ترتیب نمایش
        </label>
        <div class="relative">
            <input type="number"
                   id="sort_order"
                   name="sort_order"
                   min="0"
                   value="0"
                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                   placeholder="ترتیب نمایش">
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                </svg>
            </div>
        </div>
        <p class="mt-2 text-xs text-gray-500">
            عدد کمتر نشان‌دهنده ترتیب بالاتر است
        </p>
    </div>

    <!-- Status Field -->
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-3">
            وضعیت
        </label>
        <div class="flex items-center space-x-3 rtl:space-x-reverse">
            <label class="inline-flex items-center">
                <input type="radio" name="active" value="1" checked
                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                <span class="mr-2 text-sm font-medium text-gray-900">فعال</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="active" value="0"
                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                <span class="mr-2 text-sm font-medium text-gray-900">غیرفعال</span>
            </label>
        </div>
        <p class="mt-2 text-xs text-gray-500">
            استان‌های غیرفعال در لیست‌های عمومی نمایش داده نمی‌شوند
        </p>
    </div>

    <!-- Preview Box -->
    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
        <h4 class="text-sm font-medium text-blue-800 mb-2 flex items-center">
            <svg class="w-4 h-4 ml-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            پیش‌نمایش
        </h4>
        <div class="space-y-2 text-sm">
            <div class="flex items-center justify-between">
                <span class="text-blue-700">نام استان:</span>
                <span class="font-medium text-blue-900" id="previewName">-</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-blue-700">ترتیب نمایش:</span>
                <span class="font-medium text-blue-900" id="previewSort">0</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-blue-700">وضعیت:</span>
                <span class="font-medium text-blue-900" id="previewStatus">فعال</span>
            </div>
        </div>
    </div>

    <!-- Submit Buttons -->
    <div class="flex justify-end space-x-3 rtl:space-x-reverse pt-4 border-t border-gray-200">
        <button type="button"
                onclick="closeModal()"
                class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 font-medium">
            انصراف
        </button>
        <button type="submit"
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            ثبت استان
            <div class="mr-2 opacity-0 transition-opacity duration-200" id="submitLoading">
                <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
            </div>
        </button>
    </div>
</form>

<script>
    // Real-time preview updates
    $('#name').on('input', function () {
        const name = $(this).val().trim() || '-';
        $('#previewName').text(name);
    });

    $('#sort_order').on('input', function () {
        const sortOrder = $(this).val() || '0';
        $('#previewSort').text(sortOrder);
    });

    $('input[name="active"]').on('change', function () {
        const status = $(this).val() === '1' ? 'فعال' : 'غیرفعال';
        $('#previewStatus').text(status);
    });

    // Form validation
    $('#provinceForm').on('submit', function (e) {
        const nameInput = $('#name');

        // Validate required name
        if (!nameInput.val().trim()) {
            e.preventDefault();
            showToast('نام استان الزامی است', 'error');
            nameInput.focus();
            return false;
        }

        // Validate name length
        if (nameInput.val().trim().length < 2) {
            e.preventDefault();
            showToast('نام استان باید حداقل 2 کاراکتر باشد', 'error');
            nameInput.focus();
            return false;
        }
    });

    // Auto-focus on first input
    setTimeout(() => {
        $('#name').focus();
    }, 300);
</script>
