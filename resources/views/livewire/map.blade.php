<div class="space-y-6">
    <div class="text-center">
        <h2 class="text-3xl font-bold text-slate-800 mb-2">نقشه گلخانه‌ها و شرکت‌های اتوماسیون</h2>
        <p class="text-slate-600">مشاهده و جستجوی گلخانه‌ها و شرکت‌های اتوماسیون در سراسر کشور</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/50 p-1">
        <nav class="flex space-x-1 rtl:space-x-reverse">
            <button
                wire:click="changeTab('greenhouse')"
                class="flex-1 py-3 px-6 text-sm font-semibold rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 {{ $activeTab === 'greenhouse' ? 'bg-gradient-to-r from-emerald-500 to-emerald-600 text-white shadow-md' : 'text-slate-600 hover:text-slate-800 hover:bg-slate-50' }}">
                <span class="flex items-center justify-center space-x-2 rtl:space-x-reverse">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>گلخانه‌ها</span>
                </span>
            </button>
            <button
                wire:click="changeTab('company')"
                class="flex-1 py-3 px-6 text-sm font-semibold rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 {{ $activeTab === 'company' ? 'bg-gradient-to-r from-emerald-500 to-emerald-600 text-white shadow-md' : 'text-slate-600 hover:text-slate-800 hover:bg-slate-50' }}">
                <span class="flex items-center justify-center space-x-2 rtl:space-x-reverse">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>شرکت‌های اتوماسیون</span>
                </span>
            </button>
        </nav>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/50 p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3 rtl:space-x-reverse">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-800">فیلترهای جستجو</h3>
                    <p class="text-sm text-slate-500">نتایج را بر اساس معیارهای مورد نظر فیلتر کنید</p>
                </div>
            </div>
            <button
                wire:click="resetFilters"
                class="flex items-center space-x-2 rtl:space-x-reverse px-4 py-2 text-sm font-medium text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all duration-200 group">
                <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-300" fill="none"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>بازنشانی فیلترها</span>
            </button>
        </div>

        @php
            $greenhouseFilters = \App\Models\Filter::query()->where([
                'type'=> \App\Models\Filter::GREENHOUSE_TYPE,
                'active' => true
            ])->get();
            $companyFilters = \App\Models\Filter::query()->where([
                'type'=> \App\Models\Filter::COMPANY_TYPE,
                'active' => true
            ])->get();
            function toCamelCase($value): string
            {
                return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $value))));
            }
        @endphp

        {{-- Greenhouse Filters --}}
        @if($activeTab === 'greenhouse')
            <div class="transition-all duration-300"
                 x-data="{ @foreach($greenhouseFilters as $filter){{ toCamelCase($filter->name) }}Open: false, @endforeach }"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                <div class="flex flex-wrap gap-3">
                    @foreach($greenhouseFilters as $filter)
                        <div class="relative">
                            <button
                                @click="{{ toCamelCase($filter->name) }}Open = !{{ toCamelCase($filter->name) }}Open"
                                class="flex items-center space-x-2 rtl:space-x-reverse px-2 py-1 bg-gradient-to-r from-slate-50 to-slate-100 hover:from-emerald-50 hover:to-emerald-100 border border-slate-200 hover:border-emerald-300 rounded-xl text-sm font-medium text-slate-700 hover:text-emerald-700 transition-all duration-200 shadow-sm hover:shadow-md group">
                                <div
                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-white group-hover:bg-emerald-100 transition-colors duration-200">
                                    @switch($filter->name)
                                        @case(\App\Models\Filter::GREENHOUSE_SUBSTRATE_FILTER)
                                            <svg class="w-4 h-4 text-slate-500 group-hover:text-emerald-600" fill="none"
                                                 stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                            </svg>
                                            @break
                                        @case(\App\Models\Filter::GREENHOUSE_PRODUCT_FILTER)
                                            <svg class="w-4 h-4 text-slate-500 group-hover:text-emerald-600" fill="none"
                                                 stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                            @break
                                        @case(\App\Models\Filter::GREENHOUSE_PROVINCE_FILTER)
                                            <svg class="w-4 h-4 text-slate-500 group-hover:text-emerald-600" fill="none"
                                                 stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            @break
                                        @case(\App\Models\Filter::GREENHOUSE_AUTOMATION_TYPE_FILTER)
                                            <svg class="w-4 h-4 text-slate-500 group-hover:text-emerald-600" fill="none"
                                                 stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            @break
                                        @case(\App\Models\Filter::GREENHOUSE_SERVER_CONNECTION_FILTER)
                                            <svg class="w-4 h-4 text-slate-500 group-hover:text-emerald-600" fill="none"
                                                 stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                            </svg>
                                            @break
                                    @endswitch
                                </div>
                                <span>{{ $filter->title }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200"
                                     :class="{{ toCamelCase($filter->name) }}Open ? 'rotate-180' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div
                                x-show="{{ toCamelCase($filter->name) }}Open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-95"
                                @click.away="{{ toCamelCase($filter->name) }}Open = false"
                                class="absolute top-full mt-2 left-0 z-50 min-w-[170px] bg-white border border-slate-200 rounded-xl shadow-xl p-1.5"
                                style="z-index: 999 !important;">

                                @switch($filter->name)
                                    @case(\App\Models\Filter::GREENHOUSE_SUBSTRATE_FILTER)
                                        <div class="max-h-60 overflow-y-auto custom-scrollbar">
                                            <div class="space-y-1">
                                                @foreach($substrates as $substrate)
                                                    <label
                                                        class="flex items-center p-3 rounded-lg hover:bg-slate-50 cursor-pointer group transition-colors duration-200">
                                                        <input
                                                            type="checkbox"
                                                            value="{{ $substrate['name'] }}"
                                                            wire:model.live="substrateFilter"
                                                            class="w-4 h-4 text-emerald-600 bg-white border-slate-300 rounded focus:ring-emerald-500 focus:ring-2">
                                                        <div class="mr-3 flex-1">
                                                            <span
                                                                class="text-sm font-medium text-slate-700 group-hover:text-slate-900">
                                                                {{ $substrate['name'] }}
                                                            </span>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @break

                                    @case(\App\Models\Filter::GREENHOUSE_PRODUCT_FILTER)
                                        <div class="max-h-60 overflow-y-auto custom-scrollbar">
                                            <div class="space-y-1">
                                                @foreach($productTypes as $product)
                                                    <label
                                                        class="flex items-center p-3 rounded-lg hover:bg-slate-50 cursor-pointer group transition-colors duration-200">
                                                        <input
                                                            type="checkbox"
                                                            value="{{ $product['name'] }}"
                                                            wire:model.live="productFilter"
                                                            class="w-4 h-4 text-emerald-600 bg-white border-slate-300 rounded focus:ring-emerald-500 focus:ring-2">
                                                        <div class="mr-3 flex-1">
                                                            <span
                                                                class="text-sm font-medium text-slate-700 group-hover:text-slate-900">
                                                                {{ $product['name'] }}
                                                            </span>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @break

                                    @case(\App\Models\Filter::GREENHOUSE_PROVINCE_FILTER)
                                        <div class="max-h-60 overflow-y-auto custom-scrollbar">
                                            <div class="space-y-1">
                                                @foreach($provinces as $province)
                                                    <label
                                                        class="flex items-center p-3 rounded-lg hover:bg-slate-50 cursor-pointer group transition-colors duration-200">
                                                        <input
                                                            type="checkbox"
                                                            value="{{ $province['name'] }}"
                                                            wire:model.live="provinceFilter"
                                                            class="w-4 h-4 text-emerald-600 bg-white border-slate-300 rounded focus:ring-emerald-500 focus:ring-2">
                                                        <div class="mr-3 flex-1">
                                                            <span
                                                                class="text-sm font-medium text-slate-700 group-hover:text-slate-900">
                                                                {{ $province['name'] }}
                                                            </span>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @break

                                    @case(\App\Models\Filter::GREENHOUSE_AUTOMATION_TYPE_FILTER)
                                        <div class="max-h-60 overflow-y-auto custom-scrollbar">
                                            <div class="space-y-1">
                                                @foreach($automationTypes as $automation)
                                                    <label
                                                        class="flex items-center p-3 rounded-lg hover:bg-slate-50 cursor-pointer group transition-colors duration-200">
                                                        <input
                                                            type="checkbox"
                                                            value="{{ $automation['value'] }}"
                                                            wire:model.live="automationTypeFilter"
                                                            class="w-4 h-4 text-emerald-600 bg-white border-slate-300 rounded focus:ring-emerald-500 focus:ring-2">
                                                        <div class="mr-3 flex-1">
                                                            <span
                                                                class="text-sm font-medium text-slate-700 group-hover:text-slate-900">
                                                                {{ $automation['name'] }}
                                                            </span>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @break

                                    @case(\App\Models\Filter::GREENHOUSE_SERVER_CONNECTION_FILTER)
                                        <div class="max-h-60 overflow-y-auto custom-scrollbar">
                                            <div class="space-y-1">
                                                @foreach($serverConnections as $connection)
                                                    <label
                                                        class="flex items-center p-3 rounded-lg hover:bg-slate-50 cursor-pointer group transition-colors duration-200">
                                                        <input
                                                            type="checkbox"
                                                            value="{{ $connection['value'] }}"
                                                            wire:model.live="serverConnectionFilter"
                                                            class="w-4 h-4 text-emerald-600 bg-white border-slate-300 rounded focus:ring-emerald-500 focus:ring-2">
                                                        <div class="mr-3 flex-1">
                                                            <span
                                                                class="text-sm font-medium text-slate-700 group-hover:text-slate-900">
                                                                {{ $connection['name'] }}
                                                            </span>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @break
                                @endswitch
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Company Filters --}}
        @if($activeTab === 'company')
            <div class="transition-all duration-300"
                 x-data="{ @foreach($companyFilters as $filter){{ toCamelCase($filter->name) }}Open: false, @endforeach }"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                <div class="flex flex-wrap gap-3">
                    @foreach($companyFilters as $filter)
                        <div class="relative">
                            <button
                                @click="{{ toCamelCase($filter->name) }}Open = !{{ toCamelCase($filter->name) }}Open"
                                class="flex items-center space-x-2 rtl:space-x-reverse px-2 py-1 bg-gradient-to-r from-slate-50 to-slate-100 hover:from-emerald-50 hover:to-emerald-100 border border-slate-200 hover:border-emerald-300 rounded-xl text-sm font-medium text-slate-700 hover:text-emerald-700 transition-all duration-200 shadow-sm hover:shadow-md group">
                                <div
                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-white group-hover:bg-emerald-100 transition-colors duration-200">
                                    @switch($filter->name)
                                        @case(\App\Models\Filter::COMPANY_TYPE_FILTER)
                                            <svg class="w-4 h-4 text-slate-500 group-hover:text-emerald-600" fill="none"
                                                 stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                            @break
                                        @case(\App\Models\Filter::COMPANY_PROVINCE_FILTER)
                                            <svg class="w-4 h-4 text-slate-500 group-hover:text-emerald-600" fill="none"
                                                 stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            @break
                                        @case(\App\Models\Filter::COMPANY_AUTOMATION_FILTER)
                                            <svg class="w-4 h-4 text-slate-500 group-hover:text-emerald-600" fill="none"
                                                 stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            @break
                                    @endswitch
                                </div>
                                <span>{{ $filter->title }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200"
                                     :class="{{ toCamelCase($filter->name) }}Open ? 'rotate-180' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div
                                x-show="{{ toCamelCase($filter->name) }}Open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-95"
                                @click.away="{{ toCamelCase($filter->name) }}Open = false"
                                class="absolute top-full mt-2 left-0 z-50 min-w-[170px] bg-white border border-slate-200 rounded-xl shadow-xl p-1.5" style="z-index: 999 !important;">

                                @switch($filter->name)
                                    @case(\App\Models\Filter::COMPANY_PROVINCE_FILTER)
                                        <div class="max-h-60 overflow-y-auto custom-scrollbar">
                                            <div class="space-y-1">
                                                @foreach($companyProvinces as $province)
                                                    <label
                                                        class="flex items-center p-3 rounded-lg hover:bg-slate-50 cursor-pointer group transition-colors duration-200">
                                                        <input
                                                            type="checkbox"
                                                            value="{{ $province['name'] }}"
                                                            wire:model.live="companyProvinceFilter"
                                                            class="w-4 h-4 text-emerald-600 bg-white border-slate-300 rounded focus:ring-emerald-500 focus:ring-2">
                                                        <div class="mr-3 flex-1">
                                                    <span
                                                        class="text-sm font-medium text-slate-700 group-hover:text-slate-900">
                                                        {{ $province['name'] }}
                                                    </span>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @break

                                    @case(\App\Models\Filter::COMPANY_TYPE_FILTER)
                                        <div class="max-h-60 overflow-y-auto custom-scrollbar">
                                            <div class="space-y-1">
                                                @foreach($companyType as $type)
                                                    <label
                                                        class="flex items-center p-3 rounded-lg hover:bg-slate-50 cursor-pointer group transition-colors duration-200">
                                                        <input
                                                            type="checkbox"
                                                            value="{{ $type['name'] }}"
                                                            wire:model.live="companyTypeFilter"
                                                            class="w-4 h-4 text-emerald-600 bg-white border-slate-300 rounded focus:ring-emerald-500 focus:ring-2">
                                                        <div class="mr-3 flex-1">
                                                    <span
                                                        class="text-sm font-medium text-slate-700 group-hover:text-slate-900">
                                                        {{ $type['name'] }}
                                                    </span>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @break

                                    @case(\App\Models\Filter::COMPANY_AUTOMATION_FILTER)
                                        <div class="max-h-60 overflow-y-auto custom-scrollbar">
                                            <div class="space-y-1">
                                                @foreach($companyAutomation as $automation)
                                                    <label
                                                        class="flex items-center p-3 rounded-lg hover:bg-slate-50 cursor-pointer group transition-colors duration-200">
                                                        <input
                                                            type="checkbox"
                                                            value="{{ $automation['value'] }}"
                                                            wire:model.live="companyAutomationFilter"
                                                            class="w-4 h-4 text-emerald-600 bg-white border-slate-300 rounded focus:ring-emerald-500 focus:ring-2">
                                                        <div class="mr-3 flex-1">
                                                    <span
                                                        class="text-sm font-medium text-slate-700 group-hover:text-slate-900">
                                                        {{ $automation['name'] }}
                                                    </span>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @break
                                @endswitch
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($activeTab === 'company')
            {{-- Active Filters Display --}}
            @php
                $activeFilterCount = count($companyTypeFilter) + count($companyProvinceFilter) + count($companyAutomationFilter);
                $displayFilters = [];

                // Add company filters
                foreach($companyTypeFilter as $filter) {
                    $displayFilters[] = $filter;
                }
                foreach($companyProvinceFilter as $filter) {
                    $displayFilters[] = $filter;
                }

                // Add company automation filters with proper names
                foreach($companyAutomationFilter as $filter) {
                    if($filter === 'climate') {
                        $displayFilters[] = 'مجری اتوماسیون کنترل اقلیم';
                    } elseif($filter === 'feeding') {
                        $displayFilters[] = 'مجری اتوماسیون تغذیه';
                    }
                }
            @endphp

            @if($activeFilterCount > 0)
                <div class="mt-6 pt-6 border-t border-slate-200">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-sm font-semibold text-slate-700">فیلترهای فعال ({{ $activeFilterCount }})</h4>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($displayFilters as $filter)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                {{ $filter }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
        @if($activeTab === 'greenhouse')
            @php
                $activeFilterCount = count($substrateFilter) + count($productFilter) + count($provinceFilter) + count($automationTypeFilter) + count($serverConnectionFilter);
                $displayFilters = [];

                foreach($substrateFilter as $filter) {
                    $displayFilters[] = $filter;
                }
                foreach($productFilter as $filter) {
                    $displayFilters[] = $filter;
                }
                foreach($provinceFilter as $filter) {
                    $displayFilters[] = $filter;
                }

                foreach($automationTypeFilter as $filter) {
                    if($filter === 'climate') {
                        $displayFilters[] = 'دارای اتوماسیون کنترل اقلیم';
                    } elseif($filter === 'feeding') {
                        $displayFilters[] = 'دارای اتوماسیون تغذیه';
                    }
                }

                foreach($serverConnectionFilter as $filter) {
                    if($filter === true || $filter === 1 || $filter === '1') {
                        $displayFilters[] = 'دارای اتصال به سرور';
                    } else {
                        $displayFilters[] = 'فاقد اتصال به سرور';
                    }
                }
            @endphp

            @if($activeFilterCount > 0)
                <div class="mt-6 pt-6 border-t border-slate-200">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-sm font-semibold text-slate-700">فیلترهای فعال ({{ $activeFilterCount }})</h4>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($displayFilters as $filter)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                {{ $filter }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/50 overflow-hidden">
        <div class="p-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">نقشه تعاملی</h3>
                        <p class="text-sm text-slate-500">روی نشانگرها کلیک کنید تا جزئیات بیشتر ببینید</p>
                    </div>
                </div>
                <div class="text-sm text-slate-500">
                    {{ $activeTab === 'greenhouse' ? 'نمایش گلخانه‌ها' : 'نمایش شرکت‌ها' }}
                </div>
            </div>
        </div>
        <div id="map" class="w-full h-[700px]" wire:ignore></div>
    </div>

    <script>
        let greenhouseMarkers = {!! $greenhousesData !!};
        let companyMarkers = {!! $companiesData !!};
        let currentActiveTab = '{{ $activeTab }}';

        document.addEventListener('livewire:init', () => {
            Livewire.on('submit-filter', (e) => {
                console.log('🔄 Filter event received:', e[0].type, 'Data length:', JSON.parse(e[0].data).length);

                const mapContainer = document.getElementById('map');
                if (mapContainer) {
                    mapContainer.style.opacity = '0.7';
                    mapContainer.style.transition = 'opacity 0.3s ease';
                }

                setTimeout(() => {
                    renderMarkers(e[0].type, JSON.parse(e[0].data));

                    if (mapContainer) {
                        mapContainer.style.opacity = '1';
                    }
                }, 100);
            });

            Livewire.on('tab-changed', (e) => {
                console.log('🔄 Tab changed to:', e[0].activeTab);
                currentActiveTab = e[0].activeTab;
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => {
                if (typeof renderMarkers === 'function') {
                    console.log('🗺️ Initializing map with:', currentActiveTab, 'data');
                    if (currentActiveTab === 'company') {
                        renderMarkers('company', companyMarkers);
                    } else {
                        renderMarkers('greenhouse', greenhouseMarkers);
                    }
                }
            }, 1000);
        });

        document.addEventListener('alpine:init', () => {
            const style = document.createElement('style');
            style.textContent = `
               .custom-scrollbar::-webkit-scrollbar {
                   width: 6px;
               }
               .custom-scrollbar::-webkit-scrollbar-track {
                   background: #f1f5f9;
                   border-radius: 3px;
               }
               .custom-scrollbar::-webkit-scrollbar-thumb {
                   background: #cbd5e1;
                   border-radius: 3px;
               }
               .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                   background: #94a3b8;
               }
           `;
            document.head.appendChild(style);
        });
    </script>
</div>
