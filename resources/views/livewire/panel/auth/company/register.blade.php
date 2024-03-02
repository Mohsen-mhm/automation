<div class="w-full flex flex-col justify-center items-center">
    <div
        class="md:w-3/5 mt-10 flex flex-col justify-center items-center p-6 bg-white border border-gray-200 rounded-lg shadow-lg">
        <h5 class="mb-8 text-2xl font-semibold tracking-tight text-gray-900">ثبت شرکت جدید</h5>
        <form class="w-full mb-2" wire:submit="register" enctype="multipart/form-data">
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
                    <input type="text" id="name" wire:model.live="name"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
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
                    <select type="text" id="type" wire:model.live="type" wire:ignore
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
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
                    <input type="text" id="national_id" wire:model.live="national_id"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
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
                    <input type="text" id="registration_number" wire:model.live="registration_number"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
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
                    <input type="text" id="registration_place" wire:model.live="registration_place"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
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
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
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
                    <select type="text" id="province" wire:model.live="province" wire:ignore
                            class="ir-province bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
                            placeholder="فارس" required></select>
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
                    <select type="text" id="city" wire:model.live="city" wire:ignore
                            class="ir-city bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
                            placeholder="شیراز" required></select>
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
                    <input type="text" id="address" wire:model.live="address"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
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
                    <input type="text" id="postal" wire:model.live="postal"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
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
                    <input type="text" id="ceo_name" wire:model.live="ceo_name"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
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
                    <input type="text" id="ceo_national_id" wire:model.live="ceo_national_id"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
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
                    <input type="text" id="ceo_phone" wire:model.live="ceo_phone"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
                           placeholder="09123456789" required>
                    @error('ceo_phone')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div class="flex justify-start items-center">
                    <div class="flex items-center me-4">
                        <input id="climate_system" type="checkbox" value="0" wire:model.live="climate_system"
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
                        <input id="feeding_system" type="checkbox" value="0" wire:model.live="feeding_system"
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
                    <input type="text" id="interface_name" wire:model.live="interface_name"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
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
                    <input type="text" id="interface_phone" wire:model.live="interface_phone"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
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
                    <input type="text" id="landline_number" wire:model.live="landline_number"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
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
                    <input type="text" id="phone_number" wire:model.live="phone_number"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
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
                           class="bg-gray-50 text-left border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
                           placeholder="https://maps.app.goo.gl/....." required>
                    @error('location_link')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
                <div class="flex flex-col justify-center items-start" dir="ltr">
                    <div role="status" wire:loading wire:loading.target="getCoordinates()">
                        <svg aria-hidden="true"
                             class="w-6 h-6 text-gray-200 animate-spin fill-blue-600"
                             viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor"/>
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill"/>
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div wire:loading.remove>
                        <p>coordinates: <b class="text-[#258641]" wire:transition>{{ $coordinates }}</b></p>
                        <p>latitude: <b class="text-[#258641]" wire:transition>{{ $latitude }}</b></p>
                        <p>longitude: <b class="text-[#258641]" wire:transition>{{ $longitude }}</b></p>
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
                    <input type="text" id="website" wire:model.live="website"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
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
                    <input type="email" id="email" wire:model.live="email"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
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
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input wire:model.live="company_logo"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none transition"
                           id="company_logo" type="file" required>
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
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input wire:model.live="operation_licence"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none transition"
                           id="operation_licence" type="file" required>
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
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input type="text" id="brand" wire:model.live="brand"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
                           placeholder="سیمرغ" required>
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
                    <input type="file" id="official_newspaper" wire:model.live="official_newspaper" accept="image/*,.pdf"
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
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input wire:model.live="brand_logo"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none transition"
                           id="brand_logo" type="file" required>
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
                        <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                        </svg>
                    </label>
                    <input wire:model.live="trademark_certificate"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none transition"
                           id="trademark_certificate" type="file" required>
                    @error('trademark_certificate')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span>
                    </p>
                    @enderror
                </div>
            </div>

            <div class="w-full flex justify-center items-center mt-8">
                <button type="submit"
                        class="focus:outline-none text-white font-bold bg-[#258641] hover:bg-[#215e32] focus:ring-4 focus:ring-green-300 rounded-lg px-5 py-2.5 me-2 mb-2 transition">
                    ثبت و ارسال
                </button>
            </div>
        </form>
    </div>

    <div class="w-full flex justify-center items-center mt-8 mb-24">
        <a href="{{ route('home') }}"
           class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 transition">
            بازگشت به صفحه اصلی
        </a>
        <a href="{{ route('login.company') }}"
           class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none transition">
            صفحه ورود
        </a>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="./../assets/js/ir-city-select/ir-city-select.js"></script>
</div>
