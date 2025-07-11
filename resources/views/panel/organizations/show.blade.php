<div class="space-y-6">
    <!-- Organization Header -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-6 text-white">
        <div class="flex items-center space-x-4 rtl:space-x-reverse">
            <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold">{{ $organization->fname }} {{ $organization->lname }}</h2>
                <p class="text-indigo-100">{{ $organization->organization_name }}</p>
                <div class="flex items-center space-x-2 rtl:space-x-reverse mt-2">
                    @if($organization->active)
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
                        $statusConfig = match($organization->status) {
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

    <!-- Organization Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Personal Information -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-blue-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    اطلاعات شخصی
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">نام:</span>
                    <span class="text-sm text-gray-900">{{ $organization->fname }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">نام خانوادگی:</span>
                    <span class="text-sm text-gray-900">{{ $organization->lname }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">کد ملی:</span>
                    <span class="text-sm text-gray-900 font-mono">{{ $organization->national_id }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">تاریخ عضویت:</span>
                    <span class="text-sm text-gray-900">
                        {{ $organization->created_at ? \Morilog\Jalali\Jalalian::fromDateTime($organization->created_at)->toDateString() : '-' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Organization Information -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-emerald-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    اطلاعات سازمانی
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">نام سازمان:</span>
                    <span class="text-sm text-gray-900">{{ $organization->organization_name }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">سمت سازمانی:</span>
                    <span class="text-sm text-gray-900">{{ $organization->organization_level }}</span>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-purple-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    اطلاعات تماس
                </h3>
            </div>
            <div class="p-6 space-y-4">
                @if($organization->landline_number)
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600">تلفن ثابت:</span>
                        <span class="text-sm text-gray-900 font-mono">{{ $organization->landline_number }}</span>
                    </div>
                @endif
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">تلفن همراه:</span>
                    <span class="text-sm text-gray-900 font-mono">{{ $organization->phone_number }}</span>
                </div>
            </div>
        </div>

        <!-- Location Information -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-red-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    اطلاعات مکانی
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">استان:</span>
                    <span class="text-sm text-gray-900">{{ $organization->province }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">شهر:</span>
                    <span class="text-sm text-gray-900">{{ $organization->city }}</span>
                </div>
                <div class="flex justify-between items-start py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">آدرس:</span>
                    <span class="text-sm text-gray-900 text-left max-w-xs">{{ $organization->address }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">کد پستی:</span>
                    <span class="text-sm text-gray-900 font-mono">{{ $organization->postal }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Organization Documents -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 text-cyan-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                مدارک و تصاویر
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @if($nationalCard)
                    <div class="text-center">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <img src="{{ asset($nationalCard) }}" alt="کارت ملی"
                                 class="w-full h-32 object-cover rounded-lg mb-3">
                            <p class="text-sm font-medium text-gray-900">کارت ملی</p>
                        </div>
                    </div>
                @endif

                @if($personnelCard)
                    <div class="text-center">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <img src="{{ asset($personnelCard) }}" alt="کارت پرسنلی"
                                 class="w-full h-32 object-cover rounded-lg mb-3">
                            <p class="text-sm font-medium text-gray-900">کارت پرسنلی</p>
                        </div>
                    </div>
                @endif

                @if($introductionLetter)
                    <div class="text-center">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <img src="{{ asset($introductionLetter) }}" alt="معرفی نامه"
                                 class="w-full h-32 object-cover rounded-lg mb-3">
                            <p class="text-sm font-medium text-gray-900">معرفی نامه</p>
                        </div>
                    </div>
                @endif
            </div>

            @if(!$nationalCard && !$personnelCard && !$introductionLetter)
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-500">هیچ مدرکی آپلود نشده است</p>
                </div>
            @endif
        </div>
    </div>
</div>
