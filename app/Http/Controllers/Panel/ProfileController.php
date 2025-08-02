<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\ProfileUpdateRequest;
use App\Models\Company;
use App\Models\Greenhouse;
use App\Models\OrganizationUser;
use App\Models\Role;
use App\Models\Config;
use App\Services\CoordinateExtractionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

class ProfileController extends Controller
{
    public function __construct(
        private CoordinateExtractionService $coordinateService
    ) {}

    public function index()
    {
        abort_if(!auth()->user()->isActive(), 403);

        $user = auth()->user();
        $profileData = null;
        $profileType = null;

        if ($user->hasRole(Role::COMPANY_ROLE)) {
            $profileData = Company::where('national_id', $user->national_id)->first();
            $profileType = 'company';
        } elseif ($user->hasRole(Role::GREENHOUSE_ROLE)) {
            $profileData = Greenhouse::where('owner_national_id', $user->national_id)->first();
            $profileType = 'greenhouse';
        } elseif ($user->hasRole(Role::ORGANIZATION_ROLE)) {
            $profileData = OrganizationUser::where('national_id', $user->national_id)->first();
            $profileType = 'organization';
        }

        if (!$profileData) {
            abort(404, 'پروفایل یافت نشد');
        }

        $additionalData = $this->getAdditionalData($profileType);

        return view('panel.profile.index', compact('profileData', 'profileType', 'additionalData'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = auth()->user();

        try {
            DB::beginTransaction();

            if ($user->hasRole(Role::COMPANY_ROLE)) {
                $this->updateCompanyProfile($request);
            } elseif ($user->hasRole(Role::GREENHOUSE_ROLE)) {
                $this->updateGreenhouseProfile($request);
            } elseif ($user->hasRole(Role::ORGANIZATION_ROLE)) {
                $this->updateOrganizationProfile($request);
            }

            DB::commit();

            return redirect()->route('panel.home')
                ->with('success', 'پروفایل با موفقیت بروزرسانی شد');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Profile update error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'خطا در بروزرسانی پروفایل')
                ->withInput();
        }
    }

    public function getCoordinates(Request $request)
    {
        $request->validate([
            'url' => 'required|string|url'
        ]);

        try {
            $coordinates = $this->coordinateService->extractCoordinatesFromUrl($request->url);

            return response()->json([
                'success' => true,
                'coordinates' => $coordinates
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در دریافت مختصات: ' . $e->getMessage()
            ], 400);
        }
    }

    private function updateCompanyProfile(ProfileUpdateRequest $request)
    {
        $user = auth()->user();
        $company = Company::where('national_id', $user->national_id)->firstOrFail();

        $data = $request->validated();

        // Handle file uploads
        $data = $this->handleFileUploads($data, $request->allFiles(), $company, [
            'company_logo' => 'logos',
            'brand_logo' => 'logos',
            'trademark_certificate' => 'certificates',
            'operation_licence' => 'licences',
            'official_newspaper' => 'newspaper'
        ]);

        // Handle date conversion
        if (isset($data['registration_date'])) {
            $data['registration_date'] = Jalalian::fromFormat('Y/m/d', $data['registration_date'])
                ->toCarbon()->toDateString();
        }

        // Handle coordinates
        if (isset($data['location_link']) && $data['location_link'] !== $company->location_link) {
            $this->handleCoordinates($data);
        }

        // Set status to edited when profile is updated
        $data['status'] = Config::STATUS_EDITED;
        $data['active'] = 0;

        $company->update($data);

        // Update user info
        $user->update([
            'name' => $data['name'],
            'phone_number' => $data['interface_phone'],
            'active' => 0
        ]);
    }

    private function updateGreenhouseProfile(ProfileUpdateRequest $request)
    {
        $user = auth()->user();
        $greenhouse = Greenhouse::where('owner_national_id', $user->national_id)->firstOrFail();

        $data = $request->validated();

        // Handle file uploads
        $data = $this->handleFileUploads($data, $request->allFiles(), $greenhouse, [
            'operation_licence' => 'licences',
            'image' => 'greenhouse_images'
        ]);

        // Handle date conversions
        foreach (['construction_date', 'operation_date'] as $dateField) {
            if (isset($data[$dateField])) {
                $data[$dateField] = Jalalian::fromFormat('Y/m/d', $data[$dateField])
                    ->toCarbon()->toDateString();
            }
        }

        // Handle coordinates
        if (isset($data['location_link']) && $data['location_link'] !== $greenhouse->location_link) {
            $this->handleCoordinates($data);
        }

        // Set status to edited
        $data['status'] = Config::STATUS_EDITED;
        $data['active'] = 0;

        $greenhouse->update($data);

        // Update user info
        $user->update([
            'name' => $data['owner_name'],
            'phone_number' => $data['owner_phone'],
            'active' => 0
        ]);
    }

    private function updateOrganizationProfile(ProfileUpdateRequest $request)
    {
        $user = auth()->user();
        $organization = OrganizationUser::where('national_id', $user->national_id)->firstOrFail();

        $data = $request->validated();

        // Handle file uploads
        $data = $this->handleFileUploads($data, $request->allFiles(), $organization, [
            'national_card' => 'documents',
            'personnel_card' => 'documents',
            'introduction_letter' => 'documents'
        ]);

        // Set status to edited
        $data['status'] = Config::STATUS_EDITED;
        $data['active'] = 0;

        $organization->update($data);

        // Update user info
        $user->update([
            'name' => $data['fname'] . ' ' . $data['lname'],
            'phone_number' => $data['phone_number'],
            'active' => 0
        ]);
    }

    private function handleFileUploads(array $data, array $files, $model, array $fileFields): array
    {
        foreach ($fileFields as $field => $folder) {
            if (isset($files[$field])) {
                $file = $files[$field];
                $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $path = "storage/{$folder}/" . now()->year . '/' . now()->month . '/' . now()->day;

                try {
                    $file->storeAs($path, $fileName);
                    $data[$field] = $path . '/' . $fileName;
                } catch (\Exception $e) {
                    \Log::error("File upload error for {$field}: " . $e->getMessage());
                    unset($data[$field]);
                }
            } elseif ($model && !isset($files[$field])) {
                // Keep existing file if no new file uploaded
                unset($data[$field]);
            }
        }

        return $data;
    }

    private function handleCoordinates(array &$data): void
    {
        if (isset($data['location_link'])) {
            try {
                $coordinates = $this->coordinateService->extractCoordinatesFromUrl($data['location_link']);

                $data['coordinates'] = $coordinates['coordinates'];
                $data['latitude'] = $coordinates['latitude'];
                $data['longitude'] = $coordinates['longitude'];

            } catch (\Exception $e) {
                \Log::warning('Coordinate extraction failed for profile', [
                    'url' => $data['location_link'],
                    'error' => $e->getMessage()
                ]);

                // Keep original coordinates if extraction fails
                if (!isset($data['coordinates'])) {
                    $data['coordinates'] = null;
                    $data['latitude'] = null;
                    $data['longitude'] = null;
                }
            }
        }
    }

    private function getAdditionalData(string $profileType): array
    {
        $data = [];

        switch ($profileType) {
            case 'company':
                $data['companyTypes'] = $this->getCompanyTypes();
                $data['provinces'] = $this->getProvinces();
                $data['cities'] = collect([]);
                break;

            case 'greenhouse':
                $data['substrates'] = $this->getSubstrates();
                $data['productTypes'] = $this->getProductTypes();
                $data['greenhouseStatuses'] = $this->getGreenhouseStatuses();
                $data['provinces'] = $this->getProvinces();
                $data['cities'] = collect([]);
                break;

            case 'organization':
                $data['provinces'] = $this->getProvinces();
                $data['cities'] = collect([]);
                break;
        }

        return $data;
    }

    private function getCompanyTypes(): array
    {
        $config = Config::where('name', Config::COMPANY_TYPE)->first();
        return $config ? json_decode($config->value, true) ?? [] : [];
    }

    private function getProvinces()
    {
        return \App\Models\Province::where('active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    private function getSubstrates(): array
    {
        $config = Config::where('name', Config::SUBSTRATE)->first();
        return $config ? json_decode($config->value, true) ?? [] : [];
    }

    private function getProductTypes(): array
    {
        $config = Config::where('name', Config::PRODUCT_TYPE)->first();
        return $config ? json_decode($config->value, true) ?? [] : [];
    }

    private function getGreenhouseStatuses(): array
    {
        $config = Config::where('name', Config::GREENHOUSE_STATUS)->first();
        return $config ? json_decode($config->value, true) ?? [] : [];
    }
}
