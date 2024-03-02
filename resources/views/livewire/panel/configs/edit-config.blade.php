<x-modal>
    <x-slot name="name">
        edit-modal
    </x-slot>

    <x-slot name="title">
        ویرایش تنظیمات
    </x-slot>

    <x-slot name="content">
        <form class="p-4 md:p-5" wire:submit="update">
            @csrf

            @if($isJsonType)
                <label for="value" wire:transition
                       class="block mb-2 text-sm font-medium text-gray-900">مقادیر</label>
                <div class="w-full grid gap-2 mb-2 grid-cols-2" wire:transition>
                    @foreach($value as $item)
                        <span id="{{ $item['id'] }}"
                              class="flex justify-between items-center px-2 py-1 me-2 text-sm font-medium text-blue-800 bg-blue-100 rounded">
                                <b>{{ $item['item'] }}</b>
                                <button type="button" wire:click="removeJsonValue('{{ $item['id'] }}')"
                                        onclick="document.getElementById('{{ $item['id'] }}').classList.add('hidden')"
                                        class="inline-flex items-center p-1 ms-2 text-sm text-blue-400 bg-transparent rounded-sm hover:bg-blue-200 hover:text-blue-900"
                                        aria-label="Remove">
                                    <svg class="w-2 h-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Remove badge</span>
                                </button>
                            </span>
                    @endforeach
                </div>
                <div class="col-span-2 mb-3 flex justify-center items-end" wire:transition>
                    <div class="w-2/3" wire:transition>
                        <input type="text" name="value" id="value" wire:model.live="valueInput"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                               placeholder="افزودن مقدار جدید">
                    </div>
                    <div class="w-1/3 flex h-full justify-center items-end" wire:transition>
                        <div wire:click="addJsonValue()"
                             class="cursor-pointer text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            <svg class="w-5 h-5 text-white" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="M9 1v16M1 9h16"/>
                            </svg>
                        </div>
                    </div>
                </div>
            @endif
            @if(!$isJsonType)
                <div class="grid gap-4 mb-4 grid-cols-2" wire:transition>
                    <div class="col-span-2">
                        <label for="value"
                               class="block mb-2 text-sm font-medium text-gray-900">هزینه</label>
                        <input type="text" name="value" id="value" wire:model.live="value"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                               placeholder="مقدار">
                        @error('value')
                        <p class="mt-2 text-sm text-red-600"><span
                                class="font-medium">{{ $message }}</span></p>
                        @enderror
                    </div>
                </div>
            @endif
            <button type="submit" wire:loading.class="opacity-50" wire:loading.attr="disabled"
                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                <svg class="ml-2 -mr-1 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="m13.835 7.578-.005.007-7.137 7.137 2.139 2.138 7.143-7.142-2.14-2.14Zm-10.696 3.59 2.139 2.14 7.138-7.137.007-.005-2.141-2.141-7.143 7.143Zm1.433 4.261L2 12.852.051 18.684a1 1 0 0 0 1.265 1.264L7.147 18l-2.575-2.571Zm14.249-14.25a4.03 4.03 0 0 0-5.693 0L11.7 2.611 17.389 8.3l1.432-1.432a4.029 4.029 0 0 0 0-5.689Z"/>
                </svg>
                اعمال تغییرات
            </button>

        </form>
    </x-slot>
</x-modal>
