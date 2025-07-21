{{-- Modern Menu Component (menu.blade.php) --}}
<aside
    :class="sidebarToggle ? 'translate-x-0' : 'translate-x-full'"
    class="fixed right-0 top-0 z-50 h-screen w-80 transform bg-white shadow-2xl transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 lg:shadow-none"
    @click.outside="sidebarToggle = false">

    {{-- Header --}}
    <div
        class="flex items-center justify-between border-b border-slate-200 bg-gradient-to-r from-emerald-500 to-emerald-600 px-6 py-4 text-white">
        <div class="flex items-center space-x-3 rtl:space-x-reverse">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold">منوی کاربری</h3>
                <p class="text-sm text-emerald-100">سامانه گلخانه‌ها</p>
            </div>
        </div>
        <button
            class="rounded-lg p-2 text-white/80 hover:bg-white/20 hover:text-white lg:hidden"
            @click.stop="sidebarToggle = false">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Content --}}
    <div class="flex h-full flex-col overflow-hidden">
        <div class="flex-1 overflow-y-auto p-4 custom-scrollbar">
            <nav x-data="{
                selectedItem: '',
                init() {
                    // Load from localStorage on init
                    const stored = localStorage.getItem('menu_selected');
                    if (stored) {
                        this.selectedItem = stored;
                    }
                },
                selectItem(item) {
                    this.selectedItem = this.selectedItem === item ? '' : item;
                    localStorage.setItem('menu_selected', this.selectedItem);
                }
             }">
                <ul class="space-y-2">
                    @guest
                        {{-- Home Link --}}
                        @if(\Illuminate\Support\Facades\Route::currentRouteName() != 'home')
                            <li>
                                <a href="{{ route('home') }}"
                                   class="group flex items-center rounded-xl px-4 py-3 text-slate-700 transition-all hover:bg-slate-100 hover:text-emerald-600">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-600 transition-colors group-hover:bg-emerald-100 group-hover:text-emerald-600">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                                        </svg>
                                    </div>
                                    <span class="mr-3 font-medium">صفحه اصلی</span>
                                </a>
                            </li>
                        @endif

                        {{-- Greenhouses Section --}}
                        <li>
                            <button @click="selectItem('Greenhouses')"
                                    class="group flex w-full items-center rounded-xl px-4 py-3 text-slate-700 transition-all hover:bg-slate-100 hover:text-emerald-600"
                                    :class="{ 'bg-emerald-50 text-emerald-600': selectedItem === 'Greenhouses' }">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-600 transition-colors group-hover:bg-emerald-100 group-hover:text-emerald-600"
                                    :class="{ 'bg-emerald-100 text-emerald-600': selectedItem === 'Greenhouses' }">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <span class="mr-3 flex-1 text-right font-medium">پنل گلخانه‌ها</span>
                                <svg class="h-5 w-5 transform transition-transform duration-200"
                                     :class="{ 'rotate-180': selectedItem === 'Greenhouses' }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="selectedItem === 'Greenhouses'"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="mt-2 space-y-1 pr-4">
                                <a href="{{ route('login.greenhouse') }}"
                                   class="group flex items-center rounded-lg px-4 py-2 text-sm text-slate-600 transition-colors hover:bg-emerald-50 hover:text-emerald-600">
                                    <div class="flex h-6 w-6 items-center justify-center">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                        </svg>
                                    </div>
                                    <span class="mr-3">ورود گلخانه‌دار</span>
                                </a>
                                <a href="{{ route('register.greenhouse') }}"
                                   class="group flex items-center rounded-lg px-4 py-2 text-sm text-slate-600 transition-colors hover:bg-emerald-50 hover:text-emerald-600">
                                    <div class="flex h-6 w-6 items-center justify-center">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                    </div>
                                    <span class="mr-3">ثبت گلخانه</span>
                                </a>
                            </div>
                        </li>

                        {{-- Companies Section --}}
                        <li>
                            <button @click="selectItem('Company')"
                                    class="group flex w-full items-center rounded-xl px-4 py-3 text-slate-700 transition-all hover:bg-slate-100 hover:text-emerald-600"
                                    :class="{ 'bg-emerald-50 text-emerald-600': selectedItem === 'Company' }">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-600 transition-colors group-hover:bg-emerald-100 group-hover:text-emerald-600"
                                    :class="{ 'bg-emerald-100 text-emerald-600': selectedItem === 'Company' }">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <span class="mr-3 flex-1 text-right font-medium">پنل شرکت‌ها</span>
                                <svg class="h-5 w-5 transform transition-transform duration-200"
                                     :class="{ 'rotate-180': selectedItem === 'Company' }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="selectedItem === 'Company'"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="mt-2 space-y-1 pr-4">
                                <a href="{{ route('auth.company.login') }}"
                                   class="group flex items-center rounded-lg px-4 py-2 text-sm text-slate-600 transition-colors hover:bg-emerald-50 hover:text-emerald-600">
                                    <div class="flex h-6 w-6 items-center justify-center">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                        </svg>
                                    </div>
                                    <span class="mr-3">ورود شرکت</span>
                                </a>
                                <a href="{{ route('auth.company.register') }}"
                                   class="group flex items-center rounded-lg px-4 py-2 text-sm text-slate-600 transition-colors hover:bg-emerald-50 hover:text-emerald-600">
                                    <div class="flex h-6 w-6 items-center justify-center">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                    </div>
                                    <span class="mr-3">ثبت شرکت</span>
                                </a>
                            </div>
                        </li>

                        {{-- Organization Section --}}
                        <li>
                            <button @click="selectItem('Organization')"
                                    class="group flex w-full items-center rounded-xl px-4 py-3 text-slate-700 transition-all hover:bg-slate-100 hover:text-emerald-600"
                                    :class="{ 'bg-emerald-50 text-emerald-600': selectedItem === 'Organization' }">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-600 transition-colors group-hover:bg-emerald-100 group-hover:text-emerald-600"
                                    :class="{ 'bg-emerald-100 text-emerald-600': selectedItem === 'Organization' }">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 4V6L13.5 7V4H10.5V7L9 6V4L3 7V9L9 12L12 10.5L15 12L21 9ZM6 10V12L9 13.5V15.5L6 14V16L9 17.5V19.5L6 18V20L12 23L18 20V18L15 19.5V17.5L18 16V14L15 15.5V13.5L18 12V10L15 11.5L12 10L9 11.5L6 10Z"/>
                                    </svg>
                                </div>
                                <span class="mr-3 flex-1 text-right font-medium">کاربران سازمانی</span>
                                <svg class="h-5 w-5 transform transition-transform duration-200"
                                     :class="{ 'rotate-180': selectedItem === 'Organization' }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="selectedItem === 'Organization'"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="mt-2 space-y-1 pr-4">
                                <a href="{{ route('login.organization') }}"
                                   class="group flex items-center rounded-lg px-4 py-2 text-sm text-slate-600 transition-colors hover:bg-emerald-50 hover:text-emerald-600">
                                    <div class="flex h-6 w-6 items-center justify-center">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                        </svg>
                                    </div>
                                    <span class="mr-3">ورود کاربر سازمانی</span>
                                </a>
                                <a href="{{ route('register.organization') }}"
                                   class="group flex items-center rounded-lg px-4 py-2 text-sm text-slate-600 transition-colors hover:bg-emerald-50 hover:text-emerald-600">
                                    <div class="flex h-6 w-6 items-center justify-center">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                    </div>
                                    <span class="mr-3">ثبت کاربر سازمانی</span>
                                </a>
                            </div>
                        </li>

                    @else
                        {{-- Authenticated User Section --}}
                        <li class="mb-6">
                            <div class="rounded-xl bg-gradient-to-r from-emerald-50 to-emerald-100 p-4">
                                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                    <div
                                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-500 text-white">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-slate-800">
                                            @if(auth()->user()->hasRole(\App\Models\Role::ADMIN_ROLE))
                                                {{ auth()->user()->getName() }}
                                            @elseif(auth()->user()->hasRole(\App\Models\Role::COMPANY_ROLE))
                                                @php
                                                    $company = \App\Models\Company::query()->whereNationalId(auth()->user()->getNationalId())->first();
                                                @endphp
                                                شرکت {{ $company->name }}
                                            @elseif(auth()->user()->hasRole(\App\Models\Role::GREENHOUSE_ROLE))
                                                @php
                                                    $greenhouse = \App\Models\Greenhouse::query()->whereOwnerNationalId(auth()->user()->getNationalId())->first();
                                                @endphp
                                                {{ $greenhouse->name }}
                                            @elseif(auth()->user()->hasRole(\App\Models\Role::ORGANIZATION_ROLE))
                                                @php
                                                    $organization = \App\Models\OrganizationUser::query()->whereNationalId(auth()->user()->getNationalId())->first();
                                                @endphp
                                                {{ $organization->fname . ' ' . $organization->lname }}
                                            @endif
                                        </h3>
                                        <p class="text-sm text-emerald-600">کاربر فعال</p>
                                    </div>
                                </div>
                            </div>
                        </li>

                        {{-- Dashboard Link --}}
                        <li>
                            <a href="{{ route('panel.home') }}"
                               class="group flex items-center rounded-xl px-4 py-3 text-slate-700 transition-all hover:bg-slate-100 hover:text-emerald-600">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-600 transition-colors group-hover:bg-emerald-100 group-hover:text-emerald-600">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"/>
                                    </svg>
                                </div>
                                <span class="mr-3 font-medium">پنل کاربری</span>
                            </a>
                        </li>
                    @endguest

                    {{-- Other Section --}}
                    <li class="border-t border-slate-200 pt-4">
                        <button @click="selectItem('Other')"
                                class="group flex w-full items-center rounded-xl px-4 py-3 text-slate-700 transition-all hover:bg-slate-100 hover:text-emerald-600"
                                :class="{ 'bg-emerald-50 text-emerald-600': selectedItem === 'Other' }">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-600 transition-colors group-hover:bg-emerald-100 group-hover:text-emerald-600"
                                :class="{ 'bg-emerald-100 text-emerald-600': selectedItem === 'Other' }">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="mr-3 flex-1 text-right font-medium">سایر</span>
                            <svg class="h-5 w-5 transform transition-transform duration-200"
                                 :class="{ 'rotate-180': selectedItem === 'Other' }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="selectedItem === 'Other'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="mt-2 space-y-1 pr-4">
                            <a href="{{ route('about.us') }}"
                               class="group flex items-center rounded-lg px-4 py-2 text-sm text-slate-600 transition-colors hover:bg-emerald-50 hover:text-emerald-600">
                                <div class="flex h-6 w-6 items-center justify-center">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="mr-3">درباره ما</span>
                            </a>
                            <a href="{{ route('contact.us') }}"
                               class="group flex items-center rounded-lg px-4 py-2 text-sm text-slate-600 transition-colors hover:bg-emerald-50 hover:text-emerald-600">
                                <div class="flex h-6 w-6 items-center justify-center">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="mr-3">تماس با ما</span>
                            </a>
                            <a href="{{ route('login.simurgh') }}"
                               class="group flex items-center rounded-lg px-4 py-2 text-sm text-slate-600 transition-colors hover:bg-emerald-50 hover:text-emerald-600">
                                <div class="flex h-6 w-6 items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="h-4 w-4">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path
                                            d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z"/>
                                        <path d="M15 9h.01"/>
                                    </svg>
                                </div>
                                <span class="mr-3">ورود ادمین</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</aside>
