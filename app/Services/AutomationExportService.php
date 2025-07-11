<?php

namespace App\Services;

use App\Models\Automation;
use App\Models\Config;
use Illuminate\Http\Response;
use Morilog\Jalali\Jalalian;

class AutomationExportService
{
    /**
     * Export automations to CSV format
     */
    public function exportToCsv($search = null): Response
    {
        $query = Automation::query()->with(['greenhouse', 'climateCompany', 'feedingCompany']);

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('greenhouse', function ($greenhouse) use ($search) {
                    $greenhouse->where('name', 'like', '%' . $search . '%')
                        ->orWhere('licence_number', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('climateCompany', function ($company) use ($search) {
                        $company->where('name', 'like', '%' . $search . '%')
                            ->orWhere('national_id', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('feedingCompany', function ($company) use ($search) {
                        $company->where('name', 'like', '%' . $search . '%')
                            ->orWhere('national_id', 'like', '%' . $search . '%');
                    });
            });
        }

        // Default sorting
        $query->orderBy('id', 'desc');
        $automations = $query->get();

        // Generate CSV content
        $csvContent = $this->generateCsvContent($automations);

        // Create response
        $fileName = 'automations_' . now()->format('Y_m_d_H_i_s') . '.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Export automations to Excel format (simple HTML table)
     */
    public function exportToExcel($search = null): Response
    {
        $query = Automation::query()->with(['greenhouse', 'climateCompany', 'feedingCompany']);

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('greenhouse', function ($greenhouse) use ($search) {
                    $greenhouse->where('name', 'like', '%' . $search . '%')
                        ->orWhere('licence_number', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('climateCompany', function ($company) use ($search) {
                        $company->where('name', 'like', '%' . $search . '%')
                            ->orWhere('national_id', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('feedingCompany', function ($company) use ($search) {
                        $company->where('name', 'like', '%' . $search . '%')
                            ->orWhere('national_id', 'like', '%' . $search . '%');
                    });
            });
        }

        // Default sorting
        $query->orderBy('id', 'desc');
        $automations = $query->get();

        // Generate Excel content (HTML table that Excel can read)
        $excelContent = $this->generateExcelContent($automations);

        // Create response
        $fileName = 'automations_' . now()->format('Y_m_d_H_i_s') . '.xls';

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
    private function generateCsvContent($automations): string
    {
        $output = fopen('php://temp', 'r+');

        // Add BOM for UTF-8 support in Excel
        fwrite($output, "\xEF\xBB\xBF");

        // Add headers
        $headers = [
            'ردیف',
            'گلخانه',
            'شماره پروانه گلخانه',
            'شرکت مجری کنترل اقلیم',
            'تاریخ اجرای کنترل اقلیم',
            'لینک API کنترل اقلیم',
            'تاریخ اتصال کنترل اقلیم',
            'شرکت مجری تغذیه و آبیاری',
            'تاریخ اجرای تغذیه و آبیاری',
            'لینک API تغذیه و آبیاری',
            'تاریخ اتصال تغذیه و آبیاری',
            'وضعیت',
            'تاریخ ایجاد'
        ];
        fputcsv($output, $headers);

        // Add data rows
        foreach ($automations as $index => $automation) {
            $row = [
                $index + 1,
                $automation->greenhouse?->name ?? '-',
                $automation->greenhouse?->licence_number ?? '-',
                $automation->climateCompany?->name ?? '-',
                $automation->climate_date ? Jalalian::fromDateTime($automation->climate_date)->toDateString() : '-',
                $automation->climate_api_link ?? '-',
                $automation->climate_linked_date ? Jalalian::fromDateTime($automation->climate_linked_date)->toDateString() : '-',
                $automation->feedingCompany?->name ?? '-',
                $automation->feeding_date ? Jalalian::fromDateTime($automation->feeding_date)->toDateString() : '-',
                $automation->feeding_api_link ?? '-',
                $automation->feeding_linked_date ? Jalalian::fromDateTime($automation->feeding_linked_date)->toDateString() : '-',
                $this->getStatusText($automation),
                $automation->created_at ? Jalalian::fromDateTime($automation->created_at)->toDateString() : '-'
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
    private function generateExcelContent($automations): string
    {
        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>گزارش اتوماسیون‌ها</title>
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
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>ردیف</th>
                <th>گلخانه</th>
                <th>شرکت مجری کنترل اقلیم</th>
                <th>تاریخ اجرای کنترل اقلیم</th>
                <th>شرکت مجری تغذیه و آبیاری</th>
                <th>تاریخ اجرای تغذیه و آبیاری</th>
                <th>وضعیت</th>
                <th>تاریخ ایجاد</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($automations as $index => $automation) {
            $html .= '<tr>';
            $html .= '<td>' . ($index + 1) . '</td>';
            $html .= '<td>' . htmlspecialchars($automation->greenhouse?->name ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($automation->climateCompany?->name ?? '-') . '</td>';
            $html .= '<td>' . ($automation->climate_date ? Jalalian::fromDateTime($automation->climate_date)->toDateString() : '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($automation->feedingCompany?->name ?? '-') . '</td>';
            $html .= '<td>' . ($automation->feeding_date ? Jalalian::fromDateTime($automation->feeding_date)->toDateString() : '-') . '</td>';
            $html .= '<td>' . $this->getStatusText($automation) . '</td>';
            $html .= '<td>' . ($automation->created_at ? Jalalian::fromDateTime($automation->created_at)->toDateString() : '-') . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>
    </table>
</body>
</html>';

        return $html;
    }

    /**
     * Get status text in Persian
     */
    private function getStatusText(Automation $automation): string
    {
        $statusText = $automation->active ? 'فعال' : 'غیرفعال';

        $statusText .= ' - ';

        $statusText .= match ($automation->status) {
            Config::STATUS_PENDING => Config::STATUS_PENDING_FA,
            Config::STATUS_EDITED => Config::STATUS_EDITED_FA,
            Config::STATUS_CONFIRMED => Config::STATUS_CONFIRMED_FA,
            Config::STATUS_REJECTED => Config::STATUS_REJECTED_FA,
            Config::STATUS_DEACTIVATE => Config::STATUS_DEACTIVATE_FA,
            default => 'ثبت نشده'
        };

        return $statusText;
    }
}
