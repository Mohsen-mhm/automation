<!-- JSON Configuration Edit Form -->
<form id="editConfigForm" data-config-type="json">
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

    <!-- JSON Values Section -->
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-3">
            مقادیر
            <span class="text-xs text-gray-500">(لیست مقادیر قابل انتخاب)</span>
        </label>

        <!-- Current Values Display -->
        <div id="jsonValuesList"
             class="space-y-2 mb-4 max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-3 bg-gray-50">
            @forelse($json_values as $index => $item)
                <div
                    class="json-value-item flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg shadow-sm group hover:shadow-md transition-all duration-200"
                    data-index="{{ $index }}">
                    <div class="flex items-center space-x-3 rtl:space-x-reverse flex-1">
                        <div
                            class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-sm font-medium">
                            {{ $index + 1 }}
                        </div>
                        <span class="text-gray-900 font-medium">{{ $item['value'] }}</span>
                        <input type="hidden" name="json_values[]" value="{{ $item['value'] }}">
                    </div>
                    <button type="button"
                            onclick="removeJsonValue({{ $index }})"
                            class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all duration-200 opacity-0 group-hover:opacity-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @empty
                <div id="emptyState" class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-sm">هیچ مقداری تعریف نشده است</p>
                </div>
            @endforelse
        </div>

        <!-- Add New Value -->
        <div class="flex gap-3">
            <div class="flex-1">
                <input type="text"
                       id="newJsonValue"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="افزودن مقدار جدید...">
            </div>
            <button type="button"
                    onclick="addJsonValue()"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-200 flex items-center space-x-2 rtl:space-x-reverse shadow-sm hover:shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>افزودن</span>
            </button>
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
            اعمال تغییرات
            <div class="mr-2 opacity-0 transition-opacity duration-200" id="submitLoading">
                <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
            </div>
        </button>
    </div>
</form>

<script>
    let jsonValueIndex = {{ count($json_values) }};

    function addJsonValue() {
        const input = document.getElementById('newJsonValue');
        const value = input.value.trim();

        if (!value) {
            showToast('لطفا مقداری وارد کنید', 'error');
            return;
        }

        // Check for duplicates
        const existingValues = Array.from(document.querySelectorAll('input[name="json_values[]"]')).map(input => input.value);
        if (existingValues.includes(value)) {
            showToast('این مقدار قبلاً اضافه شده است', 'error');
            return;
        }

        const container = document.getElementById('jsonValuesList');
        const emptyState = document.getElementById('emptyState');

        if (emptyState) {
            emptyState.remove();
        }

        const itemDiv = document.createElement('div');
        itemDiv.className = 'json-value-item flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg shadow-sm group hover:shadow-md transition-all duration-200';
        itemDiv.setAttribute('data-index', jsonValueIndex);

        itemDiv.innerHTML = `
            <div class="flex items-center space-x-3 rtl:space-x-reverse flex-1">
                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-sm font-medium">
                    ${jsonValueIndex + 1}
                </div>
                <span class="text-gray-900 font-medium">${value}</span>
                <input type="hidden" name="json_values[]" value="${value}">
            </div>
            <button type="button"
                    onclick="removeJsonValue(${jsonValueIndex})"
                    class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all duration-200 opacity-0 group-hover:opacity-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;

        container.appendChild(itemDiv);
        input.value = '';
        jsonValueIndex++;

        // Animate the new item
        itemDiv.style.opacity = '0';
        itemDiv.style.transform = 'translateY(-10px)';
        requestAnimationFrame(() => {
            itemDiv.style.transition = 'all 0.3s ease';
            itemDiv.style.opacity = '1';
            itemDiv.style.transform = 'translateY(0)';
        });

        showToast('مقدار جدید اضافه شد', 'success');
    }

    function removeJsonValue(index) {
        const item = document.querySelector(`[data-index="${index}"]`);
        if (item) {
            item.style.transition = 'all 0.3s ease';
            item.style.opacity = '0';
            item.style.transform = 'translateX(20px)';

            setTimeout(() => {
                item.remove();
                updateNumbering();

                // Check if list is empty
                const container = document.getElementById('jsonValuesList');
                if (container.children.length === 0) {
                    container.innerHTML = `
                        <div id="emptyState" class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-sm">هیچ مقداری تعریف نشده است</p>
                        </div>
                    `;
                }
            }, 300);

            showToast('مقدار حذف شد', 'info');
        }
    }

    function updateNumbering() {
        const items = document.querySelectorAll('.json-value-item');
        items.forEach((item, index) => {
            const numberSpan = item.querySelector('.w-8.h-8');
            if (numberSpan) {
                numberSpan.textContent = index + 1;
            }
        });
    }

    // Handle Enter key in input
    document.getElementById('newJsonValue').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addJsonValue();
        }
    });
</script>
