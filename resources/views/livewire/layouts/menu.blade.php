<div class="relative h-full" style="margin: 0 !important;">
    <div id="drawer-navigation" tabindex="-1"
         class="group flex flex-col transition justify-between items-center h-full overflow-hidden text-gray-100 bg-[#258641]">
        <div class="w-full px-2 overflow-y-auto">
            <a class="flex items-center w-full px-2 mt-3"
               href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" id="drawer-navigation-label">
                <svg class="min-w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 22 21">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                          d="M7.24 7.194a24.16 24.16 0 0 1 3.72-3.062m0 0c3.443-2.277 6.732-2.969 8.24-1.46 2.054 2.053.03 7.407-4.522 11.959-4.552 4.551-9.906 6.576-11.96 4.522C1.223 17.658 1.89 14.412 4.121 11m6.838-6.868c-3.443-2.277-6.732-2.969-8.24-1.46-2.054 2.053-.03 7.407 4.522 11.959m3.718-10.499a24.16 24.16 0 0 1 3.719 3.062M17.798 11c2.23 3.412 2.898 6.658 1.402 8.153-1.502 1.503-4.771.822-8.2-1.433m1-6.808a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/>
                </svg>
                <span class="mr-2 text-sm lg:font-bold lg:flex hidden group-hover:flex transition">سامانه متمرکز گلخانه‌های
                    برخط کشور</span>
            </a>

            <div class="flex flex-col items-center w-full mt-3 border-t border-gray-200">

                @guest
                    <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-[#226435] transition hover:text-gray-100 @if (\Illuminate\Support\Facades\Route::is('panel.profile')) text-gray-200 bg-[#226435] @endif"
                       href="{{ route('login.company') }}">
                        <svg class="min-w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 15V9m4 6V9m4 6V9m4 6V9M2 16h16M1 19h18M2 7v1h16V7l-8-6-8 6Z"/>
                        </svg>
                        <span class="text-sm lg:text-base mr-2 lg:font-medium lg:flex hidden group-hover:flex transition">پنل شرکت ها</span>
                    </a>

                    <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-[#226435] transition hover:text-gray-100 @if (\Illuminate\Support\Facades\Route::is('panel.profile')) text-gray-200 bg-[#226435] @endif"
                       href="{{ route('login.organization') }}">
                        <svg class="min-w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor"
                             viewBox="0 0 20 19">
                            <path
                                d="M7.324 9.917A2.479 2.479 0 0 1 7.99 7.7l.71-.71a2.484 2.484 0 0 1 2.222-.688 4.538 4.538 0 1 0-3.6 3.615h.002ZM7.99 18.3a2.5 2.5 0 0 1-.6-2.564A2.5 2.5 0 0 1 6 13.5v-1c.005-.544.19-1.072.526-1.5H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h7.687l-.697-.7ZM19.5 12h-1.12a4.441 4.441 0 0 0-.579-1.387l.8-.795a.5.5 0 0 0 0-.707l-.707-.707a.5.5 0 0 0-.707 0l-.795.8A4.443 4.443 0 0 0 15 8.62V7.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.12c-.492.113-.96.309-1.387.579l-.795-.795a.5.5 0 0 0-.707 0l-.707.707a.5.5 0 0 0 0 .707l.8.8c-.272.424-.47.891-.584 1.382H8.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1.12c.113.492.309.96.579 1.387l-.795.795a.5.5 0 0 0 0 .707l.707.707a.5.5 0 0 0 .707 0l.8-.8c.424.272.892.47 1.382.584v1.12a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1.12c.492-.113.96-.309 1.387-.579l.795.8a.5.5 0 0 0 .707 0l.707-.707a.5.5 0 0 0 0-.707l-.8-.795c.273-.427.47-.898.584-1.392h1.12a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5ZM14 15.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                        </svg>
                        <span class="text-sm lg:text-base mr-2 lg:font-medium lg:flex hidden group-hover:flex transition">پنل کاربران
                            سازمانی</span>
                    </a>

                    <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-[#226435] transition hover:text-gray-100 @if (\Illuminate\Support\Facades\Route::is('panel.profile')) text-gray-200 bg-[#226435] @endif"
                       href="{{ route('login.greenhouse') }}">
                        <svg class="min-w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 21 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6.487 1.746c0 4.192 3.592 1.66 4.592 5.754 0 .828 1 1.5 2 1.5s2-.672 2-1.5a1.5 1.5 0 0 1 1.5-1.5h1.5m-16.02.471c4.02 2.248 1.776 4.216 4.878 5.645C10.18 13.61 9 19 9 19m9.366-6h-2.287a3 3 0 0 0-3 3v2m6-8a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <span class="text-sm lg:text-base mr-2 lg:font-medium lg:flex hidden group-hover:flex transition">پنل گلخانه
                            ها</span>
                    </a>
                @else
                    @if(auth()->user()->hasRole(\App\Models\Role::ADMIN_ROLE))
                        <h2 class="text-md font-extrabold text-center mt-3">{{ auth()->user()->getName() }}</h2>
                    @elseif(auth()->user()->hasRole(\App\Models\Role::COMPANY_ROLE))
                        @php
                            $company = \App\Models\Company::query()->whereNationalId(auth()->user()->getNationalId())->first();
                        @endphp
                        <h2 class="text-md font-extrabold text-center mt-3">شرکت {{ $company->name }}</h2>
                    @elseif(auth()->user()->hasRole(\App\Models\Role::GREENHOUSE_ROLE))
                        @php
                            $greenhouse = \App\Models\Greenhouse::query()->whereOwnerNationalId(auth()->user()->getNationalId())->first();
                        @endphp
                        <h2 class="text-md font-extrabold text-center mt-3">گلخانه {{ $greenhouse->name }}</h2>
                    @elseif(auth()->user()->hasRole(\App\Models\Role::ORGANIZATION_ROLE))
                        @php
                            $organization = \App\Models\OrganizationUser::query()->whereNationalId(auth()->user()->getNationalId())->first();
                        @endphp
                        <h2 class="text-md font-extrabold text-center mt-3">کاربر
                            سازمانی {{ $organization->fname . ' ' . $organization->lname }}</h2>
                    @endif

                    <a class="flex items-center w-full h-12 px-3 mt-3 border-t border-gray-200 rounded hover:bg-[#226435] transition hover:text-gray-100 @if (\Illuminate\Support\Facades\Route::is('panel.home')) text-gray-200 bg-[#226435] @endif"
                       href="{{ route('panel.home') }}">
                        <svg class="min-w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m4 12 8-8 8 8M6 10.5V19c0 .6.4 1 1 1h3v-3c0-.6.4-1 1-1h2c.6 0 1 .4 1 1v3h3c.6 0 1-.4 1-1v-8.5"/>
                        </svg>
                        <span class="mr-2 font-medium lg:flex hidden group-hover:flex transition">ورود به پنل</span>
                    </a>
                @endguest

            </div>

            <div class="my-24"></div>
        </div>
    </div>
</div>
