<?php

namespace App\Livewire\Panel\Automations;

use App\Models\Automation;
use App\Models\Company;
use App\Models\Config;
use App\Models\Greenhouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Milwad\LaravelValidate\Rules\ValidUrl;
use Morilog\Jalali\Jalalian;

class EditAutomation extends Component
{
    use WithFileUploads;

    public $automation;

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

    protected $listeners = [
        'editInitialize' => 'initialization',
        'refresh' => '$refresh'
    ];

    public function mount()
    {
        $this->climate_companies = Company::query()->where('climate_system', true)->get();
        $this->feeding_companies = Company::query()->where('feeding_system', true)->get();
        $this->greenhouses = Greenhouse::all();
        $this->statuses = Config::getStatuses()->toArray();
    }

    public function initialization($id): void
    {
        $this->reset();
        $this->mount();

        $this->automation = Automation::query()->find($id);

        $this->greenhouse_id = collect($this->automation)->get('greenhouse_id');
        $this->climate_company_id = collect($this->automation)->get('climate_company_id');
        $this->climate_date = Jalalian::fromDateTime(collect($this->automation)->get('climate_date'))->toDateString();
        $this->climate_api_link = collect($this->automation)->get('climate_api_link');
        $this->climate_linked_date = Jalalian::fromDateTime(collect($this->automation)->get('climate_linked_date'))->toDateString();
        $this->feeding_company_id = collect($this->automation)->get('feeding_company_id');
        $this->feeding_date = Jalalian::fromDateTime(collect($this->automation)->get('feeding_date'))->toDateString();
        $this->feeding_api_link = collect($this->automation)->get('feeding_api_link');
        $this->feeding_linked_date = Jalalian::fromDateTime(collect($this->automation)->get('feeding_linked_date'))->toDateString();
        $this->status = collect($this->automation)->get('status');
    }

    public function rules()
    {
        return [
            'greenhouse_id' => ['required', 'exists:greenhouses,id'],
            'climate_company_id' => ['nullable', 'exists:companies,id'],
            'climate_date' => ['nullable', 'string'],
            'climate_api_link' => ['nullable', 'string', new ValidUrl(), Rule::unique('automations', 'climate_api_link')->ignore(collect($this->automation)->get('id'))],
            'climate_linked_date' => ['nullable', 'string'],
            'feeding_company_id' => ['nullable', 'exists:companies,id'],
            'feeding_date' => ['nullable', 'string'],
            'feeding_api_link' => ['nullable', 'string', new ValidUrl(), Rule::unique('automations', 'feeding_api_link')->ignore(collect($this->automation)->get('id'))],
            'feeding_linked_date' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        $validData = $this->validate();
        $this->assignDate();
        $validData['feeding_date'] = $this->feeding_date;
        $validData['climate_date'] = $this->climate_date;
        $validData['climate_linked_date'] = $this->climate_linked_date;
        $validData['feeding_linked_date'] = $this->feeding_linked_date;

        if ($validData['status']) {
            $validData['active'] = $validData['status'] == Config::STATUS_CONFIRMED ? 1 : 0;
        } else {
            $validData['status'] = Config::STATUS_EDITED;
            $validData['active'] = 0;
        }

        DB::beginTransaction();
        try {
            Automation::create($validData);
            DB::commit();

            toastr()->success('اطلاعات با موفقیت ثبت شد', 'موفق');
            $this->reset();
            $this->mount();
            $this->dispatch('close-edit-modal');
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
        return view('livewire.panel.automations.edit-automation');
    }
}
