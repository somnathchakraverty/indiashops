<?php
namespace indiashopps\Support\Widget;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use indiashopps\Support\Widget\InvalidWidgetException;

Class Widget
{
    protected $widget;
    protected $view_path;
    protected $components     = [];
    protected $component_path = 'v3.widget';
    protected $html_path;
    protected $css_path;


    /**
     * Widget constructor.
     */
    public function __construct()
    {
        $this->view_path = collect(app('config')->get('view.paths'))->first() . "/";

        if( isMobile() )
        {
            $this->component_path = "v3.mobile.widget";
        }

        if( isAmpPage() )
        {
            $this->component_path = "v3.amp.widget";
        }
    }

    /**
     * @param $component_name
     * @param $variables
     * @param bool $above_the_fold
     */
    public function addComponent($component_name, &$variables, $variable_name = '', $above_the_fold = false)
    {

        if ((is_array($variables) || is_object($variables)) && isset($variable_name) && !($variables instanceof Collection)) {
            $component = new \stdClass();

            $component->name                   = $component_name;
            $component->variables              = $variables;
            $component->variable               = $variable_name;
            $component->atf                    = (bool)$above_the_fold;
            $this->components[$component_name] = $component;
        } else {
            \Log::error("Invalid Variable or Variable name used for Component $component_name:: LINE_NO :: " . __LINE__);
        }
    }

    /**
     *
     */
    public function getAboveTheFoldResources()
    {
        return $this->getResource(true);
    }

    /**
     * @param bool $atf
     * @return string
     */
    private function getResource($atf = false)
    {
        $css_content = '';

        foreach ($this->components as $name => $component) {
            if ($component->atf === $atf) {
                $css_file = $this->view_path . $this->getRealPath() . "/" . $name . "/content.css";
                if (file_exists($css_file)) {
                    $css_content .= file_get_contents($css_file);
                }
            }
        }

        if (!empty($css_content)) {
            $css_content = "<style>$css_content</style>";
        }

        return $css_content;
    }

    /**
     * Gets Footer Resources for Added Components
     */
    public function getFooterResources()
    {
        return $this->getResource();
    }

    /**
     * @param $component_name
     * @return View|string
     */
    public function getComponent($component_name)
    {
        if (isset($this->components[$component_name])) {
            return $this->renderComponent($component_name);
        }
    }

    /**
     * @param $path
     * @return $this
     */
    public function setComponentPath($path)
    {
        if (file_exists($this->view_path . replaceAll('.', '/', $path))) {
            $this->component_path = $path;
        }

        return $this;
    }


    /**
     * @param $component_name
     * @param array $data
     * @return View|string
     */
    private function renderComponent($component_name, &$data = [])
    {
        $content = '';

        if (isset($this->components[$component_name]) && view()->exists($this->component_path . ".$component_name.content")) {
            try {
                if (request()->has('ajax')) {
                    $data['ajax'] = true;
                } else {
                    $content .= $this->getResource();
                }
                
                $data['headers'] = Cache::rememberForever('top_level_menu', function () {
                    return \DB::table('gc_cat')->whereLevel(0)->get();
                });

                $data['current_path']       = $this->component_path . "." . $component_name;
                $component                  = $this->components[$component_name];
                $data[$component->variable] = $component->variables;
                $content .= view($this->component_path . ".$component_name.content", $data);
            }
            catch (\Exception $e) {
                \Log::error($e->getMessage() . "::" . $e->getLine() . "::" . $e->getFile());
            }

            if ($content instanceof View) {
                $content = (string)$content;
            }
        } else {
            \Log::error("Component Not Registered / Found .. :: Component Name :: $component_name :: LINE :: " . __LINE__);
        }

        $this->dequeueComponent($component_name);

        return $content;
    }

    public function getAjaxComponent($component_name, &$variables, $variable_name = '', &$data = [])
    {
        $this->addComponent($component_name, $variables, $variable_name );

        if (isset($this->components[$component_name])) {
            return $this->renderComponent($component_name, $data);
        }
    }

    private function dequeueComponent($component_name)
    {
        if (isset($this->components[$component_name])) {
            unset($this->components[$component_name]);
        }
    }

    private function getRealPath()
    {
        return replaceAll(".", "/", $this->component_path);
    }

    public function dump()
    {
        dd($this);
    }
}

?>