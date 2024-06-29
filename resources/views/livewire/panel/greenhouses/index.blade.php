<div class="w-full p-5 flex flex-col overflow-x-hidden">
    <div class="mt-6 mb-3">
        @can(\App\Models\Greenhouse::GREENHOUSE_CREATE)
            <button type="button" data-modal-target="create-modal" data-modal-toggle="create-modal"
                    class="text-white bg-green-600 hover:bg-green-500 border border-green-200 focus:ring-4 focus:outline-none focus:ring-green-100 font-medium rounded-lg text-sm px-4 py-2 text-center inline-flex items-center me-2 mb-2">
                <svg class="w-6 h-6 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 12h14m-7 7V5"/>
                </svg>
                افزودن گلخانه جدید
            </button>
        @endcan
    </div>
    <div>
        <livewire:panel.greenhouses.greenhouses-table/>
    </div>

    @can(\App\Models\Greenhouse::GREENHOUSE_CREATE)
        <livewire:panel.greenhouses.create-greenhouse/>
    @endcan
    @can(\App\Models\Greenhouse::GREENHOUSE_EDIT)
        <livewire:panel.greenhouses.edit-greenhouse/>
    @endcan
    <livewire:panel.greenhouses.show-greenhouse/>
</div>
