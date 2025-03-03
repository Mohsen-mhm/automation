<x-modal>
    <x-slot name="name">
        show-modal
    </x-slot>

    <x-slot name="title">
        اطلاعات کاربر سازمانی
    </x-slot>

    <x-slot name="content">
        <div class="w-full overflow-y-scroll">
            <div class="overflow-hidden p-3">
                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">نام</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($organization)
                            <p wire:transition>{{ $organization->get('fname') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">نام خانوادگی</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($organization)
                            <p wire:transition>{{ $organization->get('lname') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">کدملی</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($organization)
                            <p wire:transition>{{ $organization->get('national_id') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">سازمان</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($organization)
                            <p wire:transition>{{ $organization->get('organization_name') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">سمت سازمانی</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($organization)
                            <p wire:transition>{{ $organization->get('organization_level') }}</p>
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
                        @if($organization)
                            <p wire:transition>{{ $organization->get('province') }}</p>
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
                        @if($organization)
                            <p wire:transition>{{ $organization->get('city') }}</p>
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
                        @if($organization)
                            <p wire:transition>{{ $organization->get('address') }}</p>
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
                        @if($organization)
                            <p wire:transition>{{ $organization->get('postal') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">تلفن ثابت</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($organization)
                            <p wire:transition>{{ $organization->get('landline_number') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">تلفن ثابت</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($organization)
                            <p wire:transition>{{ $organization->get('phone_number') }}</p>
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
                        @if($organization)
                            @if ($organization->get('active'))
                                <span style="background-color: rgb(222 247 236); color: rgb(3 84 63) !important;"
                                      class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">فعال</span>
                            @else
                                <span style="background-color: rgb(253 232 232); color: rgb(155 28 28) !important;"
                                      class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">غیرفعال</span>
                            @endif
                            @switch ($organization->get('status'))
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
                        <small class="font-bold">کارت ملی</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($nationalCard)
                            <img src="{{ asset($nationalCard) }}"
                                 style="max-width: 20rem"
                                 alt="{{ $organization->get('fname') }} national card"/>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">کارت پرسنلی</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($personnelCard)
                            <img src="{{ asset($personnelCard) }}"
                                 style="max-width: 20rem"
                                 alt="{{ $organization->get('fname') }} personnel card"/>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">معرفی نامه</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($introductionLetter)
                            <img src="{{ asset($introductionLetter) }}"
                                 style="max-width: 20rem"
                                 alt="{{ $organization->get('fname') }} introduction letter"/>
                        @else
                            -
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </x-slot>
</x-modal>
