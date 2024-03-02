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
            <div class="w-full grid grid-cols-1">
                <div class="flex flex-col justify-center items-center min-h-[30rem]">
                    <h4 class="text-2xl font-bold">تعداد کاربران سامانه</h4>
                    <livewire:livewire-column-chart
                        :column-chart-model="$usersCount"/>
                </div>
            </div>
        @endif
    </div>
</div>
