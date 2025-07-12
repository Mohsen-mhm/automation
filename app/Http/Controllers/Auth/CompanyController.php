<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CompanyLoginRequest;
use App\Http\Requests\Auth\CompanyRegisterRequest;
use App\Models\Company;
use App\Models\Config;
use App\Models\Role;
use App\Models\User;
use App\Models\Province;
use App\Models\City;
use App\Services\SMS\smsService;
use App\Services\CoordinateExtractionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

class CompanyController extends Controller
{
    public function __construct(
        private CoordinateExtractionService $coordinateService
    )
    {
    }

    /**
     * Show company login form
     */
    public function showLogin()
    {
        return view('auth.company.login');
    }

    /**
     * Handle company login
     */
    public function login(CompanyLoginRequest $request)
    {
        try {
            $company = Company::where([
                'national_id' => $request->national_id,
                'interface_phone' => $request->phone_number,
            ])->first();

            if (!$company || !$company->user || !$company->user->hasRole(Role::COMPANY_ROLE)) {
                return back()->withErrors([
                    'national_id' => 'کد ملی یا شماره همراه صحیح نیست.',
                    'phone_number' => 'کد ملی یا شماره همراه صحیح نیست.',
                ])->withInput();
            }

            $user = $company->user;
            $status = smsService::checkCode($user->id, $request->code);

            if ($status) {
                Auth::login($user);
                return redirect()->route('panel.home');
            } else {
                return back()->withErrors([
                    'code' => 'کد نامعتبر است.'
                ])->withInput();
            }
        } catch (\Exception $e) {
            return back()->with('error', 'خطای سرور، دوباره تلاش کنید')->withInput();
        }
    }

    /**
     * Send SMS verification code
     */
    public function sendSms(Request $request)
    {
        $request->validate([
            'national_id' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
        ]);

        $company = Company::where([
            'national_id' => $request->national_id,
            'interface_phone' => $request->phone_number,
        ])->first();

        if (!$company || !$company->user || !$company->user->hasRole(Role::COMPANY_ROLE)) {
            return response()->json([
                'success' => false,
                'message' => 'کد ملی یا شماره همراه صحیح نیست.'
            ], 422);
        }

        $user = $company->user;

        try {
            $code = smsService::generateCode($user->id);
            $result = smsService::sendSMS($user->getPhone(), $code);

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'کد ورود با موفقیت ارسال شد.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در ارسال کد. دوباره تلاش کنید یا با پشتیبانی در ارتباط باشید'
                ], 500);
            }
        } catch (\Exception $e) {
            \Log::error('SMS sending failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'خطا در ارسال کد. دوباره تلاش کنید یا با پشتیبانی در ارتباط باشید'
            ], 500);
        }
    }

    /**
     * Show company registration form
     */
    public function showRegister()
    {
        $companyTypes = $this->getCompanyTypes();
        $provinces = Province::where('active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('auth.company.register', compact('companyTypes', 'provinces'));
    }

    /**
     * Handle company registration
     */
    public function register(CompanyRegisterRequest $request)
    {
        DB::beginTransaction();

        try {
            // Handle coordinates extraction
            $coordinates = $this->extractCoordinates($request->location_link);
            if (!$coordinates) {
                return back()->with('error', 'دریافت مشخصات ناموفق بود. لینک را مجددا وارد نمایید.')->withInput();
            }

            // Handle file uploads
            $fileData = $this->handleFileUploads($request);
            if (!$fileData) {
                return back()->with('error', 'خطا در آپلود فایل‌ها. دوباره تلاش کنید.')->withInput();
            }

            // Convert date
            $registrationDate = null;
            if ($request->registration_date) {
                $registrationDate = Jalalian::fromFormat('Y/m/d', $request->registration_date)
                    ->toCarbon()->toDateString();
            }

            // Create user
            $user = User::create([
                'name' => $request->name,
                'national_id' => $request->national_id,
                'phone_number' => $request->interface_phone,
                'active' => false
            ]);

            // Create company
            $companyData = array_merge($request->validated(), $fileData, $coordinates, [
                'user_id' => $user->id,
                'registration_date' => $registrationDate,
                'status' => Config::STATUS_PENDING,
                'active' => false
            ]);

            Company::create($companyData);

            // Assign role
            $role = Role::where('name', Role::COMPANY_ROLE)->first();
            $user->roles()->sync([$role->id]);

            DB::commit();

            return redirect()->route('home')->with('success', 'اطلاعات شما با موفقیت ارسال شد و به زودی بررسی می شود.');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Company registration error: ' . $e->getMessage());
            return back()->with('error', 'خطای سرور در ارسال اطلاعات. دوباره تلاش کنید.')->withInput();
        }
    }

    /**
     * Get cities by province (AJAX)
     */
    public function getCities(Request $request)
    {
        $cities = City::where('province_id', $request->province_id)
            ->where('active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json([
            'success' => true,
            'cities' => $cities
        ]);
    }

    /**
     * Extract coordinates from Google Maps URL
     */
    private function extractCoordinates(string $url): ?array
    {
        try {
            return $this->coordinateService->extractCoordinatesFromUrl($url);
        } catch (\Exception $e) {
            \Log::error('Coordinate extraction failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Handle file uploads
     */
    private function handleFileUploads(CompanyRegisterRequest $request): ?array
    {
        $fileFields = [
            'company_logo' => 'logos',
            'brand_logo' => 'logos',
            'trademark_certificate' => 'certificates',
            'operation_licence' => 'licences',
            'official_newspaper' => 'newspaper'
        ];

        $uploadedFiles = [];

        foreach ($fileFields as $field => $folder) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $path = "storage/{$folder}/" . now()->year . '/' . now()->month . '/' . now()->day;

                try {
                    $file->storeAs($path, $fileName);
                    $uploadedFiles[$field] = $path . '/' . $fileName;
                } catch (\Exception $e) {
                    \Log::error("File upload error for {$field}: " . $e->getMessage());
                    return null;
                }
            }
        }

        return $uploadedFiles;
    }

    /**
     * Get company types from config
     */
    private function getCompanyTypes(): array
    {
        $config = Config::where('name', Config::COMPANY_TYPE)->first();

        if (!$config) {
            return [];
        }

        return json_decode($config->value, true) ?? [];
    }
}
