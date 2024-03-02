<div class="w-full flex flex-col justify-center items-center h-fit">
    <div class="w-full flex flex-col justify-center items-center bg-gray-100 p-4 sm:p-8 lg:flex lg:space-x-8 lg:p-12">

        <div class="w-3/4 flex-col justify-center items-center">
            @if(auth()->user()->hasRole(\App\Models\Role::COMPANY_ROLE))
                <livewire:components.company-profile/>
            @elseif(auth()->user()->hasRole(\App\Models\Role::ORGANIZATION_ROLE))
                <livewire:components.organization-profile/>
            @elseif(auth()->user()->hasRole(\App\Models\Role::GREENHOUSE_ROLE))
                <livewire:components.greenhouse-profile/>
            @endif
        </div>

    </div>
</div>
