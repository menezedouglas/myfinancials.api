<?php

namespace App\Http\Middleware;

use App\Exceptions\Auth\UnauthenticatedException;
use App\Exceptions\Exception;
use Closure;
use Throwable;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class Authenticate extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string[] ...$guards
     * @return mixed
     * @throws UnauthenticatedException|Exception
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        try {
            if(!$request->header('Authorization'))
                throw new UnauthenticatedException();


            JWTAuth::parseToken()->authenticate();
        } catch (Throwable $e) {
            if(auth()->check())
                auth()->logout();

            throw new UnauthenticatedException();
        }
        return $next($request);
    }
}
