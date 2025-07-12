<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\GreenhouseLoginRequest;
use App\Http\Requests\Auth\GreenhouseRegisterRequest;
use App\Models\Config;
use App\Models\Greenhouse;
use App\Models\GreenhouseAlert;
use App\Models\Province;
use App\Models\City;
use App\Models\Role;
use App\Models\User;
use App\Services\SMS\smsService;
use App\Services\CoordinateExtractionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

class GreenhouseController extends Controller
{
    public function __construct(
        private CoordinateExtractionService $coordinateService
    )
    {
    }

    /**
     * Show greenhouse login form
     */
    public function showLogin()
    {
        return view('auth.greenhouse.login');
    }

    /**
     * Show greenhouse registration form
     */
    public function showRegister()
    {
        try {
            $substrates = $this->getConfigValues(Config::SUBSTRATE);
            $productTypes = $this->getConfigValues(Config::PRODUCT_TYPE);
            $greenhouseStatuses = $this->getConfigValues(Config::GREENHOUSE_STATUS);
            $provinces = Province::where('active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(['id', 'name']);

            return view('auth.greenhouse.register', compact(
                'substrates',
                'productTypes',
                'greenhouseStatuses',
                'provinces'
            ));
        } catch (Exception $e) {
            return redirect()->route('login.greenhouse')
                ->with('error', 'خطای سرور، دوباره تلاش کنید');
        }
    }

    /**
     * Send SMS verification code
     */
    public function sendSms(Request $request)
    {
        $request->validate([
            'licence_number' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
        ], [
            '*.required' => 'این فیلد باید حتما وارد شود.'
        ]);

        try {
            $greenhouse = Greenhouse::where([
                'licence_number' => $request->licence_number,
                'owner_phone' => $request->phone_number,
            ])->first();

            if (!$greenhouse || !$greenhouse->user || !$greenhouse->user->hasRole(Role::GREENHOUSE_ROLE)) {
                return response()->json([
                    'success' => false,
                    'message' => 'شماره پروانه یا شماره همراه صحیح نیست.'
                ], 422);
            }

            $user = $greenhouse->user;
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
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطای سرور، دوباره تلاش کنید'
            ], 500);
        }
    }

    /**
     * Handle greenhouse login
     */
    public function login(GreenhouseLoginRequest $request)
    {
        try {
            $greenhouse = Greenhouse::where([
                'licence_number' => $request->licence_number,
                'owner_phone' => $request->phone_number,
            ])->first();

            if (!$greenhouse || !$greenhouse->user || !$greenhouse->user->hasRole(Role::GREENHOUSE_ROLE)) {
                return back()->withErrors([
                    'licence_number' => 'شماره پروانه یا شماره همراه صحیح نیست.',
                    'phone_number' => 'شماره پروانه یا شماره همراه صحیح نیست.',
                ])->withInput();
            }

            $user = $greenhouse->user;
            $status = smsService::checkCode($user->id, $request->code);

            if ($status) {
                Auth::login($user);
                return redirect()->route('panel.home');
            } else {
                return back()->withErrors([
                    'code' => 'کد نامعتبر است.'
                ])->withInput();
            }
        } catch (Exception $e) {
            return back()->with('error', 'خطای سرور، دوباره تلاش کنید')->withInput();
        }
    }

    /**
     * Handle greenhouse registration
     */
    public function register(GreenhouseRegisterRequest $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validated();

            // Handle coordinates extraction
            if (isset($validatedData['location_link'])) {
                try {
                    $coordinates = $this->coordinateService->extractCoordinatesFromUrl($validatedData['location_link']);
                    $validatedData['coordinates'] = $coordinates['coordinates'];
                    $validatedData['latitude'] = $coordinates['latitude'];
                    $validatedData['longitude'] = $coordinates['longitude'];
                } catch (Exception $e) {
                    return back()->withErrors([
                        'location_link' => 'دریافت مشخصات ناموفق بود. لینک را مجددا وارد نمایید.'
                    ])->withInput();
                }
            }

            // Handle date conversion
            if ($validatedData['operation_date']) {
                $validatedData['operation_date'] = Jalalian::fromFormat('Y/m/d', $validatedData['operation_date'])
                    ->toCarbon()->toDateString();
            }

            if ($validatedData['construction_date']) {
                $validatedData['construction_date'] = Jalalian::fromFormat('Y/m/d', $validatedData['construction_date'])
                    ->toCarbon()->toDateString();
            }

            // Handle file uploads
            $validatedData['operation_licence'] = $this->handleFileUpload(
                $request->file('operation_licence'),
                'licences'
            );

            $validatedData['image'] = $this->handleFileUpload(
                $request->file('image'),
                'logos'
            );

            // Create user
            $user = User::create([
                'name' => $validatedData['name'],
                'national_id' => $validatedData['owner_national_id'],
                'phone_number' => $validatedData['owner_phone'],
                'active' => 0 // Initially inactive until approval
            ]);

            $validatedData['user_id'] = $user->id;

            // Create greenhouse
            $greenhouse = Greenhouse::create($validatedData);

            // Create greenhouse alert settings
            GreenhouseAlert::create(['greenhouse_id' => $greenhouse->id]);

            // Assign role
            $user->roles()->sync(Role::where('name', Role::GREENHOUSE_ROLE)->first()->id);

            DB::commit();

            return redirect()->route('home')
                ->with('success', 'اطلاعات شما با موفقیت ارسال شد و به زودی بررسی می شود.');

        } catch (Exception $e) {
            DB::rollback();
            \Log::error('Greenhouse registration error: ' . $e->getMessage());

            return back()->with('error', 'خطای سرور در ارسال اطلاعات. دوباره تلاش کنید.')
                ->withInput();
        }
    }

    /**
     * Get provinces for dropdown
     */
    public function getProvinces()
    {
        $provinces = Province::where('active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json([
            'success' => true,
            'provinces' => $provinces
        ]);
    }

    /**
     * Get cities by province
     */
    public function getCities($provinceId)
    {
        $cities = City::where('province_id', $provinceId)
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
     * Get config values as array
     */
    private function getConfigValues(string $configName): array
    {
        $config = Config::where('name', $configName)->first();

        if (!$config) {
            return [];
        }

        return json_decode($config->value, true) ?? [];
    }

    /**
     * Handle file upload
     */
    private function handleFileUpload($file, string $folder): ?string
    {
        if (!$file) {
            return null;
        }

        try {
            $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = "storage/{$folder}/" . now()->year . '/' . now()->month . '/' . now()->day;

            $file->storeAs($path, $fileName);

            return $path . '/' . $fileName;
        } catch (Exception $e) {
            \Log::error("File upload error for {$folder}: " . $e->getMessage());
            return null;
        }
    }
}
