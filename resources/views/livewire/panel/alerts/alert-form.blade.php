<div>
    <div
        x-data="{ luxInputs: @if($lux_active) true @else false @endif, tempInputs: @if($temp_active) true @else false @endif, windInputs: @if($wind_active) true @else false @endif, humidityInputs: @if($humidity_active) true @else false @endif  }">
        <form class="p-4 md:p-5" wire:submit="store">
            @csrf

            <div class="flex items-center mb-4">
                <ul class="grid w-full gap-6 md:grid-cols-4">
                    <li>
                        <input type="checkbox" id="lux-option" wire:model.live="lux_active" class="hidden peer"
                               x-model="luxInputs">
                        <label for="lux-option"
                               class="flex flex-col justify-center items-center w-full p-5 text-gray-500 min-h-[11rem] bg-white border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-yellow-700 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-100">
                            <div class="flex flex-col justify-center items-center">
                                <svg class="w-10 h-10 mb-3 text-yellow-600" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M12 5V3m0 18v-2M7 7 5.7 5.7m12.8 12.8L17 17M5 12H3m18 0h-2M7 17l-1.4 1.4M18.4 5.6 17 7.1M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/>
                                </svg>
                                <div class="w-full text-lg font-semibold text-center">روشنایی محیط</div>
                            </div>
                        </label>
                    </li>
                    <li>
                        <input type="checkbox" id="temp-option" wire:model.live="temp_active" class="hidden peer"
                               x-model="tempInputs">
                        <label for="temp-option"
                               class="flex flex-col justify-center items-center w-full p-5 text-gray-500 min-h-[11rem] bg-white border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-red-700 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-100">
                            <div class="flex flex-col justify-center items-center">
                                <svg class="w-10 h-10 mb-3 text-red-600" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M18.1 17.6A7.2 7.2 0 0 1 12 21a6.6 6.6 0 0 1-5.8-3c-2.7-4.6.3-8.8.9-9.7A4.4 4.4 0 0 0 8 4c1.3 1 6.4 3.3 5.5 10.6 1.5-1.1 2.7-3 2.9-6.2 1.4 1 4 5.5 1.7 9.2Z"/>
                                </svg>
                                <div class="w-full text-lg font-semibold text-center">دمای محیط</div>
                            </div>
                        </label>
                    </li>
                    <li>
                        <input type="checkbox" id="wind-option" wire:model.live="wind_active" class="hidden peer"
                               x-model="windInputs">
                        <label for="wind-option"
                               class="flex flex-col justify-center items-center w-full p-5 text-gray-500 min-h-[11rem] bg-white border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-sky-700 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-100">
                            <div class="flex flex-col justify-center items-center">
                                <svg class="w-10 h-10 mb-3 text-sky-600" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M11.8 5.7A4.8 4.8 0 0 0 7 10a3.4 3.4 0 0 1 2.7-1.7c1.7 0 3 2 3.8 2.6a5.7 5.7 0 0 0 5.4 1c2-.7 2.9-3 3.1-4-1 1.4-2.4 2.2-4.3 1.2-1.2-.6-2.1-3.4-6-3.3Zm-5 6.3A4.8 4.8 0 0 0 2 16.2a3.4 3.4 0 0 1 2.7-1.7c1.7 0 3 2 3.8 2.6a5.7 5.7 0 0 0 5.4.9c2-.7 3-2.9 3.1-4-1 1.4-2.4 2.3-4.2 1.3-1.3-.7-2.2-3.4-6-3.3Z"/>
                                </svg>
                                <div class="w-full text-lg font-semibold text-center">سرعت باد محیط</div>
                            </div>
                        </label>
                    </li>
                    <li>
                        <input type="checkbox" id="humidity-option" wire:model.live="humidity_active"
                               class="hidden peer"
                               x-model="humidityInputs">
                        <label for="humidity-option"
                               class="flex flex-col justify-center items-center w-full p-5 text-gray-500 min-h-[11rem] bg-white border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-green-700 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-100">
                            <div class="flex flex-col justify-center items-center">
                                <svg class="w-10 h-10 mb-3 text-green-600" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                          d="M4.4 7.7c2 .5 2.4 2.8 3.2 3.8 1 1.4 2 1.3 3.2 2.7 1.8 2.3 1.3 5.7 1.3 6.7M20 15h-1a4 4 0 0 0-4 4v1M8.6 4c0 .8.1 1.9 1.5 2.6 1.4.7 3 .3 3 2.3 0 .3 0 2 1.9 2 2 0 2-1.7 2-2 0-.6.5-.9 1.2-.9H20m1 4a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <div class="w-full text-lg font-semibold text-center">رطوبت محیط</div>
                            </div>
                        </label>
                    </li>
                </ul>
            </div>

            <div class="w-full flex flex-col justify-center items-center">
                <label x-show="luxInputs" class="block mt-2 text-lg font-medium text-gray-900">روشنایی محیط</label>
                <div x-show="luxInputs" x-transition:enter="transition-opacity ease-out duration-300"
                     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-in duration-300"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="w-full flex flex-col justify-center items-center">
                    <div class="w-full flex justify-center items-center">
                        <div class="w-full my-5 mx-3">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-yellow-600" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M12 5V3m0 18v-2M7 7 5.7 5.7m12.8 12.8L17 17M5 12H3m18 0h-2M7 17l-1.4 1.4M18.4 5.6 17 7.1M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/>
                                    </svg>
                                </div>
                                <input type="number" id="min-lux" wire:model.live="min_lux"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full ps-10 p-2.5"
                                       placeholder="حداقل روشنایی بر اساس واحد لوکس"/>
                            </div>
                        </div>
                        <div class="w-full my-5 mx-3">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-yellow-600" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M12 5V3m0 18v-2M7 7 5.7 5.7m12.8 12.8L17 17M5 12H3m18 0h-2M7 17l-1.4 1.4M18.4 5.6 17 7.1M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/>
                                    </svg>
                                </div>
                                <input type="number" id="max-lux" wire:model.live="max_lux"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full ps-10 p-2.5"
                                       placeholder="حداکثر روشنایی بر اساس واحد لوکس"/>
                            </div>
                        </div>
                    </div>
                    @error('lux_error')
                    <p x-show="luxInputs" class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>

                <label x-show="tempInputs" class="block mt-2 text-lg font-medium text-gray-900">دمای محیط</label>
                <div x-show="tempInputs" x-transition:enter="transition-opacity ease-out duration-300"
                     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-in duration-300"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="w-full flex flex-col justify-center items-center">
                    <div class="w-full flex justify-center items-center">
                        <div class="w-full my-5 mx-3">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-red-600" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg"
                                         fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M18.1 17.6A7.2 7.2 0 0 1 12 21a6.6 6.6 0 0 1-5.8-3c-2.7-4.6.3-8.8.9-9.7A4.4 4.4 0 0 0 8 4c1.3 1 6.4 3.3 5.5 10.6 1.5-1.1 2.7-3 2.9-6.2 1.4 1 4 5.5 1.7 9.2Z"/>
                                    </svg>
                                </div>
                                <input type="number" id="min-temp" wire:model.live="min_temp"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full ps-10 p-2.5"
                                       placeholder="حداقل دما بر اساس واحد سانتی گراد"/>
                            </div>
                        </div>
                        <div class="w-full my-5 mx-3">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-red-600" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg"
                                         fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M18.1 17.6A7.2 7.2 0 0 1 12 21a6.6 6.6 0 0 1-5.8-3c-2.7-4.6.3-8.8.9-9.7A4.4 4.4 0 0 0 8 4c1.3 1 6.4 3.3 5.5 10.6 1.5-1.1 2.7-3 2.9-6.2 1.4 1 4 5.5 1.7 9.2Z"/>
                                    </svg>
                                </div>
                                <input type="number" id="max-temp" wire:model.live="max_temp"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full ps-10 p-2.5"
                                       placeholder="حداکثر دما بر اساس واحد سانتی گراد"/>
                            </div>
                        </div>
                    </div>
                    @error('temp_error')
                    <p x-show="tempInputs" class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>

                <label x-show="windInputs" class="block mt-2 text-lg font-medium text-gray-900">سرعت باد محیط</label>
                <div x-show="windInputs" x-transition:enter="transition-opacity ease-out duration-300"
                     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-in duration-300"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="w-full flex flex-col justify-center items-center">
                    <div class="w-full flex justify-center items-center">
                        <div class="w-full my-5 mx-3">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-sky-600" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg"
                                         fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M11.8 5.7A4.8 4.8 0 0 0 7 10a3.4 3.4 0 0 1 2.7-1.7c1.7 0 3 2 3.8 2.6a5.7 5.7 0 0 0 5.4 1c2-.7 2.9-3 3.1-4-1 1.4-2.4 2.2-4.3 1.2-1.2-.6-2.1-3.4-6-3.3Zm-5 6.3A4.8 4.8 0 0 0 2 16.2a3.4 3.4 0 0 1 2.7-1.7c1.7 0 3 2 3.8 2.6a5.7 5.7 0 0 0 5.4.9c2-.7 3-2.9 3.1-4-1 1.4-2.4 2.3-4.2 1.3-1.3-.7-2.2-3.4-6-3.3Z"/>
                                    </svg>
                                </div>
                                <input type="number" id="min-wind" wire:model.live="min_wind"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full ps-10 p-2.5"
                                       placeholder="حداقل سرعت باد بر اساس واحد کیلومتر بر ساعت"/>
                            </div>
                        </div>
                        <div class="w-full my-5 mx-3">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-sky-600" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg"
                                         fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M11.8 5.7A4.8 4.8 0 0 0 7 10a3.4 3.4 0 0 1 2.7-1.7c1.7 0 3 2 3.8 2.6a5.7 5.7 0 0 0 5.4 1c2-.7 2.9-3 3.1-4-1 1.4-2.4 2.2-4.3 1.2-1.2-.6-2.1-3.4-6-3.3Zm-5 6.3A4.8 4.8 0 0 0 2 16.2a3.4 3.4 0 0 1 2.7-1.7c1.7 0 3 2 3.8 2.6a5.7 5.7 0 0 0 5.4.9c2-.7 3-2.9 3.1-4-1 1.4-2.4 2.3-4.2 1.3-1.3-.7-2.2-3.4-6-3.3Z"/>
                                    </svg>
                                </div>
                                <input type="number" id="max-wind" wire:model.live="max_wind"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full ps-10 p-2.5"
                                       placeholder="حداکثر سرعت باد بر اساس واحد کیلومتر بر ساعت"/>
                            </div>
                        </div>
                    </div>
                    @error('wind_error')
                    <p x-show="windInputs" class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>

                <label x-show="humidityInputs" class="block mt-2 text-lg font-medium text-gray-900">رطوبت محیط</label>
                <div x-show="humidityInputs" x-transition:enter="transition-opacity ease-out duration-300"
                     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-in duration-300"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="w-full flex flex-col justify-center items-center">
                    <div class="w-full flex justify-center items-center">
                        <div class="w-full my-5 mx-3">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-green-600" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                              d="M4.4 7.7c2 .5 2.4 2.8 3.2 3.8 1 1.4 2 1.3 3.2 2.7 1.8 2.3 1.3 5.7 1.3 6.7M20 15h-1a4 4 0 0 0-4 4v1M8.6 4c0 .8.1 1.9 1.5 2.6 1.4.7 3 .3 3 2.3 0 .3 0 2 1.9 2 2 0 2-1.7 2-2 0-.6.5-.9 1.2-.9H20m1 4a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                </div>
                                <input type="number" id="min-humidity" wire:model.live="min_humidity"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full ps-10 p-2.5"
                                       placeholder="حداقل رطوبت بر اساس واحد گرم بر متر مکعب"/>
                            </div>
                        </div>
                        <div class="w-full my-5 mx-3">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-green-600" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                              d="M4.4 7.7c2 .5 2.4 2.8 3.2 3.8 1 1.4 2 1.3 3.2 2.7 1.8 2.3 1.3 5.7 1.3 6.7M20 15h-1a4 4 0 0 0-4 4v1M8.6 4c0 .8.1 1.9 1.5 2.6 1.4.7 3 .3 3 2.3 0 .3 0 2 1.9 2 2 0 2-1.7 2-2 0-.6.5-.9 1.2-.9H20m1 4a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                </div>
                                <input type="number" id="max-humidity" wire:model.live="max_humidity"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full ps-10 p-2.5"
                                       placeholder="حداکثر رطوبت بر اساس واحد گرم بر متر مکعب"/>
                            </div>
                        </div>
                    </div>
                    @error('humidity_error')
                    <p x-show="humidityInputs" class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="w-full flex justify-center items-center">
                <button type="submit" wire:loading.class="opacity-50" wire:loading.attr="disabled"
                        class="text-white mt-5 inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    <svg class="ml-2 -mr-1 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                         fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="m13.835 7.578-.005.007-7.137 7.137 2.139 2.138 7.143-7.142-2.14-2.14Zm-10.696 3.59 2.139 2.14 7.138-7.137.007-.005-2.141-2.141-7.143 7.143Zm1.433 4.261L2 12.852.051 18.684a1 1 0 0 0 1.265 1.264L7.147 18l-2.575-2.571Zm14.249-14.25a4.03 4.03 0 0 0-5.693 0L11.7 2.611 17.389 8.3l1.432-1.432a4.029 4.029 0 0 0 0-5.689Z"/>
                    </svg>
                    اعمال تغییرات
                </button>
            </div>
        </form>
    </div>
</div>
