<div class="space-y-6">
    <!-- Automation Header -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-6 text-white">
        <div class="flex items-center space-x-4 rtl:space-x-reverse">
            <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v15c0 .6.4 1 1 1h15M8 16l2.5-5.5 3 3L17.3 7 20 9.7"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold">اتوماسیون گلخانه</h2>
                <p class="text-indigo-100">{{ $automation->greenhouse?->name ?? 'نامشخص' }}</p>
                <div class="flex items-center space-x-2 rtl:space-x-reverse mt-2">
                    @if($automation->active)
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <div class="w-1.5 h-1.5 bg-green-500 rounded-full ml-1.5"></div>
                            فعال
                        </span>
                    @else
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <div class="w-1.5 h-1.5 bg-red-500 rounded-full ml-1.5"></div>
                            غیرفعال
                        </span>
                    @endif

                    @php
                        $statusConfig = match($automation->status) {
                            \App\Models\Config::STATUS_PENDING => ['bg-yellow-100 text-yellow-800', \App\Models\Config::STATUS_PENDING_FA],
                            \App\Models\Config::STATUS_EDITED => ['bg-blue-100 text-blue-800', \App\Models\Config::STATUS_EDITED_FA],
                            \App\Models\Config::STATUS_CONFIRMED => ['bg-green-100 text-green-800', \App\Models\Config::STATUS_CONFIRMED_FA],
                            \App\Models\Config::STATUS_REJECTED => ['bg-red-100 text-red-800', \App\Models\Config::STATUS_REJECTED_FA],
                            \App\Models\Config::STATUS_DEACTIVATE => ['bg-gray-100 text-gray-800', \App\Models\Config::STATUS_DEACTIVATE_FA],
                            default => ['bg-gray-100 text-gray-800', 'ثبت نشده']
                        };
                    @endphp

                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusConfig[0] }}">
                       {{ $statusConfig[1] }}
                   </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Automation Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Greenhouse Information -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-emerald-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    اطلاعات گلخانه
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">نام گلخانه:</span>
                    <span class="text-sm text-gray-900">{{ $automation->greenhouse?->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">شماره پروانه:</span>
                    <span class="text-sm text-gray-900 font-mono">{{ $automation->greenhouse?->licence_number ?? '-' }}</span>
                </div>
                @if($automation->greenhouse)
                    <div class="pt-2">
                        <a href="{{ route('panel.greenhouses.index', 'table-search=' . $automation->greenhouse->licence_number) }}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-emerald-600 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition-colors duration-200">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            مشاهده جزئیات گلخانه
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Climate Control System -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-blue-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                    </svg>
                    سیستم کنترل اقلیم
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">شرکت مجری:</span>
                    <span class="text-sm text-gray-900">{{ $automation->climateCompany?->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">تاریخ اجرا:</span>
                    <span class="text-sm text-gray-900">
                       {{ $automation->climate_date ? \Morilog\Jalali\Jalalian::fromDateTime($automation->climate_date)->toDateString() : '-' }}
                   </span>
                </div>
                <div class="flex justify-between items-start py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">لینک API:</span>
                    <span class="text-sm text-gray-900 text-left max-w-xs break-all">
                       {{ $automation->climate_api_link ? \Illuminate\Support\Str::limit($automation->climate_api_link, 50) : '-' }}
                   </span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">تاریخ اتصال:</span>
                    <span class="text-sm text-gray-900">
                       {{ $automation->climate_linked_date ? \Morilog\Jalali\Jalalian::fromDateTime($automation->climate_linked_date)->toDateString() : '-' }}
                   </span>
                </div>
                @if($automation->climateCompany)
                    <div class="pt-2">
                        <a href="{{ route('panel.companies.index', 'table-search=' . $automation->climateCompany->national_id) }}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            مشاهده جزئیات شرکت
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Feeding & Irrigation System -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-green-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                    سیستم تغذیه و آبیاری
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">شرکت مجری:</span>
                    <span class="text-sm text-gray-900">{{ $automation->feedingCompany?->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">تاریخ اجرا:</span>
                    <span class="text-sm text-gray-900">
                       {{ $automation->feeding_date ? \Morilog\Jalali\Jalalian::fromDateTime($automation->feeding_date)->toDateString() : '-' }}
                   </span>
                </div>
                <div class="flex justify-between items-start py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">لینک API:</span>
                    <span class="text-sm text-gray-900 text-left max-w-xs break-all">
                       {{ $automation->feeding_api_link ? \Illuminate\Support\Str::limit($automation->feeding_api_link, 50) : '-' }}
                   </span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">تاریخ اتصال:</span>
                    <span class="text-sm text-gray-900">
                       {{ $automation->feeding_linked_date ? \Morilog\Jalali\Jalalian::fromDateTime($automation->feeding_linked_date)->toDateString() : '-' }}
                   </span>
                </div>
                @if($automation->feedingCompany)
                    <div class="pt-2">
                        <a href="{{ route('panel.companies.index', 'table-search=' . $automation->feedingCompany->national_id) }}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-green-600 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            مشاهده جزئیات شرکت
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- System Information -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-purple-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    اطلاعات سیستم
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">تاریخ ایجاد:</span>
                    <span class="text-sm text-gray-900">
                       {{ $automation->created_at ? \Morilog\Jalali\Jalalian::fromDateTime($automation->created_at)->toDateString() : '-' }}
                   </span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">آخرین بروزرسانی:</span>
                    <span class="text-sm text-gray-900">
                       {{ $automation->updated_at ? \Morilog\Jalali\Jalalian::fromDateTime($automation->updated_at)->toDateString() : '-' }}
                   </span>
                </div>
            </div>
        </div>
    </div>

    <!-- API Links Details (if available) -->
    @if($automation->climate_api_link || $automation->feeding_api_link)
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-orange-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    لینک‌های API
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($automation->climate_api_link)
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                            <h4 class="text-sm font-semibold text-blue-900 mb-2">API کنترل اقلیم</h4>
                            <p class="text-sm text-blue-700 break-all">{{ $automation->climate_api_link }}</p>
                            <div class="mt-3 flex items-center space-x-2 rtl:space-x-reverse">
                               <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                   فعال
                               </span>
                                @if($automation->climate_linked_date)
                                    <span class="text-xs text-blue-600">
                                       اتصال: {{ \Morilog\Jalali\Jalalian::fromDateTime($automation->climate_linked_date)->toDateString() }}
                                   </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($automation->feeding_api_link)
                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                            <h4 class="text-sm font-semibold text-green-900 mb-2">API تغذیه و آبیاری</h4>
                            <p class="text-sm text-green-700 break-all">{{ $automation->feeding_api_link }}</p>
                            <div class="mt-3 flex items-center space-x-2 rtl:space-x-reverse">
                               <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                   فعال
                               </span>
                                @if($automation->feeding_linked_date)
                                    <span class="text-xs text-green-600">
                                       اتصال: {{ \Morilog\Jalali\Jalalian::fromDateTime($automation->feeding_linked_date)->toDateString() }}
                                   </span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                @if(!$automation->climate_api_link && !$automation->feeding_api_link)
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                  d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        <p class="text-gray-500">هیچ لینک API‌ای تنظیم نشده است</p>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
