<?php

namespace App\Livewire\Panel\Configs;

use App\Models\Config;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditConfig extends Component
{
    public bool $isJsonType = false;
    public $config;

    #[Validate('required|string|min:2')]
    public string $title;
    #[Validate('required')]
    public string|Collection $value;
    #[Validate('nullable|integer')]
    public int|null $cost;
    public $valueInput;
    protected $listeners = [
        'editInitialize' => 'initialization',
        'refresh' => '$refresh'
    ];

    public function initialization($id): void
    {
        $this->reset();
        $this->config = Config::query()->find($id);

        $this->title = collect($this->config)->get('title');
        $this->value = collect($this->config)->get('type') == Config::STRING_TYPE ? collect($this->config)->get('value') : collect(json_decode(collect($this->config)->get('value')))->map(fn($item) => ['id' => Str::password(10, true, false, false, false), 'item' => $item]);
        $this->cost = collect($this->config)->get('cost');

        $this->isJsonType = collect($this->config)->get('type') == \App\Models\Config::JSON_TYPE;
    }

    public function addJsonValue(): void
    {
        $this->value = $this->value->push([
            'id' => Str::password(10, true, false, false, false),
            'item' => $this->valueInput
        ]);
        $this->dispatch('refresh');
        $this->reset('valueInput');
    }

    public function removeJsonValue($id): void
    {
        $this->value->forget($this->value->search(fn($item) => $item['id'] == $id));
        $this->dispatch('refresh');
        $this->reset('valueInput');
    }

    public function mount()
    {
        abort_if(!Gate::allows(Config::CONFIG_EDIT), 403);
    }

    public function update()
    {
        $validData = $this->validate();
        $validData['value'] = json_encode(collect($validData['value'])->map(fn($item) => $item['item']));

        $this->config->update($validData);

        $this->dispatch('refresh-table');
        $this->dispatch('close-edit-modal');
        $this->reset();
        toastr()->success('اطلاعات با موفقیت ثبت شد.', 'موفق');
    }

    public function render()
    {
        return view('livewire.panel.configs.edit-config');
    }
}
