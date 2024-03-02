<div class="w-full p-5 flex flex-col">
    <div class="mt-6 mb-3">
        @can(\App\Models\Automation::AUTOMATION_CREATE)
            <button type="button" data-modal-target="create-modal" data-modal-toggle="create-modal"
                    class="text-white bg-green-600 hover:bg-green-500 border border-green-200 focus:ring-4 focus:outline-none focus:ring-green-100 font-medium rounded-lg text-sm px-4 py-2 text-center inline-flex items-center me-2 mb-2">
                <svg class="w-6 h-6 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 12h14m-7 7V5"/>
                </svg>
                افزودن اتوماسیون جدید
            </button>
        @endcan
    </div>
    <div>
        <livewire:panel.automations.automations-table/>
    </div>

    @can(\App\Models\Automation::AUTOMATION_CREATE)
        <livewire:panel.automations.create-automation/>
    @endcan
    @can(\App\Models\Automation::AUTOMATION_EDIT)
        <livewire:panel.automations.edit-automation/>
    @endcan
    <livewire:panel.automations.show-automation/>
</div>
