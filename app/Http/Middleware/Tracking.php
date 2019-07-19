<?php namespace indiashopps\Http\Middleware;

use Carbon\Carbon;
use Closure;
use indiashopps\Models\FcmToken;
use indiashopps\Models\FcmUserActivity;
use indiashopps\Models\Redirect;

class Tracking
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
        if (env('ALIAS_URL', false) === false) {
            app('url')->forceRootUrl(env('APP_URL'));
        } else {
            app('url')->forceRootUrl(env('ALIAS_URL'));
        }

        $response = $this->validateRequest($request);

        if ($response) {
            return $response;
        }

        if ($request->has('utm_fcm_source') && $request->utm_fcm_source == 'fcm' && $request->has('identifier')) {
            $device = FcmToken::where('identifier', '=', $request->identifier)->first();

            if (!is_null($device)) {

                if (($device->visit_count == 0) || Carbon::now()->diffInHours(Carbon::parse($device->updated_at)) > 1) {
                    $device->visit_count += 1;
                    $device->save();

                    if ($request->has('category_id')) {
                        $activity               = new FcmUserActivity;
                        $activity->category_id  = $request->category_id;
                        $activity->fcm_token_id = $device->id;

                        $activity->save();
                    }
                }
            }
        }

        return $next($request);
    }

    private function validateRequest($request)
    {
        return Redirect::checkRedirectAndHackDetection($request);
    }
}
