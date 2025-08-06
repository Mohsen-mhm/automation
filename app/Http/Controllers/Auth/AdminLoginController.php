<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Http\Requests\Auth\AdminSendCodeRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\SMS\smsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Send SMS verification code
     */
    public function sendCode(AdminSendCodeRequest $request)
    {
        try {
            $user = User::query()->where([
                'national_id' => $request->national_id,
                'phone_number' => $request->phone_number,
            ])->first();

            if ($user && $user->hasRole(Role::ADMIN_ROLE)) {
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
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'کد ملی یا شماره همراه صحیح نیست.',
                    'errors' => [
                        'national_id' => ['کد ملی یا شماره همراه صحیح نیست.'],
                        'phone_number' => ['کد ملی یا شماره همراه صحیح نیست.']
                    ]
                ], 422);
            }
        } catch (\Exception $e) {
            \Log::error('Send SMS error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطای سرور، دوباره تلاش کنید'
            ], 500);
        }
    }

    /**
     * Process login attempt
     */
    public function login(AdminLoginRequest $request)
    {
        try {
            $user = User::query()->where([
                'national_id' => $request->national_id,
                'phone_number' => $request->phone_number,
            ])->whereHas('roles', function ($query) {
                $query->where('name', Role::ADMIN_ROLE);
            })->first();

            if ($user && $user->hasRole(Role::ADMIN_ROLE)) {
                $status = smsService::checkCode($user->id, $request->code);

                if ($status) {
                    Auth::login($user);

                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => true,
                            'message' => 'ورود موفقیت‌آمیز بود',
                            'redirect' => route('panel.home')
                        ]);
                    }

                    return redirect()->route('panel.home');
                } else {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'کد نامعتبر است.',
                            'errors' => [
                                'code' => ['کد نامعتبر است.']
                            ]
                        ], 422);
                    }

                    return redirect()->back()
                        ->withErrors(['code' => 'کد نامعتبر است.'])
                        ->withInput();
                }
            } else {
                $errors = [
                    'national_id' => ['کد ملی یا شماره همراه صحیح نیست.'],
                    'phone_number' => ['کد ملی یا شماره همراه صحیح نیست.']
                ];

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'کد ملی یا شماره همراه صحیح نیست.',
                        'errors' => $errors
                    ], 422);
                }

                return redirect()->back()
                    ->withErrors($errors)
                    ->withInput();
            }
        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطای سرور، دوباره تلاش کنید'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'خطای سرور، دوباره تلاش کنید')
                ->withInput();
        }
    }
}
