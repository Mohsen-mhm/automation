<?php

namespace App\Livewire\Panel\Companies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class DeleteCompany extends Component
{
    public $company;

    protected $listeners = [
        'deleteInitialize' => 'initialization',
        'refresh' => '$refresh'
    ];

    public function initialization($id): void
    {
        $this->reset();
        $this->company = Company::query()->find($id);
    }

    public function mount(): void
    {
        if (!Gate::allows(Company::COMPANY_DELETE)) {
            abort(403);
        }
    }

    public function destroy()
    {
        DB::beginTransaction();
        try {
            $companyUser = User::query()->where('national_id', $this->company->national_id)->first();
            $companyUser->delete();
            $this->company->delete();

            DB::commit();

            toastr()->success('اطلاعات با موفقیت حذف شد.', 'موفق');
            $this->reset();
            $this->dispatch('close-delete-modal');
            $this->dispatch('refresh-table');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            return toastr()->error('خطای سرور در ارسال اطلاعات.' . "<br/>" . 'دوباره تلاش کنید.'. $e->getMessage(), 'ناموفق');
        }
    }

    public function render()
    {
        return view('livewire.panel.companies.delete-company');
    }
}
