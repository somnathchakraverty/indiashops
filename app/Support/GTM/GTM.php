<?php
namespace indiashopps\Support\GTM;

use indiashopps\Http\Controllers\v3\ProductController;
use indiashopps\Support\SEO\SeoData;

Class GTM
{
    public function processPageInformation()
    {
        if (env('APP_ENV') == 'production') {
            $this->addGTMScripts();
        }
    }

    private function getGTMAttributes($var)
    {
        $route = request()->route()->getName();

        $attributes = [
            "isregistered" => (auth()->check()) ? 1 : 0,
            "uid"          => session()->getId(),
            "url"          => request()->url(),
            "page_title"   => (app('seo') instanceof SeoData) ? app('seo')->getTitle() : 'NULL'
        ];

        $mapping         = config('gtm.attribute_mapping.' . $route);
        $page_attributes = config('gtm.attributes.' . $mapping);

        if (is_null($page_attributes)) {
            $page_attributes = [];
        }

        $attributes = array_merge($attributes, config('gtm.attributes.all'));
        $attributes = array_merge($attributes, config('gtm.attributes.common'));

        foreach (config('gtm.attributes.common') as $attribute => $attr) {
            switch ($attr) {
                case "page_type";

                    $attributes[$attribute] = pageType($route);
                    break;

                default:
                    $attributes[$attribute] = $attr;
                    break;
            }
        }

        switch ($route) {
            case 'product_detail_v2':
            case 'product_detail_non_book':
            case 'product_detail_non':

                if (isset($var['product'])) {
                    $product = $var['product'];
                } else {
                    break;
                }

                foreach ($page_attributes as $attribute => $field) {

                    switch ($field) {
                        case 'image_url':
                            $attributes[$attribute] = getImageNew($product->image_url, "M");
                            break;

                        case 'product_type':

                            $attributes[$attribute] = isComparativeProduct($product) ? 'comparative' : 'non-comparative';
                            break;

                        case 'lp_vendor':

                            if (isset($product->{$field})) {
                                $attributes[$attribute] = config('vendor.name.' . $product->{$field});
                            }
                            break;

                        case 'vendor':
                            $attributes[$attribute] = count($product->vendor);
                            break;

                        default:

                            $attributes[$attribute] = $product->{$field};
                    }
                }

                break;

            default:
                foreach ($page_attributes as $attribute => $field) {

                    if (isset($var[$field])) {
                        $attributes[$attribute] = $var[$field];
                    }
                }
                break;
        }

        return $attributes;
    }

    private function addGTMScripts()
    {
        $footer = <<<EOD
                <!-- Google Tag Manager -->
                <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','GTM-KSRH3K9');</script>
                <!-- End Google Tag Manager -->
EOD;

        if ($var = config('gtm.page_variables')) {
            $attributes[] = $this->getGTMAttributes($var);
            $attributes   = json_encode($attributes);
            $header       = <<<EX
                <!-- Data layer -->
                <script>dataLayer = {$attributes}</script>
                <!-- End Data Layer -->
EX;
            $body         = <<<EX
                <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KSRH3K9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
EX;

            app('config')->set('html.content.head', [$header, $footer]);
            app('config')->set('html.content.body', [$body]);
        }

    }
}

?>