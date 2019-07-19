<?php 
namespace indiashopps\Http\Middleware;
use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Applicaion;


class AddHeaders 
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('Cache-Control', 'max-age=3600, s-maxage=18000, public');
        //$response->header('another header', 'another value');

        return $response;
    }
}