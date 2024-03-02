<x-modal>
    <x-slot name="name">
        edit-modal
    </x-slot>

    <x-slot name="title">
        ویرایش اتوماسیون
    </x-slot>

    <x-slot name="content">
        <form class="p-4 md:p-5" wire:submit="update">
            @csrf

            <div class="grid gap-6 mb-6 md:grid-cols-1">
                <div>
                    <label for="greenhouse_id" class="flex mb-2 text-sm font-medium text-gray-900">
                        گلخانه
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <select id="greenhouse_id" wire:model.blur="greenhouse_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option selected>گلخانه را انتخاب کنید</option>
                        @foreach ($greenhouses as $greenhouse)
                            <option value="{{ $greenhouse->id }}">{{ $greenhouse->name }}
                                - {{ $greenhouse->licence_number }}</option>
                        @endforeach
                    </select>
                    @error('greenhouse_id')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="climate_company_id" class="flex mb-2 text-sm font-medium text-gray-900">
                        شرکت مجری کنترل اقلیم
                    </label>
                    <select id="climate_company_id" wire:model.blur="climate_company_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option selected>شرکت را انتخاب کنید</option>
                        @foreach ($climate_companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}
                                - {{ $company->national_id }}</option>
                        @endforeach
                    </select>
                    @error('climate_company_id')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="climate_date"
                           class="flex mb-2 text-sm font-medium text-gray-900">
                        تاریخ اجراء کنترل اقلیم
                    </label>
                    <input type="text" id="climate_date" wire:model="climate_date"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
                           placeholder="1400/05/24">
                    @error('climate_date')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="feeding_company_id" class="flex mb-2 text-sm font-medium text-gray-900">
                        شرکت مجری تغذیه و آبیاری
                    </label>
                    <select id="feeding_company_id" wire:model.blur="feeding_company_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option selected>شرکت را انتخاب کنید</option>
                        @foreach ($feeding_companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}
                                - {{ $company->national_id }}</option>
                        @endforeach
                    </select>
                    @error('feeding_company_id')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="feeding_date"
                           class="flex mb-2 text-sm font-medium text-gray-900">
                        تاریخ اجراء تغذیه و آبیاری
                    </label>
                    <input type="text" id="feeding_date" wire:model="feeding_date"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
                           placeholder="1401/03/25">
                    @error('feeding_date')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="climate_api_link"
                           class="flex mb-2 text-sm font-medium text-gray-900">
                        لینک API کنترل اقلیم
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="climate_api_link" wire:model="climate_api_link"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
                           placeholder="https://example.com/...." required>
                    @error('climate_api_link')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="climate_linked_date"
                           class="flex mb-2 text-sm font-medium text-gray-900">
                        تاریخ اتصال کنترل اقلیم
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="climate_linked_date" wire:model="climate_linked_date"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
                           placeholder="1401/03/25" required>
                    @error('climate_linked_date')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="feeding_api_link"
                           class="flex mb-2 text-sm font-medium text-gray-900">
                        لینک API تغذیه و آبیاری
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="feeding_api_link" wire:model="feeding_api_link"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
                           placeholder="https://example.com/...." required>
                    @error('feeding_api_link')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="feeding_linked_date"
                           class="flex mb-2 text-sm font-medium text-gray-900">
                        تاریخ اتصال تغذیه و آبیاری
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="feeding_linked_date" wire:model="feeding_linked_date"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
                           placeholder="1401/03/25" required>
                    @error('feeding_linked_date')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            @can(\App\Models\Automation::AUTOMATION_CONFIRM)
                <div class="grid gap-6 mb-6 md:grid-cols-1">
                    <div>
                        <label for="status" class="flex mb-2 text-sm font-medium text-gray-900">
                            وضعیت
                            <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                            </svg>
                        </label>
                        <select type="text" id="status" wire:model.blur="status" wire:ignore
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
                                required>
                            <option value="">وضعیت اطلاعات گلخانه را انتخاب کنید</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status['name'] }}">
                                    {{ $status['title'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                        <p class="mt-2 text-sm text-red-600"><span
                                class="font-medium">{{ $message }}</span>
                        </p>
                        @enderror
                    </div>
                </div>
            @endcan

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
