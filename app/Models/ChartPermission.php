<?php
// app/Models/ChartPermission.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartPermission extends Model
{
    protected $fillable = [
        'chart_key',
        'chart_name',
        'chart_category',
        'admin_visible',
        'company_visible',
        'greenhouse_visible',
        'organization_visible',
        'sort_order'
    ];

    protected $casts = [
        'admin_visible' => 'boolean',
        'company_visible' => 'boolean',
        'greenhouse_visible' => 'boolean',
        'organization_visible' => 'boolean',
    ];

    public const PERMISSION_VIEW_CHARTS = 'view-charts';
    public const PERMISSION_MANAGE_CHART_PERMISSIONS = 'manage-chart-permissions';

    /**
     * Get visibility for a specific role
     */
    public function getVisibilityForRole(string $role): bool
    {
        return match ($role) {
            'admin' => $this->admin_visible,
            'company' => $this->company_visible,
            'greenhouse' => $this->greenhouse_visible,
            'organization' => $this->organization_visible,
            default => false
        };
    }

    /**
     * Set visibility for a specific role
     */
    public function setVisibilityForRole(string $role, bool $visible): void
    {
        $column = $role . '_visible';
        if (in_array($column, $this->fillable)) {
            $this->$column = $visible;
        }
    }

    /**
     * Get charts visible for a specific role
     */
    public static function getVisibleChartsForRole(string $role): array
    {
        $column = $role . '_visible';

        return self::where($column, true)
            ->orderBy('sort_order')
            ->pluck('chart_key')
            ->toArray();
    }

    /**
     * Get all available chart categories
     */
    public static function getCategories(): array
    {
        return [
            'general' => 'عمومی',
            'statistics' => 'آمار کلی',
            'location' => 'براساس موقعیت',
            'company' => 'شرکت‌ها',
            'greenhouse' => 'گلخانه‌ها',
            'automation' => 'اتوماسیون',
            'system' => 'سیستم'
        ];
    }
}
