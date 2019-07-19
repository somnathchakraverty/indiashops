<?php

namespace indiashopps\Http\Middleware;

use Closure;

class CashbackPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!userHasAccess($request->route()->getName())) {
            $permitted_routes = auth()->user()->getPermissions();
            if (empty($permitted_routes)) {
                return redirect()->route('myaccount');
            }

            return redirect()->route(collect($permitted_routes)->first());
        }

        return $next($request);
    }
}
