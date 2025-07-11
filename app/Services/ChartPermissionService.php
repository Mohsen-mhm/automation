<?php

namespace App\Services;

use App\Models\ChartPermission;
use App\Models\Role;
use Illuminate\Support\Collection;

class ChartPermissionService
{
    /**
     * Get visible charts for current user's role
     */
    public function getVisibleChartsForUser(): array
    {
        $user = auth()->user();

        if (!$user) {
            return [];
        }

        // Admin always sees all charts
        if ($user->hasRole(Role::ADMIN_ROLE)) {
            return ChartPermission::orderBy('sort_order')->pluck('chart_key')->toArray();
        }

        // Get user's primary role
        $userRole = $this->getUserPrimaryRole($user);

        return ChartPermission::getVisibleChartsForRole($userRole);
    }

    /**
     * Check if a specific chart is visible for current user
     */
    public function isChartVisible(string $chartKey): bool
    {
        $visibleCharts = $this->getVisibleChartsForUser();
        return in_array($chartKey, $visibleCharts);
    }

    /**
     * Get all chart permissions grouped by category
     */
    public function getChartPermissionsGrouped(): Collection
    {
        return ChartPermission::orderBy('chart_category')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('chart_category');
    }

    /**
     * Update chart permission for a specific role
     */
    public function updateChartPermission(string $chartKey, string $role, bool $visible): bool
    {
        $permission = ChartPermission::where('chart_key', $chartKey)->first();

        if (!$permission) {
            return false;
        }

        $permission->setVisibilityForRole($role, $visible);
        return $permission->save();
    }

    /**
     * Bulk update chart permissions
     */
    public function bulkUpdatePermissions(array $permissions): bool
    {
        try {
            foreach ($permissions as $chartKey => $roles) {
                $permission = ChartPermission::where('chart_key', $chartKey)->first();
                if ($permission) {
                    foreach ($roles as $role => $visible) {
                        $permission->setVisibilityForRole($role, $visible);
                    }
                    $permission->save();
                }
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get user's primary role for chart permissions
     */
    private function getUserPrimaryRole($user): string
    {
        if ($user->hasRole(Role::COMPANY_ROLE)) {
            return 'company';
        }

        if ($user->hasRole(Role::GREENHOUSE_ROLE)) {
            return 'greenhouse';
        }

        if ($user->hasRole(Role::ORGANIZATION_ROLE)) {
            return 'organization';
        }

        return 'organization'; // Default fallback
    }

    /**
     * Get role-specific statistics for dashboard
     */
    public function getRoleSpecificStats(string $role): array
    {
        $user = auth()->user();

        return match($role) {
            'company' => $this->getCompanyStats($user),
            'greenhouse' => $this->getGreenhouseStats($user),
            'organization' => $this->getOrganizationStats($user),
            default => []
        };
    }

    private function getCompanyStats($user): array
    {
        // Implementation for company-specific stats
        return [];
    }

    private function getGreenhouseStats($user): array
    {
        // Implementation for greenhouse-specific stats
        return [];
    }

    private function getOrganizationStats($user): array
    {
        // Implementation for organization-specific stats
        return [];
    }
}
