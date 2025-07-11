<div class="space-y-6">
    <!-- Greenhouse Header -->
    <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl p-6 text-white">
        <div class="flex items-center space-x-4 rtl:space-x-reverse">
            @if($greenhouse->image)
                <img src="{{ asset($greenhouse->image) }}" alt="تصویر {{ $greenhouse->name }}"
                     class="w-16 h-16 object-cover rounded-xl border-2 border-white/20">
            @else
                <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7.24 7.194a24.16 24.16 0 0 1 3.72-3.062m0 0c3.443-2.277 6.732-2.969 8.24-1.46 2.054 2.053.03 7.407-4.522 11.959-4.552 4.551-9.906 6.576-11.96 4.522C1.223 17.658 1.89 14.412 4.121 11m6.838-6.868c-3.443-2.277-6.732-2.969-8.24-1.46-2.054 2.053-.03 7.407 4.522 11.959m3.718-10.499a24.16 24.16 0 0 1 3.719 3.062M17.798 11c2.23 3.412 2.898 6.658 1.402 8.153-1.502 1.503-4.771.822-8.2-1.433m1-6.808a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/>
                    </svg>
                </div>
            @endif
            <div>
                <h2 class="text-2xl font-bold">{{ $greenhouse->name }}</h2>
                <p class="text-green-100">شماره پروانه: {{ $greenhouse->licence_number }}</p>
                <div class="flex items-center space-x-2 rtl:space-x-reverse mt-2">
                    @if($greenhouse->active)
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
                        $statusConfig = match($greenhouse->status) {
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

    <!-- Greenhouse Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-green-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    اطلاعات پایه
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">نوع بستر:</span>
                    <span class="text-sm text-gray-900">{{ $greenhouse->substrate_type }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">نوع محصول:</span>
                    <span class="text-sm text-gray-900">{{ $greenhouse->product_type }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">متراژ:</span>
                    <span class="text-sm text-gray-900">{{ $greenhouse->meterage }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">وضعیت گلخانه:</span>
                    <span class="text-sm text-gray-900">{{ $greenhouse->greenhouse_status }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">تاریخ احداث:</span>
                    <span class="text-sm text-gray-900">
                       {{ $greenhouse->construction_date ? \Morilog\Jalali\Jalalian::fromDateTime($greenhouse->construction_date)->toDateString() : '-' }}
                   </span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">تاریخ بهره برداری:</span>
                    <span class="text-sm text-gray-900">
                       {{ $greenhouse->operation_date ? \Morilog\Jalali\Jalalian::fromDateTime($greenhouse->operation_date)->toDateString() : '-' }}
                   </span>
                </div>
            </div>
        </div>

        <!-- Owner Information -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-emerald-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    اطلاعات مالک
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">نام مالک:</span>
                    <span class="text-sm text-gray-900">{{ $greenhouse->owner_name }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">تلفن مالک:</span>
                    <span class="text-sm text-gray-900 font-mono">{{ $greenhouse->owner_phone }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">کد ملی مالک:</span>
                    <span class="text-sm text-gray-900 font-mono">{{ $greenhouse->owner_national_id }}</span>
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
                    <span class="text-sm text-gray-900">{{ $greenhouse->province->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">شهر:</span>
                    <span class="text-sm text-gray-900">{{ $greenhouse->city->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-start py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">آدرس:</span>
                    <span class="text-sm text-gray-900 text-left max-w-xs">{{ $greenhouse->address }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-600">کد پستی:</span>
                    <span class="text-sm text-gray-900 font-mono">{{ $greenhouse->postal }}</span>
                </div>
                @if($greenhouse->coordinates)
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm font-medium text-gray-600">مختصات:</span>
                        <span class="text-sm text-gray-900 font-mono">{{ $greenhouse->coordinates }}</span>
                    </div>
                @endif
                @if($greenhouse->location_link)
                    <div class="pt-2">
                        <a href="{{ $greenhouse->location_link }}" target="_blank"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-green-600 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            مشاهده در گوگل مپ
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Systems & Features -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-orange-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    سامانه‌ها و امکانات
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 gap-6">
                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        @if($greenhouse->climate_system)
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">سامانه کنترل اقلیم</p>
                                <p class="text-xs text-green-600">موجود</p>
                            </div>
                        @else
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">سامانه کنترل اقلیم</p>
                                <p class="text-xs text-red-600">موجود نیست</p>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        @if($greenhouse->feeding_system)
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">سامانه تغذیه و آبیاری</p>
                                <p class="text-xs text-green-600">موجود</p>
                            </div>
                        @else
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">سامانه تغذیه و آبیاری</p>
                                <p class="text-xs text-red-600">موجود نیست</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Greenhouse Documents -->
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($greenhouse->image)
                    <div class="text-center">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <img src="{{ asset($greenhouse->image) }}" alt="تصویر گلخانه"
                                 class="w-full h-32 object-cover rounded-lg mb-3">
                            <p class="text-sm font-medium text-gray-900">تصویر گلخانه</p>
                        </div>
                    </div>
                @endif

                @if($greenhouse->operation_licence)
                    <div class="text-center">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <img src="{{ asset($greenhouse->operation_licence) }}" alt="پروانه بهره برداری"
                                 class="w-full h-32 object-cover rounded-lg mb-3">
                            <p class="text-sm font-medium text-gray-900">پروانه بهره برداری</p>
                        </div>
                    </div>
                @endif
            </div>

            @if(!$greenhouse->image && !$greenhouse->operation_licence)
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

    <!-- Additional Info -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 text-purple-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                اطلاعات تکمیلی
            </h3>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-sm font-medium text-gray-600">تاریخ عضویت:</span>
                <span class="text-sm text-gray-900">
                   {{ $greenhouse->created_at ? \Morilog\Jalali\Jalalian::fromDateTime($greenhouse->created_at)->toDateString() : '-' }}
               </span>
            </div>
            <div class="flex justify-between items-center py-2">
                <span class="text-sm font-medium text-gray-600">آخرین بروزرسانی:</span>
                <span class="text-sm text-gray-900">
                   {{ $greenhouse->updated_at ? \Morilog\Jalali\Jalalian::fromDateTime($greenhouse->updated_at)->toDateString() : '-' }}
               </span>
            </div>
        </div>
    </div>
</div>
