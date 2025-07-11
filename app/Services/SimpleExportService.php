<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;
use Morilog\Jalali\Jalalian;

class SimpleExportService
{
    /**
     * Get users for export with filters
     */
    public function getUsersForExport(array $filters = []): Collection
    {
        $query = User::with('roles');

        // Apply search filter
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('national_id', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('phone_number', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Apply status filter
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('active', (bool) $filters['status']);
        }

        // Apply role filter
        if (!empty($filters['role'])) {
            $query->whereHas('roles', function ($q) use ($filters) {
                $q->where('name', $filters['role']);
            });
        }

        return $query->orderBy('id', 'desc')->get();
    }

    /**
     * Create CSV content for Excel
     */
    public function createExcelCsvContent(Collection $users): string
    {
        $output = fopen('php://temp', 'r+');

        // Add BOM for UTF-8 (helps Excel recognize Persian text)
        fwrite($output, "\xEF\xBB\xBF");

        // Headers
        $headers = [
            'ردیف',
            'نام',
            'کد ملی',
            'شماره تلفن',
            'وضعیت',
            'نقش‌ها',
            'تاریخ عضویت'
        ];
        fputcsv($output, $headers);

        // Data rows
        foreach ($users as $index => $user) {
            $row = [
                $index + 1,
                $user->name,
                $user->national_id,
                $user->phone_number,
                $user->active ? 'فعال' : 'غیرفعال',
                $user->roles->pluck('title')->implode(' | '),
                Jalalian::fromDateTime($user->created_at)->toDateString()
            ];
            fputcsv($output, $row);
        }

        rewind($output);
        $content = stream_get_contents($output);
        fclose($output);

        return $content;
    }

    /**
     * Create HTML table for Excel
     */
    public function createExcelHtmlContent(Collection $users): string
    {
        $html = '<!DOCTYPE html>';
        $html .= '<html><head><meta charset="utf-8"><title>Users Export</title></head><body>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; font-family: Arial, sans-serif;">';

        // Header row
        $html .= '<tr style="background-color: #f0f0f0; font-weight: bold;">';
        $html .= '<td>ردیف</td>';
        $html .= '<td>نام</td>';
        $html .= '<td>کد ملی</td>';
        $html .= '<td>شماره تلفن</td>';
        $html .= '<td>وضعیت</td>';
        $html .= '<td>نقش‌ها</td>';
        $html .= '<td>تاریخ عضویت</td>';
        $html .= '</tr>';

        // Data rows
        foreach ($users as $index => $user) {
            $html .= '<tr>';
            $html .= '<td>' . ($index + 1) . '</td>';
            $html .= '<td>' . htmlspecialchars($user->name) . '</td>';
            $html .= '<td>' . htmlspecialchars($user->national_id) . '</td>';
            $html .= '<td>' . htmlspecialchars($user->phone_number) . '</td>';
            $html .= '<td>' . ($user->active ? 'فعال' : 'غیرفعال') . '</td>';
            $html .= '<td>' . htmlspecialchars($user->roles->pluck('title')->implode(' | ')) . '</td>';
            $html .= '<td>' . Jalalian::fromDateTime($user->created_at)->toDateString() . '</td>';
            $html .= '</tr>';
        }

        $html .= '</table></body></html>';

        return $html;
    }

    /**
     * Generate export filename
     */
    public function generateFilename(string $format = 'csv'): string
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        return "users_export_{$timestamp}.{$format}";
    }
}
