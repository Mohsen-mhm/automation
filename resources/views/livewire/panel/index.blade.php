<div class="w-full flex flex-col justify-start items-center">
    <div class="w-full flex flex-col justify-start items-center bg-gray-100 p-4 sm:p-8 lg:flex lg:space-x-8 lg:p-12">
        @if(!auth()->user()->isActive())
            <div
                class="flex flex-col text-center items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50"
                role="alert">
                <svg class="flex-shrink-0 inline w-5 h-5 mb-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">هشدار</span>
                <div class="flex flex-col text-lg">
                    <span class="font-bold mt-2">اطلاعات شما در حال بررسی می باشد!</span>
                    <span class="mt-2">لطفا تا تایید اطلاعات توسط پشتیبانی، صبور باشید.</span>
                </div>
            </div>
        @else
            @if(auth()->user()->hasRole(\App\Models\Role::ADMIN_ROLE))
                @if(collect($companyPerProvince->toArray()['data'])->count())
                    <div class="w-full grid grid-cols-1">
                        <div class="flex flex-col justify-center items-center min-h-[30rem]">
                            <h4 class="text-2xl font-bold">شرکت ها بر حسب استان</h4>
                            <livewire:livewire-column-chart
                                :column-chart-model="$companyPerProvince"/>
                        </div>
                    </div>
                @endif
                @if(collect($greenhousePerProvince->toArray()['data'])->count())
                    <hr class="w-full border-[#026B56] my-6">
                    <div class="w-full grid grid-cols-1">
                        <div class="flex flex-col justify-center items-center min-h-[30rem]">
                            <h4 class="text-2xl font-bold">گلخانه ها بر حسب استان</h4>
                            <livewire:livewire-column-chart
                                :column-chart-model="$greenhousePerProvince"/>
                        </div>
                    </div>
                @endif

                @if(collect($usersCount->toArray()['data'])->count())
                    <hr class="w-full border-[#026B56] my-6">
                    <div class="w-full grid grid-cols-1 lg:grid-cols-2">
                        <div class="flex flex-col justify-center items-center min-h-[30rem]">
                            <h4 class="text-2xl font-bold">تعداد کاربران سامانه</h4>
                            <livewire:livewire-column-chart
                                :column-chart-model="$usersCount"/>
                        </div>
                    </div>
                @endif
                @if(collect($climateAutomationCountPerCompany->toArray()['data'])->count())
                    <hr class="w-full border-[#026B56] my-6">
                    <div class="w-full grid grid-cols-1">
                        <div class="flex flex-col justify-center items-center min-h-[30rem]">
                            <h4 class="text-2xl font-bold">گلخانه های اقلیم اجرا شده توسط هر شرکت</h4>
                            <livewire:livewire-column-chart
                                :column-chart-model="$climateAutomationCountPerCompany"/>
                        </div>
                    </div>
                @endif

                @if(collect($feedingAutomationCountPerCompany->toArray()['data'])->count())
                    <hr class="w-full border-[#026B56] my-6">
                    <div class="w-full grid grid-cols-1">
                        <div class="flex flex-col justify-center items-center min-h-[30rem]">
                            <h4 class="text-2xl font-bold">گلخانه های تغذیه اجرا شده توسط هر شرکت</h4>
                            <livewire:livewire-column-chart
                                :column-chart-model="$feedingAutomationCountPerCompany"/>
                        </div>
                    </div>
                @endif
            @endif
        @endif
        @if(auth()->user()->hasRole(\App\Models\Role::ADMIN_ROLE))
            <div class="w-full flex justify-center items-center flex-wrap -m-4 text-center">
                <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
                    <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
                        <svg class="text-green-500 w-12 h-12 mb-3 inline-block" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                  d="m3.5 5.5 7.9 6c.4.3.8.3 1.2 0l7.9-6M4 19h16c.6 0 1-.4 1-1V6c0-.6-.4-1-1-1H4a1 1 0 0 0-1 1v12c0 .6.4 1 1 1Z"/>
                        </svg>
                        <h2 class="title-font font-medium text-4xl text-gray-900">{{ $credit ?: 'خطا' }}</h2>
                        <small class="leading-relaxed">موجودی باقی مانده تعداد پیامک پنل</small>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
