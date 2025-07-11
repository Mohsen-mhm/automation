<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Services\ContactUsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ContactUsController extends Controller
{
    public function __construct(
        private ContactUsService $contactUsService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!Gate::allows(ContactUs::CONTACT_US_INDEX), 403);

        // For AJAX requests, return JSON
        if ($request->ajax()) {
            $contactUs = $this->contactUsService->getPaginatedContactUs([
                'search' => $request->get('search'),
                'per_page' => $request->get('per_page', 15)
            ]);

            return response()->json([
                'contactUs' => $contactUs->items(),
                'pagination' => [
                    'current_page' => $contactUs->currentPage(),
                    'last_page' => $contactUs->lastPage(),
                    'per_page' => $contactUs->perPage(),
                    'total' => $contactUs->total()
                ]
            ]);
        }

        return view('panel.contact-us.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactUs $contactUs)
    {
        abort_if(!Gate::allows(ContactUs::CONTACT_US_INDEX), 403);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('panel.contact-us.show-modal', compact('contactUs'))->render(),
                'contactUs' => $contactUs
            ]);
        }

        return view('panel.contact-us.show', compact('contactUs'));
    }

    /**
     * Get contact us data for DataTables
     */
    public function getData(Request $request)
    {
        abort_if(!Gate::allows(ContactUs::CONTACT_US_INDEX), 403);

        try {
            $data = $this->contactUsService->getDataTablesData($request->all());
            return response()->json($data);
        } catch (\Exception $e) {
            \Log::error('DataTables error: ' . $e->getMessage());

            return response()->json([
                'draw' => (int) ($request->get('draw', 1)),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'خطا در بارگذاری اطلاعات'
            ], 500);
        }
    }

    /**
     * Export contact us to Excel/CSV
     */
    public function export(Request $request)
    {
        abort_if(!Gate::allows(ContactUs::CONTACT_US_INDEX), 403);

        $search = $request->get('search');
        $format = $request->get('format', 'excel'); // excel or csv

        try {
            $exportService = new \App\Services\ContactUsExportService();

            if ($format === 'csv') {
                return $exportService->exportToCsv($search);
            }

            return $exportService->exportToExcel($search);

        } catch (\Exception $e) {
            \Log::error('Export error: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در تولید فایل'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'خطا در تولید فایل');
        }
    }
}
