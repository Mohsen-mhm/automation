<?php

namespace App\Services;

use App\Models\Config;
use App\Models\OrganizationUser;
use Illuminate\Http\Response;
use Morilog\Jalali\Jalalian;

class OrganizationExportService
{
    /**
     * Export organizations to CSV format
     */
    public function exportToCsv($search = null): Response
    {
        $query = OrganizationUser::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('fname', 'like', '%' . $search . '%')
                    ->orWhere('lname', 'like', '%' . $search . '%')
                    ->orWhere('national_id', 'like', '%' . $search . '%')
                    ->orWhere('organization_name', 'like', '%' . $search . '%')
                    ->orWhere('organization_level', 'like', '%' . $search . '%')
                    ->orWhere('phone_number', 'like', '%' . $search . '%');
            });
        }

        // Default sorting
        $query->orderBy('id', 'desc');
        $organizations = $query->get();

        // Generate CSV content
        $csvContent = $this->generateCsvContent($organizations);

        // Create response
        $fileName = 'organizations_' . now()->format('Y_m_d_H_i_s') . '.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Export organizations to Excel format (simple HTML table)
     */
    public function exportToExcel($search = null): Response
    {
        $query = OrganizationUser::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('fname', 'like', '%' . $search . '%')
                    ->orWhere('lname', 'like', '%' . $search . '%')
                    ->orWhere('national_id', 'like', '%' . $search . '%')
                    ->orWhere('organization_name', 'like', '%' . $search . '%')
                    ->orWhere('organization_level', 'like', '%' . $search . '%')
                    ->orWhere('phone_number', 'like', '%' . $search . '%');
            });
        }

        // Default sorting
        $query->orderBy('id', 'desc');
        $organizations = $query->get();

        // Generate Excel content (HTML table that Excel can read)
        $excelContent = $this->generateExcelContent($organizations);

        // Create response
        $fileName = 'organizations_' . now()->format('Y_m_d_H_i_s') . '.xls';

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
    private function generateCsvContent($organizations): string
    {
        $output = fopen('php://temp', 'r+');

        // Add BOM for UTF-8 support in Excel
        fwrite($output, "\xEF\xBB\xBF");

        // Add headers
        $headers = [
            'ردیف',
            'نام',
            'نام خانوادگی',
            'کد ملی',
            'نام سازمان',
            'سمت سازمانی',
            'استان',
            'شهر',
            'آدرس',
            'کد پستی',
            'تلفن ثابت',
            'تلفن همراه',
            'وضعیت',
            'تاریخ ایجاد'
        ];
        fputcsv($output, $headers);

        // Add data rows
        foreach ($organizations as $index => $organization) {
            $row = [
                $index + 1,
                $organization->fname,
                $organization->lname,
                $organization->national_id,
                $organization->organization_name,
                $organization->organization_level,
                $organization->province,
                $organization->city,
                $organization->address,
                $organization->postal,
                $organization->landline_number ?? '-',
                $organization->phone_number,
                $this->getStatusText($organization),
                $organization->created_at ? Jalalian::fromDateTime($organization->created_at)->toDateString() : '-'
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
    private function generateExcelContent($organizations): string
    {
        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>گزارش کاربران سازمانی</title>
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
                <th style="width: 50px;">ردیف</th>
                <th style="width: 100px;">نام</th>
                <th style="width: 100px;">نام خانوادگی</th>
                <th style="width: 100px;">کد ملی</th>
                <th style="width: 150px;">نام سازمان</th>
                <th style="width: 120px;">سمت سازمانی</th>
                <th style="width: 80px;">استان</th>
                <th style="width: 80px;">شهر</th>
                <th style="width: 200px;">آدرس</th>
                <th style="width: 100px;">کد پستی</th>
                <th style="width: 120px;">تلفن ثابت</th>
                <th style="width: 120px;">تلفن همراه</th>
                <th style="width: 80px;">وضعیت</th>
                <th style="width: 100px;">تاریخ ایجاد</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($organizations as $index => $organization) {
            $html .= '<tr>';
            $html .= '<td>' . ($index + 1) . '</td>';
            $html .= '<td>' . htmlspecialchars($organization->fname) . '</td>';
            $html .= '<td>' . htmlspecialchars($organization->lname) . '</td>';
            $html .= '<td>' . htmlspecialchars($organization->national_id) . '</td>';
            $html .= '<td>' . htmlspecialchars($organization->organization_name) . '</td>';
            $html .= '<td>' . htmlspecialchars($organization->organization_level) . '</td>';
            $html .= '<td>' . htmlspecialchars($organization->province) . '</td>';
            $html .= '<td>' . htmlspecialchars($organization->city) . '</td>';
            $html .= '<td>' . htmlspecialchars($organization->address) . '</td>';
            $html .= '<td>' . htmlspecialchars($organization->postal) . '</td>';
            $html .= '<td>' . htmlspecialchars($organization->landline_number ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($organization->phone_number) . '</td>';
            $html .= '<td>' . $this->getStatusText($organization) . '</td>';
            $html .= '<td>' . ($organization->created_at ? Jalalian::fromDateTime($organization->created_at)->toDateString() : '-') . '</td>';
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
    private function getStatusText(OrganizationUser $organization): string
    {
        $statusText = $organization->active ? 'فعال' : 'غیرفعال';

        $statusText .= ' - ';

        $statusText .= match ($organization->status) {
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
