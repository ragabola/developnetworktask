<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:8', 'max:14'],
            'password' => 'required|string|min:8',
        ]);

        if (! auth()->attempt($request->only('phone', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        return response()->json([
            'access_token' => auth()->user()->createToken('api')->plainTextToken,
            'user' => auth()->user(),
        ]);
    }
}
