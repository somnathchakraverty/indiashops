<?php namespace indiashopps\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;

class MinifyHtml
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
        $response = $next($request);

        if (!($response instanceof RedirectResponse)) {
            try {
                if (!method_exists($response, 'getContent')) {
                    return $response;
                }

                // ... do stuff to $content
                $content = $response->getContent();
                $content = $this->minifyScriptsAndContents($content);
                $response->setContent($content);
            }
            catch (\Exception $e) {
                try {
                    \Log::error("Minify Error::" . $e->getMessage() . "\r\n" . $e->getTraceAsString());
                    return $response;
                }
                catch (\Exception $e) {
                }
                return $response;
            }
        }

        return $response;
    }


    private function minifyScriptsAndContents($content)
    {
        $content = preg_replace('/[\r\n\t\s]+/s', ' ', $content);#new lines, multiple spaces/tabs/newlines
        $content = preg_replace('#/\*.*?\*/#', '', $content);#comments
        //$content = preg_replace('/[\s]*([\{\},;:])[\s]*/', '\1', $content);#spaces before and after marks
        $content = preg_replace('/^\s+/', '', $content);#spaces on the begining

        return $content;
    }
}
