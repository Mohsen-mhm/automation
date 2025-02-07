<div class="w-full p-5 overflow-x-hidden">
    <div>
        <livewire:panel.configs.configs-table/>
    </div>

    @can(\App\Models\Config::CONFIG_EDIT)
        <livewire:panel.configs.edit-config/>
    @endcan

    @can(\App\Models\Filter::FILTER_ACTIVE)
        <div class="flex flex-col items-center justify-center mb-4 mt-8">
            <h3 class="mb-5 text-xl md:text-2xl font-extrabold text-gray-900 mt-5">تنظیمات فیلترها</h3>
            <ul class="grid w-full gap-6 lg:grid-cols-5">
                @foreach(\App\Models\Filter::query()->orderBy('id')->get() as $filter)
                    <li>
                        <input type="checkbox" id="{{ $filter->name }}" wire:model.live="filters"
                               value="{{ $filter->uuid }}"
                               class="hidden peer">
                        <label for="{{ $filter->name }}"
                               class="flex flex-col justify-center items-center w-full p-5 text-gray-500 min-h-[11rem] bg-white border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-green-600 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-100">
                            <div class="flex flex-col justify-center items-center">
                                @if($filter->active)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="w-14 h-14 mb-3 text-green-600">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M8.56 3.69a9 9 0 0 0 -2.92 1.95"/>
                                        <path d="M3.69 8.56a9 9 0 0 0 -.69 3.44"/>
                                        <path d="M3.69 15.44a9 9 0 0 0 1.95 2.92"/>
                                        <path d="M8.56 20.31a9 9 0 0 0 3.44 .69"/>
                                        <path d="M15.44 20.31a9 9 0 0 0 2.92 -1.95"/>
                                        <path d="M20.31 15.44a9 9 0 0 0 .69 -3.44"/>
                                        <path d="M20.31 8.56a9 9 0 0 0 -1.95 -2.92"/>
                                        <path d="M15.44 3.69a9 9 0 0 0 -3.44 -.69"/>
                                        <path d="M9 12l2 2l4 -4"/>
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="w-14 h-14 mb-3 text-red-600">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M8.56 3.69a9 9 0 0 0 -2.92 1.95"/>
                                        <path d="M3.69 8.56a9 9 0 0 0 -.69 3.44"/>
                                        <path d="M3.69 15.44a9 9 0 0 0 1.95 2.92"/>
                                        <path d="M8.56 20.31a9 9 0 0 0 3.44 .69"/>
                                        <path d="M15.44 20.31a9 9 0 0 0 2.92 -1.95"/>
                                        <path d="M20.31 15.44a9 9 0 0 0 .69 -3.44"/>
                                        <path d="M20.31 8.56a9 9 0 0 0 -1.95 -2.92"/>
                                        <path d="M15.44 3.69a9 9 0 0 0 -3.44 -.69"/>
                                        <path d="M14 14l-4 -4"/>
                                        <path d="M10 14l4 -4"/>
                                    </svg>
                                @endif
                                <div class="w-full text-lg font-semibold text-center">
                                    فیلتر
                                    {{ $filter->title }}
                                    @if($filter->isCompanyFilter())
                                        شرکت
                                    @else
                                        گلخانه
                                    @endif
                                </div>
                            </div>
                        </label>
                    </li>
                @endforeach
            </ul>
        </div>
    @endcan
</div>
