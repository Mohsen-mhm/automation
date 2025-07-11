@extends('layouts.app')

@section('title', 'داشبورد')

@section('content')
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center ml-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        سامانه متمرکز گلخانه‌های برخط
                    </h1>
                    <p class="text-gray-600 mt-2">داشبورد مدیریت و نظارت بر سیستم</p>
                </div>
                <div class="flex flex-row-reverse justify-center items-center space-x-2">
                    @if(isset($credit) && auth()->user()->hasRole(\App\Models\Role::ADMIN_ROLE))
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-200">
                            <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">موجودی پیامک</p>
                                    <p class="text-lg font-bold text-blue-600">{{ $credit }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(auth()->user()->hasRole(\App\Models\Role::ADMIN_ROLE))
                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                            <a href="{{ route('panel.chart-permissions.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                مدیریت دسترسی نمودارها
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if(!$isUserActive)
            <!-- User Inactive Warning -->
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border border-red-200 rounded-2xl p-6">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L4.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-red-800 mb-2">اطلاعات شما در حال بررسی می‌باشد!</h3>
                        <p class="text-red-700">لطفا تا تایید اطلاعات توسط پشتیبانی، صبور باشید. پس از تایید اطلاعات،
                            دسترسی کامل به سیستم برای شما فعال خواهد شد.</p>
                    </div>
                </div>
            </div>
        @else
            @if(auth()->user()->hasRole(\App\Models\Role::ADMIN_ROLE))
                <!-- Admin Dashboard Header with Chart Management Link -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">نمودارها و آمارها</h2>
                        <p class="text-gray-600">مشاهده آمار و نمودارهای سیستم</p>
                    </div>
                    @can(\App\Models\ChartPermission::PERMISSION_MANAGE_CHART_PERMISSIONS)
                        <a href="{{ route('panel.chart-permissions.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                            </svg>
                            مدیریت نمودارها
                        </a>
                    @endcan
                </div>

                <!-- Stats Cards (Always visible for admin) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">کل کاربران</p>
                                <p class="text-3xl font-bold">{{ number_format($statsCards['totalUsers']) }}</p>
                                <p class="text-blue-200 text-xs mt-1">تمام کاربران ثبت‌نام شده</p>
                            </div>
                            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-emerald-100 text-sm font-medium">شرکت‌ها</p>
                                <p class="text-3xl font-bold">{{ number_format($statsCards['totalCompanies']) }}</p>
                                <p class="text-emerald-200 text-xs mt-1">{{ number_format($statsCards['activeCompanies']) }}
                                    فعال</p>
                            </div>
                            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-amber-500 to-amber-600 rounded-2xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-amber-100 text-sm font-medium">گلخانه‌ها</p>
                                <p class="text-3xl font-bold">{{ number_format($statsCards['totalGreenhouses']) }}</p>
                                <p class="text-amber-200 text-xs mt-1">{{ number_format($statsCards['activeGreenhouses']) }}
                                    فعال</p>
                            </div>
                            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7.242 7.194a24.16 24.16 0 0 1 3.72-3.062m0 0c3.443-2.277 6.732-2.969 8.24-1.46 2.054 2.053.03 7.407-4.522 11.959-4.552 4.551-9.906 6.576-11.96 4.522C1.223 17.658 1.89 14.412 4.121 11m6.838-6.868c-3.443-2.277-6.732-2.969-8.24-1.46-2.054 2.053-.03 7.407 4.522 11.959m3.718-10.499a24.16 24.16 0 0 1 3.719 3.062M17.798 11c2.23 3.412 2.898 6.658 1.402 8.153-1.502 1.503-4.771.822-8.2-1.433m1-6.808a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium">اتوماسیون‌ها</p>
                                <p class="text-3xl font-bold">{{ number_format($statsCards['totalAutomations']) }}</p>
                                <p class="text-purple-200 text-xs mt-1">{{ number_format($statsCards['activeAutomations']) }}
                                    فعال</p>
                            </div>
                            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Non-admin users header -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200">
                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">خوش
                                آمدید {{ auth()->user()->getName() }}</h2>
                            <p class="text-gray-600">مشاهده آمار و اطلاعات مربوط به حساب کاربری شما</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Dynamic Charts Based on Permissions -->
            <div class="space-y-8">
                @if(!empty($visibleCharts))
                    <!-- Users Count Chart -->
                    @if(in_array('users_count', $visibleCharts) && isset($chartData['users_count']))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center ml-2">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    تعداد کاربران سامانه
                                </h3>
                            </div>
                            <div class="chart-container" data-chart="bar"
                                 data-data="{{ json_encode($chartData['users_count']) }}" data-height="300"></div>
                        </div>
                    @endif

                    <!-- Company and Greenhouse Charts in Grid -->
                    @if((in_array('company_per_province', $visibleCharts) && isset($chartData['company_per_province'])) || (in_array('greenhouse_per_province', $visibleCharts) && isset($chartData['greenhouse_per_province'])))
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            @if(in_array('company_per_province', $visibleCharts) && isset($chartData['company_per_province']))
                                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                            <div
                                                class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center ml-2">
                                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                            </div>
                                            شرکت‌ها بر حسب استان
                                        </h3>
                                    </div>
                                    <div class="chart-container" data-chart="bar"
                                         data-data="{{ json_encode($chartData['company_per_province']) }}"
                                         data-height="300"></div>
                                </div>
                            @endif

                            @if(in_array('greenhouse_per_province', $visibleCharts) && isset($chartData['greenhouse_per_province']))
                                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                            <div
                                                class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center ml-2">
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M7.242 7.194a24.16 24.16 0 0 1 3.72-3.062m0 0c3.443-2.277 6.732-2.969 8.24-1.46 2.054 2.053.03 7.407-4.522 11.959-4.552 4.551-9.906 6.576-11.96 4.522C1.223 17.658 1.89 14.412 4.121 11m6.838-6.868c-3.443-2.277-6.732-2.969-8.24-1.46-2.054 2.053-.03 7.407 4.522 11.959m3.718-10.499a24.16 24.16 0 0 1 3.719 3.062M17.798 11c2.23 3.412 2.898 6.658 1.402 8.153-1.502 1.503-4.771.822-8.2-1.433m1-6.808a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/>
                                                </svg>
                                            </div>
                                            گلخانه‌ها بر حسب استان
                                        </h3>
                                    </div>
                                    <div class="chart-container" data-chart="bar"
                                         data-data="{{ json_encode($chartData['greenhouse_per_province']) }}"
                                         data-height="300"></div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Automation Charts -->
                    @if((in_array('climate_automation_per_company', $visibleCharts) && isset($chartData['climate_automation_per_company'])) || (in_array('feeding_automation_per_company', $visibleCharts) && isset($chartData['feeding_automation_per_company'])))
                        @if(in_array('climate_automation_per_company', $visibleCharts) && isset($chartData['climate_automation_per_company']))
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                        <div
                                            class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center ml-2">
                                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        تعداد گلخانه‌های اقلیم اجرا شده توسط هر شرکت
                                    </h3>
                                </div>
                                <div class="chart-container" data-chart="bar"
                                     data-data="{{ json_encode($chartData['climate_automation_per_company']) }}"
                                     data-height="400"></div>
                            </div>
                        @endif

                        @if(in_array('feeding_automation_per_company', $visibleCharts) && isset($chartData['feeding_automation_per_company']))
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                        <div
                                            class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center ml-2">
                                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                            </svg>
                                        </div>
                                        تعداد گلخانه‌های تغذیه اجرا شده توسط هر شرکت
                                    </h3>
                                </div>
                                <div class="chart-container" data-chart="bar"
                                     data-data="{{ json_encode($chartData['feeding_automation_per_company']) }}"
                                     data-height="400"></div>
                            </div>
                        @endif
                    @endif

                    <!-- Greenhouse Analysis Charts -->
                    @if((in_array('greenhouses_by_area', $visibleCharts) && isset($chartData['greenhouses_by_area'])) || (in_array('greenhouses_by_product', $visibleCharts) && isset($chartData['greenhouses_by_product'])))
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            @if(in_array('greenhouses_by_area', $visibleCharts) && isset($chartData['greenhouses_by_area']))
                                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                            <div
                                                class="w-8 h-8 bg-cyan-100 rounded-lg flex items-center justify-center ml-2">
                                                <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                                </svg>
                                            </div>
                                            گلخانه‌ها بر حسب متراژ
                                        </h3>
                                    </div>
                                    <div class="chart-container" data-chart="doughnut"
                                         data-data="{{ json_encode($chartData['greenhouses_by_area']) }}"
                                         data-height="300"></div>
                                </div>
                            @endif

                            @if(in_array('greenhouses_by_product', $visibleCharts) && isset($chartData['greenhouses_by_product']))
                                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                            <div
                                                class="w-8 h-8 bg-lime-100 rounded-lg flex items-center justify-center ml-2">
                                                <svg class="w-4 h-4 text-lime-600" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                            </div>
                                            گلخانه‌ها بر حسب محصول
                                        </h3>
                                    </div>
                                    <div class="chart-container" data-chart="doughnut"
                                         data-data="{{ json_encode($chartData['greenhouses_by_product']) }}"
                                         data-height="300"></div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Control System Charts -->
                    @if((in_array('greenhouses_by_climate_control', $visibleCharts) && isset($chartData['greenhouses_by_climate_control'])) || (in_array('greenhouses_by_feeding_control', $visibleCharts) && isset($chartData['greenhouses_by_feeding_control'])))
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            @if(in_array('greenhouses_by_climate_control', $visibleCharts) && isset($chartData['greenhouses_by_climate_control']))
                                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                            <div
                                                class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center ml-2">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                                                </svg>
                                            </div>
                                            گلخانه‌ها بر حسب کنترل اقلیم
                                        </h3>
                                    </div>
                                    <div class="chart-container" data-chart="pie"
                                         data-data="{{ json_encode($chartData['greenhouses_by_climate_control']) }}"
                                         data-height="300"></div>
                                </div>
                            @endif

                            @if(in_array('greenhouses_by_feeding_control', $visibleCharts) && isset($chartData['greenhouses_by_feeding_control']))
                                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                            <div
                                                class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center ml-2">
                                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                                </svg>
                                            </div>
                                            گلخانه‌ها بر حسب کنترل تغذیه
                                        </h3>
                                    </div>
                                    <div class="chart-container" data-chart="pie"
                                         data-data="{{ json_encode($chartData['greenhouses_by_feeding_control']) }}"
                                         data-height="300"></div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Company Greenhouse Control Charts -->
                    @if(in_array('greenhouses_by_company_climate', $visibleCharts) && isset($chartData['greenhouses_by_company_climate']))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center ml-2">
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                    </div>
                                    گلخانه‌ها بر حسب کنترل اقلیم شرکت‌ها
                                </h3>
                            </div>
                            <div class="chart-container" data-chart="bar"
                                 data-data="{{ json_encode($chartData['greenhouses_by_company_climate']) }}"
                                 data-height="400"></div>
                        </div>
                    @endif

                    @if(in_array('greenhouses_by_company_feeding', $visibleCharts) && isset($chartData['greenhouses_by_company_feeding']))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center ml-2">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                    </div>
                                    گلخانه‌ها بر حسب کنترل تغذیه شرکت‌ها
                                </h3>
                            </div>
                            <div class="chart-container" data-chart="bar"
                                 data-data="{{ json_encode($chartData['greenhouses_by_company_feeding']) }}"
                                 data-height="400"></div>
                        </div>
                    @endif

                    <!-- Registration and Connection Stats -->
                    @if(in_array('registered_vs_linked_greenhouses', $visibleCharts) && isset($chartData['registered_vs_linked_greenhouses']))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <div class="w-8 h-8 bg-violet-100 rounded-lg flex items-center justify-center ml-2">
                                        <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                        </svg>
                                    </div>
                                    تعداد گلخانه‌های موجود در استان و گلخانه‌های ثبت‌نام‌شده
                                </h3>
                            </div>
                            <div class="chart-container" data-chart="bar"
                                 data-data="{{ json_encode($chartData['registered_vs_linked_greenhouses']) }}"
                                 data-height="300"></div>
                        </div>
                    @endif

                    @if(in_array('greenhouse_area_by_province', $visibleCharts) && isset($chartData['greenhouse_area_by_province']))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <div class="w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center ml-2">
                                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                        </svg>
                                    </div>
                                    متراژ گلخانه‌ها بر حسب استان (هزار متر مربع)
                                </h3>
                            </div>
                            <div class="chart-container" data-chart="bar"
                                 data-data="{{ json_encode($chartData['greenhouse_area_by_province']) }}"
                                 data-height="400"></div>
                        </div>
                    @endif

                    @if(in_array('server_connected_greenhouses', $visibleCharts) && isset($chartData['server_connected_greenhouses']))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <div
                                        class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center ml-2">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-2.829a5 5 0 010-7.07m7.072 0a5 5 0 010 7.07M13 12a1 1 0 11-2 0 1 1 0 012 0z"/>
                                        </svg>
                                    </div>
                                    تعداد گلخانه‌های متصل به سرور در هر استان
                                </h3>
                            </div>
                            <div class="chart-container" data-chart="bar"
                                 data-data="{{ json_encode($chartData['server_connected_greenhouses']) }}"
                                 data-height="400"></div>
                        </div>
                    @endif

                    <!-- Role-Specific Information Cards -->
                    @if(!auth()->user()->hasRole(\App\Models\Role::ADMIN_ROLE))
                        <div
                            class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl p-6 border border-indigo-200">
                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                <div class="w-12 h-12 bg-indigo-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">اطلاعات مفید</h3>
                                    <p class="text-gray-600 text-sm">
                                        @if(auth()->user()->hasRole(\App\Models\Role::COMPANY_ROLE))
                                            شما به عنوان نماینده شرکت می‌توانید نمودارهای مربوط به عملکرد شرکت و
                                            گلخانه‌های تحت پوشش خود را مشاهده کنید.
                                        @elseif(auth()->user()->hasRole(\App\Models\Role::GREENHOUSE_ROLE))
                                            شما به عنوان مالک گلخانه می‌توانید آمار و اطلاعات مربوط به گلخانه‌ها و
                                            سیستم‌های کنترلی را مشاهده کنید.
                                        @elseif(auth()->user()->hasRole(\App\Models\Role::ORGANIZATION_ROLE))
                                            شما به عنوان کاربر سازمانی می‌توانید آمار کلی سیستم و گزارش‌های مدیریتی را
                                            مشاهده کنید.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                @else
                    <!-- No charts available message -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-12 text-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">هیچ نموداری برای نمایش وجود ندارد</h3>
                        <p class="text-gray-500 mb-6 max-w-md mx-auto">
                            در حال حاضر هیچ نموداری برای نقش کاربری شما فعال نشده است. لطفا با مدیر سیستم تماس بگیرید.
                        </p>
                        <div class="flex items-center justify-center space-x-4 rtl:space-x-reverse">
                            <div class="bg-gray-50 rounded-lg px-4 py-2">
                                <span class="text-sm text-gray-600">نقش شما:</span>
                                <span class="text-sm font-medium text-gray-900 mr-2">
                                   @if(auth()->user()->hasRole(\App\Models\Role::COMPANY_ROLE))
                                        نماینده شرکت
                                    @elseif(auth()->user()->hasRole(\App\Models\Role::GREENHOUSE_ROLE))
                                        مالک گلخانه
                                    @elseif(auth()->user()->hasRole(\App\Models\Role::ORGANIZATION_ROLE))
                                        کاربر سازمانی
                                    @endif
                               </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Quick Actions for Non-Admin Users -->
            @if(!auth()->user()->hasRole(\App\Models\Role::ADMIN_ROLE))
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center ml-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        عملیات سریع
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @can(\App\Models\Permission::PROFILE_INDEX)
                            <a href="{{ route('panel.profile.index') }}"
                               class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors duration-200 border border-blue-200">
                                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center ml-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">مشاهده پروفایل</p>
                                    <p class="text-sm text-gray-600">ویرایش اطلاعات کاربری</p>
                                </div>
                            </a>
                        @endcan

                        @if(auth()->user()->hasRole(\App\Models\Role::COMPANY_ROLE))
                            @can(\App\Models\Company::COMPANY_INDEX)
                                <a href="{{ route('panel.companies') }}"
                                   class="flex items-center p-4 bg-emerald-50 hover:bg-emerald-100 rounded-xl transition-colors duration-200 border border-emerald-200">
                                    <div
                                        class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center ml-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">مدیریت شرکت</p>
                                        <p class="text-sm text-gray-600">مشاهده اطلاعات شرکت</p>
                                    </div>
                                </a>
                            @endcan
                        @endif

                        @if(auth()->user()->hasRole(\App\Models\Role::GREENHOUSE_ROLE))
                            @can(\App\Models\Greenhouse::GREENHOUSE_INDEX)
                                <a href="{{ route('panel.greenhouses') }}"
                                   class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition-colors duration-200 border border-green-200">
                                    <div
                                        class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center ml-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M7.242 7.194a24.16 24.16 0 0 1 3.72-3.062m0 0c3.443-2.277 6.732-2.969 8.24-1.46 2.054 2.053.03 7.407-4.522 11.959-4.552 4.551-9.906 6.576-11.96 4.522C1.223 17.658 1.89 14.412 4.121 11m6.838-6.868c-3.443-2.277-6.732-2.969-8.24-1.46-2.054 2.053-.03 7.407 4.522 11.959m3.718-10.499a24.16 24.16 0 0 1 3.719 3.062M17.798 11c2.23 3.412 2.898 6.658 1.402 8.153-1.502 1.503-4.771.822-8.2-1.433m1-6.808a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">مدیریت گلخانه</p>
                                        <p class="text-sm text-gray-600">مشاهده اطلاعات گلخانه</p>
                                    </div>
                                </a>
                            @endcan
                        @endif

                        <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <div class="w-10 h-10 bg-gray-400 rounded-lg flex items-center justify-center ml-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">پشتیبانی</p>
                                <p class="text-sm text-gray-600">دریافت کمک و راهنمایی</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .chart-container {
            position: relative;
            width: 100%;
            min-height: 200px;
        }

        .chart-container canvas {
            border-radius: 12px;
        }

        /* Loading animation for charts */
        .chart-loading {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            color: #6B7280;
        }

        .chart-loading::before {
            content: '';
            width: 20px;
            height: 20px;
            border: 2px solid #E5E7EB;
            border-top: 2px solid #3B82F6;
            border-radius: 50%;
            margin-left: 8px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /* Enhanced hover effects */
        .chart-container:hover {
            transform: translateY(-2px);
            transition: transform 0.2s ease-in-out;
        }

        /* Responsive chart adjustments */
        @media (max-width: 768px) {
            .chart-container[data-height="400"] {
                height: 300px !important;
            }

            .chart-container[data-height="300"] {
                height: 250px !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chartContainers = document.querySelectorAll('.chart-container');

            if (chartContainers.length === 0) {
                console.log('No chart containers found');
                return;
            }

            chartContainers.forEach((container, index) => {
                try {
                    const chartType = container.dataset.chart;
                    const chartDataRaw = container.dataset.data;
                    const chartHeight = parseInt(container.dataset.height) || 300;

                    if (!chartDataRaw) {
                        console.error('No chart data found for container', index);
                        showChartError(container, 'داده‌ای برای نمایش یافت نشد');
                        return;
                    }

                    let chartData;
                    try {
                        chartData = JSON.parse(chartDataRaw);
                    } catch (e) {
                        console.error('Invalid JSON data for chart', index, e);
                        showChartError(container, 'داده نمودار معتبر نیست');
                        return;
                    }

                    if (!Array.isArray(chartData) || chartData.length === 0) {
                        console.log('No data available for chart', index);
                        showNoData(container);
                        return;
                    }

                    // Set container height
                    container.style.height = chartHeight + 'px';

                    // Create canvas with unique ID
                    const canvas = document.createElement('canvas');
                    canvas.id = `chart-${index}`;
                    canvas.style.maxHeight = '100%';
                    container.innerHTML = ''; // Clear any existing content
                    container.appendChild(canvas);

                    // Prepare chart data
                    const labels = chartData.map(item => item.name || 'نامشخص');
                    const data = chartData.map(item => {
                        const count = parseInt(item.count) || 0;
                        return count;
                    });
                    const colors = chartData.map(item => item.color || '#3B82F6');

                    // Validate that we have valid data
                    if (data.every(value => value === 0)) {
                        showNoData(container);
                        return;
                    }

                    const config = {
                        type: chartType,
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'تعداد',
                                data: data,
                                backgroundColor: colors,
                                borderColor: colors,
                                borderWidth: chartType === 'bar' ? 0 : 2,
                                borderRadius: chartType === 'bar' ? 8 : 0,
                                borderSkipped: false,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: chartType === 'bar' ? 'top' : 'bottom',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 15,
                                        font: {
                                            family: 'Inter, system-ui, sans-serif',
                                            size: 12
                                        }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    titleColor: '#fff',
                                    bodyColor: '#fff',
                                    borderColor: 'rgba(255, 255, 255, 0.1)',
                                    borderWidth: 1,
                                    cornerRadius: 8,
                                    displayColors: true,
                                    rtl: true,
                                    textDirection: 'rtl',
                                    callbacks: {
                                        label: function (context) {
                                            let value = context.parsed;

                                            if (chartType === 'bar') {
                                                value = context.parsed.y;
                                            } else if (chartType === 'pie' || chartType === 'doughnut') {
                                                value = context.parsed;
                                            }

                                            const numericValue = parseInt(value) || 0;
                                            return `تعداد: ${numericValue.toLocaleString('fa-IR')}`;
                                        },
                                        title: function (context) {
                                            return context[0].label;
                                        }
                                    }
                                }
                            },
                            scales: chartType === 'bar' ? {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(156, 163, 175, 0.1)',
                                        drawBorder: false
                                    },
                                    ticks: {
                                        font: {
                                            family: 'Inter, system-ui, sans-serif',
                                            size: 11
                                        },
                                        callback: function (value) {
                                            const numericValue = parseInt(value) || 0;
                                            return numericValue.toLocaleString('fa-IR');
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        font: {
                                            family: 'Inter, system-ui, sans-serif',
                                            size: 11
                                        },
                                        maxRotation: 45,
                                        minRotation: 0
                                    }
                                }
                            } : {},
                            animation: {
                                duration: 1000,
                                easing: 'easeOutQuart'
                            },
                            interaction: {
                                intersect: false,
                                mode: 'index'
                            }
                        }
                    };

                    // Create chart
                    const chart = new Chart(canvas, config);

                    console.log(`Chart ${index} created successfully with ${data.length} data points`);

                } catch (error) {
                    console.error(`Error creating chart ${index}:`, error);
                    showChartError(container, 'خطا در ایجاد نمودار');
                }
            });
        });

        function showChartError(container, message) {
            container.innerHTML = `
                <div class="flex items-center justify-center h-full">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-red-600 font-medium">${message}</p>
                        <button onclick="location.reload()" class="mt-2 px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-sm transition-colors duration-200">
                            تلاش مجدد
                        </button>
                    </div>
                </div>
            `;
        }

        function showNoData(container) {
            container.innerHTML = `
                <div class="flex items-center justify-center h-full">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 font-medium">داده‌ای برای نمایش وجود ندارد</p>
                        <p class="text-gray-400 text-sm mt-1">اطلاعات هنوز در سیستم ثبت نشده است</p>
                    </div>
                </div>
            `;
        }

        // Add debugging function
        function debugCharts() {
            const containers = document.querySelectorAll('.chart-container');
            console.log('Found chart containers:', containers.length);

            containers.forEach((container, index) => {
                console.log(`Container ${index}:`, {
                    type: container.dataset.chart,
                    hasData: !!container.dataset.data,
                    dataLength: container.dataset.data ? JSON.parse(container.dataset.data).length : 0,
                    height: container.dataset.height
                });
            });
        }

        // Call debug function if needed
        // debugCharts();
    </script>
@endpush
