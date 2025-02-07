<div class="w-full">
    <ul
        class="flex text-sm font-medium text-center text-gray-500 rounded-lg" wire:ignore>
        <li class="w-full">
            <div id="greenhouseTab"
                 class="inline-block w-full p-2 bg-[#026B56] text-gray-50 border-gray-200 hover:text-white hover:bg-[#013328] active focus:ring-4 focus:ring-green-300 focus:outline-none rounded-s-lg font-medium lg:font-bold text-base lg:text-lg cursor-pointer"
                 wire:click="changeTab('greenhouse')">
                گلخانه
                ها
            </div>
        </li>
        <li class="w-full">
            <div id="companyTab"
                 class="inline-block w-full p-2 text-gray-900 bg-gray-200 border-gray-200 focus:ring-4 focus:ring-green-300 focus:outline-none rounded-e-lg font-medium lg:font-bold text-base lg:text-lg cursor-pointer"
                 wire:click="changeTab('company')">
                شرکت های اتوماسیون
            </div>
        </li>
    </ul>
    <ul
        class="relative w-auto flex text-sm font-medium text-center text-gray-500 rounded-lg border border-[#026B56] my-2 py-2 pt-10"
        wire:ignore>
        <div class="absolute left-3 top-2 group cursor-pointer z-50" wire:click="resetFilters">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="text-[#013328] group-hover:scale-110">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747"/>
                <path d="M20 4v5h-5"/>
            </svg>
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
        <li class="w-full absolute top-1 right-1/2 translate-x-1/2 z-40" id="greenhouseFiltersList">
            <div class="w-full flex justify-center items-center space-x-1" id="greenhouseFiltersSection"
                 x-data="{ @foreach($greenhouseFilters as $filter){{ toCamelCase($filter->name) }}Open: false, @endforeach }">
                @foreach($greenhouseFilters as $filter)
                    <div class="w-auto relative mx-1">
                        <button @click="{{ toCamelCase($filter->name) }}Open = !{{ toCamelCase($filter->name) }}Open"
                                class="text-[#026B56] hover:text-white border border-[#026B56] mt-0.5 hover:bg-[#026B56] focus:ring-1 focus:outline-none focus:ring-[#026B56] rounded-lg px-3 py-2 text-xs font-bold text-center inline-flex items-center">
                            {{ $filter->title }}
                        </button>
                        <div
                            x-show="{{ toCamelCase($filter->name) }}Open"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute right-1/2 translate-x-1/2 z-40 mt-2 p-2 bg-[#013328] border border-[#026B56] rounded-lg shadow-lg min-w-[150px]"
                            @click.away="{{ toCamelCase($filter->name) }}Open = false"
                        >
                            @switch($filter->name)
                                @case(\App\Models\Filter::GREENHOUSE_SUBSTRATE_FILTER)
                                    <ul class="space-y-1 text-sm text-start text-gray-700"
                                        aria-labelledby="dropdownHelperButton">
                                        @foreach($substrates as $substrate)
                                            <li>
                                                <div class="flex p-2 rounded hover:bg-[#026B56]">
                                                    <div class="flex items-center h-5">
                                                        <input id="{{ $substrate['uuid'] }}"
                                                               type="checkbox" value="{{ $substrate['name'] }}"
                                                               wire:model.live="substrateFilter"
                                                               class="w-4 h-4 text-yellow-500 bg-transparent border-gray-300 rounded focus:ring-yellow-400 focus:ring-2">
                                                    </div>
                                                    <div class="ms-2 text-sm">
                                                        <label for="{{ $substrate['uuid'] }}"
                                                               class="font-medium text-white">
                                                            <div>{{ $substrate['name'] }}</div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @break
                                @case(\App\Models\Filter::GREENHOUSE_PRODUCT_FILTER)
                                    <ul class="space-y-1 text-sm text-start text-gray-700"
                                        aria-labelledby="dropdownHelperButton">
                                        @foreach($productTypes as $product)
                                            <li>
                                                <div class="flex p-2 rounded hover:bg-[#026B56]">
                                                    <div class="flex items-center h-5">
                                                        <input id="{{ $product['uuid'] }}"
                                                               type="checkbox" value="{{ $product['name'] }}"
                                                               wire:model.live="productFilter"
                                                               class="w-4 h-4 text-yellow-500 bg-transparent border-gray-300 rounded focus:ring-yellow-400 focus:ring-2">
                                                    </div>
                                                    <div class="ms-2 text-sm">
                                                        <label for="{{ $product['uuid'] }}"
                                                               class="font-medium text-white">
                                                            <div>{{ $product['name'] }}</div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @break
                                @case(\App\Models\Filter::GREENHOUSE_PROVINCE_FILTER)
                                    <ul class="space-y-1 text-sm text-start text-gray-700"
                                        aria-labelledby="dropdownHelperButton">
                                        @foreach($provinces as $province)
                                            <li>
                                                <div class="flex p-2 rounded hover:bg-[#026B56]">
                                                    <div class="flex items-center h-5">
                                                        <input id="{{ $province['uuid'] }}"
                                                               type="checkbox" value="{{ $province['name'] }}"
                                                               wire:model.live="provinceFilter"
                                                               class="w-4 h-4 text-yellow-500 bg-transparent border-gray-300 rounded focus:ring-yellow-400 focus:ring-2">
                                                    </div>
                                                    <div class="ms-2 text-sm">
                                                        <label for="{{ $province['uuid'] }}"
                                                               class="font-medium text-white">
                                                            <div>{{ $province['name'] }}</div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @break
                            @endswitch
                        </div>
                    </div>
                @endforeach
            </div>
        </li>

        <li class="w-full absolute top-1 right-1/2 translate-x-1/2 translate-y-16 z-0" id="companyFiltersList">
            <div class="w-full flex justify-center items-center space-x-1 opacity-0" id="companyFiltersSection"
                 x-data="{ @foreach($companyFilters as $filter){{ toCamelCase($filter->name) }}Open: false, @endforeach }">
                @foreach($companyFilters as $filter)
                    <div class="w-auto relative mx-1">
                        <button @click="{{ toCamelCase($filter->name) }}Open = !{{ toCamelCase($filter->name) }}Open"
                                disabled
                                class="text-[#026B56] hover:text-white border border-[#026B56] mt-0.5 hover:bg-[#026B56] focus:ring-1 focus:outline-none focus:ring-[#026B56] rounded-lg px-3 py-2 text-xs font-bold text-center inline-flex items-center">
                            {{ $filter->title }}
                        </button>
                        <div
                            x-show="{{ toCamelCase($filter->name) }}Open"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute right-1/2 translate-x-1/2 z-40 mt-2 p-2 bg-[#013328] border border-[#026B56] rounded-lg min-w-[150px]"
                            @click.away="{{ toCamelCase($filter->name) }}Open = false"
                        >
                            @switch($filter->name)
                                @case(\App\Models\Filter::COMPANY_TYPE_FILTER)
                                    <ul class="space-y-1 text-sm text-start text-gray-700"
                                        aria-labelledby="dropdownHelperButton">
                                        @foreach($companyType as $type)
                                            <li>
                                                <div class="flex p-2 rounded hover:bg-[#026B56]">
                                                    <div class="flex items-center h-5">
                                                        <input id="{{ $type['uuid'] }}"
                                                               type="checkbox" value="{{ $type['name'] }}"
                                                               wire:model.live="companyTypeFilter"
                                                               class="w-4 h-4 text-yellow-500 bg-transparent border-gray-300 rounded focus:ring-yellow-400 focus:ring-2">
                                                    </div>
                                                    <div class="ms-2 text-sm">
                                                        <label for="{{ $type['uuid'] }}"
                                                               class="font-medium text-white">
                                                            <div>{{ $type['name'] }}</div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @break
                                @case(\App\Models\Filter::COMPANY_PROVINCE_FILTER)
                                    <ul class="space-y-1 text-sm text-start text-gray-700"
                                        aria-labelledby="dropdownHelperButton">
                                        @foreach($companyProvinces as $province)
                                            <li>
                                                <div class="flex p-2 rounded hover:bg-[#026B56]">
                                                    <div class="flex items-center h-5">
                                                        <input id="{{ $province['uuid'] }}"
                                                               type="checkbox" value="{{ $province['name'] }}"
                                                               wire:model.live="companyProvinceFilter"
                                                               class="w-4 h-4 text-yellow-500 bg-transparent border-gray-300 rounded focus:ring-yellow-400 focus:ring-2">
                                                    </div>
                                                    <div class="ms-2 text-sm">
                                                        <label for="{{ $province['uuid'] }}"
                                                               class="font-medium text-white">
                                                            <div>{{ $province['name'] }}</div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @break
                            @endswitch
                        </div>
                    </div>
                @endforeach
            </div>
        </li>
    </ul>

    <div id="map" class="w-full h-[700px] rounded-lg mt-3 border border-[#026B56] z-30" wire:ignore></div>
    <link rel="stylesheet" href="./assets/css/map.css">
    <script>
        let greenhouseMarkers = {!! $greenhousesData !!};
        let companyMarkers = {!! $companiesData !!};

        document.addEventListener('livewire:init', () => {
            Livewire.on('submit-filter', (e) => {
                renderMarkers(e[0].type, JSON.parse(e[0].data));
            });
        });
    </script>

</div>
