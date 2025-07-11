<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Config;
use Illuminate\Http\Response;
use Morilog\Jalali\Jalalian;

class CompanyExportService
{
    /**
     * Export companies to CSV format
     */
    public function exportToCsv($search = null): Response
    {
        $query = Company::query()->with(['province', 'city']);

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('national_id', 'like', '%' . $search . '%')
                    ->orWhere('ceo_name', 'like', '%' . $search . '%')
                    ->orWhere('interface_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Default sorting
        $query->orderBy('id', 'desc');
        $companies = $query->get();

        // Generate CSV content
        $csvContent = $this->generateCsvContent($companies);

        // Create response
        $fileName = 'companies_' . now()->format('Y_m_d_H_i_s') . '.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Export companies to Excel format (simple HTML table)
     */
    public function exportToExcel($search = null): Response
    {
        $query = Company::query()->with(['province', 'city']);

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('national_id', 'like', '%' . $search . '%')
                    ->orWhere('ceo_name', 'like', '%' . $search . '%')
                    ->orWhere('interface_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Default sorting
        $query->orderBy('id', 'desc');
        $companies = $query->get();

        // Generate Excel content (HTML table that Excel can read)
        $excelContent = $this->generateExcelContent($companies);

        // Create response
        $fileName = 'companies_' . now()->format('Y_m_d_H_i_s') . '.xls';

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
    private function generateCsvContent($companies): string
    {
        $output = fopen('php://temp', 'r+');

        // Add BOM for UTF-8 support in Excel
        fwrite($output, "\xEF\xBB\xBF");

        // Add headers
        $headers = [
            'ردیف',
            'نام شرکت',
            'نوع شرکت',
            'شناسه ملی',
            'شماره ثبت',
            'محل ثبت',
            'تاریخ ثبت',
            'نام مدیرعامل',
            'تلفن مدیرعامل',
            'کدملی مدیرعامل',
            'نام رابط',
            'تلفن رابط',
            'استان',
            'شهر',
            'آدرس',
            'کد پستی',
            'تلفن ثابت',
            'تلفن همراه',
            'وب سایت',
            'ایمیل',
            'علامت تجاری',
            'سامانه کنترل اقلیم',
            'سامانه تغذیه و آبیاری',
            'وضعیت',
            'تاریخ ایجاد'
        ];
        fputcsv($output, $headers);

        // Add data rows
        foreach ($companies as $index => $company) {
            $row = [
                $index + 1,
                $company->name,
                $company->type,
                $company->national_id,
                $company->registration_number,
                $company->registration_place,
                $company->registration_date ? Jalalian::fromDateTime($company->registration_date)->toDateString() : '-',
                $company->ceo_name,
                $company->ceo_phone,
                $company->ceo_national_id,
                $company->interface_name,
                $company->interface_phone,
                $company->province?->name ?? '-',
                $company->city?->name ?? '-',
                $company->address,
                $company->postal,
                $company->landline_number,
                $company->phone_number ?? '-',
                $company->website,
                $company->email,
                $company->brand,
                $company->climate_system ? 'دارد' : 'ندارد',
                $company->feeding_system ? 'دارد' : 'ندارد',
                $this->getStatusText($company),
                $company->created_at ? Jalalian::fromDateTime($company->created_at)->toDateString() : '-'
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
    private function generateExcelContent($companies): string
    {
        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>گزارش شرکت‌ها</title>
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
                <th style="width: 150px;">نام شرکت</th>
                <th style="width: 100px;">نوع شرکت</th>
                <th style="width: 100px;">شناسه ملی</th>
                <th style="width: 100px;">شماره ثبت</th>
                <th style="width: 100px;">محل ثبت</th>
                <th style="width: 100px;">تاریخ ثبت</th>
                <th style="width: 120px;">نام مدیرعامل</th>
                <th style="width: 120px;">تلفن مدیرعامل</th>
                <th style="width: 120px;">نام رابط</th>
                <th style="width: 120px;">تلفن رابط</th>
                <th style="width: 100px;">استان</th>
                <th style="width: 100px;">شهر</th>
                <th style="width: 200px;">آدرس</th>
                <th style="width: 100px;">کد پستی</th>
                <th style="width: 120px;">تلفن ثابت</th>
                <th style="width: 150px;">وب سایت</th>
                <th style="width: 150px;">ایمیل</th>
                <th style="width: 100px;">علامت تجاری</th>
                <th style="width: 80px;">وضعیت</th>
                <th style="width: 100px;">تاریخ ایجاد</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($companies as $index => $company) {
            $html .= '<tr>';
            $html .= '<td>' . ($index + 1) . '</td>';
            $html .= '<td>' . htmlspecialchars($company->name) . '</td>';
            $html .= '<td>' . htmlspecialchars($company->type) . '</td>';
            $html .= '<td>' . htmlspecialchars($company->national_id) . '</td>';
            $html .= '<td>' . htmlspecialchars($company->registration_number) . '</td>';
            $html .= '<td>' . htmlspecialchars($company->registration_place) . '</td>';
            $html .= '<td>' . ($company->registration_date ? Jalalian::fromDateTime($company->registration_date)->toDateString() : '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($company->ceo_name) . '</td>';
            $html .= '<td>' . htmlspecialchars($company->ceo_phone) . '</td>';
            $html .= '<td>' . htmlspecialchars($company->interface_name) . '</td>';
            $html .= '<td>' . htmlspecialchars($company->interface_phone) . '</td>';
            $html .= '<td>' . htmlspecialchars($company->province?->name ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($company->city?->name ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($company->address) . '</td>';
            $html .= '<td>' . htmlspecialchars($company->postal) . '</td>';
            $html .= '<td>' . htmlspecialchars($company->landline_number) . '</td>';
            $html .= '<td>' . htmlspecialchars($company->website) . '</td>';
            $html .= '<td>' . htmlspecialchars($company->email) . '</td>';
            $html .= '<td>' . htmlspecialchars($company->brand) . '</td>';
            $html .= '<td>' . $this->getStatusText($company) . '</td>';
            $html .= '<td>' . ($company->created_at ? Jalalian::fromDateTime($company->created_at)->toDateString() : '-') . '</td>';
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
    private function getStatusText(Company $company): string
    {
        $statusText = $company->active ? 'فعال' : 'غیرفعال';

        $statusText .= ' - ';

        $statusText .= match ($company->status) {
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
