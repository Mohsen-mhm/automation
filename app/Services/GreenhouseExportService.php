<?php

namespace App\Services;

use App\Models\Greenhouse;
use App\Models\Config;
use Illuminate\Http\Response;
use Morilog\Jalali\Jalalian;

class GreenhouseExportService
{
    /**
     * Export greenhouses to CSV format
     */
    public function exportToCsv($search = null): Response
    {
        $query = Greenhouse::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('licence_number', 'like', '%' . $search . '%')
                    ->orWhere('owner_name', 'like', '%' . $search . '%')
                    ->orWhere('owner_national_id', 'like', '%' . $search . '%');
            });
        }

        $query->orderBy('id', 'desc');
        $greenhouses = $query->get();

        // Generate CSV content
        $csvContent = $this->generateCsvContent($greenhouses);

        // Create response
        $fileName = 'greenhouses_' . now()->format('Y_m_d_H_i_s') . '.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Export greenhouses to Excel format
     */
    public function exportToExcel($search = null): Response
    {
        $query = Greenhouse::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('licence_number', 'like', '%' . $search . '%')
                    ->orWhere('owner_name', 'like', '%' . $search . '%')
                    ->orWhere('owner_national_id', 'like', '%' . $search . '%');
            });
        }

        $query->orderBy('id', 'desc');
        $greenhouses = $query->get();

        // Generate Excel content
        $excelContent = $this->generateExcelContent($greenhouses);

        // Create response
        $fileName = 'greenhouses_' . now()->format('Y_m_d_H_i_s') . '.xls';

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
    private function generateCsvContent($greenhouses): string
    {
        $output = fopen('php://temp', 'r+');

        // Add BOM for UTF-8 support in Excel
        fwrite($output, "\xEF\xBB\xBF");

        // Add headers
        $headers = [
            'ردیف',
            'نام گلخانه',
            'شماره پروانه',
            'نوع بستر',
            'نوع محصول',
            'متراژ',
            'وضعیت گلخانه',
            'تاریخ احداث',
            'تاریخ بهره برداری',
            'نام مالک',
            'تلفن مالک',
            'کد ملی مالک',
            'استان',
            'شهر',
            'آدرس',
            'کد پستی',
            'سامانه کنترل اقلیم',
            'سامانه تغذیه و آبیاری',
            'وضعیت',
            'تاریخ ایجاد'
        ];
        fputcsv($output, $headers);

        // Add data rows
        foreach ($greenhouses as $index => $greenhouse) {
            $row = [
                $index + 1,
                $greenhouse->name,
                $greenhouse->licence_number,
                $greenhouse->substrate_type,
                $greenhouse->product_type,
                $greenhouse->meterage,
                $greenhouse->greenhouse_status,
                $greenhouse->construction_date ? Jalalian::fromDateTime($greenhouse->construction_date)->toDateString() : '-',
                $greenhouse->operation_date ? Jalalian::fromDateTime($greenhouse->operation_date)->toDateString() : '-',
                $greenhouse->owner_name,
                $greenhouse->owner_phone,
                $greenhouse->owner_national_id,
                $greenhouse->province ?? '-',
                $greenhouse->city ?? '-',
                $greenhouse->address,
                $greenhouse->postal,
                $greenhouse->climate_system ? 'دارد' : 'ندارد',
                $greenhouse->feeding_system ? 'دارد' : 'ندارد',
                $this->getStatusText($greenhouse),
                $greenhouse->created_at ? Jalalian::fromDateTime($greenhouse->created_at)->toDateString() : '-'
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
    private function generateExcelContent($greenhouses): string
    {
        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>گزارش گلخانه‌ها</title>
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
                <th>نام گلخانه</th>
                <th>شماره پروانه</th>
                <th>نوع بستر</th>
                <th>نوع محصول</th>
                <th>متراژ</th>
                <th>نام مالک</th>
                <th>تلفن مالک</th>
                <th>استان</th>
                <th>شهر</th>
                <th>آدرس</th>
                <th>وضعیت</th>
                <th>تاریخ ایجاد</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($greenhouses as $index => $greenhouse) {
            $html .= '<tr>';
            $html .= '<td>' . ($index + 1) . '</td>';
            $html .= '<td>' . htmlspecialchars($greenhouse->name) . '</td>';
            $html .= '<td>' . htmlspecialchars($greenhouse->licence_number) . '</td>';
            $html .= '<td>' . htmlspecialchars($greenhouse->substrate_type) . '</td>';
            $html .= '<td>' . htmlspecialchars($greenhouse->product_type) . '</td>';
            $html .= '<td>' . htmlspecialchars($greenhouse->meterage) . '</td>';
            $html .= '<td>' . htmlspecialchars($greenhouse->owner_name) . '</td>';
            $html .= '<td>' . htmlspecialchars($greenhouse->owner_phone) . '</td>';
            $html .= '<td>' . htmlspecialchars($greenhouse->province ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($greenhouse->city ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($greenhouse->address) . '</td>';
            $html .= '<td>' . $this->getStatusText($greenhouse) . '</td>';
            $html .= '<td>' . ($greenhouse->created_at ? Jalalian::fromDateTime($greenhouse->created_at)->toDateString() : '-') . '</td>';
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
    private function getStatusText(Greenhouse $greenhouse): string
    {
        $statusText = $greenhouse->active ? 'فعال' : 'غیرفعال';

        $statusText .= ' - ';

        $statusText .= match ($greenhouse->status) {
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
