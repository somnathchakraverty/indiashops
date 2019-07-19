<?php

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Home', newUrl('/'));
});

// Home > About
Breadcrumbs::register('about', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('About', newUrl('about'));
});

Breadcrumbs::register('aboutus_v2', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('About');
});

Breadcrumbs::register('privacy_policy', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Privacy & Policies');
});

Breadcrumbs::register('coupon_search', function ($breadcrumbs) {
    $breadcrumbs->parent('coupons');
    $breadcrumbs->push('Search Results : ' . request()->get('search_text'));
});

Breadcrumbs::register('mobile_review_page', function ($breadcrumbs, $slug, $id) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Reviews : ' . unslug($slug));
});

// Home > About
Breadcrumbs::register('career', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Career', newUrl('career'));
});

Breadcrumbs::register('contact', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Contact Us', newUrl('contact'));
});

Breadcrumbs::register('fk_loyality', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Flipkart Plus Loyality Program');
});

Breadcrumbs::register('flipkart-sale', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('FlipKart Freedom Sale');
});

Breadcrumbs::register('bbillion-sale', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('FlipKart Big Billion day Sale');
});

Breadcrumbs::register('sitemap_v2', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Sitemap');
});

Breadcrumbs::register('coupons', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Coupons', newUrl('coupons'));
});

Breadcrumbs::register('coupons_v2', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Coupons', newUrl('coupons'));
});

Breadcrumbs::register('vendor_page_v2', function ($breadcrumbs, $vendor) {
    $breadcrumbs->parent('coupons');
    $breadcrumbs->push(ucwords($vendor) . ' Coupons');
});

Breadcrumbs::register('category_page_v2', function ($breadcrumbs, $cat) {
    $breadcrumbs->parent('coupons');
    $breadcrumbs->push(ucwords($cat) . ' Coupons');
});

Breadcrumbs::register('search', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Search', newUrl('coupons'));
});

Breadcrumbs::register('thankyou', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Thank You', newUrl('coupons'));
});

Breadcrumbs::register('register', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('New User', newUrl('user/register'));
});

Breadcrumbs::register('login', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Login', newUrl('user/login'));
});

Breadcrumbs::register('myaccount', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('My Account', newUrl('myaccount'));
});

Breadcrumbs::register('reset', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Reset Password', newUrl('user/resetPassword'));
});

Breadcrumbs::register('couponlist', function ($breadcrumbs, $vendor) {
    $breadcrumbs->parent('coupons');
    $breadcrumbs->push(ucfirst($vendor), newUrl('coupon/couponlist'));
});

Breadcrumbs::register('c_search', function ($breadcrumbs) {
    $breadcrumbs->parent('coupons');
    $breadcrumbs->push("Search", newUrl('/coupons'));
});

Breadcrumbs::register('category_list', function ($breadcrumbs, $category) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(ucwords($category), url($category));
});

Breadcrumbs::register('couponcat', function ($breadcrumbs, $category) {
    $breadcrumbs->parent('coupons');
    $category = explode("-coupons.html", $category)[0];
    $category = helper::decode_url($category);
    $breadcrumbs->push(ucwords($category), newUrl('coupon/couponlistcategory'));
});

Breadcrumbs::register('coupondetail', function ($breadcrumbs, $name, $promo) {
    $breadcrumbs->parent('coupons');
    $breadcrumbs->push(unslug($name), newUrl('coupon/$name/$promo'));
});

Breadcrumbs::register('compare-products', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Compare Products', newUrl('compare-products'));
});

Breadcrumbs::register('compare-mobiles', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Compare Mobiles', newUrl('compare-mobiles'));
});

Breadcrumbs::register('bestphones', function ($breadcrumbs, $price) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Best Phone Under Rs.' . $price, newUrl('mobiles'));
});

Breadcrumbs::register('bbetphones', function ($breadcrumbs, $min, $max) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Best Phone Between Rs.' . $min . ' - Rs.' . $max, newUrl('mobiles'));
});

