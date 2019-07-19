<?php namespace indiashopps\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use indiashopps\Http\Controllers\v3\MobileController;

class DetectMobile
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
        if (isMobile() && !is_null($request->route())) {
            $response = $this->hasMobileRoute($request->route()->getName(), $request);

            if ($response instanceof RedirectResponse) {
                return $response;
            }

            if ($response !== false && $response instanceof Response) {
                return $response;
            }
        }

        return $next($request);
    }

    private function hasMobileRoute($route, Request $request)
    {
        $controller = new MobileController;

        if ($request->has('mobile_ajax')) {
            $request->request->add(['page_type' => 'mobile_pages', 'page_section' => $route]);

            return $controller->getPage($request);
        }

        $request->request->add(['mobile_page' => true]);

        if ($controller->hasMobilePage($route)) {
            $data     = $controller->getMetaData($route);
            $response = $controller->hasNonAjaxContent($route, $request);

            if ($response instanceof RedirectResponse || $response instanceof View) {
                return $response;
            }

            $data = array_merge($data, $response);

            $data['has_ajax_page'] = false;

            if (isset($data['view_file']) && view()->exists($data['view_file'])) {
                return new Response(view($data['view_file'], $data));
            }

            $data['has_ajax_page'] = true;

            return new Response(view("v3.mobile.master", $data));
        }

        return false;
    }
}
