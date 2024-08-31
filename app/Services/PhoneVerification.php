<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class PhoneVerification
{
    public function publishCode($phone)
    {
        $code = '123456';

        if(Cache::has($phone)) Cache::forget($phone);

        Cache::add($phone, encrypt($code), now()->addMinutes(30));
    }

    public function checkCode($phone, $code)
    {
        $cached = Cache::get($phone);

        if(! $cached) {
            throw ValidationException::withMessages([
                'code' => 'Verification code has expired',
            ]);
        }

        if (decrypt($cached) !== $code) {
            throw ValidationException::withMessages([
                'code' => 'Invalid verification code',
            ]);
        }

        Cache::forget($phone);
    }

    public function validateToken($token)
    {
        if(! $token) throw ValidationException::withMessages(['token' => 'Please provide the verification token in the query string , /api/register?verify_token=YOUR TOKEN HERE']);
        else {
            try {
                decrypt($token);
            } catch (DecryptException $e) {
                throw ValidationException::withMessages(['token' => 'Please provide a valid verification token']);
            }

        }
    }
}
