<form action="{{ route('panel.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <!-- Personal Information -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-blue-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            اطلاعات شخصی
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="fname" class="block text-sm font-medium text-gray-700 mb-2">
                    نام
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="fname" name="fname" value="{{ old('fname', $organization->fname) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="علی">
                @error('fname')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="lname" class="block text-sm font-medium text-gray-700 mb-2">
                    نام خانوادگی
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="lname" name="lname" value="{{ old('lname', $organization->lname) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="احمدی">
                @error('lname')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="national_id" class="block text-sm font-medium text-gray-700 mb-2">
                    کد ملی
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="national_id" name="national_id"
                       value="{{ old('national_id', $organization->national_id) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="2281234567">
                @error('national_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Organization Information -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-purple-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            اطلاعات سازمانی
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="organization_name" class="block text-sm font-medium text-gray-700 mb-2">
                    نام سازمان
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="organization_name" name="organization_name"
                       value="{{ old('organization_name', $organization->organization_name) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="جهاد کشاورزی">
                @error('organization_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="organization_level" class="block text-sm font-medium text-gray-700 mb-2">
                    سمت سازمانی
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="organization_level" name="organization_level"
                       value="{{ old('organization_level', $organization->organization_level) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="مدیر اجرایی">
                @error('organization_level')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Location Information -->
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
                <select id="province" name="province"
                        class="province-select w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white text-gray-900 transition-all duration-200"
                        required>
                    <option value="">استان را انتخاب کنید</option>
                    @foreach($provinces as $province)
                        <option
                            value="{{ $province->name }}" {{ old('province', $organization->province) === $province->name ? 'selected' : '' }}>
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
                <select id="city" name="city"
                        class="city-select w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white text-gray-900 transition-all duration-200"
                        required>
                    <option value="">شهر را انتخاب کنید</option>
                    @if($organization->city)
                        <option value="{{ $organization->city }}"
                                selected>{{ $organization->city }}</option>
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
                <input type="text" id="address" name="address" value="{{ old('address', $organization->address) }}"
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
                <input type="text" id="postal" name="postal" value="{{ old('postal', $organization->postal) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="718123456">
                @error('postal')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-orange-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            اطلاعات تماس
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="landline_number" class="block text-sm font-medium text-gray-700 mb-2">
                    شماره تلفن ثابت
                </label>
                <input type="tel" id="landline_number" name="landline_number"
                       value="{{ old('landline_number', $organization->landline_number) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="07123456789">
                @error('landline_number')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">
                    شماره تلفن همراه
                    <span class="text-red-500">*</span>
                </label>
                <input type="tel" id="phone_number" name="phone_number"
                       value="{{ old('phone_number', $organization->phone_number) }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="09123456789">
                @error('phone_number')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Documents -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-cyan-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            مدارک هویتی
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- National Card -->
            <div class="space-y-4">
                <div>
                    <label for="national_card" class="block text-sm font-medium text-gray-700 mb-2">
                        تصویر کارت ملی
                        @if($organization->national_card)
                            <span class="text-sm text-green-600">(فایل موجود)</span>
                        @endif
                    </label>
                    <input type="file" id="national_card" name="national_card" accept="image/*"
                           class="w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                    @error('national_card')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @if($organization->national_card)
                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-700 mb-2">کارت ملی فعلی</p>
                        <img src="{{ asset($organization->national_card) }}" alt="کارت ملی"
                             class="w-32 h-32 object-cover rounded-lg border border-gray-200 mx-auto">
                    </div>
                @endif
            </div>

            <!-- Personnel Card -->
            <div class="space-y-4">
                <div>
                    <label for="personnel_card" class="block text-sm font-medium text-gray-700 mb-2">
                        تصویر کارت پرسنلی
                        @if($organization->personnel_card)
                            <span class="text-sm text-green-600">(فایل موجود)</span>
                        @endif
                    </label>
                    <input type="file" id="personnel_card" name="personnel_card" accept="image/*"
                           class="w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                    @error('personnel_card')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @if($organization->personnel_card)
                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-700 mb-2">کارت پرسنلی فعلی</p>
                        <img src="{{ asset($organization->personnel_card) }}" alt="کارت پرسنلی"
                             class="w-32 h-32 object-cover rounded-lg border border-gray-200 mx-auto">
                    </div>
                @endif
            </div>

            <!-- Introduction Letter -->
            <div class="space-y-4">
                <div>
                    <label for="introduction_letter" class="block text-sm font-medium text-gray-700 mb-2">
                        تصویر معرفی نامه
                        @if($organization->introduction_letter)
                            <span class="text-sm text-green-600">(فایل موجود)</span>
                        @endif
                    </label>
                    <input type="file" id="introduction_letter" name="introduction_letter" accept="image/*"
                           class="w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                    @error('introduction_letter')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @if($organization->introduction_letter)
                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-700 mb-2">معرفی نامه فعلی</p>
                        <img src="{{ asset($organization->introduction_letter) }}" alt="معرفی نامه"
                             class="w-32 h-32 object-cover rounded-lg border border-gray-200 mx-auto">
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-center pt-6">
        <button type="submit"
                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            ثبت و ارسال تغییرات
        </button>
    </div>
</form>