Breadcrumbs::register('sports_shoes', function ($breadcrumbs, $brand, $group) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($brand . ' sports shoes for ' . $group);
});
Breadcrumbs::register('smartphone', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push("mobile", newUrl('mobile'));
    $breadcrumbs->push("smartphone");
});
Breadcrumbs::register('dual_sim', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push("mobile", newUrl('mobile'));
    $breadcrumbs->push("dual sim phones");
});
Breadcrumbs::register('windows_phones', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push("mobile", newUrl('mobile'));
    $breadcrumbs->push("windows phones");
});
Breadcrumbs::register('android_phones', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push("mobile", newUrl('mobile'));
    $breadcrumbs->push("android phones");
});
Breadcrumbs::register('bbphones', function ($breadcrumbs, $brand, $price) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Best ' . $brand . ' Phone Under Rs.' . $price, newUrl('mobiles'));
});

Breadcrumbs::register('category', function ($breadcrumbs, $name) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(unslug($name), newUrl(create_slug($name)));
});

Breadcrumbs::register('sub_category', function ($breadcrumbs, $p_name, $cname) {

    if ($cname == "mobiles-price-list-in-india" || $cname == "mobiles") {
        $name = "mobile list";
    } else {
        $name = $cname;
    }
    $name = str_replace("Price List In India","",unslug($name));

    $breadcrumbs->parent('category', ucwords($p_name), ucwords($cname));
    $name = str_replace("hp", "HP", $name);
    $name = str_replace("htc", "HTC", $name);
    $name = str_replace("lg", "LG", $name);
    $breadcrumbs->push(clear_url($name), newUrl(seoUrl(create_slug($p_name) . "/" . create_slug($cname))));
});

Breadcrumbs::register('category_all_brands', function ($breadcrumbs, $p_name, $cname) {
    $breadcrumbs->parent('sub_category', $p_name, $cname);
    $breadcrumbs->push("All Brands ");
});

Breadcrumbs::register('amp.sub_category', function ($breadcrumbs, $p_name, $cname) {

    if ($cname == "mobiles-price-list-in-india" || $cname == "mobiles") {
        $name = "mobile list";
    } else {
        $name = $cname;
    }
    $breadcrumbs->parent('amp.category_list', $p_name);
    $breadcrumbs->push(unslug($name), categoryLink([cs($p_name), cs($cname)]));
});
Breadcrumbs::register('product_list', function ($breadcrumbs, $p_name, $child, $cname) {
    $breadcrumbs->parent('sub_category', ucwords($p_name), $child);
    $breadcrumbs->push(clear_url($cname), newUrl(seoUrl(create_slug($p_name) . "/" . create_slug($child) . "/" . create_slug($cname))));
});

Breadcrumbs::register('amp.product_list', function ($breadcrumbs, $p_name, $child, $cname) {
    $breadcrumbs->parent('amp.sub_category', $p_name, $child);
    $breadcrumbs->push(unslug($cname), categoryLink([cs($p_name), cs($child), cs($cname)]));
});

Breadcrumbs::register('amp.category_list', function ($breadcrumbs, $category) {
    $breadcrumbs->parent('amp_home');
    $breadcrumbs->push(ucwords($category), route('amp.category_list', [$category]));
});

Breadcrumbs::register('amp.brands.listing', function ($breadcrumbs, $group, $brand, $category) {
    if (session()->has('second_category_bread')) {
        $breadcrumbs->parent('amp.product_list', $group, cs(session()->get('second_category_bread')[0]), $category);
    } elseif (session()->has('first_category_bread')) {
        $breadcrumbs->parent('amp.sub_category', $group, $category);
    } else {
        $breadcrumbs->parent('amp.category_list', $group);
    }
    $breadcrumbs->push(strtoupper($brand) . " " . unslug($category), route('amp.brands.listing', [
        cs($group),
        cs($brand),
        cs($category)
    ]));
});


/*************Custom Links**************************************/
Breadcrumbs::register('listing', function ($breadcrumbs, $group, $category) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push("List of $group " . reverse_slug($category));
});

Breadcrumbs::register('list_of_men_women', function ($breadcrumbs, $group, $category, $keyword) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push("List of " . ucwords($group) . " " . unslug($category), newUrl(create_slug("list of $group $category")));
    $breadcrumbs->push(unslug($keyword));
});

