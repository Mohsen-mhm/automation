<?php

namespace App\Services;

use App\Models\GreenhouseAlert;
use App\Models\Greenhouse;
use Illuminate\Support\Facades\DB;

class AlertService
{
    /**
     * Update alert settings
     */
    public function updateAlert(GreenhouseAlert $alert, array $data): bool
    {
        DB::beginTransaction();

        try {
            $validData = $this->prepareAlertData($data);

            $alert->update($validData);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Alert update error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Prepare alert data for saving
     */
    private function prepareAlertData(array $data): array
    {
        $validData = [];

        // Lux settings
        if ($data['lux_active']) {
            $validData['lux_active'] = true;
            $validData['min_lux'] = $data['min_lux'];
            $validData['max_lux'] = $data['max_lux'];
        } else {
            $validData['lux_active'] = false;
            $validData['min_lux'] = null;
            $validData['max_lux'] = null;
        }

        // Temperature settings
        if ($data['temp_active']) {
            $validData['temp_active'] = true;
            $validData['min_temp'] = $data['min_temp'];
            $validData['max_temp'] = $data['max_temp'];
        } else {
            $validData['temp_active'] = false;
            $validData['min_temp'] = null;
            $validData['max_temp'] = null;
        }

        // Wind settings
        if ($data['wind_active']) {
            $validData['wind_active'] = true;
            $validData['min_wind'] = $data['min_wind'];
            $validData['max_wind'] = $data['max_wind'];
        } else {
            $validData['wind_active'] = false;
            $validData['min_wind'] = null;
            $validData['max_wind'] = null;
        }

        // Humidity settings
        if ($data['humidity_active']) {
            $validData['humidity_active'] = true;
            $validData['min_humidity'] = $data['min_humidity'];
            $validData['max_humidity'] = $data['max_humidity'];
        } else {
            $validData['humidity_active'] = false;
            $validData['min_humidity'] = null;
            $validData['max_humidity'] = null;
        }

        return $validData;
    }

    /**
     * Get alert statistics for dashboard
     */
    public function getStatistics(): array
    {
        $total = GreenhouseAlert::count();
        $activeAlerts = GreenhouseAlert::where(function ($query) {
            $query->where('lux_active', true)
                ->orWhere('temp_active', true)
                ->orWhere('wind_active', true)
                ->orWhere('humidity_active', true);
        })->count();

        $luxAlerts = GreenhouseAlert::where('lux_active', true)->count();
        $tempAlerts = GreenhouseAlert::where('temp_active', true)->count();
        $windAlerts = GreenhouseAlert::where('wind_active', true)->count();
        $humidityAlerts = GreenhouseAlert::where('humidity_active', true)->count();

        // Most common alert ranges
        $commonRanges = [
            'lux' => $this->getCommonRange('lux'),
            'temp' => $this->getCommonRange('temp'),
            'wind' => $this->getCommonRange('wind'),
            'humidity' => $this->getCommonRange('humidity'),
        ];

        return [
            'total' => $total,
            'active_alerts' => $activeAlerts,
            'inactive_alerts' => $total - $activeAlerts,
            'by_type' => [
                'lux' => $luxAlerts,
                'temperature' => $tempAlerts,
                'wind' => $windAlerts,
                'humidity' => $humidityAlerts,
            ],
            'common_ranges' => $commonRanges,
        ];
    }

    /**
     * Get common alert ranges for a specific type
     */
    private function getCommonRange(string $type): array
    {
        $activeColumn = "{$type}_active";
        $minColumn = "min_{$type}";
        $maxColumn = "max_{$type}";

        $result = GreenhouseAlert::where($activeColumn, true)
            ->selectRaw("AVG({$minColumn}) as avg_min, AVG({$maxColumn}) as avg_max")
            ->first();

        return [
            'avg_min' => $result ? round($result->avg_min, 1) : null,
            'avg_max' => $result ? round($result->avg_max, 1) : null,
        ];
    }

    /**
     * Get alert settings by greenhouse ID
     */
    public function getAlertByGreenhouseId(int $greenhouseId): ?GreenhouseAlert
    {
        $greenhouse = Greenhouse::find($greenhouseId);
        return $greenhouse ? $greenhouse->alert : null;
    }

    /**
     * Check if alert settings are configured
     */
    public function hasConfiguredAlerts(GreenhouseAlert $alert): bool
    {
        return $alert->lux_active ||
            $alert->temp_active ||
            $alert->wind_active ||
            $alert->humidity_active;
    }

    /**
     * Get alert configuration summary
     */
    public function getAlertSummary(GreenhouseAlert $alert): array
    {
        $summary = [];

        if ($alert->lux_active) {
            $summary['lux'] = [
                'min' => $alert->min_lux,
                'max' => $alert->max_lux,
                'unit' => 'لوکس'
            ];
        }

        if ($alert->temp_active) {
            $summary['temperature'] = [
                'min' => $alert->min_temp,
                'max' => $alert->max_temp,
                'unit' => '°C'
            ];
        }

        if ($alert->wind_active) {
            $summary['wind'] = [
                'min' => $alert->min_wind,
                'max' => $alert->max_wind,
                'unit' => 'km/h'
            ];
        }

        if ($alert->humidity_active) {
            $summary['humidity'] = [
                'min' => $alert->min_humidity,
                'max' => $alert->max_humidity,
                'unit' => '%'
            ];
        }

        return $summary;
    }
}
