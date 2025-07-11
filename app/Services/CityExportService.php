<?php

namespace App\Services;
use App\Models\City;
use Illuminate\Http\Response;

class CityExportService
{
    /**
     * Export cities to CSV format
     */
    public function exportToCsv($search = null, $provinceId = null, $status = null): Response
    {
        $query = City::with('province');

        // Apply filters
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('province', function ($q2) use ($search) {
                        $q2->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        if (!empty($provinceId)) {
            $query->where('province_id', $provinceId);
        }

        if ($status !== null && $status !== '') {
            $query->where('active', (bool)$status);
        }

        $query->orderBy('sort_order')->orderBy('name');
        $cities = $query->get();

        // Generate CSV content
        $csvContent = $this->generateCsvContent($cities);

        // Create response
        $fileName = 'cities_' . now()->format('Y_m_d_H_i_s') . '.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Export cities to Excel format
     */
    public function exportToExcel($search = null, $provinceId = null, $status = null): Response
    {
        $query = \App\Models\City::with('province');

        // Apply filters
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('province', function ($q2) use ($search) {
                        $q2->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        if (!empty($provinceId)) {
            $query->where('province_id', $provinceId);
        }

        if ($status !== null && $status !== '') {
            $query->where('active', (bool)$status);
        }

        $query->orderBy('sort_order')->orderBy('name');
        $cities = $query->get();

        // Generate Excel content
        $excelContent = $this->generateExcelContent($cities);

        // Create response
        $fileName = 'cities_' . now()->format('Y_m_d_H_i_s') . '.xls';

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
    private function generateCsvContent($cities): string
    {
        $output = fopen('php://temp', 'r+');

        // Add BOM for UTF-8 support in Excel
        fwrite($output, "\xEF\xBB\xBF");

        // Add headers
        $headers = [
            'ردیف',
            'نام شهر',
            'نام استان',
            'وضعیت',
            'ترتیب نمایش',
            'تاریخ ایجاد',
            'تاریخ بروزرسانی'
        ];
        fputcsv($output, $headers);

        // Add data rows
        foreach ($cities as $index => $city) {
            $row = [
                $index + 1,
                $city->name,
                $city->province->name,
                $city->active ? 'فعال' : 'غیرفعال',
                $city->sort_order,
                $city->created_at ? $city->created_at->format('Y/m/d H:i') : '-',
                $city->updated_at ? $city->updated_at->format('Y/m/d H:i') : '-'
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
    private function generateExcelContent($cities): string
    {
        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>گزارش شهرها</title>
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
        <h2>گزارش شهرهای کشور</h2>
        <p>تاریخ گزارش: ' . now()->format('Y/m/d H:i') . '</p>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width: 60px;">ردیف</th>
                <th style="width: 200px;">نام شهر</th>
                <th style="width: 150px;">نام استان</th>
                <th style="width: 80px;">وضعیت</th>
                <th style="width: 100px;">ترتیب نمایش</th>
                <th style="width: 120px;">تاریخ ایجاد</th>
                <th style="width: 120px;">تاریخ بروزرسانی</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($cities as $index => $city) {
            $html .= '<tr>';
            $html .= '<td>' . ($index + 1) . '</td>';
            $html .= '<td>' . htmlspecialchars($city->name) . '</td>';
            $html .= '<td>' . htmlspecialchars($city->province->name) . '</td>';
            $html .= '<td style="text-align: center;">' . ($city->active ? 'فعال' : 'غیرفعال') . '</td>';
            $html .= '<td style="text-align: center;">' . $city->sort_order . '</td>';
            $html .= '<td>' . ($city->created_at ? $city->created_at->format('Y/m/d H:i') : '-') . '</td>';
            $html .= '<td>' . ($city->updated_at ? $city->updated_at->format('Y/m/d H:i') : '-') . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>
    </table>
</body>
</html>';

        return $html;
    }
}
