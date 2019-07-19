<?php

namespace indiashopps\Http\Middleware;

use Closure;

class ApiAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth_token = $request->header('Authorization');

        if (is_null($auth_token) || empty($auth_token)) {
            return response(['Auth Token Missing'], 403);
        }

        if (!in_array($auth_token, config('auth_tokens'))) {
            return response(['Invalid Auth Token'], 403);
        }

        return $next($request);
    }
}
