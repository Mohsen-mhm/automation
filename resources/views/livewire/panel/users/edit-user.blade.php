<x-modal>
    <x-slot name="name">
        edit-modal
    </x-slot>

    <x-slot name="title">
        ویرایش کاربر
    </x-slot>

    <x-slot name="content">
        <form class="p-4 md:p-5" wire:submit="update">
            @csrf

            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                    <label for="name"
                           class="block mb-2 text-sm font-medium text-gray-900">نام کاربر</label>
                    <input type="text" name="name" id="name" wire:model.live="name"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                           placeholder="نام">
                    @error('name')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span></p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                    <label for="national_id"
                           class="block mb-2 text-sm font-medium text-gray-900 ">کد ملی/شناسه ملی</label>
                    <input type="text" name="national_id" id="national_id" wire:model.live="national_id"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                           placeholder="کدملی/شناسه ملی">
                    @error('national_id')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span></p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                    <label for="phone_number"
                           class="block mb-2 text-sm font-medium text-gray-900 ">شماره تلفن</label>
                    <input type="text" name="phone_number" id="phone_number" wire:model.live="phone_number"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                           placeholder="شماره تلفن">
                    @error('phone_number')
                    <p class="mt-2 text-sm text-red-600"><span
                            class="font-medium">{{ $message }}</span></p>
                    @enderror
                </div>
            </div>

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
