<?php

namespace App\Services;

use App\Models\Config;
use Illuminate\Http\Response;

class ConfigExportService
{
    /**
     * Export configs to CSV format
     */
    public function exportToCsv($search = null): Response
    {
        $query = Config::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('value', 'like', '%' . $search . '%');
            });
        }

        // Default sorting
        $query->orderBy('id', 'desc');
        $configs = $query->get();

        // Generate CSV content
        $csvContent = $this->generateCsvContent($configs);

        // Create response
        $fileName = 'configs_' . now()->format('Y_m_d_H_i_s') . '.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Export configs to Excel format (simple HTML table)
     */
    public function exportToExcel($search = null): Response
    {
        $query = Config::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('value', 'like', '%' . $search . '%');
            });
        }

        // Default sorting
        $query->orderBy('id', 'desc');
        $configs = $query->get();

        // Generate Excel content (HTML table that Excel can read)
        $excelContent = $this->generateExcelContent($configs);

        // Create response
        $fileName = 'configs_' . now()->format('Y_m_d_H_i_s') . '.xls';

        return response($excelContent)
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Generate CSV content
     */
    private function generateCsvContent($configs): string
    {
        $output = fopen('php://temp', 'r+');

        // Add BOM for UTF-8 support in Excel
        fwrite($output, "\xEF\xBB\xBF");

        // Add headers
        $headers = [
            'ردیف',
            'عنوان',
            'نوع',
            'مقدار',
            'تاریخ ایجاد',
            'تاریخ بروزرسانی'
        ];
        fputcsv($output, $headers);

        // Add data rows
        foreach ($configs as $index => $config) {
            $row = [
                $index + 1,
                $config->title,
                $this->getConfigType($config->type),
                $this->formatConfigValue($config),
                $config->created_at ? $config->created_at->format('Y/m/d H:i') : '-',
                $config->updated_at ? $config->updated_at->format('Y/m/d H:i') : '-'
            ];
            fputcsv($output, $row);
        }

        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);

        return $csvContent;
    }

    /**
     * Generate Excel content (HTML table)
     */
    private function generateExcelContent($configs): string
    {
        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>گزارش تنظیمات سیستم</title>
    <style>
        body {
            font-family: Tahoma, Arial, sans-serif;
            direction: rtl;
            text-align: right;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: right;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 15px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th style="width: 60px;">ردیف</th>
                <th style="width: 200px;">عنوان</th>
                <th style="width: 80px;">نوع</th>
                <th style="width: 300px;">مقدار</th>
                <th style="width: 120px;">تاریخ ایجاد</th>
                <th style="width: 120px;">تاریخ بروزرسانی</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($configs as $index => $config) {
            $html .= '<tr>';
            $html .= '<td>' . ($index + 1) . '</td>';
            $html .= '<td>' . htmlspecialchars($config->title) . '</td>';
            $html .= '<td>' . $this->getConfigType($config->type) . '</td>';
            $html .= '<td>' . htmlspecialchars($this->formatConfigValue($config)) . '</td>';
            $html .= '<td>' . ($config->created_at ? $config->created_at->format('Y/m/d H:i') : '-') . '</td>';
            $html .= '<td>' . ($config->updated_at ? $config->updated_at->format('Y/m/d H:i') : '-') . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>
    </table>
</body>
</html>';

        return $html;
    }

    /**
     * Get config type in Persian
     */
    private function getConfigType($type): string
    {
        return match($type) {
            Config::JSON_TYPE => 'فهرست',
            Config::STRING_TYPE => 'متنی',
            default => 'نامشخص'
        };
    }

    /**
     * Format config value for display
     */
    private function formatConfigValue(Config $config): string
    {
        if ($config->type == Config::JSON_TYPE) {
            $jsonValues = json_decode($config->value, true);
            if (is_array($jsonValues)) {
                return implode(' | ', $jsonValues);
            }
            return $config->value;
        }

        return $config->value;
    }
}
