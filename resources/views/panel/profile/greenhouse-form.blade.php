<form action="{{ route('panel.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <!-- Greenhouse Basic Info -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-green-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            اطلاعات پایه گلخانه
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    نام گلخانه
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $greenhouse->name) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="گلخانه محمدی">
                @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="licence_number" class="block text-sm font-medium text-gray-700 mb-2">
                    شماره پروانه
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="licence_number" name="licence_number"
                       value="{{ old('licence_number', $greenhouse->licence_number) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="4689496584">
                @error('licence_number')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="substrate_type" class="block text-sm font-medium text-gray-700 mb-2">
                    نوع بستر
                    <span class="text-red-500">*</span>
                </label>
                <select id="substrate_type" name="substrate_type" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-gray-900 transition-all duration-200">
                    <option value="">بستر را انتخاب کنید</option>
                    @foreach($substrates as $substrate)
                        <option
                            value="{{ $substrate }}" {{ old('substrate_type', $greenhouse->substrate_type) === $substrate ? 'selected' : '' }}>
                            {{ $substrate }}
                        </option>
                    @endforeach
                </select>
                @error('substrate_type')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="product_type" class="block text-sm font-medium text-gray-700 mb-2">
                    نوع محصول
                    <span class="text-red-500">*</span>
                </label>
                <select id="product_type" name="product_type" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-gray-900 transition-all duration-200">
                    <option value="">محصول را انتخاب کنید</option>
                    @foreach($productTypes as $productType)
                        <option
                            value="{{ $productType }}" {{ old('product_type', $greenhouse->product_type) === $productType ? 'selected' : '' }}>
                            {{ $productType }}
                        </option>
                    @endforeach
                </select>
                @error('product_type')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="meterage" class="block text-sm font-medium text-gray-700 mb-2">
                    متراژ
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="meterage" name="meterage" value="{{ old('meterage', $greenhouse->meterage) }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="2000 متر مربع">
                @error('meterage')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="greenhouse_status" class="block text-sm font-medium text-gray-700 mb-2">
                    وضعیت گلخانه
                    <span class="text-red-500">*</span>
                </label>
                <select id="greenhouse_status" name="greenhouse_status" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-gray-900 transition-all duration-200">
                    <option value="">وضعیت را انتخاب کنید</option>
                    @foreach($greenhouseStatuses as $status)
                        <option
                            value="{{ $status }}" {{ old('greenhouse_status', $greenhouse->greenhouse_status) === $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                @error('greenhouse_status')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="construction_date" class="block text-sm font-medium text-gray-700 mb-2">
                    تاریخ احداث
                </label>
                <input type="text" id="construction_date" name="construction_date"
                       value="{{ old('construction_date', $greenhouse->construction_date ? \Morilog\Jalali\Jalalian::fromDateTime($greenhouse->construction_date)->toDateString() : '') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="1400/05/24">
                @error('construction_date')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="operation_date" class="block text-sm font-medium text-gray-700 mb-2">
                    تاریخ بهره برداری
                </label>
                <input type="text" id="operation_date" name="operation_date"
                       value="{{ old('operation_date', $greenhouse->operation_date ? \Morilog\Jalali\Jalalian::fromDateTime($greenhouse->operation_date)->toDateString() : '') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="1400/08/15">
                @error('operation_date')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Owner Information -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-purple-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            اطلاعات مالک
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-2">
                    نام مالک
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="owner_name" name="owner_name"
                       value="{{ old('owner_name', $greenhouse->owner_name) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="محسن محمدی">
                @error('owner_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="owner_national_id" class="block text-sm font-medium text-gray-700 mb-2">
                    کد ملی مالک
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="owner_national_id" name="owner_national_id"
                       value="{{ old('owner_national_id', $greenhouse->owner_national_id) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="2281234567">
                @error('owner_national_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="owner_phone" class="block text-sm font-medium text-gray-700 mb-2">
                    تلفن همراه مالک
                    <span class="text-red-500">*</span>
                </label>
                <input type="tel" id="owner_phone" name="owner_phone"
                       value="{{ old('owner_phone', $greenhouse->owner_phone) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="09123456789">
                @error('owner_phone')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Systems -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-orange-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            سامانه‌ها
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-center">
                <input type="hidden" name="climate_system" value="0">
                <input type="checkbox" id="climate_system" name="climate_system" value="1"
                       {{ old('climate_system', $greenhouse->climate_system) ? 'checked' : '' }}
                       class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 focus:ring-2">
                <label for="climate_system" class="mr-2 text-sm font-medium text-gray-700">
                    دارای سامانه کنترل اقلیم
                </label>
            </div>

            <div class="flex items-center">
                <input type="hidden" name="feeding_system" value="0">
                <input type="checkbox" id="feeding_system" name="feeding_system" value="1"
                       {{ old('feeding_system', $greenhouse->feeding_system) ? 'checked' : '' }}
                       class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 focus:ring-2">
                <label for="feeding_system" class="mr-2 text-sm font-medium text-gray-700">
                    دارای سامانه تغذیه و آبیاری
                </label>
            </div>
        </div>
    </div>

    <!-- Location Info -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-emerald-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <select id="province" name="province_id"
                        class="province-select w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white text-gray-900 transition-all duration-200"
                        required>
                    <option value="">استان را انتخاب کنید</option>
                    @foreach($provinces as $province)
                        <option
                            value="{{ $province->id }}" {{ old('province', $greenhouse->province?->name) === $province->name ? 'selected' : '' }}>
                            {{ $province->name }}
                        </option>
                    @endforeach
                </select>
                @error('province')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                    شهر
                    <span class="text-red-500">*</span>
                </label>
                <select id="city" name="city_id"
                        class="city-select w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white text-gray-900 transition-all duration-200"
                        required>
                    <option value="">شهر را انتخاب کنید</option>
                    @if($greenhouse->city)
                        <option value="{{ $greenhouse->city->id }}" selected>{{ $greenhouse->city->name }}</option>
                    @endif
                </select>
                @error('city')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                    آدرس
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="address" name="address" value="{{ old('address', $greenhouse->address) }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="بلوار پاسداران، ...">
                @error('address')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="postal" class="block text-sm font-medium text-gray-700 mb-2">
                    کد پستی
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="postal" name="postal" value="{{ old('postal', $greenhouse->postal) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="718123456">
                @error('postal')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="location_link" class="block text-sm font-medium text-gray-700 mb-2">
                    لینک موقعیت گوگل مپ
                </label>
                <input type="url" id="location_link" name="location_link"
                       value="{{ old('location_link', $greenhouse->location_link) }}"
                       class="location-link w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="https://maps.app.goo.gl/...">
                @error('location_link')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="coordinates-display bg-white rounded-lg p-4 border border-gray-200">
                @if($greenhouse->coordinates)
                    <p>مختصات: <strong class="text-emerald-600">{{ $greenhouse->coordinates }}</strong></p>
                    <p>عرض جغرافیایی: <strong class="text-emerald-600">{{ $greenhouse->latitude }}</strong></p>
                    <p>طول جغرافیایی: <strong class="text-emerald-600">{{ $greenhouse->longitude }}</strong></p>
                @else
                    <p class="text-gray-500 text-sm">مختصات جغرافیایی پس از وارد کردن لینک موقعیت نمایش داده خواهد
                        شد</p>
                @endif
            </div>
        </div>
    </div>

    <!-- File Uploads -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-cyan-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            مدارک و تصاویر
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Operation Licence -->
            <div class="space-y-4">
                <div>
                    <label for="operation_licence" class="block text-sm font-medium text-gray-700 mb-2">
                        پروانه بهره برداری
                        @if($greenhouse->operation_licence)
                            <span class="text-sm text-green-600">(فایل موجود)</span>
                        @endif
                    </label>
                    <input type="file" id="operation_licence" name="operation_licence" accept="image/*"
                           class="w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                    @error('operation_licence')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @if($greenhouse->operation_licence)
                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-700 mb-2">پروانه فعلی</p>
                        <img src="{{ asset($greenhouse->operation_licence) }}" alt="پروانه بهره برداری"
                             class="w-32 h-32 object-cover rounded-lg border border-gray-200 mx-auto">
                    </div>
                @endif
            </div>

            <!-- Greenhouse Image -->
            <div class="space-y-4">
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        تصویر یا لوگو گلخانه
                        @if($greenhouse->image)
                            <span class="text-sm text-green-600">(فایل موجود)</span>
                        @endif
                    </label>
                    <input type="file" id="image" name="image" accept="image/*"
                           class="w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                    @error('image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @if($greenhouse->image)
                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-700 mb-2">تصویر فعلی</p>
                        <img src="{{ asset($greenhouse->image) }}" alt="تصویر گلخانه"
                             class="w-32 h-32 object-cover rounded-lg border border-gray-200 mx-auto">
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-center pt-6">
        <button type="submit"
                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            ثبت و ارسال تغییرات
        </button>
    </div>
</form>
