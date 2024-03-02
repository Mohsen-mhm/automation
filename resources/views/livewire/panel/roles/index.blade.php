<div class="w-full p-5">
    <div>
        <livewire:panel.roles.roles-table/>
    </div>

    @can(\App\Models\Role::ROLE_ASSIGN)
        <livewire:panel.roles.assign-role/>
    @endcan
</div>
