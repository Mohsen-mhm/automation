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
                        <small class="font-bold">نام شرکت</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($company)
                            <p wire:transition>{{ $company->get('name') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">نوع شرکت</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($company)
                            <p wire:transition>{{ $company->get('type') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">شناسه ملی</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($company)
                            <p wire:transition>{{ $company->get('national_id') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">شماره ثبت</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($company)
                            <p wire:transition>{{ $company->get('registration_number') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">محل ثبت</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($company)
                            <p wire:transition>{{ $company->get('registration_place') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">تاریخ ثبت</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($company)
                            <p wire:transition>{{ \Morilog\Jalali\Jalalian::fromDateTime($company->get('registration_date'))->toDateString() }}</p>
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
                        @if($company)
                            @if($company->get('climate_system'))
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
                        @if($company)
                            @if($company->get('feeding_system'))
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
                        <small class="font-bold">نام مدیر عامل</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($company)
                            <p wire:transition>{{ $company->get('ceo_name') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">تلفن مدیر عامل</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($company)
                            <p wire:transition>{{ $company->get('ceo_phone') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">کدملی مدیر عامل</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($company)
                            <p wire:transition>{{ $company->get('ceo_national_id') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">نام رابط سامانه</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($company)
                            <p wire:transition>{{ $company->get('interface_name') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">تلفن رابط سامانه</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($company)
                            <p wire:transition>{{ $company->get('interface_phone') }}</p>
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
                        @if($company)
                            <p wire:transition>{{ $company->get('province') }}</p>
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
                        @if($company)
                            <p wire:transition>{{ $company->get('city') }}</p>
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
                        @if($company)
                            <p wire:transition>{{ $company->get('address') }}</p>
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
                        @if($company)
                            <p wire:transition>{{ $company->get('postal') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">شماره تلفن ثابت</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($company)
                            <p wire:transition>{{ $company->get('landline_number') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">شماره تلفن همراه</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($company)
                            <p wire:transition>{{ $company->get('phone_number') }}</p>
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
                        @if($company)
                            <p wire:transition>{{ $company->get('coordinates') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">وب سایت شرکت</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($company)
                            <p wire:transition>{{ $company->get('website') }}</p>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">ایمیل شرکت</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($company)
                            <p wire:transition>{{ $company->get('email') }}</p>
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
                        @if($company)
                            @if ($company->get('active'))
                                <span style="background-color: rgb(222 247 236); color: rgb(3 84 63) !important;"
                                      class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">فعال</span>
                            @else
                                <span style="background-color: rgb(253 232 232); color: rgb(155 28 28) !important;"
                                      class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">غیرفعال</span>
                            @endif
                            @switch ($company->get('status'))
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
                        <small class="font-bold">لوگو شرکت</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($companyLogo)
                            <img src="{{ asset($companyLogo) }}"
                                 style="max-width: 20rem"
                                 alt="{{ $company->get('name') }} logo"/>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">علامت تجاری</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($brandLogo)
                            <img src="{{ asset($brandLogo) }}"
                                 style="max-width: 20rem"
                                 alt="{{ $company->get('name') }} brand logo"/>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">گواهی ثبت علامت تجاری</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($trademarkCertificate)
                            <img src="{{ asset($trademarkCertificate) }}"
                                 style="max-width: 20rem"
                                 alt="{{ $company->get('name') }} trademark certificate"/>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div
                    class="grid grid-cols-2 px-4 py-5 text-center text-gray-700 border border-gray-200">
                    <div class="text-gray-800 flex justify-center items-center text-center">
                        <small class="font-bold">مجوز فناوری یا پروانه بهره برداری</small>
                    </div>
                    <div class="text-gray-700 flex justify-center items-center text-center">
                        @if($operationLicence)
                            <img src="{{ asset($operationLicence) }}"
                                 style="max-width: 20rem"
                                 alt="{{ $company->get('name') }} operation licence"/>
                        @else
                            -
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </x-slot>
</x-modal>
