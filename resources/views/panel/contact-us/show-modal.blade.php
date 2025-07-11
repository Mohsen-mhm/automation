<div class="bg-white rounded-xl overflow-hidden">
    <!-- Contact Information Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
        <!-- Name -->
        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 text-blue-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <h4 class="text-sm font-semibold text-gray-700">نام فرستنده</h4>
            </div>
            <p class="text-gray-900 font-medium">{{ $contactUs->name ?: '-' }}</p>
        </div>

        <!-- Email -->
        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 text-green-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <h4 class="text-sm font-semibold text-gray-700">آدرس ایمیل</h4>
            </div>
            <p class="text-gray-900 font-medium">{{ $contactUs->email ?: '-' }}</p>
        </div>

        <!-- Phone -->
        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 text-purple-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <h4 class="text-sm font-semibold text-gray-700">شماره تلفن</h4>
            </div>
            <p class="text-gray-900 font-medium">{{ $contactUs->phone ?: '-' }}</p>
        </div>

        <!-- Date -->
        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 text-orange-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h4 class="text-sm font-semibold text-gray-700">تاریخ ارسال</h4>
            </div>
            <p class="text-gray-900 font-medium">{{ $contactUs->created_at ? $contactUs->created_at->format('Y/m/d H:i') : '-' }}</p>
        </div>
    </div>

    <!-- Subject -->
    <div class="px-6 pb-4">
        <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
            <div class="flex items-center mb-3">
                <svg class="w-5 h-5 text-blue-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                <h4 class="text-sm font-semibold text-gray-700">موضوع پیام</h4>
            </div>
            <p class="text-gray-900 font-medium text-lg">{{ $contactUs->subject ?: '-' }}</p>
        </div>
    </div>

    <!-- Message -->
    <div class="px-6 pb-6">
        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
            <div class="flex items-center mb-3">
                <svg class="w-5 h-5 text-gray-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h4 class="text-sm font-semibold text-gray-700">متن پیام</h4>
            </div>
            <div class="bg-white rounded-lg p-4 border border-gray-200 max-h-64 overflow-y-auto">
                <p class="text-gray-900 leading-relaxed whitespace-pre-wrap">{{ $contactUs->message ?: 'پیامی وجود ندارد.' }}</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3 rtl:space-x-reverse">
        <!-- Reply Button (if email exists) -->
        @if($contactUs->email)
            <a href="mailto:{{ $contactUs->email }}?subject=Re: {{ $contactUs->subject }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                پاسخ به ایمیل
            </a>
        @endif

        <!-- Call Button (if phone exists) -->
        @if($contactUs->phone)
            <a href="tel:{{ $contactUs->phone }}"
               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                تماس تلفنی
            </a>
        @endif

        <!-- Close Button -->
        <button onclick="closeShowModal()"
                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors duration-200">
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            بستن
        </button>
    </div>
</div>
