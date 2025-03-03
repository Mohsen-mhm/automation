<x-modal>
    <x-slot name="name">
        show-modal
    </x-slot>

    <x-slot name="title">
        اطلاعات گلخانه
    </x-slot>

    <x-slot name="content">
        <div class="w-full overflow-y-scroll">
            <div class="overflow-hidden p-3">
                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">نام گلخانه</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            <p wire:transition>{{ $greenhouse->get('name') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">شماره پروانه</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            <p wire:transition>{{ $greenhouse->get('licence_number') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">نوع بستر</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            <p wire:transition>{{ $greenhouse->get('substrate_type') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">نوع محصول</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            <p wire:transition>{{ $greenhouse->get('product_type') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">متراژ</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            <p wire:transition>{{ $greenhouse->get('meterage') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">وضعیت گلخانه</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            <p wire:transition>{{ $greenhouse->get('greenhouse_status') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">تاریخ احداث</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            <p wire:transition>{{ \Morilog\Jalali\Jalalian::fromDateTime($greenhouse->get('construction_date'))->toDateString() }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">تاریخ بهره برداری</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            <p wire:transition>{{ \Morilog\Jalali\Jalalian::fromDateTime($greenhouse->get('operation_date'))->toDateString() }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">نام مالک</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            <p wire:transition>{{ $greenhouse->get('owner_name') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">کدملی مالک</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            <p wire:transition>{{ $greenhouse->get('owner_national_id') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">تلفن همراه مالک</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            <p wire:transition>{{ $greenhouse->get('owner_phone') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">سامانه کنترل اقلیم</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            @if($greenhouse->get('climate_system'))
                                <p wire:transition>دارد</p>
                            @else
                                <p wire:transition>ندارد</p>
                            @endif
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">سامانه تغذیه و آبیاری</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            @if($greenhouse->get('feeding_system'))
                                <p wire:transition>دارد</p>
                            @else
                                <p wire:transition>ندارد</p>
                            @endif
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">استان</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            <p wire:transition>{{ $greenhouse->get('province') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">شهر</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            <p wire:transition>{{ $greenhouse->get('city') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">آدرس</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            <p wire:transition>{{ $greenhouse->get('address') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">کد پستی</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            <p wire:transition>{{ $greenhouse->get('postal') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">طول و عرض جغرافیایی</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            <p wire:transition>{{ $greenhouse->get('coordinates') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">وضعیت</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($greenhouse)
                            @if ($greenhouse->get('active'))
                                <span style="background-color: rgb(222 247 236); color: rgb(3 84 63) !important;"
                                      class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">فعال</span>
                            @else
                                <span style="background-color: rgb(253 232 232); color: rgb(155 28 28) !important;"
                                      class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">غیرفعال</span>
                            @endif
                            @switch ($greenhouse->get('status'))
                                @case (\App\Models\Config::STATUS_PENDING)
                                    <span style="background-color: rgb(253 246 178); color: rgb(114 59 19) !important;"
                                          class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">{{ \App\Models\Config::STATUS_PENDING_FA }}</span>
                                    @break
                                @case (\App\Models\Config::STATUS_EDITED)
                                    <span style="background-color: rgb(225 239 254); color: rgb(30 66 159) !important;"
                                          class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">{{ \App\Models\Config::STATUS_EDITED_FA }}</span>
                                    @break
                                @case (\App\Models\Config::STATUS_CONFIRMED)
                                    <span style="background-color: rgb(222 247 236); color: rgb(3 84 63) !important;"
                                          class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">{{ \App\Models\Config::STATUS_CONFIRMED_FA }}</span>
                                    @break
                                @case (\App\Models\Config::STATUS_REJECTED)
                                    <span style="background-color: rgb(253 232 232); color: rgb(155 28 28) !important;"
                                          class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">{{ \App\Models\Config::STATUS_REJECTED_FA }}</span>
                                    @break
                                @case (\App\Models\Config::STATUS_DEACTIVATE)
                                    <span style="background-color: rgb(243 244 246); color: rgb(31 41 55) !important;"
                                          class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">{{ \App\Models\Config::STATUS_DEACTIVATE_FA }}</span>
                                    @break
                                @default
                                    <span style="background-color: rgb(243 244 246); color: rgb(31 41 55) !important;"
                                          class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">ثبت نشده</span>
                                    @break
                            @endswitch
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">تصویر یا لوگو گلخانه</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($image)
                            <img src="{{ asset($image) }}"
                                 style="max-width: 20rem"
                                 alt="{{ $greenhouse->get('name') }} image"/>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">پروانه بهره برداری</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($operationLicence)
                            <img src="{{ asset($operationLicence) }}"
                                 style="max-width: 20rem"
                                 alt="{{ $greenhouse->get('name') }} operation licence"/>
                        @else
                            -
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </x-slot>
</x-modal>
