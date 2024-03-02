<div class="w-full p-5">
    <div>
        <livewire:panel.users.users-table/>
    </div>

    @can(\App\Models\User::USER_EDIT)
        <livewire:panel.users.edit-user/>
    @endcan
</div>
