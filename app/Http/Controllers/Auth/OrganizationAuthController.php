<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OrganizationLoginRequest;
use App\Http\Requests\Auth\OrganizationRegisterRequest;
use App\Http\Requests\Auth\OrganizationSmsRequest;
use App\Models\City;
use App\Models\OrganizationUser;
use App\Models\Province;
use App\Models\Role;
use App\Models\User;
use App\Services\SMS\smsService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrganizationAuthController extends Controller
{
    /**
     * Show organization login form
     */
    public function showLogin()
    {
        return view('auth.organization.login');
    }

    /**
     * Show organization register form
     */
    public function showRegister()
    {
        $provinces = Province::where('active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('auth.organization.register', compact('provinces'));
    }

    /**
     * Get cities by province (AJAX endpoint)
     */
    public function getCitiesByProvince(Request $request)
    {
        $request->validate([
            'province_id' => 'required|exists:provinces,id'
        ]);

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
     * Send SMS verification code
     */
    public function sendSms(OrganizationSmsRequest $request)
    {
        try {
            $organization = OrganizationUser::where([
                'national_id' => $request->national_id,
                'phone_number' => $request->phone_number,
            ])->first();

            if (!$organization || !$organization->user || !$organization->user->hasRole(Role::ORGANIZATION_ROLE)) {
                return response()->json([
                    'success' => false,
                    'message' => 'کد ملی یا شماره همراه صحیح نیست.'
                ], 422);
            }

            $user = $organization->user;
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
            \Log::error('SMS send error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطای سرور، دوباره تلاش کنید'
            ], 500);
        }
    }

    /**
     * Handle organization login
     */
    public function login(OrganizationLoginRequest $request)
    {
        try {
            $organization = OrganizationUser::where([
                'national_id' => $request->national_id,
                'phone_number' => $request->phone_number,
            ])->first();

            if (!$organization || !$organization->user || !$organization->user->hasRole(Role::ORGANIZATION_ROLE)) {
                return redirect()->back()
                    ->withErrors([
                        'national_id' => 'کد ملی یا شماره همراه صحیح نیست.',
                        'phone_number' => 'کد ملی یا شماره همراه صحیح نیست.'
                    ])
                    ->withInput();
            }

            $user = $organization->user;
            $status = smsService::checkCode($user->id, $request->code);

            if ($status) {
                Auth::login($user);
                return redirect()->route('panel.home')
                    ->with('success', 'با موفقیت وارد شدید');
            } else {
                return redirect()->back()
                    ->withErrors(['code' => 'کد نامعتبر است.'])
                    ->withInput();
            }

        } catch (Exception $e) {
            \Log::error('Organization login error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'خطای سرور، دوباره تلاش کنید')
                ->withInput();
        }
    }

    /**
     * Handle organization registration
     */
    public function register(OrganizationRegisterRequest $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validated();

            // Handle file uploads
            $validatedData['national_card'] = $this->uploadFile($request->file('national_card'), 'national');
            $validatedData['personnel_card'] = $this->uploadFile($request->file('personnel_card'), 'personnel');
            $validatedData['introduction_letter'] = $this->uploadFile($request->file('introduction_letter'), 'introduction');

            // Create user
            $user = User::create([
                'name' => $validatedData['fname'] . ' ' . $validatedData['lname'],
                'national_id' => $validatedData['national_id'],
                'phone_number' => $validatedData['phone_number'],
                'active' => false, // Organization users need approval
            ]);

            // Create organization user
            $validatedData['user_id'] = $user->id;
            OrganizationUser::create($validatedData);

            // Assign role
            $role = Role::where('name', Role::ORGANIZATION_ROLE)->first();
            if ($role) {
                $user->roles()->sync([$role->id]);
            }

            DB::commit();

            return redirect()->route('home')
                ->with('success', 'اطلاعات شما با موفقیت ارسال شد و به زودی بررسی می‌شود.');

        } catch (Exception $e) {
            DB::rollback();
            \Log::error('Organization registration error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'خطای سرور در ارسال اطلاعات. دوباره تلاش کنید.')
                ->withInput();
        }
    }

    /**
     * Handle file upload
     */
    private function uploadFile($file, $folder)
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
            throw new Exception("خطا در آپلود فایل {$folder}");
        }
    }
}