Breadcrumbs::register('list_of_category', function ($breadcrumbs, $category, $keyword) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push("List of " . reverse_slug($category));
    $breadcrumbs->push(reverse_slug($keyword));
});
/*************Custom Links**************************************/


Breadcrumbs::register('p_detail', function ($breadcrumbs, $product, $brand = 0) {

    if (empty($product->parent_category)) {
        $parent = $product->grp;
    } else {
        $parent = $product->parent_category;
    }

    $child = $product->category;

    if ($parent == $product->grp && $product->grp == $product->category) {
        $breadcrumbs->parent('category', ucwords($parent));
    } else {
        if (!empty($product->grp) && (strtolower($parent) != strtolower($product->grp))) {
            $breadcrumbs->parent('product_list', ucwords($product->grp), $parent, $child);
        } else {
            $breadcrumbs->parent('sub_category', ucwords($parent), $child);
        }
        try {
            if (isset($product->brand) && !empty($product->brand)  && $brand >= 5) { //&& $product->grp != 'books'
                $c_brand = ucfirst($product->brand);

                if (in_array($product->grp, config('listing.brand.groups'))) {
                    $breadcrumbs->push(clear_url($c_brand . " " . $child), route('brands.listing', [
                        cs($product->grp),
                        cs($product->brand),
                        cs($product->category)
                    ]));
                } elseif ($parent == $product->grp) {
                    $breadcrumbs->push(clear_url($c_brand . " " . $child), route('brand_category_list_comp_1', [
                        cs($product->brand),
                        cs($product->category),
                        $product->category_id
                    ]));
                } else {
                    $url = route('brand_category_list', [
                        cs($product->brand),
                        cs($product->grp),
                        cs($product->category)
                    ]);
                    $breadcrumbs->push(clear_url($c_brand . " " . $child), $url);
                }
            }
        }
        catch (\Exception $e) {
            if (isset($product->brand) && !empty($product->brand) && $product->grp != 'books' && $brand >= 5) {
                $c_brand = ucfirst($product->brand);
                if ($parent == $product->grp) {
                    $breadcrumbs->push(clear_url($c_brand . " " . $child), newUrl(seoUrl(create_slug($parent) . "/" . create_slug($product->brand) . "--" . create_slug($child))));
                } else {
                    $breadcrumbs->push(clear_url($c_brand . " " . $child), newUrl(seoUrl(create_slug($product->grp) . "/" . create_slug($parent) . "/" . create_slug($product->brand) . "--" . create_slug($child))));
                }
            }
        }
    }

    $breadcrumbs->push(clear_url($product->name), newUrl('product/' . $product->name . "/" . $product->id));
});

