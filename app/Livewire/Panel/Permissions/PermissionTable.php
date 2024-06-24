<?php

namespace App\Livewire\Panel\Permissions;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Permission;

class PermissionTable extends DataTableComponent
{

    protected int $index = 0;

    protected $model = Permission::class;

    protected $listeners = [
        'refresh-table' => '$refresh'
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setFiltersEnabled()
            ->setFilterLayoutSlideDown()
            ->setPerPageVisibilityStatus(false)
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
            Column::make("عنوان", "title")
                ->searchable()
                ->sortable(),
        ];
    }
}
