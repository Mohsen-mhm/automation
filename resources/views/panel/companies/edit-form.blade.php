<form id="editForm" class="space-y-6" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Company Basic Info -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-blue-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            اطلاعات پایه شرکت
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    نام شرکت
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ $company->name }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="شرکت سیمرغ">
            </div>

            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                    نوع شرکت
                    <span class="text-red-500">*</span>
                </label>
                <select id="type" name="type" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200">
                    <option value="">نوع شرکت را انتخاب کنید</option>
                    @foreach($companyTypes as $type)
                        <option
                            value="{{ $type }}" {{ $company->type === $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="national_id" class="block text-sm font-medium text-gray-700 mb-2">
                    شناسه ملی
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="national_id" name="national_id" value="{{ $company->national_id }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="1016110254">
            </div>

            <div>
                <label for="registration_number" class="block text-sm font-medium text-gray-700 mb-2">
                    شماره ثبت
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="registration_number" name="registration_number"
                       value="{{ $company->registration_number }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="123456">
            </div>

            <div>
                <label for="registration_place" class="block text-sm font-medium text-gray-700 mb-2">
                    محل ثبت
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="registration_place" name="registration_place"
                       value="{{ $company->registration_place }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="شیراز">
            </div>

            <div>
                <label for="registration_date" class="block text-sm font-medium text-gray-700 mb-2">
                    تاریخ ثبت
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="registration_date" name="registration_date" value="{{ $registration_date }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="1400/05/24">
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
                <label for="province_id" class="block text-sm font-medium text-gray-700 mb-2">
                    استان
                    <span class="text-red-500">*</span>
                </label>
                <select id="province_id" name="province_id"
                        class="province-select w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                        required>
                    <option value="">استان را انتخاب کنید</option>
                    @foreach($provinces as $province)
                        <option
                            value="{{ $province->id }}" {{ $company->province_id == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="city_id" class="block text-sm font-medium text-gray-700 mb-2">
                    شهر
                    <span class="text-red-500">*</span>
                </label>
                <select id="city_id" name="city_id"
                        class="city-select w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                        required>
                    @if($cities->count() > 0)
                        <option value="">شهر را انتخاب کنید</option>
                        @foreach($cities as $city)
                            <option
                                value="{{ $city->id }}" {{ $company->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    @else
                        <option value="">ابتدا استان را انتخاب کنید</option>
                    @endif
                </select>
            </div>

            <div class="md:col-span-2">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                    آدرس
                    <span class="text-red-500">*</span>
                </label>
                <textarea id="address" name="address" rows="3" required
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                          placeholder="بلوار پاسداران، ...">{{ $company->address }}</textarea>
            </div>

            <div>
                <label for="postal" class="block text-sm font-medium text-gray-700 mb-2">
                    کد پستی
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="postal" name="postal" value="{{ $company->postal }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="7181234567">
            </div>

            <div>
                <label for="location_link" class="block text-sm font-medium text-gray-700 mb-2">
                    لینک موقعیت گوگل مپ
                    <span class="text-red-500">*</span>
                </label>
                <input type="url" id="location_link" name="location_link" value="{{ $company->location_link }}"
                       class="location-link w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       required
                       placeholder="https://maps.app.goo.gl/...">
            </div>

            <div class="md:col-span-2 coordinates-display bg-white rounded-lg p-4 border border-gray-200">
                @if($company->coordinates)
                    <p>مختصات: <strong class="text-blue-600">{{ $company->coordinates }}</strong></p>
                    <p>عرض جغرافیایی: <strong class="text-blue-600">{{ $company->latitude }}</strong></p>
                    <p>طول جغرافیایی: <strong class="text-blue-600">{{ $company->longitude }}</strong></p>
                @else
                    <p class="text-gray-500 text-sm">مختصات جغرافیایی پس از وارد کردن لینک موقعیت نمایش داده خواهد
                        شد</p>
                @endif
            </div>
        </div>
    </div>

    <!-- CEO & Interface Info -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-blue-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
            </svg>
            اطلاعات مدیریت
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="ceo_name" class="block text-sm font-medium text-gray-700 mb-2">
                    نام مدیر عامل
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="ceo_name" name="ceo_name" value="{{ $company->ceo_name }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="احمد احمدی">
            </div>

            <div>
                <label for="ceo_phone" class="block text-sm font-medium text-gray-700 mb-2">
                    تلفن مدیر عامل
                    <span class="text-red-500">*</span>
                </label>
                <input type="tel" id="ceo_phone" name="ceo_phone" value="{{ $company->ceo_phone }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="09123456789">
            </div>

            <div>
                <label for="ceo_national_id" class="block text-sm font-medium text-gray-700 mb-2">
                    کد ملی مدیر عامل
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="ceo_national_id" name="ceo_national_id" value="{{ $company->ceo_national_id }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="0123456789">
            </div>

            <div>
                <label for="interface_name" class="block text-sm font-medium text-gray-700 mb-2">
                    نام رابط
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="interface_name" name="interface_name" value="{{ $company->interface_name }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="محسن محسنی">
            </div>

            <div>
                <label for="interface_phone" class="block text-sm font-medium text-gray-700 mb-2">
                    تلفن رابط
                    <span class="text-red-500">*</span>
                </label>
                <input type="tel" id="interface_phone" name="interface_phone" value="{{ $company->interface_phone }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="09123456789">
            </div>

            <div>
                <label for="landline_number" class="block text-sm font-medium text-gray-700 mb-2">
                    تلفن ثابت شرکت
                    <span class="text-red-500">*</span>
                </label>
                <input type="tel" id="landline_number" name="landline_number" value="{{ $company->landline_number }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="07123456789">
            </div>

            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">
                    تلفن همراه شرکت
                </label>
                <input type="tel" id="phone_number" name="phone_number" value="{{ $company->phone_number }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="09123456789">
            </div>

            <div>
                <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                    وب سایت شرکت
                    <span class="text-red-500">*</span>
                </label>
                <input type="url" id="website" name="website" value="{{ $company->website }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="https://company.ir">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    ایمیل شرکت
                    <span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" name="email" value="{{ $company->email }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="info@company.ir">
            </div>
        </div>
    </div>

    <!-- Brand & Systems Info -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-blue-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            علامت تجاری و سامانه‌ها
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">
                    علامت تجاری
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="brand" name="brand" value="{{ $company->brand }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="سیمرغ">
            </div>

            <div class="flex items-center space-x-6 rtl:space-x-reverse">
                <div class="flex items-center">
                    <input type="hidden" name="climate_system" value="0">
                    <input type="checkbox" id="climate_system" name="climate_system" value="1"
                           {{ $company->climate_system ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="climate_system" class="mr-2 text-sm font-medium text-gray-700">
                        دارای سامانه کنترل اقلیم
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="hidden" name="feeding_system" value="0">
                    <input type="checkbox" id="feeding_system" name="feeding_system" value="1"
                           {{ $company->feeding_system ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="feeding_system" class="mr-2 text-sm font-medium text-gray-700">
                        دارای سامانه تغذیه و آبیاری
                    </label>
                </div>
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
                <label for="company_logo" class="block text-sm font-medium text-gray-700 mb-2">
                    لوگو شرکت
                    @if($company->company_logo)
                        <span class="text-sm text-green-600">(فایل موجود)</span>
                    @endif
                </label>
                <input type="file" id="company_logo" name="company_logo" accept="image/*"
                       class="w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                @if($company->company_logo)
                    <div class="mt-2">
                        <img src="{{ asset($company->company_logo) }}" alt="لوگو شرکت"
                             class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                    </div>
                @endif
            </div>

            <div>
                <label for="brand_logo" class="block text-sm font-medium text-gray-700 mb-2">
                    لوگو علامت تجاری
                    @if($company->brand_logo)
                        <span class="text-sm text-green-600">(فایل موجود)</span>
                    @endif
                </label>
                <input type="file" id="brand_logo" name="brand_logo" accept="image/*"
                       class="w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                @if($company->brand_logo)
                    <div class="mt-2">
                        <img src="{{ asset($company->brand_logo) }}" alt="لوگو علامت تجاری"
                             class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                    </div>
                @endif
            </div>

            <div>
                <label for="trademark_certificate" class="block text-sm font-medium text-gray-700 mb-2">
                    گواهی ثبت علامت تجاری
                    @if($company->trademark_certificate)
                        <span class="text-sm text-green-600">(فایل موجود)</span>
                    @endif
                </label>
                <input type="file" id="trademark_certificate" name="trademark_certificate" accept="image/*"
                       class="w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                @if($company->trademark_certificate)
                    <div class="mt-2">
                        <img src="{{ asset($company->trademark_certificate) }}" alt="گواهی ثبت علامت تجاری"
                             class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                    </div>
                @endif
            </div>

            <div>
                <label for="operation_licence" class="block text-sm font-medium text-gray-700 mb-2">
                    پروانه بهره برداری
                    @if($company->operation_licence)
                        <span class="text-sm text-green-600">(فایل موجود)</span>
                    @endif
                </label>
                <input type="file" id="operation_licence" name="operation_licence" accept="image/*"
                       class="w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                @if($company->operation_licence)
                    <div class="mt-2">
                        <img src="{{ asset($company->operation_licence) }}" alt="پروانه بهره برداری"
                             class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                    </div>
                @endif
            </div>

            <div class="md:col-span-2">
                <label for="official_newspaper" class="block text-sm font-medium text-gray-700 mb-2">
                    روزنامه رسمی آخرین تغییرات
                    @if($company->official_newspaper)
                        <span class="text-sm text-green-600">(فایل موجود)</span>
                    @endif
                </label>
                <input type="file" id="official_newspaper" name="official_newspaper" accept="image/*,.pdf"
                       class="w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
        </div>
    </div>

    @can(\App\Models\Company::COMPANY_CONFIRM)
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
                    وضعیت شرکت
                </label>
                <select id="status" name="status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200">
                    <option value="">وضعیت را انتخاب کنید</option>
                    @foreach($statuses as $status)
                        <option
                            value="{{ $status['name'] }}" {{ $company->status === $status['name'] ? 'selected' : '' }}>{{ $status['title'] }}</option>
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
