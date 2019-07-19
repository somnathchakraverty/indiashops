<?php

namespace indiashopps\Exceptions;

use Exception;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;
use Psr\Log\LoggerInterface;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Route;
use ErrorException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        'Symfony\Component\HttpKernel\Exception\HttpException',
        TokenMismatchException::class,
        ErrorException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof TokenMismatchException) {
            if (is_null($request->route())) {
                try {
                    $route = Route::getRoutes()->match($request);
                }
                catch (\Exception $exp) {
                    return response('Gotcha... FU', 403);
                }
            } else {
                $route = $request->route();
            }

            $a             = (new Agent());
            $crawlerDetect = $a->getCrawlerDetect();
            $routeMethods  = $route->getMethods();

            if (in_array($request->method(), $routeMethods) && !($a->isPhone() || $a->isMobile() || $a->isDesktop() || $a->isTablet()) || $crawlerDetect->isCrawler() || $a->isRobot()) {
                return response('Gotcha... FU', 403);
            }
        }

        if ((method_exists($e, "getStatusCode") && $e->getStatusCode() != 404) || $e instanceof ErrorException) {
            $logger = $this->container->make(LoggerInterface::class);

            $logger->error('Error information : ', [
                Request::method(),
                Request::url(),
                Request::all(),
                "file:: " . $e->getFile(),
                "line:: " . $e->getLine(),
                "SERVER IP ::" . env("SERVER_IP", "NOT SET"),
                "User Agent :: " . (new Agent())->getUserAgent(),
                app('Illuminate\Routing\UrlGenerator')->previous(),
                "Error: " . $e->getMessage(),
                "Device:: " . ((isMobile()) ? "Mobile" : "Desktop"),
                "trace:: " . $e->getTraceAsString()
            ]);
        }

        if ($request->has('brand')) {
            app('config')->set('amp_page', true);
            return response(app()
                ->make('indiashopps\Http\Controllers\v3\BaseController')
                ->productDiscontinued($request->get('brand')));

        } elseif ($request->has('slug')) {
            app('config')->set('amp_page', true);
            return response(app()
                ->make('indiashopps\Http\Controllers\v3\BaseController')
                ->productDiscontinued($request->get('slug')));
        }
        
        if ($e instanceof ErrorException) {
            abort(404);
        }

        if ($e instanceof \BadMethodCallException) {
            return redirect('/');
        }

        if ($this->isHttpException($e)) {
            if ($e->getStatusCode() == 404) {
                if (true) {
                    return redirect()->route('404-page', [], 301);
                }

                try {
                    if (!is_null($request->route()) && $request->route()->getName() == 'category_list') {
                        $del   = '-price-list-in-india-';
                        $parts = explode($del, $request->route()->parameter('category'));

                        if (isset($parts[1])) {
                            $parts = explode("-", $request->getUri());
                            array_pop($parts);
                            $parts = implode("-", $parts);
                            return redirect($parts);
                        }
                    }

                    if (!is_null($request->route()) && $request->route()->getName() == 'brand_category_list_comp_1') {
                        $response = checkBrandListingPageRedirect($request->route());

                        if ($response instanceof RedirectResponse) {
                            return $response;
                        }
                    }

                    if (stripos($request->getUri(), 'index.html') !== false) {
                        $uri = str_replace('/index.html', '', $request->getUri());
                        $uri = str_replace('index.html', '', $uri);

                        return redirect($uri, 301);
                    }
                }
                catch (\Exception $e) {
                }

                if (stripos($request->getUri(), '%7Bpage') !== false || $request->has('src')) {
                    return redirect(route('home_v2'), 301);
                }

                if (stripos($request->getUri(), '-%7Bvendor') !== false) {
                    return redirect(route('home_v2'), 301);
                }

                if (stripos($request->getUri(), '%7Border_by') !== false || stripos($request->getUri(), 'sort_order?') !== false) {
                    return redirect(route('home_v2'), 301);
                }

                if (array_key_exists($request->getRequestUri(), config('redirects'))) {
                    $redirect_url = config('redirects')[$request->getRequestUri()];
                    return redirect($redirect_url, 301);
                }

                if (!is_null($request->route())) {
                    $params = $request->route()->parametersWithoutNulls();
                    $name   = '';

                    if (isset($params['name']) && !empty($params['name'])) {
                        $name = $params['name'];
                    } elseif (isset($params['slug']) && !empty($params['slug'])) {
                        $name = $params['slug'];
                    }

                    if (isset($name) && !empty($name)) {
                        $query['name'] = unslug($name);
                        $handle_404    = composer_url('handle_404.php?' . http_build_query($query));

                        $result = json_decode(file_get_contents($handle_404));

                        if (isset($result->prod) && isset($result->prod->hits->hits[0])) {
                            $p = $result->prod->hits->hits[0]->_source;

                            if (isset($p->vendor) && !empty($p->vendor) && !is_array($p->vendor)) {
                                return redirect(route('product_detail_non', [
                                    $p->grp,
                                    create_slug($p->name),
                                    $p->id,
                                    $p->vendor
                                ]), 301);
                            } else {
                                return redirect(route('product_detail_v2', [create_slug($p->name), $p->id]), 301);
                            }
                        }
                    }
                }
            }
            if (view()->exists('v3.errors.' . $e->getStatusCode())) {
                return response()->view('v3.errors.' . $e->getStatusCode(), [], $e->getStatusCode());
            } else {
                return redirect('/');
            }
        }

        return parent::render($request, $e);
    }
}
