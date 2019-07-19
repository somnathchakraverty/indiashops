<?php

namespace indiashopps\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use indiashopps\Http\Middleware\ApiAuthorization;
use indiashopps\Http\Middleware\CashbackPermission;
use indiashopps\Http\Middleware\CombineAll;
use indiashopps\Http\Middleware\DetectMobile;
use indiashopps\Http\Middleware\LoggedIn;
use indiashopps\Http\Middleware\MinifyHtml;
use indiashopps\Http\Middleware\Tracking;
use indiashopps\Http\Middleware\Versioning;
use indiashopps\Http\Middleware\AddHeaders;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \indiashopps\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \indiashopps\Http\Middleware\TrustProxies::class,
        \indiashopps\Http\Middleware\Versioning::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \indiashopps\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \indiashopps\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'                => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic'          => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings'            => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can'                 => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'               => \indiashopps\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle'            => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'min_html'            => MinifyHtml::class,
        'tracking'            => Tracking::class,
        'mobile_site'         => DetectMobile::class,
        // 'versioning'          => Versioning::class,
        'api_check'           => ApiAuthorization::class,
        'login'               => LoggedIn::class,
        'cashback_permission' => CashbackPermission::class,
        'myHeader'            => \indiashopps\Http\Middleware\AddHeaders::class,
    ];
}
