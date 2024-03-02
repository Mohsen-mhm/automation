<?php

namespace App\Livewire\Panel;

use App\Models\Company;
use App\Models\Greenhouse;
use App\Models\OrganizationUser;
use App\Services\SMS\smsService;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public string|null $credit;

    public function mount()
    {
        $result = smsService::getCredit();
        $this->credit = $result ?: null;
    }

    public function usersCountChart(): ColumnChartModel
    {
        return (new ColumnChartModel())
            ->setTitle('کاربران سامانه')
            ->addColumn('کاربران سازمانی', OrganizationUser::query()->count(), '#f6ad55')
            ->addColumn('شرکت ها', Company::query()->count(), '#fc8181')
            ->addColumn('گلخانه ها', Greenhouse::query()->count(), '#90cdf4')
            ->setColumnWidth(40)
            ->setOpacity(1);
    }

    #[Layout('livewire.panel.layouts.app')]
    public function render()
    {
        return view('livewire.panel.index', [
            'usersCount' => $this->usersCountChart(),
        ]);
    }
}
