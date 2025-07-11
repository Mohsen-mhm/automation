<?php

namespace App\Services;

use App\Models\ContactUs;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactUsService
{
    /**
     * Get paginated contact us with search and filtering
     */
    public function getPaginatedContactUs(array $filters = []): LengthAwarePaginator
    {
        $query = ContactUs::query();

        // Apply search filter
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('email', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('subject', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('phone', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('message', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Default sorting
        $query->orderBy('id', 'desc');

        // Get pagination settings
        $perPage = $filters['per_page'] ?? 15;

        return $query->paginate($perPage);
    }

    /**
     * Get DataTables formatted data
     */
    public function getDataTablesData(array $request): array
    {
        $query = ContactUs::query();

        // Handle search
        if (!empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%')
                    ->orWhere('subject', 'like', '%' . $searchValue . '%')
                    ->orWhere('phone', 'like', '%' . $searchValue . '%')
                    ->orWhere('message', 'like', '%' . $searchValue . '%');
            });
        }

        // Default sorting by ID desc
        $query->orderBy('id', 'desc');

        $totalRecords = ContactUs::count();
        $filteredRecords = $query->count();

        // Pagination
        $start = (int)($request['start'] ?? 0);
        $length = (int)($request['length'] ?? 10);

        // Handle "show all" case
        if ($length == -1) {
            $contactUs = $query->get();
        } else {
            $contactUs = $query->skip($start)->take($length)->get();
        }

        $data = [];
        foreach ($contactUs as $index => $contact) {
            $rowIndex = $start + $index + 1;

            $data[] = [
                $rowIndex,
                $contact->name ?: '-',
                $contact->subject ?: '-',
                $contact->email ?: '-',
                $contact->phone ?: '-',
                $contact->created_at ? $contact->created_at->format('Y/m/d H:i') : '-',
                $this->generateActionButtons($contact)
            ];
        }

        return [
            'draw' => (int)($request['draw'] ?? 1),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];
    }

    /**
     * Generate action buttons for DataTables
     */
    private function generateActionButtons(ContactUs $contactUs): string
    {
        $buttons = '';

        if (\Gate::allows(ContactUs::CONTACT_US_INDEX)) {
            $buttons .= '<button class="btn-show inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200"
                               data-contact-id="' . $contactUs->id . '"
                               title="نمایش جزئیات">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                           </svg>
                           <span class="mr-1">نمایش</span>
                         </button>';
        }

        return $buttons;
    }
}
