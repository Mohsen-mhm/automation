<form id="alertForm" action="{{ $action }}" method="{{ $method }}" class="space-y-8">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    <!-- Parameter Selection Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Lux Parameter -->
        <div
            class="parameter-card bg-white border-2 border-gray-200 rounded-xl p-6 transition-all duration-300 hover:shadow-lg"
            data-card="lux">
            <div class="text-center">
                <div class="w-16 h-16 bg-yellow-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 5V3m0 18v-2M7 7 5.7 5.7m12.8 12.8L17 17M5 12H3m18 0h-2M7 17l-1.4 1.4M18.4 5.6 17 7.1M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">روشنایی محیط</h3>
                <p class="text-sm text-gray-500 mb-4">واحد: لوکس</p>

                <div class="flex items-center justify-center">
                    <input type="checkbox"
                           id="lux_active"
                           name="lux_active"
                           value="1"
                           data-parameter="lux"
                           {{ old('lux_active', $alert->lux_active ?? false) ? 'checked' : '' }}
                           class="w-5 h-5 text-yellow-600 bg-gray-100 border-gray-300 rounded focus:ring-yellow-500 focus:ring-2">
                    <label for="lux_active" class="mr-2 text-sm font-medium text-gray-700">فعال‌سازی</label>
                </div>
            </div>

            <!-- Range Inputs -->
            <div class="mt-6 space-y-4 lux-inputs">
                <div>
                    <label for="min_lux" class="block text-sm font-medium text-gray-700 mb-2">حداقل روشنایی</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 5V3m0 18v-2M7 7 5.7 5.7m12.8 12.8L17 17M5 12H3m18 0h-2M7 17l-1.4 1.4M18.4 5.6 17 7.1M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/>
                            </svg>
                        </div>
                        <input type="number" @if(!$isAdmin) readonly @endif
                               id="min_lux"
                               name="min_lux"
                               value="{{ old('min_lux', $alert->min_lux ?? '') }}"
                               data-parameter="lux"
                               placeholder="مثال: 1000"
                               class="range-input block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 bg-gray-50">
                    </div>
                </div>

                <div>
                    <label for="max_lux" class="block text-sm font-medium text-gray-700 mb-2">حداکثر روشنایی</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 5V3m0 18v-2M7 7 5.7 5.7m12.8 12.8L17 17M5 12H3m18 0h-2M7 17l-1.4 1.4M18.4 5.6 17 7.1M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/>
                            </svg>
                        </div>
                        <input type="number" @if(!$isAdmin) readonly @endif
                               id="max_lux"
                               name="max_lux"
                               value="{{ old('max_lux', $alert->max_lux ?? '') }}"
                               data-parameter="lux"
                               placeholder="مثال: 5000"
                               class="range-input block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 bg-gray-50">
                    </div>
                </div>
            </div>
        </div>

        <!-- Temperature Parameter -->
        <div
            class="parameter-card bg-white border-2 border-gray-200 rounded-xl p-6 transition-all duration-300 hover:shadow-lg"
            data-card="temp">
            <div class="text-center">
                <div class="w-16 h-16 bg-red-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M18.1 17.6A7.2 7.2 0 0 1 12 21a6.6 6.6 0 0 1-5.8-3c-2.7-4.6.3-8.8.9-9.7A4.4 4.4 0 0 0 8 4c1.3 1 6.4 3.3 5.5 10.6 1.5-1.1 2.7-3 2.9-6.2 1.4 1 4 5.5 1.7 9.2Z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">دمای محیط</h3>
                <p class="text-sm text-gray-500 mb-4">واحد: سانتی‌گراد</p>

                <div class="flex items-center justify-center">
                    <input type="checkbox"
                           id="temp_active"
                           name="temp_active"
                           value="1"
                           data-parameter="temp"
                           {{ old('temp_active', $alert->temp_active ?? false) ? 'checked' : '' }}
                           class="w-5 h-5 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 focus:ring-2">
                    <label for="temp_active" class="mr-2 text-sm font-medium text-gray-700">فعال‌سازی</label>
                </div>
            </div>

            <!-- Range Inputs -->
            <div class="mt-6 space-y-4 temp-inputs">
                <div>
                    <label for="min_temp" class="block text-sm font-medium text-gray-700 mb-2">حداقل دما</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M18.1 17.6A7.2 7.2 0 0 1 12 21a6.6 6.6 0 0 1-5.8-3c-2.7-4.6.3-8.8.9-9.7A4.4 4.4 0 0 0 8 4c1.3 1 6.4 3.3 5.5 10.6 1.5-1.1 2.7-3 2.9-6.2 1.4 1 4 5.5 1.7 9.2Z"/>
                            </svg>
                        </div>
                        <input type="number" @if(!$isAdmin) readonly @endif
                               id="min_temp"
                               name="min_temp"
                               value="{{ old('min_temp', $alert->min_temp ?? '') }}"
                               data-parameter="temp"
                               placeholder="مثال: 15"
                               class="range-input block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-gray-50">
                    </div>
                </div>

                <div>
                    <label for="max_temp" class="block text-sm font-medium text-gray-700 mb-2">حداکثر دما</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M18.1 17.6A7.2 7.2 0 0 1 12 21a6.6 6.6 0 0 1-5.8-3c-2.7-4.6.3-8.8.9-9.7A4.4 4.4 0 0 0 8 4c1.3 1 6.4 3.3 5.5 10.6 1.5-1.1 2.7-3 2.9-6.2 1.4 1 4 5.5 1.7 9.2Z"/>
                            </svg>
                        </div>
                        <input type="number" @if(!$isAdmin) readonly @endif
                               id="max_temp"
                               name="max_temp"
                               value="{{ old('max_temp', $alert->max_temp ?? '') }}"
                               data-parameter="temp"
                               placeholder="مثال: 35"
                               class="range-input block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-gray-50">
                    </div>
                </div>
            </div>
        </div>

        <!-- Wind Speed Parameter -->
        <div
            class="parameter-card bg-white border-2 border-gray-200 rounded-xl p-6 transition-all duration-300 hover:shadow-lg"
            data-card="wind">
            <div class="text-center">
                <div class="w-16 h-16 bg-sky-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-sky-600" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M11.8 5.7A4.8 4.8 0 0 0 7 10a3.4 3.4 0 0 1 2.7-1.7c1.7 0 3 2 3.8 2.6a5.7 5.7 0 0 0 5.4 1c2-.7 2.9-3 3.1-4-1 1.4-2.4 2.2-4.3 1.2-1.2-.6-2.1-3.4-6-3.3Zm-5 6.3A4.8 4.8 0 0 0 2 16.2a3.4 3.4 0 0 1 2.7-1.7c1.7 0 3 2 3.8 2.6a5.7 5.7 0 0 0 5.4.9c2-.7 3-2.9 3.1-4-1 1.4-2.4 2.3-4.2 1.3-1.3-.7-2.2-3.4-6-3.3Z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">سرعت باد محیط</h3>
                <p class="text-sm text-gray-500 mb-4">واحد: کیلومتر بر ساعت</p>

                <div class="flex items-center justify-center">
                    <input type="checkbox"
                           id="wind_active"
                           name="wind_active"
                           value="1"
                           data-parameter="wind"
                           {{ old('wind_active', $alert->wind_active ?? false) ? 'checked' : '' }}
                           class="w-5 h-5 text-sky-600 bg-gray-100 border-gray-300 rounded focus:ring-sky-500 focus:ring-2">
                    <label for="wind_active" class="mr-2 text-sm font-medium text-gray-700">فعال‌سازی</label>
                </div>
            </div>

            <!-- Range Inputs -->
            <div class="mt-6 space-y-4 wind-inputs">
                <div>
                    <label for="min_wind" class="block text-sm font-medium text-gray-700 mb-2">حداقل سرعت باد</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-sky-500" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M11.8 5.7A4.8 4.8 0 0 0 7 10a3.4 3.4 0 0 1 2.7-1.7c1.7 0 3 2 3.8 2.6a5.7 5.7 0 0 0 5.4 1c2-.7 2.9-3 3.1-4-1 1.4-2.4 2.2-4.3 1.2-1.2-.6-2.1-3.4-6-3.3Zm-5 6.3A4.8 4.8 0 0 0 2 16.2a3.4 3.4 0 0 1 2.7-1.7c1.7 0 3 2 3.8 2.6a5.7 5.7 0 0 0 5.4.9c2-.7 3-2.9 3.1-4-1 1.4-2.4 2.3-4.2 1.3-1.3-.7-2.2-3.4-6-3.3Z"/>
                            </svg>
                        </div>
                        <input type="number" @if(!$isAdmin) readonly @endif
                               id="min_wind"
                               name="min_wind"
                               value="{{ old('min_wind', $alert->min_wind ?? '') }}"
                               data-parameter="wind"
                               placeholder="مثال: 0"
                               class="range-input block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 bg-gray-50">
                    </div>
                </div>

                <div>
                    <label for="max_wind" class="block text-sm font-medium text-gray-700 mb-2">حداکثر سرعت باد</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-sky-500" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M11.8 5.7A4.8 4.8 0 0 0 7 10a3.4 3.4 0 0 1 2.7-1.7c1.7 0 3 2 3.8 2.6a5.7 5.7 0 0 0 5.4 1c2-.7 2.9-3 3.1-4-1 1.4-2.4 2.2-4.3 1.2-1.2-.6-2.1-3.4-6-3.3Zm-5 6.3A4.8 4.8 0 0 0 2 16.2a3.4 3.4 0 0 1 2.7-1.7c1.7 0 3 2 3.8 2.6a5.7 5.7 0 0 0 5.4.9c2-.7 3-2.9 3.1-4-1 1.4-2.4 2.3-4.2 1.3-1.3-.7-2.2-3.4-6-3.3Z"/>
                            </svg>
                        </div>
                        <input type="number" @if(!$isAdmin) readonly @endif
                               id="max_wind"
                               name="max_wind"
                               value="{{ old('max_wind', $alert->max_wind ?? '') }}"
                               data-parameter="wind"
                               placeholder="مثال: 50"
                               class="range-input block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 bg-gray-50">
                    </div>
                </div>
            </div>
        </div>

        <!-- Humidity Parameter -->
        <div
            class="parameter-card bg-white border-2 border-gray-200 rounded-xl p-6 transition-all duration-300 hover:shadow-lg"
            data-card="humidity">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2"
                              d="M4.4 7.7c2 .5 2.4 2.8 3.2 3.8 1 1.4 2 1.3 3.2 2.7 1.8 2.3 1.3 5.7 1.3 6.7M20 15h-1a4 4 0 0 0-4 4v1M8.6 4c0 .8.1 1.9 1.5 2.6 1.4.7 3 .3 3 2.3 0 .3 0 2 1.9 2 2 0 2-1.7 2-2 0-.6.5-.9 1.2-.9H20m1 4a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">رطوبت محیط</h3>
                <p class="text-sm text-gray-500 mb-4">واحد: درصد</p>

                <div class="flex items-center justify-center">
                    <input type="checkbox"
                           id="humidity_active"
                           name="humidity_active"
                           value="1"
                           data-parameter="humidity"
                           {{ old('humidity_active', $alert->humidity_active ?? false) ? 'checked' : '' }}
                           class="w-5 h-5 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                    <label for="humidity_active" class="mr-2 text-sm font-medium text-gray-700">فعال‌سازی</label>
                </div>
            </div>

            <!-- Range Inputs -->
            <div class="mt-6 space-y-4 humidity-inputs">
                <div>
                    <label for="min_humidity" class="block text-sm font-medium text-gray-700 mb-2">حداقل رطوبت</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-width="2"
                                      d="M4.4 7.7c2 .5 2.4 2.8 3.2 3.8 1 1.4 2 1.3 3.2 2.7 1.8 2.3 1.3 5.7 1.3 6.7M20 15h-1a4 4 0 0 0-4 4v1M8.6 4c0 .8.1 1.9 1.5 2.6 1.4.7 3 .3 3 2.3 0 .3 0 2 1.9 2 2 0 2-1.7 2-2 0-.6.5-.9 1.2-.9H20m1 4a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </div>
                        <input type="number" @if(!$isAdmin) readonly @endif
                               id="min_humidity"
                               name="min_humidity"
                               value="{{ old('min_humidity', $alert->min_humidity ?? '') }}"
                               data-parameter="humidity"
                               placeholder="مثال: 30"
                               class="range-input block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-gray-50">
                    </div>
                </div>

                <div>
                    <label for="max_humidity" class="block text-sm font-medium text-gray-700 mb-2">حداکثر رطوبت</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-width="2"
                                      d="M4.4 7.7c2 .5 2.4 2.8 3.2 3.8 1 1.4 2 1.3 3.2 2.7 1.8 2.3 1.3 5.7 1.3 6.7M20 15h-1a4 4 0 0 0-4 4v1M8.6 4c0 .8.1 1.9 1.5 2.6 1.4.7 3 .3 3 2.3 0 .3 0 2 1.9 2 2 0 2-1.7 2-2 0-.6.5-.9 1.2-.9H20m1 4a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </div>
                        <input type="number" @if(!$isAdmin) readonly @endif
                               id="max_humidity"
                               name="max_humidity"
                               value="{{ old('max_humidity', $alert->max_humidity ?? '') }}"
                               data-parameter="humidity"
                               placeholder="مثال: 80"
                               class="range-input block w-full pl-10 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-gray-50">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-600 mt-0.5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h4 class="text-red-800 font-medium mb-2">خطاهای فرم:</h4>
                    <ul class="text-red-700 text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Custom Error Messages -->
    @error('lux_error')
    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-red-600 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <p class="text-red-800 text-sm">{{ $message }}</p>
        </div>
    </div>
    @enderror

    @error('temp_error')
    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-red-600 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <p class="text-red-800 text-sm">{{ $message }}</p>
        </div>
    </div>
    @enderror

    @error('wind_error')
    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-red-600 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <p class="text-red-800 text-sm">{{ $message }}</p>
        </div>
    </div>
    @enderror

    @error('humidity_error')
    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-red-600 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <p class="text-red-808 text-sm">{{ $message }}</p>
        </div>
    </div>
    @enderror

    <!-- Submit Button -->
    @if($isAdmin)
        <div class="flex justify-center pt-6">
            <button type="submit"
                    class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                اعمال تغییرات
            </button>
        </div>
    @endif
</form>
