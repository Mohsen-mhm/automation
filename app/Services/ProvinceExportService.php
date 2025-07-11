<?php

namespace App\Services;

use App\Models\Province;
use Illuminate\Http\Response;

class ProvinceExportService
{
    /**
     * Export provinces to CSV format
     */
    public function exportToCsv($search = null, $status = null): Response
    {
        $query = Province::withCount('cities');

        // Apply filters
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($status !== null && $status !== '') {
            $query->where('active', (bool)$status);
        }

        $query->orderBy('sort_order')->orderBy('name');
        $provinces = $query->get();

        // Generate CSV content
        $csvContent = $this->generateCsvContent($provinces);

        // Create response
        $fileName = 'provinces_' . now()->format('Y_m_d_H_i_s') . '.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Export provinces to Excel format
     */
    public function exportToExcel($search = null, $status = null): Response
    {
        $query = Province::withCount('cities');

        // Apply filters
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($status !== null && $status !== '') {
            $query->where('active', (bool)$status);
        }

        $query->orderBy('sort_order')->orderBy('name');
        $provinces = $query->get();

        // Generate Excel content
        $excelContent = $this->generateExcelContent($provinces);

        // Create response
        $fileName = 'provinces_' . now()->format('Y_m_d_H_i_s') . '.xls';

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
    private function generateCsvContent($provinces): string
    {
        $output = fopen('php://temp', 'r+');

        // Add BOM for UTF-8 support in Excel
        fwrite($output, "\xEF\xBB\xBF");

        // Add headers
        $headers = [
            'ردیف',
            'نام استان',
            'تعداد شهر',
            'وضعیت',
            'ترتیب نمایش',
            'تاریخ ایجاد',
            'تاریخ بروزرسانی'
        ];
        fputcsv($output, $headers);

        // Add data rows
        foreach ($provinces as $index => $province) {
            $row = [
                $index + 1,
                $province->name,
                $province->cities_count,
                $province->active ? 'فعال' : 'غیرفعال',
                $province->sort_order,
                $province->created_at ? $province->created_at->format('Y/m/d H:i') : '-',
                $province->updated_at ? $province->updated_at->format('Y/m/d H:i') : '-'
            ];
            fputcsv($output, $row);
        }

        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);

        return $csvContent;
    }

    /**
     * Generate Excel content
     */
    private function generateExcelContent($provinces): string
    {
        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>گزارش استان‌ها</title>
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
    </style>
</head>
<body>
    <div class="header">
        <h2>گزارش استان‌های کشور</h2>
        <p>تاریخ گزارش: ' . now()->format('Y/m/d H:i') . '</p>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width: 60px;">ردیف</th>
                <th style="width: 200px;">نام استان</th>
                <th style="width: 100px;">تعداد شهر</th>
                <th style="width: 80px;">وضعیت</th>
                <th style="width: 100px;">ترتیب نمایش</th>
                <th style="width: 120px;">تاریخ ایجاد</th>
                <th style="width: 120px;">تاریخ بروزرسانی</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($provinces as $index => $province) {
            $html .= '<tr>';
            $html .= '<td>' . ($index + 1) . '</td>';
            $html .= '<td>' . htmlspecialchars($province->name) . '</td>';
            $html .= '<td style="text-align: center;">' . $province->cities_count . '</td>';
            $html .= '<td style="text-align: center;">' . ($province->active ? 'فعال' : 'غیرفعال') . '</td>';
            $html .= '<td style="text-align: center;">' . $province->sort_order . '</td>';
            $html .= '<td>' . ($province->created_at ? $province->created_at->format('Y/m/d H:i') : '-') . '</td>';
            $html .= '<td>' . ($province->updated_at ? $province->updated_at->format('Y/m/d H:i') : '-') . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>
    </table>
</body>
</html>';

        return $html;
    }
}
