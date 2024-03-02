<?php

namespace App\Livewire\Panel\Automations;

use App\Models\Automation;
use App\Models\Company;
use App\Models\Config;
use App\Models\Greenhouse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Milwad\LaravelValidate\Rules\ValidUrl;
use Morilog\Jalali\Jalalian;

class CreateAutomation extends Component
{
    use WithFileUploads;

    public array $statuses;
    public $greenhouses;
    public $climate_companies;
    public $feeding_companies;

    public string $greenhouse_id = '';
    public string $climate_company_id = '';
    public string $climate_date = '';
    public string $climate_api_link = '';
    public string $climate_linked_date = '';
    public string $feeding_company_id = '';
    public string $feeding_date = '';
    public string $feeding_api_link = '';
    public string $feeding_linked_date = '';

    public $status;

    public function mount()
    {
        $this->climate_companies = Company::query()->where('climate_system', true)->get();
        $this->feeding_companies = Company::query()->where('feeding_system', true)->get();
        $this->greenhouses = Greenhouse::all();
        $this->statuses = Config::getStatuses()->toArray();
    }

    public function rules()
    {
        return [
            'greenhouse_id' => ['required', 'exists:greenhouses,id'],
            'climate_company_id' => ['nullable', 'exists:companies,id'],
            'climate_date' => ['nullable', 'string'],
            'climate_api_link' => ['nullable', 'string', new ValidUrl(), 'unique:automations,climate_api_link'],
            'climate_linked_date' => ['nullable', 'string'],
            'feeding_company_id' => ['nullable', 'exists:companies,id'],
            'feeding_date' => ['nullable', 'string'],
            'feeding_api_link' => ['nullable', 'string', new ValidUrl(), 'unique:automations,feeding_api_link'],
            'feeding_linked_date' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'in:' . collect($this->statuses)->pluck('name')->implode(',')],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $validData = $this->validate();
        $this->assignDate();
        $validData['feeding_date'] = $this->feeding_date;
        $validData['climate_date'] = $this->climate_date;
        $validData['climate_linked_date'] = $this->climate_linked_date;
        $validData['feeding_linked_date'] = $this->feeding_linked_date;

        if ($validData['status']) {
            $validData['active'] = $validData['status'] == Config::STATUS_CONFIRMED ? 1 : 0;
        }

        DB::beginTransaction();
        try {
            Automation::create($validData);
            DB::commit();

            toastr()->success('اطلاعات با موفقیت ثبت شد', 'موفق');
            $this->reset();
            $this->mount();
            $this->dispatch('close-create-modal');
            $this->dispatch('refresh-table');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            $this->revertDate();
            return toastr()->error('خطای سرور در ارسال اطلاعات.' . "<br/>" . 'دوباره تلاش کنید.' . "<br/>" . $e->getMessage(), 'ناموفق');
        }
    }

    private function assignDate(): void
    {
        $this->climate_date = $this->climate_date ? Jalalian::fromFormat('Y/m/d', $this->climate_date)->toCarbon()->toDateString() : null;
        $this->feeding_date = $this->feeding_date ? Jalalian::fromFormat('Y/m/d', $this->feeding_date)->toCarbon()->toDateString() : null;
        $this->climate_linked_date = $this->climate_linked_date ? Jalalian::fromFormat('Y/m/d', $this->climate_linked_date)->toCarbon()->toDateString() : null;
        $this->feeding_linked_date = $this->feeding_linked_date ? Jalalian::fromFormat('Y/m/d', $this->feeding_linked_date)->toCarbon()->toDateString() : null;
    }

    private function revertDate(): void
    {
        $this->climate_date = $this->climate_date ? Jalalian::fromDateTime($this->climate_date)->toDateString() : null;
        $this->feeding_date = $this->feeding_date ? Jalalian::fromDateTime($this->feeding_date)->toDateString() : null;
        $this->climate_linked_date = $this->climate_linked_date ? Jalalian::fromDateTime($this->climate_linked_date)->toDateString() : null;
        $this->feeding_linked_date = $this->feeding_linked_date ? Jalalian::fromDateTime($this->feeding_linked_date)->toDateString() : null;
    }

    public function render()
    {
        return view('livewire.panel.automations.create-automation');
    }
}
