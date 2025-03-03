<?php

namespace App\Livewire\Panel\Users;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Morilog\Jalali\Jalalian;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class UsersTable extends DataTableComponent
{

    protected int $index = 0;
    protected $model = User::class;

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
            ->setEmptyMessage('رکوردی یافت نشد.')
            ->setThAttributes(function () {
                return [
                    'class' => 'text-right',
                ];
            })
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
            Column::make("کد ملی/شناسه ملی", "national_id")
                ->searchable()
                ->sortable(),
            Column::make("شماره تلفن همراه", "phone_number")
                ->searchable()
                ->sortable(),
            Column::make("وضعیت", "active")
                ->format(function ($value, $row, Column $column) {
                    if ($value) {
                        return '<span style="background-color: rgb(222 247 236); color: rgb(3 84 63) !important;" class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">فعال</span>';
                    }
                    return '<span style="background-color: rgb(253 232 232); color: rgb(155 28 28) !important;" class="text-sm font-medium me-2 px-2.5 py-0.5 rounded">غیرفعال</span>';
                })->html()
                ->sortable(),
            Column::make('نقش')
                ->label(function ($row, Column $column) {
                    return collect($row->roles)->pluck('title')->implode('<br/>');
                })->html(),

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
        if (Gate::allows(User::USER_EDIT)) {
            $buttons[] = $this->createActionButton('Edit', 'text-blue-600 p-1 fas fa-lg fa-pencil', 'editInitialize', 'edit-modal');
        }
        return $buttons;
    }

    private function createActionButton($label, $class, $wireClickMethod, $dataModal): LinkColumn|Column
    {
        return LinkColumn::make($label)
            ->title(fn($row) => '')
            ->location(fn($row) => 'javascript:void(0)')
            ->attributes(function ($row) use ($label, $class, $dataModal, $wireClickMethod) {
                if (User::query()->find($row->id)->hasRole(Role::ADMIN_ROLE)) {
                    return [
                        'class' => $class,
                        'style' => 'margin-right:3px; margin-left:3px',
                        'data-modal-target' => $dataModal,
                        'data-modal-toggle' => $dataModal,
                        'wire:click' => "$wireClickMethod($row->id)",
                        'title' => $label
                    ];
                }
                return [];
            });
    }

    public function editInitialize($id): void
    {
        $this->dispatch('editInitialize', $id);
    }
}
