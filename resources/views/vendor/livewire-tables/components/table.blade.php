@aware(['component', 'tableName'])

@php
    $customAttributes = [
        'wrapper' => $this->getTableWrapperAttributes(),
        'table' => $this->getTableAttributes(),
        'thead' => $this->getTheadAttributes(),
        'tbody' => $this->getTbodyAttributes(),
    ];
@endphp

@if ($component->isTailwind())
    <div
        wire:key="{{ $tableName }}-twrap" style="margin-top: 10px;"
        {{ $attributes->merge($customAttributes['wrapper'])
            ->class(['shadow-lg overflow-y-auto border border-gray-200 rounded-lg' => $customAttributes['wrapper']['default'] ?? true])
            ->except('default') }}
    >
        <table
            wire:key="{{ $tableName }}-table" style="min-width: 100%;"
            {{ $attributes->merge($customAttributes['table'])
                ->class(['min-w-full divide-y divide-gray-200' => $customAttributes['table']['default'] ?? true])
                ->except('default') }}
        >
            <thead wire:key="{{ $tableName }}-thead"
                {{ $attributes->merge($customAttributes['thead'])
                    ->class(['bg-gray-50' => $customAttributes['thead']['default'] ?? true])
                    ->except('default') }}
            >
                <tr>
                    {{ $thead }}
                </tr>
            </thead>

            <tbody
                wire:key="{{ $tableName }}-tbody"
                id="{{ $tableName }}-tbody"
                {{ $attributes->merge($customAttributes['tbody'])
                        ->class(['bg-white divide-y divide-gray-200' => $customAttributes['tbody']['default'] ?? true])
                        ->except('default') }}
            >
                {{ $slot }}
            </tbody>

            @if (isset($tfoot))
                <tfoot wire:key="{{ $tableName }}-tfoot">
                    {{ $tfoot }}
                </tfoot>
            @endif
        </table>
    </div>
@elseif ($component->isBootstrap())
    <div wire:key="{{ $tableName }}-twrap"
        {{ $attributes->merge($customAttributes['wrapper'])
            ->class(['table-responsive' => $customAttributes['wrapper']['default'] ?? true])
            ->except('default') }}
    >
        <table
            wire:key="{{ $tableName }}-table"
            {{ $attributes->merge($customAttributes['table'])
                ->class(['laravel-livewire-table table' => $customAttributes['table']['default'] ?? true])
                ->except('default')
            }}
        >
            <thead
                wire:key="{{ $tableName }}-thead"
                {{ $attributes->merge($customAttributes['thead'])
                    ->class(['' => $customAttributes['thead']['default'] ?? true])
                    ->except('default') }}
            >
                <tr>
                    {{ $thead }}
                </tr>
            </thead>

            <tbody
                wire:key="{{ $tableName }}-tbody"
                id="{{ $tableName }}-tbody"
                {{ $attributes->merge($customAttributes['tbody'])
                        ->class(['' => $customAttributes['tbody']['default'] ?? true])
                        ->except('default') }}
            >
                {{ $slot }}
            </tbody>

            @if (isset($tfoot))
                <tfoot wire:key="{{ $tableName }}-tfoot">
                    {{ $tfoot }}
                </tfoot>
            @endif
        </table>
    </div>
@endif
