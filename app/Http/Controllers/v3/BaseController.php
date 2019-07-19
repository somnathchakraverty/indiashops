<?php

namespace indiashopps\Http\Controllers\v3;

use Illuminate\Http\Request;

use DB;
use indiashopps\Category;
use indiashopps\Traits\SeoData;
use indiashopps\Traits\Redirects;
use indiashopps\Http\Controllers\Controller;
use indiashopps\Support\SolrClient\Facade\Solr as SolrClient;
use SendGrid\Mail\Mail;

class BaseController extends Controller
{
    use SeoData, Redirects;

    public $solrClient;
    public $seo;

    static $instance;

    public function __construct()
    {
        $this->solrClient = SolrClient::getInstance();
        $this->seo        = app('seo');
    }

    public function render($view, $data = [])
    {
        $data['controller'] = $this;

        return view($view, $data);
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Get category ID by name and Category ID
     *
     * @var Category Name
     * @var Parent Category ID
     */
    public function getCatIDByName($cat_name, $parent_id = 0)
    {
        $cat_name = create_slug($cat_name);
        $db       = DB::table('gc_cat');

        if (!empty($parent_id)) {
            $db = $db->where('parent_id', $parent_id);
        } else {
            $db = $db->where('parent_id', 0);
        }

        $row = $db->where(DB::raw(" create_slug(name) "), $cat_name)->lists('id');

        return @$row[0];
    }

    public function getParentIDByName($cat_name, $level = false, $group = false)
    {
        $cat_name = create_slug($cat_name);

        $db = DB::table('gc_cat AS a')->select("b.name AS name");

        if ($level) {
            $db = $db->where('a.level', $level);
        }
        if ($group) {
            $db = $db->where('a.group_name', 'like', $group);
        }
        $db  = $db->join('gc_cat AS b', 'a.parent_id', '=', 'b.id');
        $row = $db->where(DB::raw(" create_slug(a.name) "), "like", $cat_name)->get();

        return @$row[0];
    }

    public function switchWords($array, $keys = [])
    {
        foreach ($array as $key => $field) {
            if ($field instanceof Request) {
                $first  = explode(" ", $field->brand);
                $second = explode(" ", unslug($array[$key + 1]));

                $first[] = strtolower($second[0]);
                unset($second[0]);
                $array[$key]->request->add(['brand' => implode(" ", $first)]);
                $array[$key + 1] = implode(" ", $second);
            } elseif ($key + 1 < count($array)) {
                $first  = explode(" ", $array[$key]);
                $second = explode(" ", unslug($array[$key + 1]));

                $first[] = strtolower($second[0]);
                unset($second[0]);

                $array[$key]     = create_slug(implode(" ", $first));
                $array[$key + 1] = create_slug(implode(" ", $second));
            }
        }

        foreach ($array as $key => $field) {
            $array[$keys[$key]] = $field;
            unset($array[$key]);
        }

        return $array;
    }

    public function getParentName($cat_name, $group, $parent_id = 0, &$request)
    {
        $cat_name = create_slug($cat_name);

        $db = DB::table('gc_cat AS a');

        $db = $db->join('gc_cat AS b', 'a.parent_id', '=', 'b.id');

        if ($parent_id == 0) {
            $this->startLog();
            $db  = $db->select(["b.name AS name", "b.group_name"]);
            $row = $db->where(DB::raw(" create_slug(a.group_name) "), '=', $group)
                      ->where(DB::raw(" create_slug(a.name) "), "like", $cat_name)
                      ->first();
        } else {
            $db  = $db->select(["a.name AS name", "a.group_name"]);
            $row = $db->where('a.id', '=', $parent_id)
                      ->where(DB::raw(" create_slug(a.name) "), "like", $cat_name)
                      ->first();
        }

        if (is_null($row)) {
            if (count(explode(" ", $request->brand)) <= 3) {
                if (!empty($group)) {
                    $data = $this->switchWords([$request, $group, $cat_name], ['request', 'group', 'cat_name']);
                } else {
                    $data = $this->switchWords([$request, $cat_name], ['request', 'cat_name']);
                }


                extract($data);

                return $this->getParentName($cat_name, $group, $parent_id, $request);
            }

            if ($request->has('debug')) {
                \Log::error("Error: Category Not Found");
            }

            abort(404);
        } else {
            $row->category = $cat_name;

            return $row;
        }
    }

    /**
     *
     */
    public function startLog()
    {
        DB::enableQueryLog();
    }

    /**
     * @param bool $dump
     * @return mixed
     */
    public function getQueryLog($dump = true)
    {
        $log = DB::getQueryLog();

        if ($dump) {
            dd($log);
        }

        return $log;
    }

    /**
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productDiscontinued($name)
    {
        $query['name'] = unslug($name);
        $query['size'] = 16;

        $handle_404 = solr_url('handle_404.php?' . http_build_query($query));
        $result     = json_decode(file_get_contents($handle_404));

        $data['products'] = $result->prod->hits->hits;
        $data['name']     = unslug($name);

        try {
            if (isset($data['products'][0]) && isset($data['products'][0]->_source)) {
                $parameters = request()->route()->parameters();
                $product    = $data['products'][0]->_source;

                if (isComparativeProduct($product)) {
                    $data['canonical'] = route('product_detail_v2', $parameters);
                } else {
                    $parameters['cat_name'] = cs($product->grp);
                    $data['canonical']      = route('product_detail_non', $parameters);
                }
            } else {
                $data['canonical'] = \Request::url();
            }
        }
        catch (\Exception $e) {
            $data['canonical'] = \Request::url();
        }

        $this->seo->setTitle("The product you are looking for has been discontinued");

        if (isAmpPage()) {
            return view('v3.amp.discontinued', $data);
        } else {
            return view('v3.product.common.discontinued', $data);
        }
    }

    protected function redirectBackToParent($request, $parent, $cname, $child)
    {
        if (isAmpPage()) {
            $route  = 'amp.product_list';
            $sroute = 'amp.sub_category';
        } else {
            $route  = 'product_list';
            $sroute = 'sub_category';
        }

        if ($request->route()->getName() !== $route && !empty($parent) && !empty($child) && !empty($cname)) {
            $url = route('product_list', [$parent, $child, $cname]);
            return redirect(seoUrl($url), 301);
        } elseif (!empty($parent) && !empty($child) && !empty($cname)) {
            $url = route('sub_category', [$parent, $child]);
            return redirect(seoUrl($url), 301);
        } elseif (!empty($parent) && !empty($cname) && !$child && $request->route()->getName() !== $sroute) {
            $url = categoryLink([$parent, $cname]);
            return redirect($url, 301);
        } elseif (!empty($parent) && !empty($cname) && !$child && $request->has('brand_page')) {
            $url = categoryLink([$parent, $cname]);
            return redirect($url, 301);
        } else {
            $url = categoryLink([$parent]);
            return redirect($url, 301);
        }

        return false;
    }

    public function getPaginationTarget($url, $array)
    {
        foreach ($array as $field => $value) {
            if ($field != 'page') {
                $url = str_replace('{' . $field . '}', create_slug($value), $url);
            }
        }
        if (strpos($url, '{page?}') === false && strpos($url, '{page}') === false) {
            $url = str_replace(".html", '-{page?}.html', $url);
            $url = str_replace('-90001', '-90001-{page}', $url);
        }
        if (strpos($url, 'html') === false && strpos($url, '{page?}') == false && strpos($url, '{page}') == false) {
            $url = $url . "-{page}";
        }

        return trim($url, "/");
    }

    public function hasRedirectTo($p)
    {
        if (isset($p->redirect_to) && !empty($p->redirect_to) && isset($p->redirect_name) && !empty($p->redirect_name)) {
            return true;
        } else {
            return false;
        }
    }

    public function redirectTo($p)
    {
        $parts = explode("-", $p->redirect_to);

        if (isset($parts[1]) && !empty($parts[1]) && is_numeric($parts[1])) {

            if (isAmpPage()) {
                return redirect(route('amp_detail_non_comp', create_slug($p->redirect_name), $parts[0], $parts[1]), 301);
            } else {
                return redirect(route('product_detail_non', create_slug($p->grp), create_slug($parts[0]), $parts[1]), 301);
            }
        } else {
            if (isAmpPage()) {
                $route = 'amp_detail_comp';
            } else {
                $route = 'product_detail_v2';
            }

            return redirect(route($route, [create_slug($p->redirect_name), $p->redirect_to]), 301);
        }
    }

    protected function setupProductListJsonLD(&$data)
    {
        if ($data['child_categories']->isEmpty()) {
            $json_ld['@context'] = 'http://schema.org';
            $json_ld['@type']    = 'ItemList';
            $json_ld['@context'] = 'http://schema.org';
            $product_list        = [];

            foreach ($data['product'] as $key => $product) {
                $item['@type']          = 'ListItem';
                $item['position']       = ++$key;
                $item['name']           = $product->_source->name;
                $item['url']            = product_url($product);
                $item['additionalType'] = 'Product';
                $item['image']          = getImageNew($product->_source->image_url, 'M');

                $product_list[] = $item;
            }

            $json_ld['itemListElement'] = $product_list;
            $json_ld                    = json_encode($json_ld);

            $footer = <<<EX
                    <script type="application/ld+json">
                    {$json_ld}
                    </script>
EX;
            app('config')->set('html.content.footer', [$footer]);
        } else {
            $json_ld['@context'] = 'http://schema.org';
            $json_ld['@type']    = 'ItemList';
            $json_ld['@context'] = 'http://schema.org';
            $product_list        = [];

            foreach ($data['child_categories'] as $key => $category) {
                $item['@type']    = 'ListItem';
                $item['position'] = ++$key;
                $item['url']      = getCategoryUrl($category);
                $item['name']     = $category->name . " Price List In India";

                $product_list[] = $item;
            }

            $json_ld['itemListElement'] = $product_list;
            $json_ld                    = json_encode($json_ld);

            $footer = <<<EX
                    <script type="application/ld+json">
                    {$json_ld}
                    </script>
EX;
            app('config')->set('html.content.footer', [$footer]);
        }
    }

    function renderView(Request $request, $view_file, $data)
    {
        if ($request->has('mobile_page') && $request->mobile_page === true) {
            return $data;
        }

        return view($view_file, $data);
    }

    protected function addAttributesToProductName(&$product)
    {
        if (array_key_exists($product->category_id, config('product_names.category'))) {
            $key        = 'product_names.category.' . $product->category_id;
            $attributes = [];

            foreach (config($key) as $attrib => $text) {
                if (isset($product->{$attrib}) && !empty($product->{$attrib})) {
                    if ($attrib == 'ram') {
                        $value = str_replace(' ', '', $product->{$attrib});
                    } else {
                        $value = $product->{$attrib};
                    }

                    $value        = str_replace('{VALUE}', $value, $text);
                    $attributes[] = $value;
                }
            }

            if (count($attributes) > 0) {
                $product->name = preg_replace('/\((.*)\)/', '', $product->name);
                if ($product->category_id == Category::LAPTOPS) {
                    $product->name .= ' - ' . implode(" + ", $attributes);
                } else {
                    $product->name .= ' ( ' . implode(" + ", $attributes) . ' )';
                }
            }
        }
    }

    /**
     * Sends HTTP Email using SENDGRID API..
     * @author Vishal Singh <vishal@manyainternational.com>
     *
     * @param $to
     * @param $subject
     * @param $content
     * @param null $to_name
     * @throws \Exception
     * @throws \SendGrid\Mail\TypeException
     */
    public function sendEmail($to, $subject, $content, $to_name = null)
    {
        if (env('SENDGRID_API_KEY', false) === false) {
            throw new \Exception("Send Grid API Key Missing..!!");
        }

        $email = new Mail();
        $email->setFrom(env('MAIL_USERNAME'), env('MAIL_NAME'));
        $email->setSubject($subject);
        $email->addTo($to, $to_name);
        $email->addContent($this->isHTML($content) ? "text/html" : "text/plain", $content);

        $sendGrid = new \SendGrid(env('SENDGRID_API_KEY'));

        try {
            $sendGrid->send($email);
        }
        catch (\Exception $e) {
            \Log::error("Sendgrid Mail Error: " . $e->getTraceAsString());
        }
    }

    public function isHTML($string)
    {
        return ($string != strip_tags($string));
    }

    public function whitelistIP($ip)
    {
        $request_body = json_decode('{
                                  "ips": [
                                    {
                                      "ip": "' . $ip . '"
                                    }
                                  ]
                                }');

        try {
            $sg       = new \SendGrid(env('SENDGRID_API_KEY'));
            $response = $sg->client->access_settings()->whitelist()->post($request_body);
            dump($response);
        }
        catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
}
