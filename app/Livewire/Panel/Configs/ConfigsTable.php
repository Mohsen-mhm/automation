<?php

namespace App\Livewire\Panel\Configs;

use Illuminate\Support\Facades\Gate;
use Livewire\WithoutUrlPagination;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Config;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class ConfigsTable extends DataTableComponent
{
    use WithoutUrlPagination;

    protected int $index = 0;

    protected $model = Config::class;

    protected $listeners = [
        'refresh-table' => '$refresh'
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setFiltersEnabled()
            ->setFilterLayoutSlideDown()
            ->setPerPageVisibilityStatus(false)
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
            Column::make("عنوان", "title")
                ->searchable()
                ->sortable(),
            Column::make("مقدار", "value")
                ->format(function ($value, $row, Column $column) {
                    if (Config::query()->find($row->id)->type == Config::JSON_TYPE) {
                        $jsonConfig = json_decode($value);
                        return collect($jsonConfig)->implode(" || ");
                    }

                    return $value . ' ' . 'تومان';
                })->html()
                ->sortable(),

            ButtonGroupColumn::make('عملیات')
                ->buttons($this->generateActionButtons()),
        ];
    }

    public function generateActionButtons(): array
    {
        $buttons = [];
        if (Gate::allows(Config::CONFIG_EDIT)) {
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
                return [
                    'class' => $class,
                    'style' => 'margin-right:3px; margin-left:3px',
                    'data-modal-target' => $dataModal,
                    'data-modal-toggle' => $dataModal,
                    'wire:click' => "$wireClickMethod($row->id)",
                ];
            });
    }

    public function editInitialize($id): void
    {
        $this->dispatch('editInitialize', $id);
    }
}
