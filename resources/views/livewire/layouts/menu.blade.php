<aside
    :class="sidebarToggle ? 'translate-x-0' : 'translate-x-full'"
    class="absolute right-0 top-0 flex h-screen flex-col overflow-y-hidden bg-[#013328] duration-300 ease-linear shadow-lg lg:static lg:translate-x-0"
    @click.outside="sidebarToggle = false" style="z-index: 999; min-width: 300px !important; padding-top: 40px">
    <!-- SIDEBAR HEADER -->
    <div class="flex items-center text-white lg:justify-center justify-end gap-2 px-6 py-5.5 lg:py-6.5">
        <button class="block lg:hidden hover:scale-125" @click.stop="sidebarToggle = !sidebarToggle">
            <svg class="w-7 h-7 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                 fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18 17.94 6M18 18 6.06 6"/>
            </svg>
        </button>
    </div>
    <!-- SIDEBAR HEADER -->

    <div class="no-scrollbar pt-[30px] lg:pt-[50px] flex flex-col overflow-y-auto duration-300 ease-linear">
        <!-- Sidebar Menu -->
        <nav class="mt-2 px-2 py-2" x-data="{selected: $persist('Company')}">
            <!-- Menu Group -->
            <div>
                <ul class="mb-2 flex flex-col">
                    <!-- Menu Item Company -->
                    @guest
                        @if(\Illuminate\Support\Facades\Route::currentRouteName() != 'home')
                            <li class="border-b border-[#013328] py-1">
                                <a class="group relative flex items-center justify-start gap-2.5 rounded-sm p-2 text-white duration-300 ease-in-out hover:bg-[#013328]"
                                   href="{{ route('home') }}">
                                    <svg class="min-w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                         width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"
                                              d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                                    </svg>
                                    <span class="text-sm font-bold transition">
                                        صفحه اصلی
                                    </span>
                                </a>
                            </li>
                        @endif
                        <!-- Menu Item Greenhouses -->
                        <li class="border-b border-[#013328] py-1">
                            <a class="group relative flex items-center justify-start gap-2.5 rounded-sm p-2 text-white duration-300 ease-in-out hover:bg-[#013328]"
                               href="javascript:void(0)"
                               @click.prevent="selected = (selected === 'Greenhouses' ? '':'Greenhouses')"
                               :class="{ 'bg-[#013328] ': (selected === 'Greenhouses') || (page === 'onlineSystem') }">
                                <svg class="min-w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 21 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M6.487 1.746c0 4.192 3.592 1.66 4.592 5.754 0 .828 1 1.5 2 1.5s2-.672 2-1.5a1.5 1.5 0 0 1 1.5-1.5h1.5m-16.02.471c4.02 2.248 1.776 4.216 4.878 5.645C10.18 13.61 9 19 9 19m9.366-6h-2.287a3 3 0 0 0-3 3v2m6-8a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <span class="text-sm font-bold transition">
                                پنل گلخانه ها
                                </span>
                                <svg
                                    class="absolute rotate-90 left-4 top-1/2 -translate-y-1/2 fill-current flex transition"
                                    :class="{ 'rotate-0': (selected === 'Greenhouses') }" width="20" height="20"
                                    viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                                        fill=""
                                    />
                                </svg>
                            </a>
                            <!-- Dropdown Menu Start -->
                            <div class="translate transform overflow-hidden"
                                 :class="(selected === 'Greenhouses') ? 'block' :'hidden'">
                                <ul class="mb-2 mt-1 flex flex-col gap-2.5">
                                    <li class="py-1 hover:bg-[#026B56] rounded-sm">
                                        <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-white duration-300 ease-in-out"
                                           href="{{ route('login.greenhouse') }}"
                                           :class="page === 'onlineSystem' && '!text-white'">
                                            <svg class="w-4 h-4 text-white group-hover:-translate-x-1"
                                                 aria-hidden="true"
                                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                 viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                      stroke-linejoin="round" stroke-width="2"
                                                      d="m17 16-4-4 4-4m-6 8-4-4 4-4"/>
                                            </svg>
                                            ورود
                                        </a>
                                    </li>
                                    <li class="py-1 hover:bg-[#026B56] rounded-sm">
                                        <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-white duration-300 ease-in-out"
                                           href="{{ route('register.greenhouse') }}"
                                           :class="page === 'onlineSystem' && '!text-white'">
                                            <svg class="w-4 h-4 text-white group-hover:-translate-x-1"
                                                 aria-hidden="true"
                                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                 viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                      stroke-linejoin="round" stroke-width="2"
                                                      d="m17 16-4-4 4-4m-6 8-4-4 4-4"/>
                                            </svg>
                                            ثبت گلخانه
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- Dropdown Menu End -->
                        </li>
                        <!-- Menu Item Greenhouses -->

                        <li class="py-1">
                            <a class="group relative flex items-center justify-start gap-2.5 rounded-sm p-2 text-white duration-300 ease-in-out hover:bg-[#013328]"
                               href="javascript:void(0)"
                               @click.prevent="selected = (selected === 'Company' ? '':'Company')"
                               :class="{ 'bg-[#013328] ': (selected === 'Company') || (page === 'onlineSystem') }">
                                <svg class="min-w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M4 15V9m4 6V9m4 6V9m4 6V9M2 16h16M1 19h18M2 7v1h16V7l-8-6-8 6Z"/>
                                </svg>
                                <span class="text-sm font-bold transition">پنل شرکت ها</span>
                                <svg
                                    class="absolute rotate-90 left-4 top-1/2 -translate-y-1/2 fill-current flex transition"
                                    :class="{ 'rotate-0': (selected === 'Company') }" width="20" height="20"
                                    viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                                        fill=""
                                    />
                                </svg>
                            </a>
                            <!-- Dropdown Menu Start -->
                            <div class="translate transform overflow-hidden"
                                 :class="(selected === 'Company') ? 'block' :'hidden'">
                                <ul class="mb-2 mt-1 flex flex-col gap-2.5">
                                    <li class="py-1 hover:bg-[#026B56] rounded-sm">
                                        <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-white duration-300 ease-in-out"
                                           href="{{ route('login.company') }}"
                                           :class="page === 'onlineSystem' && '!text-white'">
                                            <svg class="w-4 h-4 text-white group-hover:-translate-x-1"
                                                 aria-hidden="true"
                                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                 viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                      stroke-linejoin="round" stroke-width="2"
                                                      d="m17 16-4-4 4-4m-6 8-4-4 4-4"/>
                                            </svg>
                                            ورود
                                        </a>
                                    </li>
                                    <li class="py-1 hover:bg-[#026B56] rounded-sm">
                                        <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-white duration-300 ease-in-out"
                                           href="{{ route('register.company') }}"
                                           :class="page === 'onlineSystem' && '!text-white'">
                                            <svg class="w-4 h-4 text-white group-hover:-translate-x-1"
                                                 aria-hidden="true"
                                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                 viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                      stroke-linejoin="round" stroke-width="2"
                                                      d="m17 16-4-4 4-4m-6 8-4-4 4-4"/>
                                            </svg>
                                            ثبت شرکت
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- Dropdown Menu End -->
                        </li>
                        <!-- Menu Item Company -->

                        <!-- Menu Item Organization -->
                        <li class="border-t border-[#013328] py-1">
                            <a class="group relative flex items-center justify-start gap-2.5 rounded-sm p-2 text-white duration-300 ease-in-out hover:bg-[#013328]"
                               href="javascript:void(0)"
                               @click.prevent="selected = (selected === 'Organization' ? '':'Organization')"
                               :class="{ 'bg-[#013328] ': (selected === 'Organization') || (page === 'onlineSystem') }">
                                <svg class="min-w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                     fill="currentColor"
                                     viewBox="0 0 20 19">
                                    <path
                                        d="M7.324 9.917A2.479 2.479 0 0 1 7.99 7.7l.71-.71a2.484 2.484 0 0 1 2.222-.688 4.538 4.538 0 1 0-3.6 3.615h.002ZM7.99 18.3a2.5 2.5 0 0 1-.6-2.564A2.5 2.5 0 0 1 6 13.5v-1c.005-.544.19-1.072.526-1.5H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h7.687l-.697-.7ZM19.5 12h-1.12a4.441 4.441 0 0 0-.579-1.387l.8-.795a.5.5 0 0 0 0-.707l-.707-.707a.5.5 0 0 0-.707 0l-.795.8A4.443 4.443 0 0 0 15 8.62V7.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.12c-.492.113-.96.309-1.387.579l-.795-.795a.5.5 0 0 0-.707 0l-.707.707a.5.5 0 0 0 0 .707l.8.8c-.272.424-.47.891-.584 1.382H8.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1.12c.113.492.309.96.579 1.387l-.795.795a.5.5 0 0 0 0 .707l.707.707a.5.5 0 0 0 .707 0l.8-.8c.424.272.892.47 1.382.584v1.12a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1.12c.492-.113.96-.309 1.387-.579l.795.8a.5.5 0 0 0 .707 0l.707-.707a.5.5 0 0 0 0-.707l-.8-.795c.273-.427.47-.898.584-1.392h1.12a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5ZM14 15.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                                </svg>
                                <span class="text-sm font-bold transition">
                                پنل کاربران سازمانی
                                </span>
                                <svg
                                    class="absolute rotate-90 left-4 top-1/2 -translate-y-1/2 fill-current flex transition"
                                    :class="{ 'rotate-0': (selected === 'Organization') }" width="20" height="20"
                                    viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                                        fill=""
                                    />
                                </svg>
                            </a>
                            <!-- Dropdown Menu Start -->
                            <div class="translate transform overflow-hidden"
                                 :class="(selected === 'Organization') ? 'block' :'hidden'">
                                <ul class="mb-2 mt-1 flex flex-col gap-2.5">
                                    <li class="py-1 hover:bg-[#026B56] rounded-sm">
                                        <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-white duration-300 ease-in-out"
                                           href="{{ route('login.organization') }}"
                                           :class="page === 'onlineSystem' && '!text-white'">
                                            <svg class="w-4 h-4 text-white group-hover:-translate-x-1"
                                                 aria-hidden="true"
                                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                 viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                      stroke-linejoin="round" stroke-width="2"
                                                      d="m17 16-4-4 4-4m-6 8-4-4 4-4"/>
                                            </svg>
                                            ورود
                                        </a>
                                    </li>
                                    <li class="py-1 hover:bg-[#026B56] rounded-sm">
                                        <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-white duration-300 ease-in-out"
                                           href="{{ route('register.organization') }}"
                                           :class="page === 'onlineSystem' && '!text-white'">
                                            <svg class="w-4 h-4 text-white group-hover:-translate-x-1"
                                                 aria-hidden="true"
                                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                 viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                      stroke-linejoin="round" stroke-width="2"
                                                      d="m17 16-4-4 4-4m-6 8-4-4 4-4"/>
                                            </svg>
                                            ثبت کاربر
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- Dropdown Menu End -->
                        </li>
                        <!-- Menu Item Organization -->
                    @else
                        @if(auth()->user()->hasRole(\App\Models\Role::ADMIN_ROLE))
                            <h2 class="text-md font-bold text-white text-center my-3">{{ auth()->user()->getName() }}</h2>
                        @elseif(auth()->user()->hasRole(\App\Models\Role::COMPANY_ROLE))
                            @php
                                $company = \App\Models\Company::query()->whereNationalId(auth()->user()->getNationalId())->first();
                            @endphp
                            <h2 class="text-md font-bold text-white text-center my-3">شرکت {{ $company->name }}</h2>
                        @elseif(auth()->user()->hasRole(\App\Models\Role::GREENHOUSE_ROLE))
                            @php
                                $greenhouse = \App\Models\Greenhouse::query()->whereOwnerNationalId(auth()->user()->getNationalId())->first();
                            @endphp
                            <h2 class="text-md font-bold text-white text-center my-3">
                                {{ $greenhouse->name }}</h2>
                        @elseif(auth()->user()->hasRole(\App\Models\Role::ORGANIZATION_ROLE))
                            @php
                                $organization = \App\Models\OrganizationUser::query()->whereNationalId(auth()->user()->getNationalId())->first();
                            @endphp
                            <h2 class="text-md font-bold text-white text-center my-3">کاربر
                                سازمانی {{ $organization->fname . ' ' . $organization->lname }}</h2>
                        @endif

                        <!-- Menu Item Panel -->
                        <li class="py-1 hover:bg-[#026B56] rounded-sm">
                            <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-white duration-300 ease-in-out"
                               href="{{ route('panel.home') }}" @click="selected = (selected === 'Panel' ? '':'Panel')"
                               :class="{ 'bg-[#013328] ': (selected === 'Panel') && (page === 'panel') }"
                            >
                                <svg class="min-w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="m4 12 8-8 8 8M6 10.5V19c0 .6.4 1 1 1h3v-3c0-.6.4-1 1-1h2c.6 0 1 .4 1 1v3h3c.6 0 1-.4 1-1v-8.5"/>
                                </svg>
                                ورود به پنل
                            </a>
                        </li>
                        <!-- Menu Item Panel -->
                    @endguest

                    <!-- Menu Item Other -->
                    <li class="border-t border-[#013328] py-1">
                        <a class="group relative flex items-center justify-start gap-2.5 rounded-sm p-2 text-white duration-300 ease-in-out hover:bg-[#013328]"
                           href="javascript:void(0)"
                           @click.prevent="selected = (selected === 'Other' ? '':'Other')"
                           :class="{ 'bg-[#013328] ': (selected === 'Other') || (page === 'onlineSystem') }">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round"
                                 class="min-w-6 h-6">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                                <path d="M8 12l0 .01"/>
                                <path d="M12 12l0 .01"/>
                                <path d="M16 12l0 .01"/>
                            </svg>
                            <span class="text-sm font-bold transition">
                                سایر
                                </span>
                            <svg
                                class="absolute rotate-90 left-4 top-1/2 -translate-y-1/2 fill-current flex transition"
                                :class="{ 'rotate-0': (selected === 'Other') }" width="20" height="20"
                                viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                                    fill=""
                                />
                            </svg>
                        </a>
                        <!-- Dropdown Menu Start -->
                        <div class="translate transform overflow-hidden"
                             :class="(selected === 'Other') ? 'block' :'hidden'">
                            <ul class="mb-2 mt-1 flex flex-col gap-2.5">
                                <li class="py-1 hover:bg-[#026B56] rounded-sm">
                                    <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-white duration-300 ease-in-out"
                                       href="{{ route('about.us') }}"
                                       :class="page === 'onlineSystem' && '!text-white'">
                                        <svg class="w-4 h-4 text-white group-hover:-translate-x-1"
                                             aria-hidden="true"
                                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                             viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                  stroke-linejoin="round" stroke-width="2"
                                                  d="m17 16-4-4 4-4m-6 8-4-4 4-4"/>
                                        </svg>
                                        درباره ما
                                    </a>
                                </li>
                                <li class="py-1 hover:bg-[#026B56] rounded-sm">
                                    <a class="group relative flex items-center gap-2.5 rounded-md px-4 text-white duration-300 ease-in-out"
                                       href="{{ route('contact.us') }}"
                                       :class="page === 'onlineSystem' && '!text-white'">
                                        <svg class="w-4 h-4 text-white group-hover:-translate-x-1"
                                             aria-hidden="true"
                                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                             viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                  stroke-linejoin="round" stroke-width="2"
                                                  d="m17 16-4-4 4-4m-6 8-4-4 4-4"/>
                                        </svg>
                                        تماس با ما
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- Dropdown Menu End -->
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Sidebar Menu -->
    </div>
</aside>
