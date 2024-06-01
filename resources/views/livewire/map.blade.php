<div class="w-full">
    <ul
        class="flex text-sm font-medium text-center text-gray-500 rounded-lg" wire:ignore>
        <li class="w-full">
            <div id="greenhouseTab"
                 class="inline-block w-full p-2 bg-[#6058C3] text-gray-50 border-gray-200 hover:text-white hover:bg-[#7367F0] active focus:ring-4 focus:ring-green-300 focus:outline-none rounded-s-lg font-medium lg:font-bold text-base lg:text-lg cursor-pointer">
                گلخانه
                ها
            </div>
            <div class="w-full flex justify-center items-center space-x-1" id="greenhouseFiltersSection"
                 x-data="{ substrateOpen: false, productOpen: false, provinceOpen: false }">
                <div class="w-auto relative mx-1">
                    <button @click="substrateOpen = !substrateOpen"
                            class="text-[#6058C3] hover:text-white border border-[#6058C3] mt-0.5 hover:bg-[#6058C3] focus:ring-1 focus:outline-none focus:ring-[#6058C3] rounded-lg px-3 py-2 text-xs font-bold text-center inline-flex items-center">
                        فیلتر بستر
                    </button>
                    <div
                        x-show="substrateOpen"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute right-1/2 translate-x-1/2 z-50 mt-2 p-2 bg-[#343951] border border-[#6058C3] rounded-lg shadow-lg"
                        @click.away="substrateOpen = false"
                    >
                        <ul class="space-y-1 text-sm text-start text-gray-700"
                            aria-labelledby="dropdownHelperButton">
                            @foreach($substrates as $substrate)
                                <li>
                                    <div class="flex p-2 rounded hover:bg-[#6058C3]">
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
                    </div>
                </div>
                <div class="w-auto relative mx-1">
                    <button @click="productOpen = !productOpen"
                            class="text-[#6058C3] hover:text-white border border-[#6058C3] mt-0.5 hover:bg-[#6058C3] focus:ring-1 focus:outline-none focus:ring-[#6058C3] rounded-lg px-3 py-2 text-xs font-bold text-center inline-flex items-center">
                        فیلتر محصول
                    </button>
                    <div
                        x-show="productOpen"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute right-1/2 translate-x-1/2 z-50 mt-2 p-2 bg-[#343951] border border-[#6058C3] rounded-lg shadow-lg w-full"
                        @click.away="productOpen = false"
                    >
                        <ul class="space-y-1 text-sm text-start text-gray-700"
                            aria-labelledby="dropdownHelperButton">
                            @foreach($productTypes as $product)
                                <li>
                                    <div class="flex p-2 rounded hover:bg-[#6058C3]">
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
                    </div>
                </div>
                <div class="w-auto relative mx-1">
                    <button @click="provinceOpen = !provinceOpen"
                            class="text-[#6058C3] hover:text-white border border-[#6058C3] mt-0.5 hover:bg-[#6058C3] focus:ring-1 focus:outline-none focus:ring-[#6058C3] rounded-lg px-3 py-2 text-xs font-bold text-center inline-flex items-center">
                        فیلتر استان
                    </button>
                    <div
                        x-show="provinceOpen"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute right-1/2 translate-x-1/2 z-50 mt-2 p-2 bg-[#343951] border border-[#6058C3] rounded-lg shadow-lg w-full"
                        @click.away="provinceOpen = false"
                    >
                        <ul class="space-y-1 text-sm text-start text-gray-700"
                            aria-labelledby="dropdownHelperButton">
                            @foreach($provinces as $province)
                                <li>
                                    <div class="flex p-2 rounded hover:bg-[#6058C3]">
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
                    </div>
                </div>
            </div>
        </li>
        <li class="w-full">
            <div id="companyTab"
                 class="inline-block w-full p-2 text-gray-900 bg-gray-200 border-gray-200 focus:ring-4 focus:ring-green-300 focus:outline-none rounded-e-lg font-medium lg:font-bold text-base lg:text-lg cursor-pointer">
                شرکت های اتوماسیون
            </div>
            <div class="w-full hidden justify-center items-center space-x-1" id="companyFiltersSection"
                 x-data="{ companyTypeOpen: false, companyProvinceOpen: false }">
                <div class="w-auto relative mx-1">
                    <button @click="companyTypeOpen = !companyTypeOpen"
                            class="text-[#6058C3] hover:text-white border border-[#6058C3] mt-0.5 hover:bg-[#6058C3] focus:ring-1 focus:outline-none focus:ring-[#6058C3] rounded-lg px-3 py-2 text-xs font-bold text-center inline-flex items-center">
                        فیلتر نوع
                    </button>
                    <div
                        x-show="companyTypeOpen"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute right-1/2 translate-x-1/2 z-50 mt-2 p-2 bg-[#343951] border border-[#6058C3] rounded-lg shadow-lg"
                        @click.away="companyTypeOpen = false"
                    >
                        <ul class="space-y-1 text-sm text-start text-gray-700"
                            aria-labelledby="dropdownHelperButton">
                            @foreach($companyType as $type)
                                <li>
                                    <div class="flex p-2 rounded hover:bg-[#6058C3]">
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
                    </div>
                </div>
                <div class="w-auto relative mx-1">
                    <button @click="companyProvinceOpen = !companyProvinceOpen"
                            class="text-[#6058C3] hover:text-white border border-[#6058C3] mt-0.5 hover:bg-[#6058C3] focus:ring-1 focus:outline-none focus:ring-[#6058C3] rounded-lg px-3 py-2 text-xs font-bold text-center inline-flex items-center">
                        فیلتر استان
                    </button>
                    <div
                        x-show="companyProvinceOpen"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute right-1/2 translate-x-1/2 z-50 mt-2 p-2 bg-[#343951] border border-[#6058C3] rounded-lg shadow-lg w-full"
                        @click.away="companyProvinceOpen = false"
                    >
                        <ul class="space-y-1 text-sm text-start text-gray-700"
                            aria-labelledby="dropdownHelperButton">
                            @foreach($companyProvinces as $province)
                                <li>
                                    <div class="flex p-2 rounded hover:bg-[#6058C3]">
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
                    </div>
                </div>
            </div>
        </li>
    </ul>

    <div id="map" class="w-full h-[700px] rounded-lg mt-3 border border-[#6058C3] z-30" wire:ignore></div>
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
