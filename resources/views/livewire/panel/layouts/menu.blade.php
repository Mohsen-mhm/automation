<div class="text-white min-w-[15rem] p-2 hidden md:block shadow-lg bg-[#343951]" id="sidebar"
     style="">
    <div class="w-full px-2 overflow-y-auto" dir="ltr">
        <div class="w-full" dir="rtl">
            @if(auth()->user()->hasRole(\App\Models\Role::ADMIN_ROLE))
                <h2 class="text-md font-extrabold text-center">{{ auth()->user()->getName() }}</h2>
            @elseif(auth()->user()->hasRole(\App\Models\Role::COMPANY_ROLE))
                @php
                    $company = \App\Models\Company::query()->whereNationalId(auth()->user()->getNationalId())->first();
                @endphp
                <h2 class="text-md font-extrabold text-center">شرکت {{ $company->name }}</h2>
            @elseif(auth()->user()->hasRole(\App\Models\Role::GREENHOUSE_ROLE))
                @php
                    $greenhouse = \App\Models\Greenhouse::query()->whereOwnerNationalId(auth()->user()->getNationalId())->first();
                @endphp
                <h2 class="text-md font-extrabold text-center">گلخانه {{ $greenhouse->name }}</h2>
            @elseif(auth()->user()->hasRole(\App\Models\Role::ORGANIZATION_ROLE))
                @php
                    $organization = \App\Models\OrganizationUser::query()->whereNationalId(auth()->user()->getNationalId())->first();
                @endphp
                <h2 class="text-md font-extrabold text-center">کاربر
                    سازمانی {{ $organization->fname . ' ' . $organization->lname }}</h2>
            @endif

            <div class="flex flex-col items-center w-full mt-3 border-t border-gray-200">

                <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-[#6058C3] transition hover:text-gray-100 @if (\Illuminate\Support\Facades\Route::is('panel.home')) text-gray-200 bg-[#5850ba] @endif"
                   href="{{ route('panel.home') }}">
                    <svg class="min-w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m4 12 8-8 8 8M6 10.5V19c0 .6.4 1 1 1h3v-3c0-.6.4-1 1-1h2c.6 0 1 .4 1 1v3h3c.6 0 1-.4 1-1v-8.5"/>
                    </svg>
                    <span class="mr-2 font-medium group-hover:flex transition">
                            داشبورد
                        </span>
                </a>

                @can(\App\Models\Permission::PROFILE_INDEX)
                    <hr class="w-full border-t border-gray-400 mt-2">
                    <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-[#6058C3] transition hover:text-gray-100 @if (\Illuminate\Support\Facades\Route::is('panel.profile')) text-gray-200 bg-[#5850ba] @endif"
                       href="{{ route('panel.profile') }}">
                        <svg class="min-w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.3-.6-1-1-1.6-1H7.6c-.7 0-1.3.4-1.6 1M4 5h16c.6 0 1 .4 1 1v12c0 .6-.4 1-1 1H4a1 1 0 0 1-1-1V6c0-.6.4-1 1-1Zm7 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
                        </svg>
                        <span class="mr-2 font-medium group-hover:flex transition">
                            پروفایل
                            </span>
                    </a>
                @endcan

                @if(auth()->user()->isActive())
                    @can(\App\Models\Config::CONFIG_INDEX)
                        <hr class="w-full border-t border-gray-400 mt-2">
                        <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-[#6058C3] transition hover:text-gray-100 @if (\Illuminate\Support\Facades\Route::is('panel.configs')) text-gray-200 bg-[#5850ba] @endif"
                           href="{{ route('panel.configs') }}">
                            <svg class="min-w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M21 13v-2a1 1 0 0 0-1-1h-.8l-.7-1.7.6-.5a1 1 0 0 0 0-1.5L17.7 5a1 1 0 0 0-1.5 0l-.5.6-1.7-.7V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.8l-1.7.7-.5-.6a1 1 0 0 0-1.5 0L5 6.3a1 1 0 0 0 0 1.5l.6.5-.7 1.7H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.8l.7 1.7-.6.5a1 1 0 0 0 0 1.5L6.3 19a1 1 0 0 0 1.5 0l.5-.6 1.7.7v.8a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.8l1.7-.7.5.6a1 1 0 0 0 1.5 0l1.4-1.4a1 1 0 0 0 0-1.5l-.6-.5.7-1.7h.8a1 1 0 0 0 1-1Z"/>
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                            </svg>
                            <span class="mr-2 font-medium group-hover:flex transition">
                            تنظیمات
                            </span>
                        </a>
                    @endcan

                    @can(\App\Models\Role::ROLE_INDEX)
                        <hr class="w-full border-t border-gray-400 mt-2">
                        <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-[#6058C3] transition hover:text-gray-100 @if (\Illuminate\Support\Facades\Route::is('panel.roles')) text-gray-200 bg-[#5850ba] @endif"
                           href="{{ route('panel.roles') }}">
                            <svg class="min-w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 22 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M20 10a28.076 28.076 0 0 1-1.091 9M6.231 2.37a8.994 8.994 0 0 1 12.88 3.73M1.958 13S2 12.577 2 10a8.949 8.949 0 0 1 1.735-5.307m12.84 3.088c.281.706.426 1.46.425 2.22a30 30 0 0 1-.464 6.231M5 10a6 6 0 0 1 9.352-4.974M3 19a5.964 5.964 0 0 1 1.01-3.328 5.15 5.15 0 0 0 .786-1.926m8.66 2.486a13.96 13.96 0 0 1-.962 2.683M6.5 17.336C8 15.092 8 12.846 8 10a3 3 0 1 1 6 0c0 .75 0 1.521-.031 2.311M11 10.001c0 3 0 6-2 9"/>
                            </svg>
                            <span class="mr-2 font-medium group-hover:flex transition">
                            نقش ها
                            </span>
                        </a>
                    @endcan

                    @can(\App\Models\Permission::PERMISSION_INDEX)
                        <hr class="w-full border-t border-gray-400 mt-2">
                        <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-[#6058C3] transition hover:text-gray-100 @if (\Illuminate\Support\Facades\Route::is('panel.permissions')) text-gray-200 bg-[#5850ba] @endif"
                           href="{{ route('panel.permissions') }}">
                            <svg class="min-w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 16 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M11.5 8V4.5a3.5 3.5 0 1 0-7 0V8M8 12v3M2 8h12a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1Z"/>
                            </svg>
                            <span class="mr-2 font-medium group-hover:flex transition">
                            دسترسی ها
                            </span>
                        </a>
                    @endcan

                    @can(\App\Models\User::USER_INDEX)
                        <hr class="w-full border-t border-gray-400 mt-2">
                        <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-[#6058C3] transition hover:text-gray-100 @if (\Illuminate\Support\Facades\Route::is('panel.users')) text-gray-200 bg-[#5850ba] @endif"
                           href="{{ route('panel.users') }}">
                            <svg class="min-w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                      d="M16 19h4c.6 0 1-.4 1-1v-1a3 3 0 0 0-3-3h-2m-2.2-4A3 3 0 0 0 19 8a3 3 0 0 0-5.2-2M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1c0 .6-.4 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                            <span class="mr-2 font-medium group-hover:flex transition">
                            کاربران
                            </span>
                        </a>
                    @endcan

                    @can(\App\Models\Company::COMPANY_INDEX)
                        <hr class="w-full border-t border-gray-400 mt-2">
                        <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-[#6058C3] transition hover:text-gray-100 @if (\Illuminate\Support\Facades\Route::is('panel.companies')) text-gray-200 bg-[#5850ba] @endif"
                           href="{{ route('panel.companies') }}">
                            <svg class="min-w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M4 15V9m4 6V9m4 6V9m4 6V9M2 16h16M1 19h18M2 7v1h16V7l-8-6-8 6Z"/>
                            </svg>
                            <span class="mr-2 font-medium group-hover:flex transition">
                            شرکت ها
                            </span>
                        </a>
                    @endcan

                    @can(\App\Models\Greenhouse::GREENHOUSE_INDEX)
                        <hr class="w-full border-t border-gray-400 mt-2">
                        <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-[#6058C3] transition hover:text-gray-100 @if (\Illuminate\Support\Facades\Route::is('panel.greenhouses')) text-gray-200 bg-[#5850ba] @endif"
                           href="{{ route('panel.greenhouses') }}">
                            <svg class="min-w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 21 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M6.487 1.746c0 4.192 3.592 1.66 4.592 5.754 0 .828 1 1.5 2 1.5s2-.672 2-1.5a1.5 1.5 0 0 1 1.5-1.5h1.5m-16.02.471c4.02 2.248 1.776 4.216 4.878 5.645C10.18 13.61 9 19 9 19m9.366-6h-2.287a3 3 0 0 0-3 3v2m6-8a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            <span class="mr-2 font-medium group-hover:flex transition">
                            گلخانه ها
                            </span>
                        </a>
                    @endcan

                    @can(\App\Models\OrganizationUser::ORGAN_INDEX)
                        <hr class="w-full border-t border-gray-400 mt-2">
                        <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-[#6058C3] transition hover:text-gray-100 @if (\Illuminate\Support\Facades\Route::is('panel.organizations')) text-gray-200 bg-[#5850ba] @endif"
                           href="{{ route('panel.organizations') }}">
                            <svg class="min-w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="currentColor"
                                 viewBox="0 0 20 19">
                                <path
                                    d="M7.324 9.917A2.479 2.479 0 0 1 7.99 7.7l.71-.71a2.484 2.484 0 0 1 2.222-.688 4.538 4.538 0 1 0-3.6 3.615h.002ZM7.99 18.3a2.5 2.5 0 0 1-.6-2.564A2.5 2.5 0 0 1 6 13.5v-1c.005-.544.19-1.072.526-1.5H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h7.687l-.697-.7ZM19.5 12h-1.12a4.441 4.441 0 0 0-.579-1.387l.8-.795a.5.5 0 0 0 0-.707l-.707-.707a.5.5 0 0 0-.707 0l-.795.8A4.443 4.443 0 0 0 15 8.62V7.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.12c-.492.113-.96.309-1.387.579l-.795-.795a.5.5 0 0 0-.707 0l-.707.707a.5.5 0 0 0 0 .707l.8.8c-.272.424-.47.891-.584 1.382H8.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1.12c.113.492.309.96.579 1.387l-.795.795a.5.5 0 0 0 0 .707l.707.707a.5.5 0 0 0 .707 0l.8-.8c.424.272.892.47 1.382.584v1.12a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1.12c.492-.113.96-.309 1.387-.579l.795.8a.5.5 0 0 0 .707 0l.707-.707a.5.5 0 0 0 0-.707l-.8-.795c.273-.427.47-.898.584-1.392h1.12a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5ZM14 15.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                            </svg>
                            <span class="mr-2 font-medium group-hover:flex transition">
                            کاربران سازمانی
                            </span>
                        </a>
                    @endcan

                    @can(\App\Models\Automation::AUTOMATION_INDEX)
                        <hr class="w-full border-t border-gray-400 mt-2">
                        <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-[#6058C3] transition hover:text-gray-100 @if (\Illuminate\Support\Facades\Route::is('panel.automations')) text-gray-200 bg-[#5850ba] @endif"
                           href="{{ route('panel.automations') }}">
                            <svg class="min-w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M4 4v15c0 .6.4 1 1 1h15M8 16l2.5-5.5 3 3L17.3 7 20 9.7"/>
                            </svg>
                            <span class="mr-2 font-medium group-hover:flex transition">
                            اتوماسیون ها
                            </span>
                        </a>
                    @endcan

                    @can(\App\Models\GreenhouseAlert::ALERT_INDEX)
                        <hr class="w-full border-t border-gray-400 mt-2">
                        <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-[#6058C3] transition hover:text-gray-100 @if (\Illuminate\Support\Facades\Route::is('panel.alerts')) text-gray-200 bg-[#5850ba] @endif"
                           href="{{ route('panel.alerts') }}">
                            <svg class="min-w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M10.8 5.5 10.4 3m.4 2.4a5.3 5.3 0 0 1 6 4.3l.4 1.8c.4 2.3 2.4 2.6 2.6 3.7.1.6.2 1.2-.3 1.3L6.8 19c-.5 0-.7-.5-.8-1.1-.2-1.2 1.5-2.1 1.1-4.4l-.3-1.8a5.3 5.3 0 0 1 4-6.2Zm-7 4.4a8 8 0 0 1 2-4.9m2.7 13.7a3.5 3.5 0 0 0 6.7-.8l.1-.5-6.8 1.3Z"/>
                            </svg>
                            <span class="mr-2 font-medium group-hover:flex transition">
                            تنظیمات محدوده ها
                            </span>
                        </a>
                    @endcan

                @endif
                <hr class="w-full border-t border-gray-400 mt-2">
                <livewire:panel.auth.logout/>
            </div>
        </div>
    </div>
    <div class="bg-[#343951] py-52"></div>

</div>
