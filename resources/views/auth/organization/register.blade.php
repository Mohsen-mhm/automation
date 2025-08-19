@extends('auth.layouts.app')

@section('title', 'ثبت کاربر سازمانی جدید')

@section('content')
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
                            class="absolute top-1/2 left-1/2 w-64 h-64 bg-blue-50 rounded-full -translate-x-32 -translate-y-32 opacity-40"></div>
                    </div>

                    <!-- Header -->
                    <div class="text-center mb-12">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl mb-8 shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h1 class="text-4xl font-bold text-slate-800 mb-4">ثبت کاربر سازمانی جدید</h1>
                        <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                            اطلاعات کاربری خود را با دقت تکمیل کنید تا در سامانه ثبت شود
                        </p>
                    </div>

                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 13l4 4L19 7"/>
                                </svg>
                                <p class="text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <p class="text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Registration Form -->
                    <form action="{{ route('register.organization.submit') }}" method="POST"
                          enctype="multipart/form-data" class="space-y-10">
                        @csrf

                        <!-- Section 1: Personal Information -->
                        <div class="space-y-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center">
                                    <span class="text-white font-bold">۱</span>
                                </div>
                                <h2 class="text-2xl font-bold text-slate-800">اطلاعات شخصی</h2>
                            </div>

                            <div class="grid gap-6 md:grid-cols-2">
                                <!-- First Name -->
                                <div class="space-y-2">
                                    <label for="fname"
                                           class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                        <span>نام</span>
                                        <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                        </svg>
                                    </label>
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <svg
                                                class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <input
                                            type="text"
                                            id="fname"
                                            name="fname"
                                            value="{{ old('fname') }}"
                                            class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400 @error('fname') border-red-500 bg-red-50 @enderror"
                                            placeholder="علی"
                                            required>
                                    </div>
                                    @error('fname')
                                    <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="font-medium">{{ $message }}</span>
                                    </div>
                                    @enderror
                                </div>

                                <!-- Last Name -->
                                <div class="space-y-2">
                                    <label for="lname"
                                           class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                        <span>نام خانوادگی</span>
                                        <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                        </svg>
                                    </label>
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <svg
                                                class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <input
                                            type="text"
                                            id="lname"
                                            name="lname"
                                            value="{{ old('lname') }}"
                                            class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400 @error('lname') border-red-500 bg-red-50 @enderror"
                                            placeholder="احمدی"
                                            required>
                                    </div>
                                    @error('lname')
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

                            <!-- National ID -->
                            <div class="space-y-2">
                                <label for="national_id"
                                       class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span>کد ملی</span>
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
                                                  d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="national_id"
                                        name="national_id"
                                        value="{{ old('national_id') }}"
                                        class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400 @error('national_id') border-red-500 bg-red-50 @enderror"
                                        placeholder="2281234567"
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
                        </div>

                        <!-- Section 2: Organization Information -->
                        <div class="space-y-6 pt-8 border-t border-slate-200">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-green-500 rounded-xl flex items-center justify-center">
                                    <span class="text-white font-bold">۲</span>
                                </div>
                                <h2 class="text-2xl font-bold text-slate-800">اطلاعات سازمانی</h2>
                            </div>

                            <div class="grid gap-6 md:grid-cols-2">
                                <!-- Organization Name -->
                                <div class="space-y-2">
                                    <label for="organization_name"
                                           class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                        <span>سازمان</span>
                                        <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                        </svg>
                                    </label>
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <svg
                                                class="h-5 w-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                        <input
                                            type="text"
                                            id="organization_name"
                                            name="organization_name"
                                            value="{{ old('organization_name') }}"
                                            class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400 @error('organization_name') border-red-500 bg-red-50 @enderror"
                                            placeholder="جهاد"
                                            required>
                                    </div>
                                    @error('organization_name')
                                    <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="font-medium">{{ $message }}</span>
                                    </div>
                                    @enderror
                                </div>

                                <!-- Organization Level -->
                                <div class="space-y-2">
                                    <label for="organization_level"
                                           class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                        <span>سمت سازمانی</span>
                                        <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                        </svg>
                                    </label>
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <svg
                                                class="h-5 w-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                            </svg>
                                        </div>
                                        <input
                                            type="text"
                                            id="organization_level"
                                            name="organization_level"
                                            value="{{ old('organization_level') }}"
                                            class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400 @error('organization_level') border-red-500 bg-red-50 @enderror"
                                            placeholder="مدیر اجرایی"
                                            required>
                                    </div>
                                    @error('organization_level')
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

                        <!-- Section 3: Location Information -->
                        <div class="space-y-6 pt-8 border-t border-slate-200">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                                    <span class="text-white font-bold">۳</span>
                                </div>
                                <h2 class="text-2xl font-bold text-slate-800">اطلاعات مکانی</h2>
                            </div>

                            <div class="grid gap-6 md:grid-cols-2">
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
                                    <div class="relative">
                                        <select
                                            id="province"
                                            name="province"
                                            class="block w-full py-4 px-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white transition-all duration-200 text-right @error('province') border-red-500 bg-red-50 @enderror"
                                            required>
                                            <option value="">استان را انتخاب کنید</option>
                                            @foreach($provinces as $province)
                                                <option value="{{ $province->name }}"
                                                        data-id="{{ $province->id }}" {{ old('province') == $province->name ? 'selected' : '' }}>
                                                    {{ $province->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>
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
                                    <label for="city"
                                           class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                        <span>شهر</span>
                                        <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                        </svg>
                                    </label>
                                    <div class="relative">
                                        <select
                                            id="city"
                                            name="city"
                                            class="block w-full py-4 px-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white transition-all duration-200 text-right @error('city') border-red-500 bg-red-50 @enderror"
                                            required>
                                            <option value="">ابتدا استان را انتخاب کنید</option>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>
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
                                        <div
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
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
                                            name="address"
                                            value="{{ old('address') }}"
                                            class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400 @error('address') border-red-500 bg-red-50 @enderror"
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
                                        <div
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <svg
                                                class="h-5 w-5 text-slate-400 group-focus-within:text-purple-500 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <input
                                            type="text"
                                            id="postal"
                                            name="postal"
                                            value="{{ old('postal') }}"
                                            class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white transition-all duration-200 text-right placeholder:text-slate-400 @error('postal') border-red-500 bg-red-50 @enderror"
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
                                <!-- Landline Number -->
                                <div class="space-y-2">
                                    <label for="landline_number" class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                        <span>شماره تلفن ثابت</span>
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                        </div>
                                        <input
                                            type="text"
                                            id="landline_number"
                                            name="landline_number"
                                            value="{{ old('landline_number') }}"
                                            class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400 @error('landline_number') border-red-500 bg-red-50 @enderror"
                                            placeholder="07123456789" required>
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

                                <!-- Mobile Number -->
                                <div class="space-y-2">
                                    <label for="phone_number"
                                           class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                        <span>شماره تلفن همراه</span>
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <input
                                            type="text"
                                            id="phone_number"
                                            name="phone_number"
                                            value="{{ old('phone_number') }}"
                                            class="block w-full pr-12 py-4 text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:bg-white transition-all duration-200 text-left placeholder:text-slate-400 @error('phone_number') border-red-500 bg-red-50 @enderror"
                                            placeholder="09123456789"
                                            required>
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
                        </div>

                        <!-- Section 5: Documents -->
                        <div class="space-y-6 pt-8 border-t border-slate-200">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="w-10 h-10 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl flex items-center justify-center">
                                    <span class="text-white font-bold">۵</span>
                                </div>
                                <h2 class="text-2xl font-bold text-slate-800">اسناد و مدارک</h2>
                            </div>

                            <div class="grid gap-6 md:grid-cols-2">
                                <!-- National Card -->
                                <div class="space-y-2">
                                    <label for="national_card"
                                           class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                        <span>تصویر کارت ملی</span>
                                        <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                        </svg>
                                    </label>
                                    <div class="relative">
                                        <input
                                            name="national_card"
                                            class="block w-full py-4 px-4 text-sm text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl cursor-pointer focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition-all duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 @error('national_card') border-red-500 bg-red-50 @enderror"
                                            id="national_card"
                                            type="file"
                                            accept="image/*"
                                            required>
                                    </div>
                                    @error('national_card')
                                    <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="font-medium">{{ $message }}</span>
                                    </div>
                                    @enderror
                                </div>

                                <!-- Personnel Card -->
                                <div class="space-y-2">
                                    <label for="personnel_card"
                                           class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                        <span>تصویر کارت پرسنلی</span>
                                        <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                        </svg>
                                    </label>
                                    <div class="relative">
                                        <input
                                            name="personnel_card"
                                            class="block w-full py-4 px-4 text-sm text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl cursor-pointer focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition-all duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 @error('personnel_card') border-red-500 bg-red-50 @enderror"
                                            id="personnel_card"
                                            type="file"
                                            accept="image/*"
                                            required>
                                    </div>
                                    @error('personnel_card')
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
                                <!-- Introduction Letter -->
                                <div class="space-y-2">
                                    <label for="introduction_letter"
                                           class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                        <span>تصویر معرفی نامه</span>
                                        <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                        </svg>
                                    </label>
                                    <div class="relative">
                                        <input
                                            name="introduction_letter"
                                            class="block w-full py-4 px-4 text-sm text-slate-900 bg-slate-50/50 border border-slate-200 rounded-xl cursor-pointer focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition-all duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 @error('introduction_letter') border-red-500 bg-red-50 @enderror"
                                            id="introduction_letter"
                                            type="file"
                                            accept="image/*"
                                            required>
                                    </div>
                                    @error('introduction_letter')
                                    <div class="flex items-center gap-2 text-red-600 text-sm mt-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="font-medium">{{ $message }}</span>
                                    </div>
                                    @enderror
                                </div>

                                <!-- Sample Introduction Letter -->
                                <div class="space-y-2">
                                    <div
                                        class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-teal-50 to-cyan-50 rounded-xl border border-teal-200">
                                        <span class="text-center font-bold text-teal-800 mb-4">معرفی نامه نمونه</span>
                                        <div
                                            class="w-96 h-96 bg-gradient-to-br from-white to-gray-50 rounded-lg shadow-lg border-2 border-teal-200 flex items-center justify-center">
                                            <img src="{{ asset('assets/img/sample-cover-letter.jpg') }}"
                                                 class="mx-auto mb-2" alt="معرفی نامه نمونه">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-8 border-t border-slate-200">
                            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                                <button
                                    type="submit"
                                    class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-4 px-12 rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transform hover:scale-102 transition-all duration-200 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
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
                                        <h3 class="text-lg font-semibold text-red-800 mb-2">اطمینان حاصل کنید که تمامی
                                            الزامات به درستی وارد شده است.</h3>
                                        <p class="text-red-700">لطفاً خطاهای موجود در فرم را بررسی و اصلاح کنید.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>

                <!-- Footer Help -->
                <div class="text-center mt-8">
                    <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-white/40 flex justify-around items-center">
                        <div>
                            <p class="text-slate-600 mb-4">نیاز به راهنمایی دارید؟</p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                                <a href="{{ route('contact.us') }}"
                                   class="text-blue-600 hover:text-blue-700 font-medium transition-colors flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    تماس با پشتیبانی
                                </a>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mt-4">
                                قبلاً ثبت نام کرده‌اید؟
                                <a href="{{ route('login.organization') }}"
                                   class="text-blue-600 hover:text-blue-700 font-medium transition-colors">ورود</a>
                            </p>
                            <p class="text-sm text-slate-500 mt-4">
                                <a href="{{ route('home') }}"
                                   class="text-blue-600 hover:text-blue-700 font-medium transition-colors">بازگشت به صفحه اصلی</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- JavaScript -->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const provinceSelect = document.getElementById('province');
                    const citySelect = document.getElementById('city');

                    // Handle province change
                    provinceSelect.addEventListener('change', function () {
                        const selectedOption = this.options[this.selectedIndex];
                        const provinceId = selectedOption.getAttribute('data-id');

                        // Clear city options
                        citySelect.innerHTML = '<option value="">در حال بارگذاری...</option>';
                        citySelect.disabled = true;

                        if (provinceId) {
                            // Fetch cities for selected province
                            fetch(`{{ route('register.organization.cities') }}?province_id=${provinceId}`, {
                                method: 'GET',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                                .then(response => response.json())
                                .then(data => {
                                    citySelect.innerHTML = '<option value="">شهر را انتخاب کنید</option>';

                                    if (data.success && data.cities) {
                                        data.cities.forEach(city => {
                                            const option = document.createElement('option');
                                            option.value = city.name;
                                            option.textContent = city.name;
                                            option.setAttribute('data-id', city.id);

                                            // Select old city if it exists
                                            if ('{{ old('city') }}' === city.name) {
                                                option.selected = true;
                                            }

                                            citySelect.appendChild(option);
                                        });
                                    }

                                    citySelect.disabled = false;
                                })
                                .catch(error => {
                                    console.error('Error loading cities:', error);
                                    citySelect.innerHTML = '<option value="">خطا در بارگذاری شهرها</option>';
                                    citySelect.disabled = false;
                                });
                        } else {
                            citySelect.innerHTML = '<option value="">ابتدا استان را انتخاب کنید</option>';
                            citySelect.disabled = false;
                        }
                    });

                    // Trigger province change if old value exists (for form errors)
                    if (provinceSelect.value && '{{ old('province') }}') {
                        provinceSelect.dispatchEvent(new Event('change'));
                    }
                    // Form validation
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
        </div>

        <script src="{{ asset('assets/js/jquery/jquery-3.7.1.min.js') }}"></script>
    </div>
@endsection
