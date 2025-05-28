<?php

namespace App\Livewire\Panel\Greenhouses;

use App\Models\Company;
use App\Models\Greenhouse;
use App\Models\GreenhouseAlert;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class DeleteGreenhouse extends Component
{
    public $greenhouse;

    protected $listeners = [
        'deleteInitialize' => 'initialization',
        'refresh' => '$refresh'
    ];

    public function initialization($id): void
    {
        $this->reset();
        $this->greenhouse = Greenhouse::query()->find($id);
    }

    public function mount(): void
    {
        if (!Gate::allows(Greenhouse::GREENHOUSE_DELETE)) {
            abort(403);
        }
    }

    public function destroy()
    {
        DB::beginTransaction();
        try {
            $greenhouseUser = User::query()->where('national_id', $this->greenhouse->owner_national_id)->first();
            $greenhouseAlert = GreenhouseAlert::query()->where('greenhouse_id', $this->greenhouse->id)->first();
            $greenhouseUser->delete();
            $greenhouseAlert->delete();
            $this->greenhouse->delete();

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
        return view('livewire.panel.greenhouses.delete-greenhouse');
    }
}
