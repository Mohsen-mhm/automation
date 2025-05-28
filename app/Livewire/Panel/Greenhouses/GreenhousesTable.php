<?php

namespace App\Livewire\Panel\Greenhouses;

use App\Models\Company;
use App\Models\Config;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Morilog\Jalali\Jalalian;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Greenhouse;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class GreenhousesTable extends DataTableComponent
{
    public function builder(): Builder
    {
        if (auth()->user()->hasRole(Role::ADMIN_ROLE)) {
            return Greenhouse::query()->select();
        }

        $companyUser = User::query()->find(auth()->id());
        $company = Company::query()->where('national_id', $companyUser->national_id)->first();
        return Greenhouse::query()
            ->whereHas('automation', function ($query) use ($company) {
                $query->where('climate_company_id', $company->id)
                    ->orWhere('feeding_company_id', $company->id);
            })
            ->select();
    }

    protected int $index = 0;

    protected $listeners = [
        'refresh-table' => '$refresh'
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setFiltersEnabled()
            ->setFilterLayoutSlideDown()
            ->setPerPageVisibilityStatus(false)
            ->useComputedPropertiesDisabled()
            ->setThAttributes(function () {
                return [
                    'class' => 'text-right',
                ];
            })
            ->setEmptyMessage('رکوردی یافت نشد.')
            ->setSort('id', 'desc');
    }

    public function columns(): array
    {
        $this->index = $this->getPage() > 1 ? ($this->getPage() - 1) * $this->getPerPage() : 0;
        return [
            Column::make("ردیف", "id")
                ->format(fn() => ++$this->index)
                ->sortable(),
            Column::make("نام", "name")
                ->searchable()
                ->sortable(),
            Column::make("شماره پروانه", "licence_number")
                ->searchable()
                ->sortable(),
            Column::make("متراژ", "meterage")
                ->sortable(),
            Column::make("نام مالک", "owner_name")
                ->searchable()
                ->sortable(),
            Column::make("تلفن مالک", "owner_phone")
                ->sortable(),
            Column::make("کد ملی مالک", "owner_national_id")
                ->searchable()
                ->sortable(),
            Column::make("وضعیت", "active")
                ->format(function ($value, $row, Column $column) {
                    if ($value) {
                        echo '<span style="background-color: rgb(222 247 236); color: rgb(3 84 63) !important;" class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">فعال</span>&nbsp;';
                    } else {
                        echo '<span style="background-color: rgb(253 232 232); color: rgb(155 28 28) !important;" class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">غیرفعال</span>&nbsp;';
                    }
                    echo match (Greenhouse::query()->find($row->id)->status) {
                        Config::STATUS_PENDING => '<span style="background-color: rgb(253 246 178); color: rgb(114 59 19) !important;" class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">' . Config::STATUS_PENDING_FA . '</span>&nbsp;',
                        Config::STATUS_EDITED => '<span style="background-color: rgb(225 239 254); color: rgb(30 66 159) !important;" class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">' . Config::STATUS_EDITED_FA . '</span>&nbsp;',
                        Config::STATUS_CONFIRMED => '<span style="background-color: rgb(222 247 236); color: rgb(3 84 63) !important;" class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">' . Config::STATUS_CONFIRMED_FA . '</span>&nbsp;',
                        Config::STATUS_REJECTED => '<span style="background-color: rgb(253 232 232); color: rgb(155 28 28) !important;" class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">' . Config::STATUS_REJECTED_FA . '</span>&nbsp;',
                        Config::STATUS_DEACTIVATE => '<span style="background-color: rgb(243 244 246); color: rgb(31 41 55) !important;" class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">' . Config::STATUS_DEACTIVATE_FA . '</span>&nbsp;',
                        default => '<span style="background-color: rgb(243 244 246); color: rgb(31 41 55) !important;" class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">ثبت نشده</span>&nbsp;',
                    };
                })->html()
                ->sortable(),
            Column::make("تاریخ عضویت", "created_at")
                ->format(function ($value, $row, Column $column) {
                    return Jalalian::fromDateTime($value)->toDateString();
                })
                ->sortable(),

            ButtonGroupColumn::make('عملیات')
                ->buttons($this->generateActionButtons()),
        ];
    }

    public function generateActionButtons(): array
    {
        $buttons = [];
        if (Gate::allows(Greenhouse::GREENHOUSE_EDIT)) {
            $buttons[] = $this->createActionButton('محدوده ها', 'text-indigo-700 p-1 fas fa-lg fa-bell', 'alertsInitialize', '');
            $buttons[] = $this->createActionButton('ویرایش', 'text-blue-600 p-1 fas fa-lg fa-pencil', 'editInitialize', 'edit-modal');
        }
        if (Gate::allows(Greenhouse::GREENHOUSE_INDEX)) {
            $buttons[] = $this->createActionButton('نمایش', 'text-yellow-700 p-1 fas fa-lg fa-circle-info', 'showInitialize', 'show-modal');
        }
        if (Gate::allows(Greenhouse::GREENHOUSE_DELETE)) {
            $buttons[] = $this->createActionButton('حذف', 'text-red-700 p-1 fas fa-lg fa-trash', 'deleteInitialize', 'delete-modal');
        }
        return $buttons;
    }

    private function createActionButton($label, $class, $wireClickMethod, $dataModal): LinkColumn|Column
    {
        return LinkColumn::make($label)
            ->title(fn($row) => '')
            ->location(fn($row) => $wireClickMethod == "alertsInitialize" ? route('panel.alerts.admin', $row->id) : 'javascript:void(0)')
            ->attributes(function ($row) use ($label, $class, $dataModal, $wireClickMethod) {
                if ($wireClickMethod == "alertsInitialize") {
                    return [
                        'class' => $class,
                        'style' => 'margin-right:3px; margin-left:3px',
                        'title' => $label
                    ];
                }
                return [
                    'class' => $class,
                    'style' => 'margin-right:3px; margin-left:3px',
                    'data-modal-target' => $dataModal,
                    'data-modal-toggle' => $dataModal,
                    'wire:click' => "$wireClickMethod($row->id)",
                    'title' => $label
                ];
            });
    }

    public function editInitialize($id): void
    {
        $this->dispatch('editInitialize', $id);
    }

    public function showInitialize($id): void
    {
        $this->dispatch('showInitialize', $id);
    }

    public function deleteInitialize($id): void
    {
        $this->dispatch('deleteInitialize', $id);
    }
}