Breadcrumbs::register('p_detail_new', function ($breadcrumbs, $product, $brand = 0) {
    if (empty($product->parent_category)) {
        $parent = $product->grp;
    } else {
        $parent = $product->parent_category;
    }

    $child = $product->category;

    if (!empty($product->grp) && ($parent != $product->grp)) {
        $breadcrumbs->parent('product_list', ucwords($product->grp), $parent, $child);
    } else {
        $breadcrumbs->parent('sub_category', ucwords($parent), $child);
    }

    if (isset($product->brand) && !empty($product->brand) && $brand >= 5) {
        if (strtolower($product->brand) == "lg" || strtolower($product->brand) == "htc" || strtolower($product->brand) == "hp") {
            $c_brand = strtoupper($product->brand);
        } else {
            $c_brand = ucfirst($product->brand);
        }

        if ($parent == $product->grp) {
            $breadcrumbs->push(clear_url($c_brand . " " . $child), newUrl(seoUrl(create_slug($parent) . "/" . create_slug($product->brand) . "--" . create_slug($child))));
        } else {
            $breadcrumbs->push(clear_url($c_brand . " " . $child), newUrl(seoUrl(create_slug($product->grp) . "/" . create_slug($parent) . "/" . create_slug($product->brand) . "--" . create_slug($child))));
        }
    }
    if ($product->category_id == 351) {
        $breadcrumbs->push(clear_url($product->name) . " Mobile Phone", newUrl('product/detail/' . $product->name . "/" . $product->id));
    } else {
        $breadcrumbs->push(clear_url($product->name), newUrl('product/detail/' . $product->name . "/" . $product->id));
    }
});
Breadcrumbs::register('p_detail_amp', function ($breadcrumbs, $product) {
    // dd($product);

    if (empty($product->parent_category)) {
        $parent = $product->grp;
    } else {
        $parent = $product->parent_category;
    }

    $child = $product->category;
    $breadcrumbs->push("amp", "amp");

    if ($parent == $product->grp && $product->grp == $product->category) {
        $breadcrumbs->parent('category', ucwords($parent));
    } else {
        if (!empty($product->grp) && ($parent != $product->grp)) {
            $breadcrumbs->parent('product_list', $product->grp, $parent, $child);
        } else {
            $breadcrumbs->parent('sub_category', ucwords($parent), $child);
        }

        if (isset($product->brand) && !empty($product->brand) && $product->grp != 'books') {
            $c_brand = ucfirst($product->brand);
            if ($parent == $product->grp) {
                $breadcrumbs->push(clear_url($c_brand . " " . $child), newUrl(seoUrl(create_slug($parent) . "/" . create_slug($product->brand) . "--" . create_slug($child))));
            } else {
                $breadcrumbs->push(clear_url($c_brand . " " . $child), newUrl(seoUrl(create_slug($product->grp) . "/" . create_slug($parent) . "/" . create_slug($product->brand) . "--" . create_slug($child))));
            }
        }
    }

    $breadcrumbs->push(clear_url($product->name), newUrl('product/' . $product->name . "/" . $product->id));
});
Breadcrumbs::register('p_detail_new_amp', function ($breadcrumbs, $product) {
    if (empty($product->parent_category)) {
        $parent = $product->grp;
    } else {
        $parent = $product->parent_category;
    }

    $child = $product->category;
    $breadcrumbs->push("amp", "amp");
    if (!empty($product->grp) && ($parent != $product->grp)) {
        $breadcrumbs->parent('product_list', $product->grp, $parent, $child);
    } else {
        $breadcrumbs->parent('sub_category', ucwords($parent), $child);
    }

    if (isset($product->brand) && !empty($product->brand)) {
        if (strtolower($product->brand) == "lg" || strtolower($product->brand) == "htc" || strtolower($product->brand) == "hp") {
            $c_brand = strtoupper($product->brand);
        } else {
            $c_brand = ucfirst($product->brand);
        }

        if ($parent == $product->grp) {
            $breadcrumbs->push(clear_url($c_brand . " " . $child), newUrl(seoUrl(create_slug($parent) . "/" . create_slug($product->brand) . "--" . create_slug($child))));
        } else {
            $breadcrumbs->push(clear_url($c_brand . " " . $child), newUrl(seoUrl(create_slug($product->grp) . "/" . create_slug($parent) . "/" . create_slug($product->brand) . "--" . create_slug($child))));
        }
    }
    if ($product->category_id == 351) {
        $breadcrumbs->push(clear_url($product->name) . " Mobile Phone", newUrl('product/detail/' . $product->name . "/" . $product->id));
    } else {
        $breadcrumbs->push(clear_url($product->name), newUrl('product/detail/' . $product->name . "/" . $product->id));
    }

});

Breadcrumbs::register('discontinue_amp', function ($breadcrumbs, $name) {
    $breadcrumbs->push("amp", "amp");
    $breadcrumbs->parent('amp_home');
    $breadcrumbs->push($name . ' Discontinued');
});

Breadcrumbs::register('amp_home', function ($breadcrumbs) {
    $breadcrumbs->push("Home", route('amp.home'));
});

Breadcrumbs::register('trending', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Hot Trending Products', newUrl('hot-trending-products'));
});

Breadcrumbs::register('all-cat', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Categories', newUrl('hot-trending-products'));
});
Breadcrumbs::register('amazon-sale', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Amazon:: Great India Sale', newUrl('hot-trending-products'));
});

Breadcrumbs::register('upcoming_mobiles', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Upcoming Mobiles');
});

