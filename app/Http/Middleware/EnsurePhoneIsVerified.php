<?php

namespace App\Http\Middleware;

use App\Services\PhoneVerification;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePhoneIsVerified
{
    public function __construct(protected PhoneVerification $phone)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $this->phone->validateToken(token: $request->verify_token);
        return $next($request);
    }
}
