<aside
    class="fixed top-16 right-0 z-50 w-72 h-[calc(100vh-4rem)] transition-transform duration-300 transform translate-x-full md:translate-x-0 sidebar-gradient modern-shadow"
    id="sidebar">

    <!-- Sidebar Content -->
    <div class="h-full overflow-y-auto scrollbar-thin scrollbar-thumb-gray-600 scrollbar-track-transparent">
        <div class="p-6">

            <!-- User Info Card -->
            <div class="mb-8 p-4 rounded-2xl bg-emerald-500/10 backdrop-blur-sm border border-emerald-500/20">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div
                        class="w-12 h-12 bg-gradient-to-r from-emerald-400 to-teal-400 rounded-xl flex items-center justify-center">
                        <span class="text-white text-lg font-bold">
                            {{ substr(auth()->user()->getName(), 0, 1) }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        @if(auth()->user()->hasRole(\App\Models\Role::ADMIN_ROLE))
                            <h3 class="text-black font-semibold truncate">{{ auth()->user()->getName() }}</h3>
                            <p class="text-emerald-800 text-sm">مدیر سیستم</p>
                        @elseif(auth()->user()->hasRole(\App\Models\Role::COMPANY_ROLE))
                            @php
                                $company = \App\Models\Company::query()->whereNationalId(auth()->user()->getNationalId())->first();
                            @endphp
                            <h3 class="text-black font-semibold truncate">شرکت {{ $company->name ?? 'نامشخص' }}</h3>
                            <p class="text-emerald-800 text-sm">نماینده شرکت</p>
                        @elseif(auth()->user()->hasRole(\App\Models\Role::GREENHOUSE_ROLE))
                            @php
                                $greenhouse = \App\Models\Greenhouse::query()->whereOwnerNationalId(auth()->user()->getNationalId())->first();
                            @endphp
                            <h3 class="text-black font-semibold truncate">{{ $greenhouse->name ?? 'گلخانه' }}</h3>
                            <p class="text-emerald-800 text-sm">مالک گلخانه</p>
                        @elseif(auth()->user()->hasRole(\App\Models\Role::ORGANIZATION_ROLE))
                            @php
                                $organization = \App\Models\OrganizationUser::query()->whereNationalId(auth()->user()->getNationalId())->first();
                            @endphp
                            <h3 class="text-black font-semibold truncate">{{ ($organization->fname ?? '') . ' ' . ($organization->lname ?? '') }}</h3>
                            <p class="text-emerald-800 text-sm">کاربر سازمانی</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="space-y-2">

                <!-- Dashboard -->
                <a href="{{ route('panel.home') }}"
                   class="group flex items-center space-x-3 rtl:space-x-reverse px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('panel.home') ? 'bg-white/20 shadow-lg' : '' }}">
                    <div
                        class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m4 12 8-8 8 8M6 10.5V19c0 .6.4 1 1 1h3v-3c0-.6.4-1 1-1h2c.6 0 1 .4 1 1v3h3c.6 0 1-.4 1-1v-8.5"/>
                        </svg>
                    </div>
                    <span
                        class="text-black font-medium group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-200">داشبورد</span>
                </a>

                @can(\App\Models\Permission::PROFILE_INDEX)
                    <a href="{{ route('panel.profile.index') }}"
                       class="group flex items-center space-x-3 rtl:space-x-reverse px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('panel.profile') ? 'bg-white/20 shadow-lg' : '' }}">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.3-.6-1-1-1.6-1H7.6c-.7 0-1.3.4-1.6 1M4 5h16c.6 0 1 .4 1 1v12c0 .6-.4 1-1 1H4a1 1 0 0 1-1-1V6c0-.6.4-1 1-1Zm7 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
                            </svg>
                        </div>
                        <span
                            class="text-black font-medium group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-200">پروفایل</span>
                    </a>
                @endcan

                @if(auth()->user()->isActive())
                    <!-- Divider -->
                    <div class="my-6 border-t border-gray-300"></div>

                    @can(\App\Models\Config::CONFIG_INDEX)
                        <a href="{{ route('panel.configs.index') }}"
                           class="group flex items-center space-x-3 rtl:space-x-reverse px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('panel.configs.*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-gray-500 to-gray-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 13v-2a1 1 0 0 0-1-1h-.8l-.7-1.7.6-.5a1 1 0 0 0 0-1.5L17.7 5a1 1 0 0 0-1.5 0l-.5.6-1.7-.7V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.8l-1.7.7-.5-.6a1 1 0 0 0-1.5 0L5 6.3a1 1 0 0 0 0 1.5l.6.5-.7 1.7H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.8l.7 1.7-.6.5a1 1 0 0 0 0 1.5L6.3 19a1 1 0 0 0 1.5 0l.5-.6 1.7.7v.8a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.8l1.7-.7.5.6a1 1 0 0 0 1.5 0l1.4-1.4a1 1 0 0 0 0-1.5l-.6-.5.7-1.7h.8a1 1 0 0 0 1-1Z"/>
                                </svg>
                            </div>
                            <span
                                class="text-black font-medium group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-200">تنظیمات</span>
                        </a>
                    @endcan

                    @can(\App\Models\Role::ROLE_INDEX)
                        <a href="{{ route('panel.roles.index') }}"
                           class="group flex items-center space-x-3 rtl:space-x-reverse px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('panel.roles*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 22 20">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M20 10a28.076 28.076 0 0 1-1.091 9M6.231 2.37a8.994 8.994 0 0 1 12.88 3.73M1.958 13S2 12.577 2 10a8.949 8.949 0 0 1 1.735-5.307m12.84 3.088c.281.706.426 1.46.425 2.22a30 30 0 0 1-.464 6.231M5 10a6 6 0 0 1 9.352-4.974M3 19a5.964 5.964 0 0 1 1.01-3.328 5.15 5.15 0 0 0 .786-1.926m8.66 2.486a13.96 13.96 0 0 1-.962 2.683M6.5 17.336C8 15.092 8 12.846 8 10a3 3 0 1 1 6 0c0 .75 0 1.521-.031 2.311M11 10.001c0 3 0 6-2 9"/>
                                </svg>
                            </div>
                            <span
                                class="text-black font-medium group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-200">نقش ها</span>
                        </a>
                    @endcan

                    @can(\App\Models\Permission::PERMISSION_INDEX)
                        <a href="{{ route('panel.permissions.index') }}"
                           class="group flex items-center space-x-3 rtl:space-x-reverse px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('panel.permissions*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 16 20">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11.5 8V4.5a3.5 3.5 0 1 0-7 0V8M8 12v3M2 8h12a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1Z"/>
                                </svg>
                            </div>
                            <span
                                class="text-black font-medium group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-200">دسترسی ها</span>
                        </a>
                    @endcan

                    @can(\App\Models\User::USER_INDEX)
                        <a href="{{ route('panel.users.index') }}"
                           class="group flex items-center space-x-3 rtl:space-x-reverse px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('panel.users*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="2"
                                          d="M16 19h4c.6 0 1-.4 1-1v-1a3 3 0 0 0-3-3h-2m-2.2-4A3 3 0 0 0 19 8a3 3 0 0 0-5.2-2M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1c0 .6-.4 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                            </div>
                            <span
                                class="text-black font-medium group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-200">کاربران</span>
                        </a>
                    @endcan

                    @can(\App\Models\Province::PROVINCE_INDEX)
                        <a href="{{ route('panel.provinces.index') }}"
                           class="group flex items-center space-x-3 rtl:space-x-reverse px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('panel.provinces*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                            </div>
                            <span
                                class="text-black font-medium group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-200">استان ها</span>
                        </a>
                    @endcan

                    @can(\App\Models\City::CITY_INDEX)
                        <a href="{{ route('panel.cities.index') }}"
                           class="group flex items-center space-x-3 rtl:space-x-reverse px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('panel.cities*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <span
                                class="text-black font-medium group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-200">شهر ها</span>
                        </a>
                    @endcan

                    @can(\App\Models\Company::COMPANY_INDEX)
                        <a href="{{ route('panel.companies.index') }}"
                           class="group flex items-center space-x-3 rtl:space-x-reverse px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('panel.companies*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 15V9m4 6V9m4 6V9m4 6V9M2 16h16M1 19h18M2 7v1h16V7l-8-6-8 6Z"/>
                                </svg>
                            </div>
                            <span
                                class="text-black font-medium group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-200">شرکت ها</span>
                        </a>
                    @endcan

                    @can(\App\Models\Greenhouse::GREENHOUSE_INDEX)
                        <a href="{{ route('panel.greenhouses.index') }}"
                           class="group flex items-center space-x-3 rtl:space-x-reverse px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('panel.greenhouses*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-green-600 to-lime-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 21 20">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6.487 1.746c0 4.192 3.592 1.66 4.592 5.754 0 .828 1 1.5 2 1.5s2-.672 2-1.5a1.5 1.5 0 0 1 1.5-1.5h1.5m-16.02.471c4.02 2.248 1.776 4.216 4.878 5.645C10.18 13.61 9 19 9 19m9.366-6h-2.287a3 3 0 0 0-3 3v2m6-8a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </div>
                            <span
                                class="text-black font-medium group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-200">گلخانه ها</span>
                        </a>
                    @endcan

                    @can(\App\Models\OrganizationUser::ORGAN_INDEX)
                        <a href="{{ route('panel.organizations.index') }}"
                           class="group flex items-center space-x-3 rtl:space-x-reverse px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('panel.organizations*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-pink-500 to-rose-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 19">
                                    <path
                                        d="M7.324 9.917A2.479 2.479 0 0 1 7.99 7.7l.71-.71a2.484 2.484 0 0 1 2.222-.688 4.538 4.538 0 1 0-3.6 3.615h.002ZM7.99 18.3a2.5 2.5 0 0 1-.6-2.564A2.5 2.5 0 0 1 6 13.5v-1c.005-.544.19-1.072.526-1.5H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h7.687l-.697-.7ZM19.5 12h-1.12a4.441 4.441 0 0 0-.579-1.387l.8-.795a.5.5 0 0 0 0-.707l-.707-.707a.5.5 0 0 0-.707 0l-.795.8A4.443 4.443 0 0 0 15 8.62V7.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.12c-.492.113-.96.309-1.387.579l-.795-.795a.5.5 0 0 0-.707 0l-.707.707a.5.5 0 0 0 0 .707l.8.8c-.272.424-.47.891-.584 1.382H8.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1.12c.113.492.309.96.579 1.387l-.795.795a.5.5 0 0 0 0 .707l.707.707a.5.5 0 0 0 .707 0l.8-.8c.424.272.892.47 1.382.584v1.12a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1.12c.492-.113.96-.309 1.387-.579l.795.8a.5.5 0 0 0 .707 0l.707-.707a.5.5 0 0 0 0-.707l-.8-.795c.273-.427.47-.898.584-1.392h1.12a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5ZM14 15.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                                </svg>
                            </div>
                            <span
                                class="text-black font-medium group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-200">کاربران سازمانی</span>
                        </a>
                    @endcan

                    @can(\App\Models\Automation::AUTOMATION_INDEX)
                        <a href="{{ route('panel.automations.index') }}"
                           class="group flex items-center space-x-3 rtl:space-x-reverse px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('panel.automations*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-red-500 to-pink-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 4v15c0 .6.4 1 1 1h15M8 16l2.5-5.5 3 3L17.3 7 20 9.7"/>
                                </svg>
                            </div>
                            <span
                                class="text-black font-medium group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-200">اتوماسیون ها</span>
                        </a>
                    @endcan

                    @can(\App\Models\GreenhouseAlert::ALERT_INDEX)
                        <a href="{{ route('panel.alerts.index') }}"
                           class="group flex items-center space-x-3 rtl:space-x-reverse px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('panel.alerts*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10.8 5.5 10.4 3m.4 2.4a5.3 5.3 0 0 1 6 4.3l.4 1.8c.4 2.3 2.4 2.6 2.6 3.7.1.6.2 1.2-.3 1.3L6.8 19c-.5 0-.7-.5-.8-1.1-.2-1.2 1.5-2.1 1.1-4.4l-.3-1.8a5.3 5.3 0 0 1 4-6.2Zm-7 4.4a8 8 0 0 1 2-4.9m2.7 13.7a3.5 3.5 0 0 0 6.7-.8l.1-.5-6.8 1.3Z"/>
                                </svg>
                            </div>
                            <span
                                class="text-black font-medium group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-200">تنظیمات محدوده ها</span>
                        </a>
                    @endcan

                    @can(\App\Models\AboutUs::ABOUT_US_INDEX)
                        <a href="{{ route('panel.about.us.index') }}"
                           class="group flex items-center space-x-3 rtl:space-x-reverse px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('panel.about.us*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-teal-500 to-cyan-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10 19h-6a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1h6a2 2 0 0 1 2 2a2 2 0 0 1 2 -2h6a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-6a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2z M12 5v16 M7 7h1 M7 11h1 M16 7h1 M16 11h1 M16 15h1"/>
                                </svg>
                            </div>
                            <span
                                class="text-black font-medium group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-200">تنظیمات درباره ما</span>
                        </a>
                    @endcan

                    @can(\App\Models\ContactUs::CONTACT_US_INDEX)
                        <a href="{{ route('panel.contact-us.index') }}"
                           class="group flex items-center space-x-3 rtl:space-x-reverse px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 {{ request()->routeIs('panel.contact.us*') ? 'bg-white/20 shadow-lg' : '' }}">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-violet-500 to-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 9h8 M8 13h6 M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z"/>
                                </svg>
                            </div>
                            <span
                                class="text-black font-medium group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform duration-200">تماس با ما</span>
                        </a>
                    @endcan

                @endif

                <!-- Divider -->
                <div class="my-6 border-t border-gray-300"></div>

                <!-- Logout -->
                <div class="pt-4">
                    @include('layouts.partials.logout-button')
                </div>
            </nav>
        </div>
    </div>
</aside>

<style>
    /* Custom scrollbar for sidebar */
    .scrollbar-thin::-webkit-scrollbar {
        width: 4px;
    }

    .scrollbar-thin::-webkit-scrollbar-track {
        background: transparent;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 2px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: rgba(0, 0, 0, 0.3);
    }

    /* Smooth animations */
    .sidebar-gradient {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #f1f5f9 100%);
    }

    .modern-shadow {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1),
        0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Active menu item glow effect */
    .bg-white\/20 {
        background: rgba(16, 185, 129, 0.15);
        box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.1),
        0 2px 4px -1px rgba(16, 185, 129, 0.06);
    }

    /* Hover effects */
    .group:hover .group-hover\:scale-110 {
        transform: scale(1.1);
    }

    /* Responsive design */
    @media (max-width: 768px) {
        #sidebar {
            width: 100%;
            max-width: 320px;
        }
    }

    /* Animation for menu items */
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .group {
        animation: slideInRight 0.3s ease-out;
    }

    /* Stagger animation for menu items */
    .group:nth-child(1) {
        animation-delay: 0.1s;
    }

    .group:nth-child(2) {
        animation-delay: 0.2s;
    }

    .group:nth-child(3) {
        animation-delay: 0.3s;
    }

    .group:nth-child(4) {
        animation-delay: 0.4s;
    }

    .group:nth-child(5) {
        animation-delay: 0.5s;
    }

    .group:nth-child(6) {
        animation-delay: 0.6s;
    }

    .group:nth-child(7) {
        animation-delay: 0.7s;
    }

    .group:nth-child(8) {
        animation-delay: 0.8s;
    }

    .group:nth-child(9) {
        animation-delay: 0.9s;
    }

    .group:nth-child(10) {
        animation-delay: 1.0s;
    }
</style>
