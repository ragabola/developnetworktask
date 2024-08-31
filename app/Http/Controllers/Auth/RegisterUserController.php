<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PhoneVerification;
use Illuminate\Http\Request;

class RegisterUserController extends Controller
{
    public function __construct(protected PhoneVerification $phone)
    {
    }
    public function __invoke(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $attributes['phone'] = decrypt($request->verify_token);

        $user = User::create($attributes);

        cache()->forget('stats');

        return response()->json([
            'access_token' => $user->createToken('api')->plainTextToken,
            'user' => $user,
        ], 201);
    }
}
