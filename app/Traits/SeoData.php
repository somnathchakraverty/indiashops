<?php
namespace indiashopps\Traits;

use DB;
use Carbon\Carbon;
use indiashopps\Category;
use indiashopps\CategoryMeta;
use indiashopps\Models\BrandListing;

/**
 * @method $this setHeading(string $h1);
 * @method $this setTitle(string $title);
 * @method $this setDescription(string $description);
 * @method $this setKeywords(string $keywords);
 * @method $this setShortDescription(string $keywords);
 * @method string getHeading();
 * @method string getTitle();
 * @method string getDescription();
 * @method string getKeywords();
 * @method string getShortDescription();
 *
 */
Trait SeoData
{
    /**
     * @param $string
     * @param string $brand
     * @param string $category
     * @return array|object
     */
    public function getMeta($string, $brand = '', $category = '')
    {
        if (is_string($string)) {
            $metas = (object)config($string);
        } else {
            $metas = $string;
        }

        if (is_null($metas)) {
            return false;
        }

        foreach ($metas as $key => $meta) {
            $search = ['{DATE}', '{YEAR}', '{BRAND}', '{GROUP}', '{CATEGORY}', '{{cat}}'];
            $replace = [
                Carbon::now()->format('F, Y'),
                Carbon::now()->format('Y'),
                ucwords($brand),
                ucwords($category),
                ucwords($category),
                ucwords($category),
            ];

            foreach ($search as $k => $s) {
                $metas->{$key} = preg_replace('/' . $s . '/', $replace[$k], $metas->{$key});
                $metas->{$key} = preg_replace('/\s\s+/', ' ', $metas->{$key});
                $metas->{$key} = preg_replace('/' . $s . '/', $replace[$k], $metas->{$key});
            }
        }

        if (empty($brand) && empty($category)) {
            return (array)$metas;
        } else {
            return $metas;
        }
    }

    public function processSeoMetaData($request, &$data, $vars)
    {
        if ($request->has('custom_page')) {
            return true;
        }

        $seo = $this->seo;

        $brand = (isset($vars['brand'])) ? $vars['brand'] : '';
        $cat = (isset($vars['cat'])) ? $vars['cat'] : '';
        $cname = (isset($vars['cname'])) ? $vars['cname'] : '';
        $c_name = (isset($data['c_name'])) ? $data['c_name'] : '';
        $parent = (isset($vars['parent'])) ? $vars['parent'] : '';
        $page = (isset($vars['page'])) ? $vars['page'] : 0;
        $has_meta = false;

        if (!empty($brand)) {
            $brand_meta = CategoryMeta::where('brand', 'like', $brand)->whereCatId($cat)->first();

            if (!is_null($brand_meta)) {
                $meta = (object)$this->getMeta(json_decode($brand_meta->meta), $brand, $c_name);

                $this->seo->setMetaData((array)$meta);

                if (!$request->has('custom_page') && isset($brand_meta->description) && !empty($brand_meta->description)) {
                    $seo->setContent($brand_meta->description);
                }

                $data['brand_meta'] = $meta;
                $has_meta = true;
            } elseif ($request->has('brand_listing_page')) {

                $return = $this->brandListingMeta($cat, $brand, $c_name, $data);

                if ($return === false && isset($vars['category'])) {
                    if ($vars['category'] instanceof Category) {
                        $return = $this->brandListingMeta($vars['category']->parent_id, $brand, $c_name, $data);
                        if ($return === true) {
                            $has_meta = true;
                        }
                    }
                } else {
                    $has_meta = true;
                }
            } elseif($request->has('brand_page')){
                $return = $this->brandListingMeta($cat, $brand, $c_name, $data);

                $b_parent_id = DB::table('gc_cat')->where('id', $cat)->select(['id', 'parent_id'])->first();
                $cat_parent_id = $b_parent_id->parent_id;

                if ($return === false && isset($cat_parent_id)) {
                        $return = $this->brandListingMeta($cat_parent_id, $brand, $c_name, $data);
                        if ($return === true) {
                            $has_meta = true;
                        }
                } else {
                    $has_meta = true;
                }
            }

            if ($has_meta === false) {
                if (in_array($cat, config("vendor.comparitive_category"))) {
                    $meta = $this->getMeta('meta.list.comp', $brand, unslug($cname));
                } else {
                    $meta = $this->getMeta('meta.list.non', $brand, unslug($cname));
                }
            }


            if (isset($meta) && !empty($meta)) {
                if (isset($meta->description)) {
                    $seo->setDescription($meta->description);
                }
                if (isset($meta->title)) {
                    $seo->setTitle($meta->title);
                }

                if (isset($meta->h1)) {
                    $seo->setHeading($meta->h1);
                } else {
                    $seo->setHeading(ucwords($brand) . " " . ucwords(unslug($cname)) . " Price List in India");
                }

                $data['facets']->categories = "";
            }
        } elseif ($request->has('h1')) {
            $seo->setHeading($request->h1);
        } else {
            if ($cname == 'cameras-dslrs-more') {
                $seo->setHeading("Cameras & DSLRs Price List in India");
            } elseif ($parent == 'books') {
                $seo->setHeading(ucwords(unslug($cname)) . " Books Price List in India");
            } else {
                $seo->setHeading(ucwords(unslug($cname)) . " Price List in India");
            }
        }

        if (isset($cat) && !$request->has('price_filter') && !$request->has('apply_filters')) {
            $list_desc = DB::table('gc_cat')->where('id', $cat)->select(['meta', 'seo_title', 'description'])->first();
            $list_desc = (object)$this->getMeta($list_desc, $brand, $c_name);

            if (!empty($list_desc->meta)) {
                $data['list_desc'] = json_decode($list_desc->meta);
            }

            if (isset($data['list_desc']->keywords) && !empty($data['list_desc']->keywords)) {
                $seo->setKeywords($data['list_desc']->keywords);
            }

            if (isset($data['list_desc']->description) && !empty($data['list_desc']->description)) {
                $seo->setDescription($data['list_desc']->description);
            }

            if (isset($data['list_desc']->short_description) && !empty($data['list_desc']->short_description)) {
                $seo->setShortDescription($data['list_desc']->short_description);
            }

            if (isset($data['list_desc']->text) && !empty($data['list_desc']->text)) {
                $seo->setContent($data['list_desc']->text);
            }

            if (!empty($list_desc->seo_title)) {
                if ($page > 1) {
                    $seo->setTitle("Page - " . $page . " | " . $list_desc->seo_title);
                } else {
                    $seo->setTitle($list_desc->seo_title);
                }

            }

            if (!empty($data['list_desc']->h1)) {
                $seo->setHeading($data['list_desc']->h1);
            }
        }

        $route = $request->route()->getName();

        if ($request->meta_data) {
            $data = array_merge($data, $request->meta_data);
        }

        if (config('static_meta.routes.' . $route)) {
            $static_meta = (array)$this->getMeta('static_meta.routes.' . $route, $brand, $c_name);
            $data = array_merge($data, $static_meta);
            $seo->setMetaData($static_meta);
        }

        //if (!isset($brand) && $parent && !isset($data['list_desc']) &&  array_key_exists($parent, config("meta.list.group"))) {
        if (empty($brand) && $parent && array_key_exists($parent, config("meta.list.group"))) {
            $meta = $this->getMeta('meta.list.group.' . $parent, '', $c_name);
        }

        if ($request->has('description') || $request->has('title')) {
            $seo->setDescription($request->input('description'));
            $seo->setTitle($request->input('title'));
            $seo->setContent($request->input('text'));
            $seo->setKeywords($request->input('keyword'));
            $seo->setHeading($request->input('h1'));
        }

        if (isset($meta) && is_object($meta)) {
            foreach ($meta as $key => $value) {
                if (!$seo->has($key)) {
                    $function = "set" . ucfirst($key);
                    $seo->{$function}($value);
                }
            }
        }

        if (isset($data['h1'])) {
            $seo->setHeading($data['h1']);
        }
        $seo->setVars($vars);
    }

    public function seoData()
    {
    }

    public function processMetaByRoute()
    {
        if (!is_null(request()->route())) {
            $route = request()->route()->getName();

            if (array_key_exists($route, config('meta.routes'))) {
                $metas = $this->getMeta('meta.routes.' . $route);

                foreach (request()->route()->parameters() as $parameter => $value) {
                    foreach ($metas as $key => $meta) {
                        $metas[$key] = preg_replace('/{' . $parameter . '}/', $value, $meta);
                    }
                }

                $this->seo->setMetaData($metas);
            }
        }
    }

    public function brandListingMeta($cat_id, $brand, $c_name, &$data)
    {
        $listing = BrandListing::select([
            'title',
            'keywords',
            'short_description',
            'description',
            'h1',
            'table_heading',
            'content'
        ])->forCategory($cat_id)->first();

        if (!is_null($listing)) {
            $listing = (object)$listing->toArray();
            $listing = $this->getMeta($listing, $brand, $c_name);

            $this->seo->setMetaData((array)$listing);
            $data['custom_page_meta']['table_heading'] = $listing->table_heading;

            return true;
        }

        return false;

    }
}

?>