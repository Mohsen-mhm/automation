<?php

namespace App\Services\SMS;

use App\Models\ActiveCode;
use Melipayamak\MelipayamakApi;
use Melipayamak\SmsRest;
use Melipayamak\SmsSoap;

class smsService
{
    public static function generateCode($userId): int
    {
        $code = mt_rand(100000, 999999);

        ActiveCode::query()->create([
            'user_id' => $userId,
            'code' => $code,
            'expired_at' => now()->addMinutes(ActiveCode::CODE_EXPIRATION),
        ]);

        return $code;
    }

    private static function getLatestActiveCode($userId)
    {
        return ActiveCode::query()->whereUserId($userId)
            ->latest()
            ->first();
    }

    public static function checkCode($userId, $userCode): bool
    {
        $activeCode = self::getLatestActiveCode($userId);

        if ($activeCode && $userCode == $activeCode->code && now() < $activeCode->expired_at) {
            ActiveCode::query()->whereUserId($userId)->delete();
            return true;
        }

        return false;
    }

    public static function sendSMS(string $phone, string $code)
    {
        try {
            $api = new MelipayamakApi(config('melipayamak.username'), config('melipayamak.password'));
            $smsSoup = $api->sms('soap');
            $response = $smsSoup->sendByBaseNumber(array($code), $phone, '200368');

            return strlen($response) > 10;
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), 'خطا');
        }
    }

    public static function getCredit()
    {
        try {
            $api = new MelipayamakApi(config('melipayamak.username'), config('melipayamak.password'));
            $sms = $api->sms();
            $response = collect(json_decode($sms->getCredit(), true));

            if ($response->get('RetStatus')) {
                return (int)$response->get('Value');
            }
            return 0;
        } catch (\Exception $e) {
            toastr()->error($e->getMessage(), 'خطا');
        }
    }
}
