<x-modal>
    <x-slot name="name">
        show-modal
    </x-slot>

    <x-slot name="title">
        اطلاعات شرکت
    </x-slot>

    <x-slot name="content">
        <div class="w-full overflow-y-scroll">
            <div class="overflow-hidden p-3">

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">گلخانه</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($automation)
                            <p wire:transition><a class="font-medium text-blue-600 hover:underline"
                                                  href="{{ route('panel.greenhouses', 'table-search=' . $automation->greenhouse->licence_number) }}">{{ $automation->greenhouse->name }}
                                    - {{ $automation->greenhouse->licence_number }}</a></p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">شرکت مجری کنترل اقلیم</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($automation)
                            <p wire:transition><a class="font-medium text-blue-600 hover:underline"
                                                  href="{{ route('panel.companies', 'table-search=' . $automation->climateCompany->national_id) }}">{{ $automation->climateCompany->name }}
                                    - {{ $automation->climateCompany->national_id }}</a></p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">تاریخ اجراء کنترل اقلیم</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($automation)
                            <p wire:transition>{{ \Morilog\Jalali\Jalalian::fromDateTime($automation->climate_date)->toDateString() }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">شرکت مجری تغذیه و آبیاری</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($automation)
                            <p wire:transition><a class="font-medium text-blue-600 hover:underline"
                                                  href="{{ route('panel.companies', 'table-search=' . $automation->feedingCompany->national_id) }}">{{ $automation->feedingCompany->name }}
                                    - {{ $automation->feedingCompany->national_id }}</a></p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">تاریخ اجراء تغذیه و آبیاری</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($automation)
                            <p wire:transition>{{ \Morilog\Jalali\Jalalian::fromDateTime($automation->feeding_date)->toDateString() }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">لینک API کنترل اقلیم</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($automation)
                            <p wire:transition>{{ \Illuminate\Support\Str::limit($automation->climate_api_link, 50) }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">تاریخ اتصال کنترل اقلیم</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($automation)
                            <p wire:transition>{{ \Morilog\Jalali\Jalalian::fromDateTime($automation->climate_linked_date)->toDateString() }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">لینک API تغذیه و آبیاری</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($automation)
                            <p wire:transition>{{ \Illuminate\Support\Str::limit($automation->feeding_api_link, 50) }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">تاریخ اتصال تغذیه و آبیاری</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($automation)
                            <p wire:transition>{{ \Morilog\Jalali\Jalalian::fromDateTime($automation->feeding_linked_date)->toDateString() }}</p>
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
                        @if($automation)
                            @if ($automation->active)
                                <span style="background-color: rgb(222 247 236); color: rgb(3 84 63) !important;"
                                      class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">فعال</span>
                            @else
                                <span style="background-color: rgb(253 232 232); color: rgb(155 28 28) !important;"
                                      class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">غیرفعال</span>
                            @endif
                            @switch ($automation->status)
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

            </div>
        </div>
    </x-slot>
</x-modal>
