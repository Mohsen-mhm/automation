<?php

namespace App\Livewire\Panel\Configs;

use App\Models\Config;
use App\Models\Filter;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public array $filters = [];

    public function mount()
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!Gate::allows(Config::CONFIG_INDEX), 403);

        $this->filters = Filter::query()->where('active', true)->pluck('uuid')->toArray();
    }

    public function updatedFilters(): void
    {
        Filter::query()->whereNotIn('uuid', $this->filters)->each(function ($filter) {
            $filter->deactivate();
        });
        Filter::query()->whereIn('uuid', $this->filters)->each(function ($filter) {
            $filter->activate();
        });

        toastr()->success('فیلتر ها با موفقیت آپدیت شدند.', 'موفق');
    }

    #[Layout('livewire.panel.layouts.app')]
    public function render()
    {
        return view('livewire.panel.configs.index');
    }
}
