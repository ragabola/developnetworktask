<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\PhoneVerification;
use Illuminate\Http\Request;

class PhoneVerificationController extends Controller
{
    public function __construct(protected PhoneVerification $phone)
    {
    }
    public function send(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:8', 'max:14' , 'unique:users' ]
        ]);

        $this->phone->publishCode(phone: $request->phone);

        return response()->json([
            'message' => 'Verification code sent successfully',
            'expires_in' => now()->addMinutes(30)->timestamp,
        ]);

    }

    public function verify(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:8|max:14',
            'code' => 'required|numeric|digits:6',
        ]);

        $this->phone->checkCode(phone: $request->phone, code: $request->code);

        return response()->json([
            'verify_token' => encrypt($request->phone),
            'expires_in' => now()->addMinutes(30)->timestamp,
        ]);
    }
}
