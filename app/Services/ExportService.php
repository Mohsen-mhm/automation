<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportService
{
    /**
     * Export roles to Excel
     */
    public function exportRoles(string $format = 'excel'): StreamedResponse
    {
        $roles = Role::with('permissions')->orderBy('id', 'desc')->get();

        if ($format === 'csv') {
            return $this->exportRolesToCsv($roles);
        }

        return $this->exportRolesToExcel($roles);
    }

    /**
     * Export permissions to Excel
     */
    public function exportPermissions(string $format = 'excel'): StreamedResponse
    {
        $permissions = Permission::with('roles')->orderBy('id', 'desc')->get();

        if ($format === 'csv') {
            return $this->exportPermissionsToCsv($permissions);
        }

        return $this->exportPermissionsToExcel($permissions);
    }

    /**
     * Export roles to Excel format
     */
    private function exportRolesToExcel($roles): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('نقش‌ها');

        // Set RTL direction
        $sheet->setRightToLeft(true);

        // Headers
        $headers = ['ردیف', 'شناسه', 'عنوان نقش', 'تعداد دسترسی‌ها', 'دسترسی‌ها', 'تاریخ ایجاد'];
        $sheet->fromArray($headers, null, 'A1');

        // Style headers
        $headerRange = 'A1:F1';
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F46E5']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // Data rows
        $row = 2;
        foreach ($roles as $index => $role) {
            $permissionNames = $role->permissions->pluck('title')->implode(', ');

            $data = [
                $index + 1,
                $role->id,
                $role->title,
                $role->permissions->count(),
                $permissionNames ?: 'بدون دسترسی',
                $this->formatDate($role->created_at)
            ];

            $sheet->fromArray($data, null, 'A' . $row);

            // Alternate row colors
            if ($row % 2 == 0) {
                $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F8FAFC']]
                ]);
            }

            $row++;
        }

        // Auto-fit columns
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Add borders to all data
        $dataRange = 'A1:F' . ($row - 1);
        $sheet->getStyle($dataRange)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        // Create file
        $filename = 'roles_export_' . date('Y_m_d_H_i_s') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        // Output to browser
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    /**
     * Export permissions to Excel format
     */
    private function exportPermissionsToExcel($permissions): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('دسترسی‌ها');

        // Set RTL direction
        $sheet->setRightToLeft(true);

        // Headers
        $headers = ['ردیف', 'شناسه', 'عنوان', 'نام سیستمی', 'دسته‌بندی', 'تعداد نقش‌ها', 'نقش‌های مرتبط', 'تاریخ ایجاد'];
        $sheet->fromArray($headers, null, 'A1');

        // Style headers
        $headerRange = 'A1:H1';
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F59E0B']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // Data rows
        $row = 2;
        foreach ($permissions as $index => $permission) {
            $roleNames = $permission->roles->pluck('title')->implode(', ');
            $category = $this->getPermissionCategory($permission->name);

            $data = [
                $index + 1,
                $permission->id,
                $permission->title,
                $permission->name,
                $category['text'],
                $permission->roles->count(),
                $roleNames ?: 'بدون نقش',
                $this->formatDate($permission->created_at)
            ];

            $sheet->fromArray($data, null, 'A' . $row);

            // Alternate row colors
            if ($row % 2 == 0) {
                $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F8FAFC']]
                ]);
            }

            $row++;
        }

        // Auto-fit columns
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Add borders to all data
        $dataRange = 'A1:H' . ($row - 1);
        $sheet->getStyle($dataRange)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        // Create file
        $filename = 'permissions_export_' . date('Y_m_d_H_i_s') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        // Output to browser
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    /**
     * Export roles to CSV format
     */
    private function exportRolesToCsv($roles): StreamedResponse
    {
        $filename = 'roles_export_' . date('Y_m_d_H_i_s') . '.csv';

        return response()->streamDownload(function () use ($roles) {
            $handle = fopen('php://output', 'w');

            // Add BOM for proper UTF-8 encoding in Excel
            fwrite($handle, "\xEF\xBB\xBF");

            // Headers
            fputcsv($handle, ['ردیف', 'شناسه', 'عنوان نقش', 'تعداد دسترسی‌ها', 'دسترسی‌ها', 'تاریخ ایجاد']);

            // Data
            foreach ($roles as $index => $role) {
                $permissionNames = $role->permissions->pluck('title')->implode(', ');

                fputcsv($handle, [
                    $index + 1,
                    $role->id,
                    $role->title,
                    $role->permissions->count(),
                    $permissionNames ?: 'بدون دسترسی',
                    $this->formatDate($role->created_at)
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    /**
     * Export permissions to CSV format
     */
    private function exportPermissionsToCsv($permissions): StreamedResponse
    {
        $filename = 'permissions_export_' . date('Y_m_d_H_i_s') . '.csv';

        return response()->streamDownload(function () use ($permissions) {
            $handle = fopen('php://output', 'w');

            // Add BOM for proper UTF-8 encoding in Excel
            fwrite($handle, "\xEF\xBB\xBF");

            // Headers
            fputcsv($handle, ['ردیف', 'شناسه', 'عنوان', 'نام سیستمی', 'دسته‌بندی', 'تعداد نقش‌ها', 'نقش‌های مرتبط', 'تاریخ ایجاد']);

            // Data
            foreach ($permissions as $index => $permission) {
                $roleNames = $permission->roles->pluck('title')->implode(', ');
                $category = $this->getPermissionCategory($permission->name);

                fputcsv($handle, [
                    $index + 1,
                    $permission->id,
                    $permission->title,
                    $permission->name,
                    $category['text'],
                    $permission->roles->count(),
                    $roleNames ?: 'بدون نقش',
                    $this->formatDate($permission->created_at)
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    /**
     * Get permission category
     */
    private function getPermissionCategory(string $name): array
    {
        if (str_contains($name, 'admin') || str_contains($name, 'system')) {
            return ['text' => 'مدیریتی'];
        } elseif (str_contains($name, 'user') || str_contains($name, 'profile')) {
            return ['text' => 'کاربری'];
        } else {
            return ['text' => 'سیستمی'];
        }
    }

    /**
     * Format date for export
     */
    private function formatDate($date): string
    {
        if (!$date) return '-';

        try {
            return verta($date)->format('Y/m/d H:i');
        } catch (\Exception $e) {
            return $date->format('Y-m-d H:i');
        }
    }
}
