<?php

namespace App\Livewire\Panel\Roles;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class AssignRole extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $role;
    public array $rolePermissions = [];
    public int $permissionPage = 1;

    protected $queryString = [
        'permissionPage' => ['except' => 1],
    ];

    protected $listeners = [
        'assignInitialize' => 'initialization',
        'refreshComponent' => '$refresh'
    ];

    public function mount()
    {
        if (!Gate::allows(Permission::PERMISSION_ASSIGN)) {
            abort(403);
        }
    }

    public function initialization($id): void
    {
        $this->reset();
        $this->role = Role::query()->findOrFail($id);
        $this->rolePermissions = $this->role->permissions->pluck('id')->toArray();
    }

    public function updated()
    {
        if (!Gate::allows(Permission::PERMISSION_ASSIGN)) {
            abort(403);
        }
        try {
            $this->role->permissions()->sync($this->rolePermissions);

            toastr()->success('با موفقیت انجام شد.');
        } catch (\Exception) {
            toastr()->error('ناموفق بود.');
        }
    }

    public function render()
    {
        return view('livewire.panel.roles.assign-role', [
            'permissions' => Permission::query()->orderBy('id', 'desc')->paginate(10, ['*'], 'permissionPage'),
        ]);
    }
}
