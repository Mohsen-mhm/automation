<?php

namespace App\Livewire\Panel\Organizations;

use App\Models\Company;
use App\Models\Greenhouse;
use App\Models\GreenhouseAlert;
use App\Models\OrganizationUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class DeleteOrganization extends Component
{
    public $organization;

    protected $listeners = [
        'deleteInitialize' => 'initialization',
        'refresh' => '$refresh'
    ];

    public function initialization($id): void
    {
        $this->reset();
        $this->organization = OrganizationUser::query()->find($id);
    }

    public function mount(): void
    {
        if (!Gate::allows(OrganizationUser::ORGAN_DELETE)) {
            abort(403);
        }
    }

    public function destroy()
    {
        DB::beginTransaction();
        try {
            $organizationUser = User::query()->where('national_id', $this->organization->national_id)->first();
            $organizationUser->delete();
            $this->organization->delete();

            DB::commit();

            toastr()->success('اطلاعات با موفقیت حذف شد.', 'موفق');
            $this->reset();
            $this->dispatch('close-delete-modal');
            $this->dispatch('refresh-table');
            return redirect()->back();
        } catch (\Exception) {
            DB::rollback();
            return toastr()->error('خطای سرور در ارسال اطلاعات.' . "<br/>" . 'دوباره تلاش کنید.', 'ناموفق');
        }
    }

    public function render()
    {
        return view('livewire.panel.organizations.delete-organization');
    }
}
