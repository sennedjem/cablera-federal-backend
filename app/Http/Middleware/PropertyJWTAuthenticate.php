<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as LaravelAuthenticate;
use \Firebase\JWT\JWT;
use \DomainException;

class PropertyJWTAuthenticate extends LaravelAuthenticate {

    public function handle($request, Closure $next, ...$guards) {
        if ($request->token && $user_id = JWT::decode($request->token, config('jwt.property_secret'), [config('jwt.algo')])->user_id) {
            $request->merge(['user_id' => $user_id]);
        } else {
            return response()->json([
                'message' => 'Invalid Property Token'
            ], 400);
        }
        return $next($request);
    }
}