/*************Brand Category Page**************************************/
Breadcrumbs::register('brand_category_list', function ($breadcrumbs, $brand, $group, $category) {

    $cat = \indiashopps\Category::whereGroupName($group)->whereName($category)->with('parent')->first();

    if (!is_null($cat)) {
        if (strcasecmp($cat->group_name, $cat->parent->name) == 0) {
            $breadcrumbs->parent('sub_category', $cat->parent->name, $cat->name);
        } else {
            $breadcrumbs->parent('product_list', $cat->group_name, $cat->parent->name, $cat->name);
        }
    } else {
        $breadcrumbs->parent('home');
    }

    $breadcrumbs->push(strtoupper($brand) . " " . unslug($group) . " " . unslug($category));
});

Breadcrumbs::register('brands.listing', function ($breadcrumbs, $group, $brand, $category) {
    if (session()->has('second_category_bread')) {
        $breadcrumbs->parent('product_list', $group, session()->get('second_category_bread')[0], $category);
    } elseif (session()->has('first_category_bread')) {
        $breadcrumbs->parent('sub_category', $group, $category);
    } else {
        $breadcrumbs->parent('category', $group);
    }
    $breadcrumbs->push(strtoupper($brand) . " " . str_replace("Price List In India","",unslug($category)), \Request::url());
});

Breadcrumbs::register('brand_category_list_comp', function ($breadcrumbs, $brand, $category, $cat_id) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(strtoupper($brand) . " " . unslug($category));
});
Breadcrumbs::register('brand_category_list_comp_1', function ($breadcrumbs, $brand, $category, $cat_id) {
    $cat = \indiashopps\Category::with('parent')->find($cat_id);

    if (strcasecmp($cat->group_name, $cat->parent->name) == 0) {
        $breadcrumbs->parent('sub_category', $cat->parent->name, $cat->name);
    } else {
        $breadcrumbs->parent('product_list', $cat->group_name, $cat->parent->name, $cat->name);
    }

    //$breadcrumbs->parent('home');
    $breadcrumbs->push(strtoupper($brand) . " " . unslug($category));
});

Breadcrumbs::register('amp.brand_category_list', function ($breadcrumbs, $brand, $group, $category) {
    $breadcrumbs->parent('brand_category_list', $brand, $group, $category);
});

Breadcrumbs::register('amp.brand_category_list_comp', function ($breadcrumbs, $brand, $category, $cat_id) {
    $breadcrumbs->parent('brand_category_list_comp', $brand, $category, $cat_id);
});
Breadcrumbs::register('amp.brand_category_list_comp_1', function ($breadcrumbs, $brand, $category, $cat_id) {
    $breadcrumbs->parent('brand_category_list_comp_1', $brand, $category, $cat_id);
});

Breadcrumbs::register('custom_page_list', function ($breadcrumbs, $slug) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(unslug($slug) . " Price list in India");
});

Breadcrumbs::register('custom_page_list_v3', function ($breadcrumbs, $group, $slug) {
    $breadcrumbs->parent('category', $group);
    $breadcrumbs->push(unslug($slug));
});

Breadcrumbs::register('search_new', function ($breadcrumbs, $search_text = '') {
    $breadcrumbs->parent('home');
    $breadcrumbs->push("SEARCH:: " . $search_text);
});

Breadcrumbs::register('most-compared', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Most Compared Phones');
});

Breadcrumbs::register('cashback.earnings', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('My Earnings');
});
Breadcrumbs::register('cashback.withdraw', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Withdraw');
});
Breadcrumbs::register('cashback.missing', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Missing Cashback');
});
Breadcrumbs::register('cashback.missing.claim', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Missing Cashback Claim');
});
Breadcrumbs::register('cashback.settings', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Profile Setting');
});
Breadcrumbs::register('cashback.claim.detail', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Claim Detail');
});
Breadcrumbs::register('cashback.users', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Users');
});
Breadcrumbs::register('cashback.users.create', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('New User');
});
Breadcrumbs::register('cashback.purchase.orders', function ($breadcrumbs, $order_id = 0) {
    $breadcrumbs->parent('home');
    if (empty($order_id)) {
        $breadcrumbs->push('Purchase Orders');
    } else {
        $breadcrumbs->push('Purchase Orders Detail');
    }
});