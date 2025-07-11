<!-- City Edit Form -->
<form id="cityForm">
    @csrf
    @method('PUT')

    <!-- Province Field -->
    <div class="mb-6">
        <label for="province_id" class="block text-sm font-medium text-gray-700 mb-2">
            استان <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <select id="province_id"
                    name="province_id"
                    class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white text-gray-900 transition-all duration-200"
                    required>
                <option value="">انتخاب استان...</option>
                @foreach($provinces as $province)
                    <option value="{{ $province->id }}" {{ $city->province_id == $province->id ? 'selected' : '' }}>
                        {{ $province->name }}
                    </option>
                @endforeach
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
            </div>
        </div>
        <p class="mt-2 text-xs text-gray-500">
            تغییر استان ممکن است بر ترتیب نمایش تأثیر بگذارد
        </p>
    </div>

    <!-- Name Field -->
    <div class="mb-6">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
            نام شهر <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <input type="text"
                   id="name"
                   name="name"
                   value="{{ $city->name }}"
                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white text-gray-900 transition-all duration-200"
                   placeholder="نام شهر را وارد کنید"
                   required>
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
        <p class="mt-2 text-xs text-gray-500">
            نام شهر در هر استان باید منحصر به فرد باشد
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
                   value="{{ $city->sort_order }}"
                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white text-gray-900 transition-all duration-200"
                   placeholder="ترتیب نمایش">
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                </svg>
            </div>
        </div>
        <p class="mt-2 text-xs text-gray-500">
            عدد کمتر نشان‌دهنده ترتیب بالاتر در استان است
        </p>
    </div>

    <!-- Status Field -->
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-3">
            وضعیت
        </label>
        <div class="flex items-center space-x-3 rtl:space-x-reverse">
            <label class="inline-flex items-center">
                <input type="radio" name="active" value="1" {{ $city->active ? 'checked' : '' }}
                class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 focus:ring-emerald-500 focus:ring-2">
                <span class="mr-2 text-sm font-medium text-gray-900">فعال</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="active" value="0" {{ !$city->active ? 'checked' : '' }}
                class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 focus:ring-emerald-500 focus:ring-2">
                <span class="mr-2 text-sm font-medium text-gray-900">غیرفعال</span>
            </label>
        </div>
        <p class="mt-2 text-xs text-gray-500">
            شهرهای غیرفعال در لیست‌های عمومی نمایش داده نمی‌شوند
        </p>
    </div>

    <!-- City Info -->
    <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-xl">
        <h4 class="text-sm font-medium text-gray-700 mb-2 flex items-center">
            <svg class="w-4 h-4 ml-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            اطلاعات شهر
        </h4>
        <div class="space-y-2 text-sm">
            <div class="flex items-center justify-between">
                <span class="text-gray-600">استان فعلی:</span>
                <span class="font-medium text-gray-900">{{ $city->province->name }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-gray-600">نام کامل:</span>
                <span class="font-medium text-gray-900">{{ $city->full_name }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-gray-600">شناسه منحصر:</span>
                <span class="font-mono text-gray-900 bg-white px-2 py-1 rounded border">{{ $city->slug }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-gray-600">تاریخ ایجاد:</span>
                <span class="font-medium text-gray-900">{{ $city->created_at->format('Y/m/d H:i') }}</span>
            </div>
        </div>
    </div>

    <!-- Preview Box -->
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
        <h4 class="text-sm font-medium text-emerald-800 mb-2 flex items-center">
            <svg class="w-4 h-4 ml-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            پیش‌نمایش تغییرات
        </h4>
        <div class="space-y-2 text-sm">
            <div class="flex items-center justify-between">
                <span class="text-emerald-700">استان:</span>
                <span class="font-medium text-emerald-900" id="previewProvince">{{ $city->province->name }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-emerald-700">نام شهر:</span>
                <span class="font-medium text-emerald-900" id="previewName">{{ $city->name }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-emerald-700">ترتیب نمایش:</span>
                <span class="font-medium text-emerald-900" id="previewSort">{{ $city->sort_order }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-emerald-700">وضعیت:</span>
                <span class="font-medium text-emerald-900"
                      id="previewStatus">{{ $city->active ? 'فعال' : 'غیرفعال' }}</span>
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
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            بروزرسانی شهر
            <div class="mr-2 opacity-0 transition-opacity duration-200" id="submitLoading">
                <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
            </div>
        </button>
    </div>
</form>

<script>
    // Real-time preview updates
    $('#province_id').on('change', function () {
        const provinceName = $(this).find('option:selected').text() || 'انتخاب نشده';
        $('#previewProvince').text(provinceName);
    });

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
    $('#cityForm').on('submit', function (e) {
        const provinceInput = $('#province_id');
        const nameInput = $('#name');

        // Validate required province
        if (!provinceInput.val()) {
            e.preventDefault();
            showToast('انتخاب استان الزامی است', 'error');
            provinceInput.focus();
            return false;
        }

        // Validate required name
        if (!nameInput.val().trim()) {
            e.preventDefault();
            showToast('نام شهر الزامی است', 'error');
            nameInput.focus();
            return false;
        }

        // Validate name length
        if (nameInput.val().trim().length < 2) {
            e.preventDefault();
            showToast('نام شهر باید حداقل 2 کاراکتر باشد', 'error');
            nameInput.focus();
            return false;
        }
    });

    // Auto-focus on first input
    setTimeout(() => {
        $('#province_id').focus();
    }, 300);
</script>
