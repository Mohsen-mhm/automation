<form class="w-full mb-2" wire:submit="update" enctype="multipart/form-data">
    @csrf
    <div class="grid gap-6 mb-6 md:grid-cols-2">
        <div>
            <label for="fname" class="flex mb-2 text-sm font-medium text-gray-900">
                نام
                <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                </svg>
            </label>
            <input type="text" id="fname" wire:model.live="fname"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
                   placeholder="علی" required>
            @error('fname')
            <p class="mt-2 text-sm text-red-600"><span
                    class="font-medium">{{ $message }}</span>
            </p>
            @enderror
        </div>
        <div>
            <label for="lname" class="flex mb-2 text-sm font-medium text-gray-900">
                نام خانوادگی
                <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                </svg>
            </label>
            <input type="text" id="lname" wire:model.live="lname"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
                   placeholder="احمدی" required>
            @error('lname')
            <p class="mt-2 text-sm text-red-600"><span
                    class="font-medium">{{ $message }}</span>
            </p>
            @enderror
        </div>
    </div>

    <div class="mb-6">
        <label for="national_id" class="flex mb-2 text-sm font-medium text-gray-900">
            کد ملی
            <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
            </svg>
        </label>
        <input type="text" id="national_id" wire:model.live="national_id"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
               placeholder="2281234567" required>
        @error('national_id')
        <p class="mt-2 text-sm text-red-600"><span
                class="font-medium">{{ $message }}</span>
        </p>
        @enderror
    </div>

    <div class="grid gap-6 mb-6 md:grid-cols-2">
        <div>
            <label for="organization_name" class="flex mb-2 text-sm font-medium text-gray-900">
                سازمان
                <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                </svg>
            </label>
            <input type="text" id="organization_name" wire:model.live="organization_name"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
                   placeholder="جهاد" required>
            @error('organization_name')
            <p class="mt-2 text-sm text-red-600"><span
                    class="font-medium">{{ $message }}</span>
            </p>
            @enderror
        </div>
        <div>
            <label for="organization_level"
                   class="flex mb-2 text-sm font-medium text-gray-900">
                سمت سازمانی
                <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                </svg>
            </label>
            <input type="text" id="organization_level" wire:model.live="organization_level"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
                   placeholder="مدیر اجرایی" required>
            @error('organization_level')
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
            <label for="landline_number" class="flex mb-2 text-sm font-medium text-gray-900">
                شماره تلفن ثابت
            </label>
            <input type="text" id="landline_number" wire:model.live="landline_number"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
                   placeholder="07123456789">
            @error('landline_number')
            <p class="mt-2 text-sm text-red-600"><span
                    class="font-medium">{{ $message }}</span>
            </p>
            @enderror
        </div>
        <div>
            <label for="phone_number" class="flex mb-2 text-sm font-medium text-gray-900">
                شماره تلفن همراه
                <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                </svg>
            </label>
            <input type="text" id="phone_number" wire:model.live="phone_number"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#258641] focus:border-[#258641] block w-full p-2.5"
                   placeholder="09123456789" required>
            @error('phone_number')
            <p class="mt-2 text-sm text-red-600"><span
                    class="font-medium">{{ $message }}</span>
            </p>
            @enderror
        </div>
    </div>

    <div class="grid gap-6 mb-6 md:grid-cols-2 flex items-center">
        <div>
            <label class="flex mb-2 text-sm font-medium text-gray-900" for="national_card">
                تصویر کارت ملی
                <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                </svg>
            </label>
            <input wire:model.live="national_card"
                   class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none transition"
                   id="national_card" type="file">
            @error('national_card')
            <p class="mt-2 text-sm text-red-600"><span
                    class="font-medium">{{ $message }}</span>
            </p>
            @enderror
        </div>

        <div class="w-full flex justify-center items-center">
            <div class="w-full flex flex-col justify-center items-center text-center">
                <span class="w-full mb-2 text-center font-bold">کارت ملی فعلی</span>
                <img src="{{ asset($old_national_card) }}" style="max-width: 150px" alt="National Card">
            </div>
        </div>
    </div>

    <div class="grid gap-6 mb-6 md:grid-cols-2 flex items-center">
        <div>
            <label class="flex mb-2 text-sm font-medium text-gray-900"
                   for="personnel_card">
                تصویر کارت پرسنلی
                <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                </svg>
            </label>
            <input wire:model.live="personnel_card"
                   class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none transition"
                   id="personnel_card" type="file">
            @error('personnel_card')
            <p class="mt-2 text-sm text-red-600"><span
                    class="font-medium">{{ $message }}</span>
            </p>
            @enderror
        </div>

        <div class="w-full flex justify-center items-center">
            <div class="w-full flex flex-col justify-center items-center text-center">
                <span class="w-full mb-2 text-center font-bold">کارت پرسنلی فعلی</span>
                <img src="{{ asset($old_personnel_card) }}" style="max-width: 150px" alt="Personnel Card">
            </div>
        </div>
    </div>

    <div class="grid gap-6 mb-6 md:grid-cols-2 flex items-center">
        <div class="w-full flex flex-col justify-center items-start">
            <label class="flex mb-2 text-sm font-medium text-gray-900"
                   for="introduction_letter">
                تصویر معرفی نامه
                <svg class="w-2 h-2 text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                </svg>
            </label>
            <input wire:model.live="introduction_letter"
                   class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none transition"
                   id="introduction_letter" type="file">
            @error('introduction_letter')
            <p class="mt-2 text-sm text-red-600"><span
                    class="font-medium">{{ $message }}</span>
            </p>
            @enderror
        </div>

        <div class="w-full flex justify-center items-center">
            <div class="w-full flex flex-col justify-center items-center text-center">
                <span class="w-full mb-2 text-center font-bold">معرفی نامه فعلی</span>
                <img src="{{ asset($old_introduction_letter) }}" style="max-width: 150px" alt="introduction letter">
            </div>
        </div>
    </div>

    <div class="w-full flex justify-center items-center mt-8">
        <button type="submit"
                class="focus:outline-none text-white font-bold bg-[#258641] hover:bg-[#215e32] focus:ring-4 focus:ring-green-300 rounded-lg px-5 py-2.5 me-2 mb-2 transition">
            ثبت و ارسال تغییرات
        </button>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="./../assets/js/ir-city-select/ir-city-select.js"></script>
</form>
