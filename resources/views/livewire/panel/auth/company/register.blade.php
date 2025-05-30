<div class="w-full">
    <div class="min-h-screen relative flex items-start justify-center p-4">
        <div class="relative w-full max-w-6xl">
            <!-- Registration Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/20 p-8 md:p-12">
                <!-- Background Decoration -->
                <div class="absolute inset-0 overflow-hidden" style="z-index: -1;">
                    <div
                        class="absolute top-0 left-0 w-96 h-96 bg-blue-100 rounded-full -translate-x-48 -translate-y-48 opacity-50"></div>
                    <div
                        class="absolute bottom-0 right-0 w-80 h-80 bg-indigo-100 rounded-full translate-x-40 translate-y-40 opacity-30"></div>
                    <div
                        class="absolute top-1/2 left-1/2 w-64 h-64 bg-sky-50 rounded-full -translate-x-32 -translate-y-32 opacity-40"></div>
                </div>

                <!-- Header -->
                <div class="text-center mb-12">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl mb-8 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h1 class="text-4xl font-bold text-slate-800 mb-4">ثبت شرکت جدید</h1>
                    <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                        اطلاعات شرکت خود را با دقت تکمیل کنید تا در سامانه ثبت شود
                    </p>
                </div>

                <!-- Registration Form -->
                <form wire:submit="register" enctype="multipart/form-data" class="space-y-10">
                    @csrf

                    <!-- Section 1: Basic Company Information -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center">
                                <span class="text-white font-bold">۱</span>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-800">اطلاعات پایه شرکت</h2>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Company Name -->
                            <div class="space-y-2">
                                <label for="name" class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>نام شرکت</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg
                                            class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="name"
                                        wire:model="name"
                                        class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400"
                                        placeholder="شرکت سیمرغ"
                                        required>
                                </div>
                                @error('name')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <!-- Company Type -->
                            <div class="space-y-2">
                                <label for="type" class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>نوع شرکت</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <select
                                    id="type"
                                    wire:model="type"
                                    wire:ignore
                                    class="block w-full py-4 px-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200 text-right"
                                    required>
                                    <option value="">نوع شرکت را انتخاب کنید</option>
                                    @foreach ($companyTypes as $companyType)
                                        <option value="{{ $companyType }}">{{ $companyType }}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- National ID -->
                            <div class="space-y-2">
                                <label for="national_id"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>شناسه ملی</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg
                                            class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="national_id"
                                        wire:model="national_id"
                                        class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400"
                                        placeholder="1016110254"
                                        required>
                                </div>
                                @error('national_id')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <!-- Registration Number -->
                            <div class="space-y-2">
                                <label for="registration_number"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>شماره ثبت</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg
                                            class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="registration_number"
                                        wire:model="registration_number"
                                        class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400"
                                        placeholder="123456"
                                        required>
                                </div>
                                @error('registration_number')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Registration Place -->
                            <div class="space-y-2">
                                <label for="registration_place"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>محل ثبت</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg
                                            class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="registration_place"
                                        wire:model="registration_place"
                                        class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400"
                                        placeholder="شیراز"
                                        required>
                                </div>
                                @error('registration_place')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <!-- Postal Code -->
                            <div class="space-y-2">
                                <label for="postal"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>کد پستی</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg
                                            class="h-5 w-5 text-slate-400 group-focus-within:text-green-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="postal"
                                        wire:model="postal"
                                        class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400"
                                        placeholder="718123456"
                                        required>
                                </div>
                                @error('postal')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Location Link -->
                            <div class="space-y-2">
                                <label for="location_link"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>لینک لوکیشن شرکت (از گوگل مپ)</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg
                                            class="h-5 w-5 text-slate-400 group-focus-within:text-green-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="location_link"
                                        wire:model.blur="location_link"
                                        dir="ltr"
                                        class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400"
                                        placeholder="https://maps.app.goo.gl/.....">
                                </div>
                                @error('location_link')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="space-y-2">
                                <label for="address"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>آدرس</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg
                                            class="h-5 w-5 text-slate-400 group-focus-within:text-purple-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="address"
                                        wire:model="address"
                                        class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400"
                                        placeholder="بلوار پاسداران، ..."
                                        required>
                                </div>
                                @error('address')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Location Information -->
                    <div class="space-y-6 pt-8 border-t border-slate-200">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl flex items-center justify-center">
                                <span class="text-white font-bold">۲</span>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-800">اطلاعات مکانی</h2>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2 ir-select">
                            <!-- Province -->
                            <div class="space-y-2">
                                <label for="province"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>استان</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <select
                                    id="province"
                                    wire:model="province"
                                    wire:ignore
                                    class="ir-province block w-full py-4 px-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white transition-all duration-200 text-right"
                                    required>
                                </select>
                                @error('province')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <!-- City -->
                            <div class="space-y-2">
                                <label for="city" class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>شهر</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <select
                                    id="city"
                                    wire:model="city"
                                    wire:ignore
                                    class="ir-city block w-full py-4 px-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white transition-all duration-200 text-right"
                                    required>
                                </select>
                                @error('city')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Landline Number -->
                            <div class="space-y-2">
                                <label for="landline_number"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>شماره تلفن ثابت شرکت</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <div class="relative group">
                                    <div
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg
                                            class="h-5 w-5 text-slate-400 group-focus-within:text-orange-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="landline_number"
                                        wire:model="landline_number"
                                        class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400"
                                        placeholder="07123456789"
                                        required>
                                </div>
                                @error('landline_number')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <!-- Company Mobile -->
                            <div class="space-y-2">
                                <label for="phone_number" class="block text-sm font-semibold text-slate-700">
                                    شماره تلفن همراه شرکت
                                </label>
                                <div class="relative group">
                                    <div
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg
                                            class="h-5 w-5 text-slate-400 group-focus-within:text-orange-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="phone_number"
                                        wire:model="phone_number"
                                        class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400"
                                        placeholder="09123456789">
                                </div>
                                @error('phone_number')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Website -->
                            <div class="space-y-2">
                                <label for="website"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>آدرس وب سایت شرکت</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <div class="relative group">
                                    <div
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg
                                            class="h-5 w-5 text-slate-400 group-focus-within:text-orange-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="website"
                                        wire:model="website"
                                        class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400"
                                        placeholder="https://company.ir"
                                        required>
                                </div>
                                @error('website')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="space-y-2">
                                <label for="email"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>آدرس ایمیل شرکت</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <div class="relative group">
                                    <div
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg
                                            class="h-5 w-5 text-slate-400 group-focus-within:text-orange-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="email"
                                        id="email"
                                        wire:model="email"
                                        class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400"
                                        placeholder="info@company.ir"
                                        required>
                                </div>
                                @error('email')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Management Information -->
                    <div class="space-y-6 pt-8 border-t border-slate-200">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                                <span class="text-white font-bold">۳</span>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-800">اطلاعات مدیریت</h2>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- CEO Name -->
                            <div class="space-y-2">
                                <label for="ceo_name"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>نام مدیرعامل</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg
                                            class="h-5 w-5 text-slate-400 group-focus-within:text-purple-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="ceo_name"
                                        wire:model="ceo_name"
                                        class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400"
                                        placeholder="محسن محمدی"
                                        required>
                                </div>
                                @error('ceo_name')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <!-- CEO National ID -->
                            <div class="space-y-2">
                                <label for="ceo_national_id"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>کد ملی مدیر عامل</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg
                                            class="h-5 w-5 text-slate-400 group-focus-within:text-purple-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="ceo_national_id"
                                        wire:model="ceo_national_id"
                                        class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400"
                                        placeholder="2281234567"
                                        required>
                                </div>
                                @error('ceo_national_id')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-3">
                            <!-- CEO Phone -->
                            <div class="space-y-2">
                                <label for="ceo_phone"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>تلفن همراه مدیر عامل</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg
                                            class="h-5 w-5 text-slate-400 group-focus-within:text-purple-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="ceo_phone"
                                        wire:model="ceo_phone"
                                        class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400"
                                        placeholder="09123456789"
                                        required>
                                </div>
                                @error('ceo_phone')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <!-- Climate System -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-4">سامانه کنترل
                                    اقلیم</label>
                                <div
                                    class="flex items-center p-4 bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl border border-emerald-200">
                                    <input
                                        id="climate_system"
                                        type="checkbox"
                                        value="0"
                                        wire:model="climate_system"
                                        class="w-5 h-5 text-emerald-600 bg-white border-emerald-300 rounded focus:ring-emerald-500 focus:ring-2">
                                    <label for="climate_system" class="mr-3 text-sm font-medium text-emerald-800">
                                        دارای سامانه کنترل اقلیم
                                    </label>
                                </div>
                                @error('climate_system')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <!-- Feeding System -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-4">سامانه تغذیه و
                                    آبیاری</label>
                                <div
                                    class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                                    <input
                                        id="feeding_system"
                                        type="checkbox"
                                        value="0"
                                        wire:model="feeding_system"
                                        class="w-5 h-5 text-blue-600 bg-white border-blue-300 rounded focus:ring-blue-500 focus:ring-2">
                                    <label for="feeding_system" class="mr-3 text-sm font-medium text-blue-800">
                                        دارای سامانه تغذیه و آبیاری
                                    </label>
                                </div>
                                @error('feeding_system')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Contact Information -->
                    <div class="space-y-6 pt-8 border-t border-slate-200">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center">
                                <span class="text-white font-bold">۴</span>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-800">اطلاعات تماس</h2>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Interface Name -->
                            <div class="space-y-2">
                                <label for="interface_name"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>نام رابط</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg
                                            class="h-5 w-5 text-slate-400 group-focus-within:text-orange-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="interface_name"
                                        wire:model="interface_name"
                                        class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400"
                                        placeholder="محسن"
                                        required>
                                </div>
                                @error('interface_name')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <!-- Interface Phone -->
                            <div class="space-y-2">
                                <label for="interface_phone"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>تلفن همراه رابط</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg
                                            class="h-5 w-5 text-slate-400 group-focus-within:text-orange-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="interface_phone"
                                        wire:model="interface_phone"
                                        class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400"
                                        placeholder="09123456789"
                                        required>
                                </div>
                                @error('interface_phone')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Registration Date -->
                        <div class="space-y-2">
                            <label for="registration_date"
                                   class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                <span>تاریخ ثبت</span>
                                <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                </svg>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg
                                        class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    id="registration_date"
                                    wire:model="registration_date"
                                    class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400"
                                    placeholder="1400/05/24"
                                    required>
                            </div>
                            @error('registration_date')
                            <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-medium">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Section 5: Brand & Documents -->
                    <div class="space-y-6 pt-8 border-t border-slate-200">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-violet-500 to-purple-500 rounded-xl flex items-center justify-center">
                                <span class="text-white font-bold">۵</span>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-800">علامت تجاری و اسناد</h2>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Brand -->
                            <div class="space-y-2">
                                <label for="brand"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>علامت تجاری</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <div class="relative group">
                                    <div
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg
                                            class="h-5 w-5 text-slate-400 group-focus-within:text-violet-500 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="brand"
                                        wire:model="brand"
                                        class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400"
                                        placeholder="سیمرغ"
                                        required>
                                </div>
                                @error('brand')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <!-- Official Newspaper -->
                            <div class="space-y-2">
                                <label for="official_newspaper"
                                       class="block text-sm font-semibold text-slate-700">
                                    روزنامه رسمی آخرین تغییرات شرکت
                                </label>
                                <input
                                    type="file"
                                    id="official_newspaper"
                                    wire:model="official_newspaper"
                                    accept="image/*,.pdf"
                                    class="block w-full py-4 px-4 text-sm text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl cursor-pointer focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition-all duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                                @error('official_newspaper')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Company Logo -->
                            <div class="space-y-2">
                                <label for="company_logo"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>تصویر لوگو شرکت</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <input
                                    type="file"
                                    id="company_logo"
                                    wire:model="company_logo"
                                    class="block w-full py-4 px-4 text-sm text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl cursor-pointer focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition-all duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100"
                                    required>
                                @error('company_logo')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <!-- Operation License -->
                            <div class="space-y-2">
                                <label for="operation_licence"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>مجوز فناوری یا پروانه بهره برداری</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <input
                                    type="file"
                                    id="operation_licence"
                                    wire:model="operation_licence"
                                    class="block w-full py-4 px-4 text-sm text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl cursor-pointer focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition-all duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100"
                                    required>
                                @error('operation_licence')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Brand Logo -->
                            <div class="space-y-2">
                                <label for="brand_logo"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>تصویر علامت تجاری</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <input
                                    type="file"
                                    id="brand_logo"
                                    wire:model="brand_logo"
                                    class="block w-full py-4 px-4 text-sm text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl cursor-pointer focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition-all duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100"
                                    required>
                                @error('brand_logo')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>

                            <!-- Trademark Certificate -->
                            <div class="space-y-2">
                                <label for="trademark_certificate"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>گواهی ثبت علامت تجاری</span>
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </label>
                                <input
                                    type="file"
                                    id="trademark_certificate"
                                    wire:model="trademark_certificate"
                                    class="block w-full py-4 px-4 text-sm text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl cursor-pointer focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition-all duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100"
                                    required>
                                @error('trademark_certificate')
                                <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-8 border-t border-slate-200">
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <button
                                type="submit"
                                class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-4 px-12 rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transform hover:scale-102 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <div class="flex items-center justify-center gap-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    ثبت و ارسال
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- Error Summary -->
                    @if($errors->any())
                        <div
                            class="mt-8 p-6 bg-gradient-to-r from-red-50 to-red-100 rounded-2xl border border-red-200">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-red-800 mb-2">اطمینان حاصل کنید که
                                        تمامی
                                        الزامات به درستی وارد شده است.</h3>
                                    <p class="text-red-700">
                                        لطفاً خطاهای موجود در فرم را بررسی و اصلاح کنید.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Footer Help -->
            <div class="text-center mt-8">
                <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-white/40">
                    <p class="text-slate-600 mb-4">نیاز به راهنمایی دارید؟</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="#"
                           class="text-blue-600 hover:text-blue-700 font-medium transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            تماس با پشتیبانی
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Styles -->
        <style>
            /* Custom focus styles for different sections */
            .group:focus-within .group-focus-within\:text-blue-500 {
                color: #3b82f6;
            }

            .group:focus-within .group-focus-within\:text-green-500 {
                color: #10b981;
            }

            .group:focus-within .group-focus-within\:text-purple-500 {
                color: #8b5cf6;
            }

            .group:focus-within .group-focus-within\:text-orange-500 {
                color: #f97316;
            }

            .group:focus-within .group-focus-within\:text-violet-500 {
                color: #8b5cf6;
            }

            /* Enhanced form validation styles */
            input:invalid:not(:focus):not(:placeholder-shown),
            select:invalid:not(:focus) {
                border-color: #ef4444;
                background-color: #fef2f2;
            }

            input:valid:not(:focus):not(:placeholder-shown),
            select:valid:not(:focus) {
                border-color: #10b981;
                background-color: #f0fdf4;
            }

            /* Smooth transitions */
            * {
                transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
                transition-duration: 150ms;
            }

            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f5f9;
            }

            ::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }

            /* File input styling */
            input[type="file"]::file-selector-button {
                margin-right: 1rem;
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                border: none;
                font-size: 0.875rem;
                font-weight: 500;
                background-color: rgb(240 253 244);
                color: rgb(21 128 61);
                cursor: pointer;
                transition: background-color 150ms ease;
            }

            input[type="file"]::file-selector-button:hover {
                background-color: rgb(220 252 231);
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <!-- Enhanced JavaScript -->
        <script>
            // Real-time form validation
            document.addEventListener('DOMContentLoaded', function () {
                const inputs = document.querySelectorAll('input[required], select[required]');

                inputs.forEach(input => {
                    input.addEventListener('blur', function () {
                        if (this.checkValidity()) {
                            this.classList.add('valid');
                            this.classList.remove('invalid');
                        } else {
                            this.classList.add('invalid');
                            this.classList.remove('valid');
                        }
                    });

                    input.addEventListener('input', function () {
                        if (this.value && this.checkValidity()) {
                            this.classList.add('valid');
                            this.classList.remove('invalid');
                        }
                    });
                });

                // Form submission loading state
                const form = document.querySelector('form');
                const submitButton = form.querySelector('button[type="submit"]');

                form.addEventListener('submit', function () {
                    submitButton.innerHTML = `
                        <div class="flex items-center justify-center gap-3">
                            <svg class="w-6 h-6 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            در حال ثبت اطلاعات...
                        </div>
                    `;
                    submitButton.disabled = true;
                });
            });
        </script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="./../assets/js/ir-city-select/ir-city-select.js"></script>
    </div>
</div>
