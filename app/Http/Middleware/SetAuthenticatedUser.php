<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class SetAuthenticatedUser extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $token = $request->bearerToken();

        if ($token) {
            $user = Auth::guard('sanctum')->user();

            if ($user) {
                $request->setUserResolver(function () use ($user) {
                    return $user;
                });
            }
        }

        return $next($request);
    }
}
