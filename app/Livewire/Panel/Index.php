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
            ->addColumn('کاربران سازمانی', OrganizationUser::query()->count(), $this->generateRandomColor())
            ->addColumn('شرکت ها', Company::query()->count(), $this->generateRandomColor())
            ->addColumn('گلخانه ها', Greenhouse::query()->count(), $this->generateRandomColor())
            ->setColumnWidth(20)
            ->setOpacity(1);
    }

    public function companyCountPerProvince(): ColumnChartModel
    {
        $companyPerProvince = (new ColumnChartModel())
            ->setTitle('شرکت ها')
            ->setColumnWidth(20)
            ->setOpacity(1);
        $companyByProvinces = Company::query()
            ->selectRaw('province, COUNT(*) as count')
            ->groupBy('province')
            ->get();

        foreach ($companyByProvinces as $province) {
            $companyPerProvince->addColumn($province->province, $province->count, $this->generateRandomColor());
        }
        return $companyPerProvince;
    }

    public function greenhouseCountPerProvince(): ColumnChartModel
    {
        $greenhousePerProvince = (new ColumnChartModel())
            ->setTitle('گلخانه ها')
            ->setColumnWidth(20)
            ->setOpacity(1);
        $greenhouseByProvinces = Greenhouse::query()
            ->selectRaw('province, COUNT(*) as count')
            ->groupBy('province')
            ->get();

        foreach ($greenhouseByProvinces as $province) {
            $greenhousePerProvince->addColumn($province->province, $province->count, $this->generateRandomColor());
        }
        return $greenhousePerProvince;
    }

    public function climateAutomationCountPerCompany(): ColumnChartModel
    {
        $climateAutomationCountPerCompany = (new ColumnChartModel())
            ->setTitle('تعداد')
            ->setColumnWidth(20)
            ->setOpacity(1);

        foreach (Company::all() as $company) {
            if ($company->climateAutomations->count()) {
                $climateAutomationCountPerCompany->addColumn($company->name, $company->climateAutomations->count(), $this->generateRandomColor());
            }
        }
        return $climateAutomationCountPerCompany;
    }

    public function feedingAutomationCountPerCompany(): ColumnChartModel
    {
        $feedingAutomationCountPerCompany = (new ColumnChartModel())
            ->setTitle('تعداد')
            ->setColumnWidth(20)
            ->setOpacity(1);

        foreach (Company::all() as $company) {
            if ($company->feedingAutomations->count()) {
                $feedingAutomationCountPerCompany->addColumn($company->name, $company->feedingAutomations->count(), $this->generateRandomColor());
            }
        }
        return $feedingAutomationCountPerCompany;
    }

    public function generateRandomColor(): string
    {
        $red = mt_rand(60, 150);
        $green = mt_rand(60, 150);
        $blue = mt_rand(60, 150);
        return sprintf('#%02X%02X%02X', $red, $green, $blue);
    }

    #[Layout('livewire.panel.layouts.app')]
    public function render()
    {
        return view('livewire.panel.index', [
            'usersCount' => $this->usersCountChart(),
            'companyPerProvince' => $this->companyCountPerProvince(),
            'greenhousePerProvince' => $this->greenhouseCountPerProvince(),
            'climateAutomationCountPerCompany' => $this->climateAutomationCountPerCompany(),
            'feedingAutomationCountPerCompany' => $this->feedingAutomationCountPerCompany(),
        ]);
    }
}
