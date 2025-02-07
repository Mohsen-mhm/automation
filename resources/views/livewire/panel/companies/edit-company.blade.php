<x-modal>
    <x-slot name="name">
        edit-modal
    </x-slot>

    <x-slot name="title">
        ویرایش شرکت
    </x-slot>

    <x-slot name="content">
        <form class="p-4 md:p-5" wire:submit="update" enctype="multipart/form-data">
            @csrf

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="name" class="flex mb-2 text-sm font-medium text-gray-900">
                        نام شرکت
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="name" wire:model.blur="name"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="شرکت سیمرغ" required>
                    @error('name')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="type" class="flex mb-2 text-sm font-medium text-gray-900">
                        نوع شرکت
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <select type="text" id="type" wire:model.blur="type" wire:ignore
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                            required>
                        <option value="">نوع شرکت را انتخاب کنید</option>
                        @foreach ($companyTypes as $companyType)
                            <option value="{{ $companyType }}">
                                {{ $companyType }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="national_id" class="flex mb-2 text-sm font-medium text-gray-900">
                        شناسه ملی
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="national_id" wire:model.blur="national_id"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="1016110254" required>
                    @error('national_id')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="registration_number"
                           class="flex mb-2 text-sm font-medium text-gray-900">
                        شماره ثبت
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="registration_number" wire:model.blur="registration_number"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="123456" required>
                    @error('registration_number')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="registration_place"
                           class="flex mb-2 text-sm font-medium text-gray-900">
                        محل ثبت
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="registration_place" wire:model.blur="registration_place"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="شیراز" required>
                    @error('registration_place')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="registration_date"
                           class="flex mb-2 text-sm font-medium text-gray-900">
                        تاریخ ثبت
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="registration_date" wire:model="registration_date"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="1400/05/24" required>
                    @error('registration_date')
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
                    <select id="province" wire:model.blur="province" wire:ignore
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
                    <label for="ceo_name" class="flex mb-2 text-sm font-medium text-gray-900">
                        نام مدیرعامل
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="ceo_name" wire:model.blur="ceo_name"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="بلوار پاسداران، ..." required>
                    @error('ceo_name')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="ceo_national_id" class="flex mb-2 text-sm font-medium text-gray-900">
                        کد ملی مدیر عامل
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="ceo_national_id" wire:model.blur="ceo_national_id"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="718123456" required>
                    @error('ceo_national_id')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-3">
                <div>
                    <label for="ceo_phone" class="flex mb-2 text-sm font-medium text-gray-900">
                        شماره تلفن همراه مدیر عامل
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="ceo_phone" wire:model.blur="ceo_phone"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="09123456789" required>
                    @error('ceo_phone')
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

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="interface_name" class="flex mb-2 text-sm font-medium text-gray-900">
                        نام رابط
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="interface_name" wire:model.blur="interface_name"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="محسن" required>
                    @error('interface_name')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="interface_phone" class="flex mb-2 text-sm font-medium text-gray-900">
                        تلفن همراه رابط
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="interface_phone" wire:model.blur="interface_phone"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="09123456789" required>
                    @error('interface_phone')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="landline_number" class="flex mb-2 text-sm font-medium text-gray-900">
                        شماره تلفن ثابت شرکت
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="landline_number" wire:model.blur="landline_number"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="07123456789" required>
                    @error('landline_number')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="phone_number" class="flex mb-2 text-sm font-medium text-gray-900">
                        شماره تلفن همراه شرکت
                    </label>
                    <input type="text" id="phone_number" wire:model.blur="phone_number"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="09123456789">
                    @error('phone_number')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="location_link" class="flex mb-2 text-sm font-medium text-gray-900">
                        لینک لوکیشن شرکت (از گوگل مپ)
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="location_link" wire:model.blur="location_link"
                           class="bg-gray-50 text-left border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="https://maps.app.goo.gl/....." required>
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

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="website" class="flex mb-2 text-sm font-medium text-gray-900">
                        آدرس وب سایت شرکت
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="website" wire:model.blur="website"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="https://company.ir" required>
                    @error('website')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="flex mb-2 text-sm font-medium text-gray-900">
                        آدرس ایمیل شرکت
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="email" id="email" wire:model.blur="email"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="info@company.ir" required>
                    @error('email')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label class="flex mb-2 text-sm font-medium text-gray-900" for="company_logo">
                        تصویر لوگو شرکت
                    </label>
                    <input wire:model.blur="company_logo"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none transition"
                           id="company_logo" type="file">
                    @error('company_logo')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label class="flex mb-2 text-sm font-medium text-gray-900"
                           for="operation_licence">
                        مجوز فناوری یا پروانه بهره برداری
                    </label>
                    <input wire:model.blur="operation_licence"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none transition"
                           id="operation_licence" type="file">
                    @error('operation_licence')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="brand" class="flex mb-2 text-sm font-medium text-gray-900">
                        علامت تجاری
                    </label>
                    <input type="text" id="brand" wire:model.blur="brand"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#026B56] focus:border-[#026B56] block w-full p-2.5"
                           placeholder="سیمرغ">
                    @error('brand')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label for="official_newspaper" class="flex mb-2 text-sm font-medium text-gray-900">
                        روزنامه رسمی آخرین تغییرات شرکت
                    </label>
                    <input type="file" id="official_newspaper" wire:model.blur="official_newspaper"
                           accept="image/*,.pdf"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none transition">
                    @error('official_newspaper')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label class="flex mb-2 text-sm font-medium text-gray-900" for="brand_logo">
                        تصویر علامت تجاری
                    </label>
                    <input wire:model.blur="brand_logo"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none transition"
                           id="brand_logo" type="file">
                    @error('brand_logo')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div>
                    <label class="flex mb-2 text-sm font-medium text-gray-900"
                           for="trademark_certificate">
                        گواهی ثبت علامت تجاری
                    </label>
                    <input wire:model.blur="trademark_certificate"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none transition"
                           id="trademark_certificate" type="file">
                    @error('trademark_certificate')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            @can(\App\Models\Company::COMPANY_CONFIRM)
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
                            <option value="">وضعیت اطلاعات شرکت را انتخاب کنید</option>
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
