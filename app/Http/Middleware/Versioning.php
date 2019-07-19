<?php

namespace indiashopps\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class Versioning
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
        $key = 'indiashopps_version';

        if( Storage::has('indiashopps_version') )
        {
            $version = Storage::get('indiashopps_version');
        }
        else
        {
            $version = 10000;
        }
        $response = $next($request);
        if( $request->cookie('front_version') != $version )
        {
            $cookie = Cookie::forever('front_version', Crypt::encrypt($version));

            return $response->withCookie($cookie);
        }

        return $response;
    }
}
