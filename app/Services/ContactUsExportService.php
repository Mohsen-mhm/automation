<?php

namespace App\Services;

use App\Models\ContactUs;
use Illuminate\Http\Response;

class ContactUsExportService
{
    /**
     * Export contact us to CSV format
     */
    public function exportToCsv($search = null): Response
    {
        $query = ContactUs::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('subject', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('message', 'like', '%' . $search . '%');
            });
        }

        // Default sorting
        $query->orderBy('id', 'desc');
        $contactUs = $query->get();

        // Generate CSV content
        $csvContent = $this->generateCsvContent($contactUs);

        // Create response
        $fileName = 'contact_us_' . now()->format('Y_m_d_H_i_s') . '.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Export contact us to Excel format (simple HTML table)
     */
    public function exportToExcel($search = null): Response
    {
        $query = ContactUs::query();

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('subject', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('message', 'like', '%' . $search . '%');
            });
        }

        // Default sorting
        $query->orderBy('id', 'desc');
        $contactUs = $query->get();

        // Generate Excel content (HTML table that Excel can read)
        $excelContent = $this->generateExcelContent($contactUs);

        // Create response
        $fileName = 'contact_us_' . now()->format('Y_m_d_H_i_s') . '.xls';

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
    private function generateCsvContent($contactUs): string
    {
        $output = fopen('php://temp', 'r+');

        // Add BOM for UTF-8 support in Excel
        fwrite($output, "\xEF\xBB\xBF");

        // Add headers
        $headers = [
            'ردیف',
            'نام',
            'ایمیل',
            'شماره تلفن',
            'موضوع',
            'پیام',
            'تاریخ ثبت'
        ];
        fputcsv($output, $headers);

        // Add data rows
        foreach ($contactUs as $index => $contact) {
            $row = [
                $index + 1,
                $contact->name ?: '-',
                $contact->email ?: '-',
                $contact->phone ?: '-',
                $contact->subject ?: '-',
                $contact->message ?: '-',
                $contact->created_at ? $contact->created_at->format('Y/m/d H:i') : '-'
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
    private function generateExcelContent($contactUs): string
    {
        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>گزارش پیام‌های تماس با ما</title>
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
                <th style="width: 150px;">نام</th>
                <th style="width: 200px;">ایمیل</th>
                <th style="width: 120px;">شماره تلفن</th>
                <th style="width: 200px;">موضوع</th>
                <th style="width: 400px;">پیام</th>
                <th style="width: 120px;">تاریخ ثبت</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($contactUs as $index => $contact) {
            $html .= '<tr>';
            $html .= '<td>' . ($index + 1) . '</td>';
            $html .= '<td>' . htmlspecialchars($contact->name ?: '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($contact->email ?: '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($contact->phone ?: '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($contact->subject ?: '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($contact->message ?: '-') . '</td>';
            $html .= '<td>' . ($contact->created_at ? $contact->created_at->format('Y/m/d H:i') : '-') . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>
    </table>
</body>
</html>';

        return $html;
    }
}
