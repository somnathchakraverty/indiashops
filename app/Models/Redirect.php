<?php namespace indiashopps\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect as LaravelRedirect;

class Redirect extends Model
{

    protected $table = 'permissions';

    public static function checkRedirectAndHackDetection(Request $request)
    {
        if (stripos($request->server('PHP_SELF'), 'public/index.php') !== false) {
            header('Location:' . str_replace('/public', '', $request->server('REQUEST_URI')));
            exit();
        }

        try {

            if (env('ALIAS_URL', false) === false) {
                $app_url = env('APP_URL');
            } else {
                $app_url = env('ALIAS_URL');
            }

            $current_domain = collect(parse_url($request->url()))->get('host');
            $real_domain    = collect(parse_url($app_url))->get('host');

            if ($current_domain != $real_domain) {
                $redirect_url = str_replace($current_domain, $real_domain, $request->url());

                return LaravelRedirect::to($redirect_url);
            }
        }
        catch (\Exception $e) {
        }

        $requested_url = trim($request->getRequestUri(), '/');

        if (array_key_exists($requested_url, config('pre_redirects'))) {
            $pre_redirect_urls = config('pre_redirects');
            return redirect($pre_redirect_urls[$requested_url], 301);
        }
    }
}
