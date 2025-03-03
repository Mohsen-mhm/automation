<x-modal>
    <x-slot name="name">
        create-modal
    </x-slot>

    <x-slot name="title">
        ایجاد گلخانه
    </x-slot>

    <x-slot name="content">
        <form class="p-4 md:p-5" wire:submit="store" enctype="multipart/form-data">
            @csrf

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="name" class="flex mb-2 text-sm font-medium text-gray-900">
                        نام
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="name" wire:model.blur="name"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="گلخانه محمدی" required>
                    @error('name')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="licence_number" class="flex mb-2 text-sm font-medium text-gray-900">
                        شماره پروانه
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="licence_number" wire:model.blur="licence_number"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="4689496584" required>
                    @error('licence_number')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="substrate_type" class="flex mb-2 text-sm font-medium text-gray-900">
                        نوع بستر
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <select id="substrate_type" wire:model.blur="substrate_type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option selected>بستر را انتخاب کنید</option>
                        @foreach ($substrates as $substrate)
                            <option value="{{ $substrate }}">{{ $substrate }}</option>
                        @endforeach
                    </select>
                    @error('substrate_type')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="product_type" class="flex mb-2 text-sm font-medium text-gray-900">
                        نوع محصول
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <select id="product_type" wire:model.blur="product_type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option selected>محصول را انتخاب کنید</option>
                        @foreach ($productTypes as $productType)
                            <option value="{{ $productType }}">{{ $productType }}</option>
                        @endforeach
                    </select>
                    @error('product_type')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="meterage" class="flex mb-2 text-sm font-medium text-gray-900">
                        متراژ
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="meterage" wire:model.blur="meterage"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="2000 متر مربع" required>
                    @error('meterage')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="greenhouse_status" class="flex mb-2 text-sm font-medium text-gray-900">
                        وضعیت گلخانه
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <select id="greenhouse_status" wire:model.blur="greenhouse_status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option selected>وضعیت را انتخاب کنید</option>
                        @foreach ($greenhouseStatuses as $greenhouseStatus)
                            <option value="{{ $greenhouseStatus }}">{{ $greenhouseStatus }}</option>
                        @endforeach
                    </select>
                    @error('greenhouse_status')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="construction_date"
                           class="flex mb-2 text-sm font-medium text-gray-900">
                        تاریخ احداث
                    </label>
                    <input type="text" id="construction_date" wire:model="construction_date"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="1400/05/24">
                    @error('construction_date')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="operation_date"
                           class="flex mb-2 text-sm font-medium text-gray-900">
                        تاریخ بهره برداری
                    </label>
                    <input type="text" id="operation_date" wire:model="operation_date"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="1401/03/25">
                    @error('operation_date')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="owner_name" class="flex mb-2 text-sm font-medium text-gray-900">
                        نام مالک
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="owner_name" wire:model.blur="owner_name"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="محسن محمدی" required>
                    @error('owner_name')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="owner_national_id" class="flex mb-2 text-sm font-medium text-gray-900">
                        کد ملی مالک
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="owner_national_id" wire:model.blur="owner_national_id"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="2281234567" required>
                    @error('owner_national_id')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-3">
                <div>
                    <label for="owner_phone" class="flex mb-2 text-sm font-medium text-gray-900">
                        تلفن همراه مالک
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="owner_phone" wire:model.blur="owner_phone"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="09123456789" required>
                    @error('owner_phone')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div class="flex justify-start items-center">
                    <div class="flex items-center me-4">
                        <input id="climate_system" type="checkbox" value="0" wire:model.blur="climate_system"
                               class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                        <label for="climate_system"
                               class="ms-2 text-sm font-medium text-gray-900">دارای سامانه کنترل
                            اقلیم</label>
                    </div>
                    @error('climate_system')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div class="flex justify-start items-center">
                    <div class="flex items-center me-4">
                        <input id="feeding_system" type="checkbox" value="0" wire:model.blur="feeding_system"
                               class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                        <label for="feeding_system"
                               class="ms-2 text-sm font-medium text-gray-900">دارای سامانه تغذیه و
                            آبیاری</label>
                    </div>
                    @error('feeding_system')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2 ir-select">
                <div>
                    <label for="province" class="flex mb-2 text-sm font-medium text-gray-900">
                        استان
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <select type="text" id="province" wire:model.blur="province" wire:ignore
                            class="ir-province bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                            required></select>
                    @error('province')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="city" class="flex mb-2 text-sm font-medium text-gray-900">
                        شهر
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <select type="text" id="city" wire:model.blur="city" wire:ignore
                            class="ir-city bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                            required></select>
                    @error('city')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="address" class="flex mb-2 text-sm font-medium text-gray-900">
                        آدرس
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="address" wire:model.blur="address"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="بلوار پاسداران، ..." required>
                    @error('address')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="postal" class="flex mb-2 text-sm font-medium text-gray-900">
                        کد پستی
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="postal" wire:model.blur="postal"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="718123456" required>
                    @error('postal')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="location_link" class="flex mb-2 text-sm font-medium text-gray-900">
                        لینک لوکیشن گلخانه (از گوگل مپ)
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="location_link" wire:model.blur="location_link"
                           class="bg-gray-50 text-left border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="https://maps.app.goo.gl/.....">
                    @error('location_link')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div class="flex flex-col justify-center items-start" dir="ltr">
                    <div wire:loading.remove>
                        <p>coordinates: <b class="text-[#026B56]" wire:transition>{{ $coordinates }}</b></p>
                        <p>latitude: <b class="text-[#026B56]" wire:transition>{{ $latitude }}</b></p>
                        <p>longitude: <b class="text-[#026B56]" wire:transition>{{ $longitude }}</b></p>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 mb-6 mt-4 md:grid-cols-2">
                <div>
                    <label class="flex mb-2 text-sm font-medium text-gray-900"
                           for="operation_licence">
                        تصویر پروانه بهره برداری
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input wire:model.blur="operation_licence"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none transition"
                           id="operation_licence" type="file" required>
                    @error('operation_licence')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label class="flex mb-2 text-sm font-medium text-gray-900" for="image">
                        تصویر یا لوگو گلخانه
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input wire:model.blur="image"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none transition"
                           id="image" type="file">
                    @error('image')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            @can(\App\Models\Greenhouse::GREENHOUSE_CONFIRM)
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
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
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
                    class="text-white inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                <svg class="ml-2 -mr-1 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="m13.835 7.578-.005.007-7.137 7.137 2.139 2.138 7.143-7.142-2.14-2.14Zm-10.696 3.59 2.139 2.14 7.138-7.137.007-.005-2.141-2.141-7.143 7.143Zm1.433 4.261L2 12.852.051 18.684a1 1 0 0 0 1.265 1.264L7.147 18l-2.575-2.571Zm14.249-14.25a4.03 4.03 0 0 0-5.693 0L11.7 2.611 17.389 8.3l1.432-1.432a4.029 4.029 0 0 0 0-5.689Z"/>
                </svg>
                ایجاد
            </button>

        </form>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    </x-slot>
</x-modal>
