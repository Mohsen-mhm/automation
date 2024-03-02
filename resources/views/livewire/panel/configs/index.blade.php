<div class="w-full p-5">
    <div>
        <livewire:panel.configs.configs-table/>
    </div>

    @can(\App\Models\Config::CONFIG_EDIT)
        <livewire:panel.configs.edit-config/>
    @endcan
</div>
