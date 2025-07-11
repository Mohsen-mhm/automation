<form id="editForm" class="space-y-6" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Basic Info -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-blue-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            اطلاعات پایه گلخانه
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    نام گلخانه
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ $greenhouse->name }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="گلخانه محمدی">
            </div>

            <div>
                <label for="licence_number" class="block text-sm font-medium text-gray-700 mb-2">
                    شماره پروانه
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="licence_number" name="licence_number" value="{{ $greenhouse->licence_number }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="4689496584">
            </div>

            <div>
                <label for="substrate_type" class="block text-sm font-medium text-gray-700 mb-2">
                    نوع بستر
                    <span class="text-red-500">*</span>
                </label>
                <select id="substrate_type" name="substrate_type" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200">
                    <option value="">نوع بستر را انتخاب کنید</option>
                    @foreach($substrates as $substrate)
                        <option value="{{ $substrate }}" {{ $greenhouse->substrate_type === $substrate ? 'selected' : '' }}>{{ $substrate }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="product_type" class="block text-sm font-medium text-gray-700 mb-2">
                    نوع محصول
                    <span class="text-red-500">*</span>
                </label>
                <select id="product_type" name="product_type" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200">
                    <option value="">نوع محصول را انتخاب کنید</option>
                    @foreach($productTypes as $productType)
                        <option value="{{ $productType }}" {{ $greenhouse->product_type === $productType ? 'selected' : '' }}>{{ $productType }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="meterage" class="block text-sm font-medium text-gray-700 mb-2">
                    متراژ
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="meterage" name="meterage" value="{{ $greenhouse->meterage }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="2000 متر مربع">
            </div>

            <div>
                <label for="greenhouse_status" class="block text-sm font-medium text-gray-700 mb-2">
                    وضعیت گلخانه
                    <span class="text-red-500">*</span>
                </label>
                <select id="greenhouse_status" name="greenhouse_status" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200">
                    <option value="">وضعیت را انتخاب کنید</option>
                    @foreach($greenhouseStatuses as $status)
                        <option value="{{ $status }}" {{ $greenhouse->greenhouse_status === $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="construction_date" class="block text-sm font-medium text-gray-700 mb-2">
                    تاریخ احداث
                </label>
                <input type="text" id="construction_date" name="construction_date" value="{{ $construction_date }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="1400/05/24">
            </div>

            <div>
                <label for="operation_date" class="block text-sm font-medium text-gray-700 mb-2">
                    تاریخ بهره برداری
                </label>
                <input type="text" id="operation_date" name="operation_date" value="{{ $operation_date }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="1401/03/25">
            </div>
        </div>
    </div>

    <!-- Owner Info -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-blue-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            اطلاعات مالک
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-2">
                    نام مالک
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="owner_name" name="owner_name" value="{{ $greenhouse->owner_name }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="محسن محمدی">
            </div>

            <div>
                <label for="owner_phone" class="block text-sm font-medium text-gray-700 mb-2">
                    تلفن همراه مالک
                    <span class="text-red-500">*</span>
                </label>
                <input type="tel" id="owner_phone" name="owner_phone" value="{{ $greenhouse->owner_phone }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="09123456789">
            </div>

            <div>
                <label for="owner_national_id" class="block text-sm font-medium text-gray-700 mb-2">
                    کد ملی مالک
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="owner_national_id" name="owner_national_id" value="{{ $greenhouse->owner_national_id }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="2281234567">
            </div>

            <div class="flex items-center space-x-6 rtl:space-x-reverse">
                <div class="flex items-center">
                    <input type="hidden" name="climate_system" value="0">
                    <input type="checkbox" id="climate_system" name="climate_system" value="1"
                           {{ $greenhouse->climate_system ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="climate_system" class="mr-2 text-sm font-medium text-gray-700">
                        دارای سامانه کنترل اقلیم
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="hidden" name="feeding_system" value="0">
                    <input type="checkbox" id="feeding_system" name="feeding_system" value="1"
                           {{ $greenhouse->feeding_system ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="feeding_system" class="mr-2 text-sm font-medium text-gray-700">
                        دارای سامانه تغذیه و آبیاری
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Location Info -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-blue-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            اطلاعات مکانی
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="province" class="block text-sm font-medium text-gray-700 mb-2">
                    استان
                    <span class="text-red-500">*</span>
                </label>
                <select id="province" name="province"
                        class="province-select w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                        required>
                    <option value="">استان را انتخاب کنید</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province->name }}" {{ $greenhouse->province->name === $province->name ? 'selected' : '' }}>{{ $province->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                    شهر
                    <span class="text-red-500">*</span>
                </label>
                <select id="city" name="city"
                        class="city-select w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                        required>
                    <option value="{{ $greenhouse->city->name }}" selected>{{ $greenhouse->city->name }}</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                    آدرس
                    <span class="text-red-500">*</span>
                </label>
                <textarea id="address" name="address" rows="3" required
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                          placeholder="بلوار پاسداران، ...">{{ $greenhouse->address }}</textarea>
            </div>

            <div>
                <label for="postal" class="block text-sm font-medium text-gray-700 mb-2">
                    کد پستی
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="postal" name="postal" value="{{ $greenhouse->postal }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="7181234567">
            </div>

            <div>
                <label for="location_link" class="block text-sm font-medium text-gray-700 mb-2">
                    لینک موقعیت گوگل مپ
                    <span class="text-red-500">*</span>
                </label>
                <input type="url" id="location_link" name="location_link" value="{{ $greenhouse->location_link }}"
                       class="location-link w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       required
                       placeholder="https://maps.app.goo.gl/...">
            </div>

            <div class="md:col-span-2 coordinates-display bg-white rounded-lg p-4 border border-gray-200">
                @if($greenhouse->coordinates)
                    <p>مختصات: <strong class="text-blue-600">{{ $greenhouse->coordinates }}</strong></p>
                    <p>عرض جغرافیایی: <strong class="text-blue-600">{{ $greenhouse->latitude }}</strong></p>
                    <p>طول جغرافیایی: <strong class="text-blue-600">{{ $greenhouse->longitude }}</strong></p>
                @else
                    <p class="text-gray-500 text-sm">مختصات جغرافیایی پس از وارد کردن لینک موقعیت نمایش داده خواهد شد</p>
                @endif
            </div>
        </div>
    </div>

    <!-- File Uploads -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-blue-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            مدارک و فایل‌ها
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="operation_licence" class="block text-sm font-medium text-gray-700 mb-2">
                    پروانه بهره برداری
                    @if($greenhouse->operation_licence)
                        <span class="text-sm text-green-600">(فایل موجود)</span>
                    @endif
                </label>
                <input type="file" id="operation_licence" name="operation_licence" accept="image/*"
                       class="w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                @if($greenhouse->operation_licence)
                    <div class="mt-2">
                        <img src="{{ asset($greenhouse->operation_licence) }}" alt="پروانه بهره برداری"
                             class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                    </div>
                @endif
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    تصویر گلخانه
                    @if($greenhouse->image)
                        <span class="text-sm text-green-600">(فایل موجود)</span>
                    @endif
                </label>
                <input type="file" id="image" name="image" accept="image/*"
                       class="w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                @if($greenhouse->image)
                    <div class="mt-2">
                        <img src="{{ asset($greenhouse->image) }}" alt="تصویر گلخانه"
                             class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                    </div>
                @endif
            </div>
        </div>
    </div>

    @can(\App\Models\Greenhouse::GREENHOUSE_CONFIRM)
        <!-- Status -->
        <div class="bg-gray-50 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-blue-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                وضعیت
            </h3>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    وضعیت گلخانه
                </label>
                <select id="status" name="status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200">
                    <option value="">وضعیت را انتخاب کنید</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status['name'] }}" {{ $greenhouse->status === $status['name'] ? 'selected' : '' }}>{{ $status['title'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endcan

    <!-- Submit Button -->
    <div class="flex justify-end space-x-3 rtl:space-x-reverse pt-6 border-t border-gray-200">
        <button type="button" onclick="closeEditModal()"
                class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 font-medium">
            انصراف
        </button>
        <button type="submit"
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-600 hover:from-blue-600 hover:to-cyan-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            اعمال تغییرات
        </button>
    </div>
</form>
