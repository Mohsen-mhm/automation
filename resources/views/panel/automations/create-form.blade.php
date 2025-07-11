<form id="createForm" class="space-y-6">
    @csrf

    <!-- Greenhouse Selection -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-emerald-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            انتخاب گلخانه
        </h3>

        <div>
            <label for="greenhouse_id" class="block text-sm font-medium text-gray-700 mb-2">
                گلخانه
                <span class="text-red-500">*</span>
            </label>
            <select id="greenhouse_id" name="greenhouse_id" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white text-gray-900 transition-all duration-200">
                <option value="">گلخانه را انتخاب کنید</option>
                @foreach($greenhouses as $greenhouse)
                    <option value="{{ $greenhouse->id }}">{{ $greenhouse->name }} - {{ $greenhouse->licence_number }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Climate Control System -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-blue-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
            </svg>
            سیستم کنترل اقلیم
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="climate_company_id" class="block text-sm font-medium text-gray-700 mb-2">
                    شرکت مجری کنترل اقلیم
                </label>
                <select id="climate_company_id" name="climate_company_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200">
                    <option value="">شرکت را انتخاب کنید</option>
                    @foreach($climate_companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }} - {{ $company->national_id }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="climate_date" class="block text-sm font-medium text-gray-700 mb-2">
                    تاریخ اجرای کنترل اقلیم
                </label>
                <input type="text" id="climate_date" name="climate_date"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="1400/05/24">
            </div>

            <div>
                <label for="climate_api_link" class="block text-sm font-medium text-gray-700 mb-2">
                    لینک API کنترل اقلیم
                </label>
                <input type="url" id="climate_api_link" name="climate_api_link"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="https://api.example.com/climate">
            </div>

            <div>
                <label for="climate_linked_date" class="block text-sm font-medium text-gray-700 mb-2">
                    تاریخ اتصال کنترل اقلیم
                </label>
                <input type="text" id="climate_linked_date" name="climate_linked_date"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="1401/03/25">
            </div>
        </div>
    </div>

    <!-- Feeding & Irrigation System -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 text-green-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
            </svg>
            سیستم تغذیه و آبیاری
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="feeding_company_id" class="block text-sm font-medium text-gray-700 mb-2">
                    شرکت مجری تغذیه و آبیاری
                </label>
                <select id="feeding_company_id" name="feeding_company_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-gray-900 transition-all duration-200">
                    <option value="">شرکت را انتخاب کنید</option>
                    @foreach($feeding_companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }} - {{ $company->national_id }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="feeding_date" class="block text-sm font-medium text-gray-700 mb-2">
                    تاریخ اجرای تغذیه و آبیاری
                </label>
                <input type="text" id="feeding_date" name="feeding_date"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="1401/03/25">
            </div>

            <div>
                <label for="feeding_api_link" class="block text-sm font-medium text-gray-700 mb-2">
                    لینک API تغذیه و آبیاری
                </label>
                <input type="url" id="feeding_api_link" name="feeding_api_link"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="https://api.example.com/feeding">
            </div>

            <div>
                <label for="feeding_linked_date" class="block text-sm font-medium text-gray-700 mb-2">
                    تاریخ اتصال تغذیه و آبیاری
                </label>
                <input type="text" id="feeding_linked_date" name="feeding_linked_date"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-gray-900 transition-all duration-200"
                       placeholder="1401/03/25">
            </div>
        </div>
    </div>

    @can(\App\Models\Automation::AUTOMATION_CONFIRM)
        <!-- Status -->
        <div class="bg-gray-50 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-purple-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                وضعیت
            </h3>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    وضعیت اتوماسیون
                </label>
                <select id="status" name="status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white text-gray-900 transition-all duration-200">
                    <option value="">وضعیت را انتخاب کنید</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status['name'] }}">{{ $status['title'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endcan

    <!-- Submit Button -->
    <div class="flex justify-end space-x-3 rtl:space-x-reverse pt-6 border-t border-gray-200">
        <button type="button" onclick="closeCreateModal()"
                class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 font-medium">
            انصراف
        </button>
        <button type="submit"
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            ایجاد اتوماسیون
        </button>
    </div>
</form>
