<?php
namespace indiashopps\Traits;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 *
 */
Trait Redirects
{
    /**
     * @param Request $request
     * @param $parent
     * @param $cname
     * @param $child
     * @param $page
     * @return RedirectResponse|boolean
     */
    public function checkCategoryRedirects(Request $request, $parent, $cname, $child, $page)
    {
        $parent_id = false; // Parent ID is made false for the search page, so that it doesn't redirect..
        $cat       = false;

        if ($page > 900) {
            if ($child) {
                return redirect(categoryLink([$parent, $child, $cname]), 301);
            } else {
                return redirect(categoryLink([$parent, $cname]), 301);
            }
        }

        /**********************Redirects SEO Purpose****************************************/
        if ($parent == 'home') {
            return redirect(url('home-decor/' . $cname), 301);
        }
        if ($cname == 'sports-shoe-price-list-in-india') {
            return redirect(url($parent . '/shoes/sports-shoes-price-list-in-india.html'), 301);
        } else {
            if ($cname == 'led-price-list-in-india') {
                return redirect(url($parent . '/lcd-led-tvs/led-tv-price-list-in-india.html'), 301);
            } else {
                if ($cname == 'plasma-price-list-in-india') {
                    return redirect(url($parent . '/lcd-led-tvs/led-tv-price-list-in-india.html'), 301);
                } else {
                    if ($cname == 'lcd-price-list-in-india') {
                        return redirect(url($parent . '/lcd-led-tvs/led-tv-price-list-in-india.html'), 301);
                    } else {
                        if ($cname == 'security-systems-price-list-in-india') {
                            return redirect(url($parent . '/security-system-gadgets-price-list-in-india.html'), 301);
                        } else {
                            if ($cname == 'mobile-chargers-price-list-in-india') {
                                return redirect(url($parent . '/mobile-accessories/chargers-price-list-in-india.html'),
                                    301);
                            } else {
                                if ($cname == 'mobile-battery-price-list-in-india') {
                                    return redirect(url($parent . '/mobile-accessories/battery-price-list-in-india.html'),
                                        301);
                                } else {
                                    if ($cname == 'smart-watches-price-list-in-india' and $parent == "mobile") {
                                        return redirect(url('electronics/smart-wearable/smart-watches-price-list-in-india.html'),
                                            301);
                                    } else {
                                        if ($cname == 'smart-bands-price-list-in-india' and $parent == "mobile") {
                                            return redirect(url('electronics/smart-wearable/smart-bands-price-list-in-india.html'),
                                                301);
                                        } else {
                                            if ($cname == 'networking-price-list-in-india' and $parent == "computers") {
                                                return redirect(url('computers/networking-devices-price-list-in-india.html'),
                                                    301);
                                            } else {
                                                if ($cname == 'gear-price-list-in-india' and $parent == "kids") {
                                                    return redirect(url('kids/baby-gear-price-list-in-india.html'),
                                                        301);
                                                } else {
                                                    if ($cname == 'accessories-price-list-in-india' and $parent == "kids") {
                                                        return redirect(url('kids/kid-accessories-price-list-in-india.html'),
                                                            301);
                                                    } else {
                                                        if ($cname == 'sports-price-list-in-india' and $parent == "sports-fitness") {
                                                            return redirect(url('sports-fitness/sports-products-goods-price-list-in-india.html'),
                                                                301);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($child == "networking" and $parent == "computers") {
            return redirect(url($parent . '/networking-devices/' . $cname . ".html"), 301);
        } elseif ($child == "gear" and $parent == "kids") {
            return redirect(url($parent . '/baby-gear/' . $cname . ".html"), 301);
        } elseif ($child == "accessories" and $parent == "kids") {
            return redirect(url($parent . '/kid-accessories/' . $cname . ".html"), 301);
        } elseif ($child == "sports" and $parent == "sports-fitness") {
            return redirect(url($parent . '/sports-products-goods/' . $cname . ".html"), 301);
        } elseif ($cname == "lifestyle-price-list-in-india" and $parent == "lifestyle") {
            return redirect(url($parent), 301);
        } elseif ($cname == "lehnga-price-list-in-india") {
            return redirect(url($parent . '/' . $child . "/lehenga-price-list-in-india.html"), 301);
        } elseif ($cname == "fragrances-price-list-in-india") {
            return redirect(url($parent . "/fragrance-price-list-in-india.html"), 301);
        } elseif ($child == "fragrances" && $cname == "perfumes-price-list-in-india") {
            return redirect(url($parent . "/fragrance/perfumes-price-list-in-india.html"), 301);
        } elseif ($child == "fragrances" && $cname == "deodorants-price-list-in-india") {
            return redirect(url($parent . "/fragrance/deodorants-price-list-in-india.html"), 301);
        }

        if ($child) {
            $key = $parent . "/" . $child . "/" . $cname;

            if (array_key_exists($key, config('redirects'))) {
                return redirect(config('redirects.' . $key), 301);
            }
        } else {
            $key = $parent . "/" . $cname;

            if (array_key_exists($key, config('redirects'))) {
                return redirect(config('redirects.' . $key), 301);
            }
        }
        $target = $cname;
        /**********************Redirects SEO Purpose****************************************/
        if ($parent == 'product' || $parent == 'coupon' || $parent == 'cdn-cgi' || $parent == 'category') {
            \Log::notice('Redirects SEO Purpose');
            abort(404);
        }

        //Checks whether SEO URL is enabled or not and redirect according to the listing page.
        if (config('app.seoEnable') && $parent) {
            $cname = explode(config('app.seoURL'), $cname);

            if (!isset($cname[1])) {

                if (isset($child) && !empty($child)) {
                    return redirect('/' . $parent . "/" . $child . "/" . $cname[0] . config('app.seoURL') . ".html",
                        301);
                } else {
                    return redirect('/' . $parent . "/" . $cname[0] . config('app.seoURL') . ".html", 301);
                }
            } else {
                $data['cname'] = $cname = $cname[0];
            }
        } else {
            $data['cname'] = $cname = explode(config('app.seoURL'), $cname);

            if (isset($cname[1])) {
                return redirect('/' . $parent . "/" . $cname[0], 301);
            }

            $data['cname'] = $cname = $cname[0];
        }
        $data['parent'] = $data['parent'] = $parent;
        $data['child']  = $data['child'] = $child;
        //print_r($parent);echo "<br>cname - ";print_r($cname);echo "<br>child - ";print_r($child);exit;

        /// GET the category IDs with CATEGORY Name ( Third Level Categories )
        if ($parent && $child && $cname) {

            $parts = explode("--", $cname);

            if (isset($parts[1]) && !empty($parts[1])) {

                $data['cat'] = $cat = $this->getCatIDByName($parts[1], $parent_id);

                return redirect(trim(route('brand_category_list', [$parts[0], $parent, $parts[1]]), '-'), 301);
            }

            $parent_id   = $this->getCatIDByName($parent);
            $child_id    = $this->getCatIDByName($child, $parent_id);
            $cat         = $this->getCatIDByName($cname, $child_id);
            $data['cat'] = $cat;

        } /// GET the category IDs with CATEGORY Name ( Second Level Categories )
        elseif ($parent && $cname) {
            $parts             = explode("--", $cname);
            $parent_id         = $this->getCatIDByName($parent);
            $data['parent_id'] = $parent_id;

            if (isset($parts[1]) && !empty($parts[1])) {
                if ($parts[0] == "smartphone") {
                    $data['filters']['type'] = "Smartphone";
                } elseif ($parts[0] == "dual-sim-phones") {
                    $data['filters']['SIM_type'] = "Dual";
                } elseif ($parts[0] == "android_phones") {
                    $data['filters']['OS'] = "Android";
                } elseif ($parts[0] == "windows_phones") {
                    $data['filters']['OS'] = "Windows";
                } else {
                    $data['cat'] = $cat = $this->getCatIDByName($parts[1], $parent_id);

                    return redirect(trim(route('brand_category_list_comp_1', [$parts[0], $parts[1], $cat]), '-'), 301);
                }

                $data['cname'] = $cname = $parts[1];
            }

            $data['cat'] = $cat = $this->getCatIDByName($cname, $parent_id);
            $c           = $this->getParentName($cname, $parent, 0, $request);

            if (is_null($cat) && isset($c->name)) {
                $c           = $this->getCatIDByName($c->name, $parent_id);
                $data['cat'] = $cat = $this->getCatIDByName($cname, $c);
            }
        }
        if (empty($parent_id) && empty($parent_id) && empty($cat) && !in_array($request->route()->getName(),
                ['search_new', 'list_of_men_women', 'list_of_category']) && !$request->has('search_text') ) {
            abort(404);
        }

        if (($parent_id || isset($child_id)) && empty($cat)) {

            if ($request->has('debug')) {
                \Log::error("Error: Category ID Not Found");
            }

            abort(404);
        }

        return $data;
    }
}

?>