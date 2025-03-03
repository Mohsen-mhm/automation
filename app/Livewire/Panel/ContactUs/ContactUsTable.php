<?php

namespace App\Livewire\Panel\ContactUs;

use Illuminate\Support\Facades\Gate;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\ContactUs;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class ContactUsTable extends DataTableComponent
{

    protected int $index = 0;

    protected $model = ContactUs::class;

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
                ->format(function ($value, $row, Column $column) {
                    return $value ?: '-';
                })
                ->searchable()
                ->sortable(),
            Column::make("عنوان", "subject")
                ->format(function ($value, $row, Column $column) {
                    return $value ?: '-';
                })
                ->searchable()
                ->sortable(),
            Column::make("ایمیل", "email")
                ->format(function ($value, $row, Column $column) {
                    return $value ?: '-';
                })
                ->sortable(),

            ButtonGroupColumn::make('عملیات')
                ->buttons($this->generateActionButtons()),
        ];
    }

    public function generateActionButtons(): array
    {
        $buttons = [];
        if (Gate::allows(ContactUs::CONTACT_US_INDEX)) {
            $buttons[] = $this->createActionButton('نمایش', 'text-yellow-700 p-1 fas fa-lg fa-circle-info', 'showInitialize', 'show-modal');
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

    public function showInitialize($id): void
    {
        $this->dispatch('showInitialize', $id);
    }
}
