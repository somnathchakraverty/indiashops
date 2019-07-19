<?php
namespace indiashopps\Support\SEO;

use DB;
use Carbon\Carbon;
use indiashopps\Category;
use indiashopps\Models\BrandDesc;

/**
 * @method $this setHeading(string $h1);
 * @method $this setSubHeading(string $h2);
 * @method $this setTitle(string $title);
 * @method $this setDescription(string $description);
 * @method $this setKeywords(string $keywords);
 * @method $this setShortDescription(string $short_description);
 * @method $this setContent(string $content);
 * @method $this setExcerpt(string $content);
 * @method string getHeading();
 * @method string getSubHeading();
 * @method string getTitle();
 * @method string getDescription();
 * @method string getKeywords();
 * @method string getContent();
 * @method string getShortDescription();
 * @method $this getExcerpt();
 *
 */
Class SeoData
{
    private $h1;
    private $h2;
    private $title;
    private $description;
    private $keywords;
    private $short_description;
    private $content;
    private $vars;
    private $snippetTitle;
    private $excerpt;

    /**
     * @param $function
     * @param $arguments
     * @return $this|mixed
     */
    public function __call($function, $arguments)
    {
        $variables = [
            'heading',
            'title',
            'description',
            'keywords',
            'short_description',
            'vars',
            'content',
            'excerpt',
            'sub_heading'
        ];
        $parts = preg_split('/set/', $function);

        if (isset($parts[1])) {
            $property = fromCamelCase($parts[1]);

            if (isset($parts[1]) && in_array($property, $variables)) {

                switch ($property) {
                    case "heading":
                        $this->h1 = collect($arguments)->first();
                        break;

                    case "sub_heading":
                        $this->h2 = collect($arguments)->first();
                        break;

                    default :
                        $this->{$property} = collect($arguments)->first();
                        break;
                }

                return $this;
            }
        }

        $parts = preg_split('/get/', $function);

        if (isset($parts[1])) {
            $property = fromCamelCase($parts[1]);

            if (isset($parts[1])) {
                switch ($property) {
                    case "heading":
                        $value = $this->h1;
                        break;

                    case "sub_heading":
                        $value = $this->h2;
                        break;

                    default :
                        if (isset($this->{$property})) {
                            $value = $this->{$property};
                        } else {
                            $value = '';
                        }
                        break;
                }

                if (empty($value) && in_array($property, ['title', 'description', "keywords"])) {
                    $value = $this->getDefault($property);
                }

                if (!in_array($property, ['content', 'short_description']) && request()
                        ->route()
                        ->getName() != 'home_v2'
                ) {
                    return preg_replace("/[\"\']+/", "", $value);
                } else {
                    return $value;
                }
            }
        }
    }

    private function getDefault($property)
    {
        if (!is_null($this->vars)) {
            extract($this->vars);
        }

        if (array_key_exists(request()->route()->getName(), config('meta.routes'))) {

            $metas = $this->getStaticMeta('meta.routes.' . request()->route()->getName());

            if (isset($metas[$property])) {
                return $metas[$property];
            }
        }

        $value = '';

        switch ($property) {
            case "title";
                if (request()->route()->getName() == 'home_v2' || request()->route()->getName() == 'amp.home') {
                    $value = "IndiaShopps: Compare Mobiles and Laptops Price in India";
                } elseif (isset($type) && $type = "couponlist") {
                    // echo $vendor_name;exit;
                    if (isset($vendor_name) && $vendor_name == "flipkart") {
                        $value = "Flipkart Coupon Code, Discount Coupons, Promo Codes | Indiashopps";
                    } elseif (isset($vendor_name) && $vendor_name == "amazon") {
                        $value = "Latest Amazon Discount Coupon Code & Promo Codes | Indiashopps";
                    } elseif (isset($vendor_name) && $vendor_name == "paytm") {
                        $value = "Paytm Mobile Recharge Offers & Coupons, Promo Codes | Indiashopps";
                    } else {
                        $value = "Compare Online - Shop for Mobiles, Electronics, Books, Men & Women | IndiaShopps";
                    }
                    $cat = "Mobiles";
                } elseif (empty($cname)) {
                    $value = "Compare Mobiles Phones Price, Features, Specification Online in India | Indiashopps";
                    $cat = "Mobiles";
                } else {
                    if (isset($brand) && !empty($brand)) {
                        if (strtolower($brand) == "lg" || strtolower($brand) == "htc" || strtolower($brand) == "hp") {
                            $value = strtoupper($brand) . " ";
                        } else {
                            $value = ucfirst($brand) . " ";
                        }
                    } else {
                        $value = "";
                    }
                    if (isset($parent) && $parent == 'mobile') {
                        if (empty($child)) {
                            if (strtolower($cname) == "mobiles") {
                                if (isset($brand) && (strtolower($brand) == 'apple')) {
                                    $value = "Apple iPhone Online Price Comparison in India | Indiashopps";
                                } elseif (isset($brand) && (strtolower($brand) == 'htc')) {
                                    $value = "HTC Mobiles Price List in India, Compare & Buy Online  | Indiashopps";
                                } elseif (isset($brand) && (strtolower($brand) == 'micromax')) {
                                    $value = "Micromax Mobiles Price List in India, Compare & Buy Online  | Indiashopps";
                                } elseif (isset($brand) && (strtolower($brand) == 'samsung')) {
                                    $value = "Compare Samsung Smartphone & Mobiles Price List in India | Indiashopps";
                                } elseif (isset($brand) && (strtolower($brand) == 'htc')) {
                                    $value = "HTC Mobiles Price List in India, Compare & Buy Online  | Indiashopps";
                                } elseif (isset($brand) && !empty($brand)) {
                                    $value .= ucfirst($cname) . " Price in India - Compare & Buy Online";
                                } else {
                                    $value = "Latest Mobile Phones Price List in India| Compare & Buy Online";
                                }
                            } elseif (strtolower($cname) == "tablets") {
                                if (isset($brand) && (strtolower($brand) == 'apple')) {
                                    $value = "Apple Ipad Online Price Comparison in India | Indiashopps";
                                } elseif (isset($brand) && (strtolower($brand) == 'samsung')) {
                                    $value = "Samsung Tablets Price List in India, Compare & Buy Online | Indiashopps";
                                } else {
                                    $value .= ucfirst($cname) . " Price in India - Compare & Buy Online";
                                }
                            } else {
                                $value .= ucfirst($cname) . " Price in India - Compare & Buy Online";
                            }
                        } else {
                            //echo $child;exit;
                            if ($child == "headphones-headsets") {
                                $value .= ucfirst($cname) . " Price List in India - Compare Online & Save";
                            } elseif ($child == "tablet-accessories") {
                                $value .= ucfirst(str_replace("-", " ", $child)) . " " . ucfirst($cname) . " Price List in India - Compare Online & Save";
                            } elseif (strtolower($child) == "mobile-accessories" && strtolower($cname) == "microsd memory cards") {
                                $value .= "Compare Price Online 32 GB, 64 GB etc. Micro SD Memory Card | Indiashopps";
                            } elseif (strtolower($child) == "mobile-accessories" && strtolower($cname) == "power banks") {
                                $value .= "Compare and Buy Online Power Banks at Best Prices in India | Indiashopps";
                            } else {
                                $value .= ucfirst($parent) . " " . ucfirst($cname) . " Price List in India - Compare Online & Save";
                            }
                        }
                    } else {
                        if (isset($parent) && ($parent == "men" || $parent == "women" || ($parent == "kids" && (isset($child) && ($child == "boy-clothing" || $child == "girl-clothing" || $child == "boys-footwear" || $child == "girls-footwear"))))) {
                            if ($parent == "kids") {
                                $value .= ucfirst(str_replace("-clothing", "", (str_replace("-footwear", "", $child)))) . " " . ucfirst($cname) . " Price List in India | Buy | Compare Online";
                            } elseif ($parent == "men" && strtolower($cname) == "casual shoes") {
                                $value .= "Explore Men Casual Shoes Price List in India - Compare & Buy Online";
                            } elseif ($parent == "men" && strtolower($cname) == "formal shoes") {
                                $value .= "Compare Online Formal Shoes Prices for Men in India | Indiashopps";
                            } elseif ($parent == "men" && strtolower($cname) == "sports shoes") {
                                $value .= "Compare Online Sports Shoes Price for Men in India | Indiashopps";
                            } elseif ($parent == "women" && strtolower($cname) == "handbags") {
                                $value .= "Compare Online Handbags Price for Women in India | Indiashopps";
                            } elseif ($parent == "women" && strtolower($cname) == "dresses") {
                                $value .= "Compare Girls Dresses Price Online in India | Indiashopps";
                            } elseif ($parent == "women" && strtolower($cname) == "sandals") {
                                $value .= "Compare Sandals Price for Girls Online in India | Indiiashopps";
                            } else {
                                $value .= ucfirst($parent) . " " . ucfirst($cname) . " Price List in India - Compare & Buy Online";
                            }
                        } elseif (isset($parent) && $parent == "electronics") {
                            # code...
                            // echo strtoupper($cname);exit;
                            if (isset($child) && !empty($child)) {
                                if (strtoupper($cname) == "LED TV") {
                                    $value = "Compare Online 32 inch, 40 inch LED TV Price List in India | IndiaShopps";
                                } else {
                                    $value = "Compare Online " . ucfirst($cname) . " Price List in India | IndiaShopps";
                                }
                            } else {
                                $value = "Compare " . ucfirst($cname) . " Price with Specification Online | IndiaShopps";
                            }
                        } elseif (isset($parent) && $parent == "appliances") {
                            # code...
                            if (isset($child) && !empty($child)) {
                                $value = "Compare Online " . ucfirst($cname) . " Price with Features & Specification in India | IndiaShopps";
                            } else {
                                $value = "Compare " . ucfirst($cname) . " Price with Features & Specification Online | IndiaShopps";
                            }
                        } elseif (isset($parent) && $parent == "beauty-health") {
                            # code...
                            if (isset($child) && !empty($child)) {
                                $value = "Compare Online " . ucwords(str_replace("-", " ", $child)) . " " . ucfirst($cname) . " Price, Features with Latest Deals & Offers | IndiaShopps";
                            } else {
                                $value = "Buy " . ucfirst($cname) . " Online with Price Comparison | Lowest Price Store - IndiaShopps";
                            }
                        } elseif (isset($parent) && $parent == "sports-fitness") {
                            # code...
                            if (isset($child) && !empty($child)) {
                                $value = "Compare Online " . ucwords(str_replace("-", " ", $child)) . " " . ucfirst($cname) . " Price, Specification with Latest Deals & Offers | IndiaShopps";
                            } else {
                                $value = "Buy " . ucfirst($cname) . " Online with Price Comparison | Lowest Price Store - IndiaShopps";
                            }
                        } elseif (isset($parent) && $parent == "home-decor") {
                            # code...
                            if (isset($child) && !empty($child)) {
                                $value = "Buy or Compare Online " . ucfirst($cname) . " Price with Latest Deals & Offers | IndiaShopps";
                            } else {
                                $value = "Buy or Compare Price " . ucfirst($cname) . " Online | Best Price Only at IndiaShopps";
                            }
                        } elseif (isset($parent) && $parent == "computers") {
                            # code...
                            if (isset($child) && !empty($child)) {
                                if (strtolower($cname) == "pen drives") {
                                    $value = "Compare Online 16GB, 32GB, 64GB Pen Drives Price List in India | IndiaShopps";
                                } else {
                                    $value = "Compare Online " . ucfirst($cname) . " Price List in India | IndiaShopps";
                                }
                            } else {
                                if (isset($brand) && (strtolower($brand) == 'dell')) {
                                    $value = "Compare Online Dell Laptop Price List in India | Indiashopps";
                                } elseif (isset($brand) && (strtolower($brand) == 'hp')) {
                                    $value = "Compare Online HP Laptop Price List in India | Indiashopps";
                                } elseif (isset($brand) && (strtolower($brand) == 'lenovo')) {
                                    $value = "Compare Online Lenovo Laptop Price List in India | Indiashopps";
                                } else {
                                    //$value = "Compare ".ucfirst($cname)." Price with Features & Full Specification Online | IndiaShopps";
                                    $value = "Compare and Buy Online " . ucfirst($cname) . " at Best Prices in India | Indiashopps";
                                }

                            }
                        } elseif (isset($parent) && $parent == "kids") {
                            # code...
                            if (isset($child) && !empty($child)) {
                                $value = "Buy or Compare Online " . ucfirst($cname) . " Price with Latest Deals & Offers | IndiaShopps";
                            } else {
                                $value = ucfirst($cname) . " Price in India - Compare & Buy Online | Indiashopps";
                            }
                        } elseif (isset($parent) && $parent == "camera") {
                            # code...
                            if (isset($child) && !empty($child)) {
                                $value = "Compare Online " . ucfirst($cname) . " Price, Features &  Full Specification | IndiaShopps";
                            } else {
                                $value = "Compare " . ucfirst($cname) . " Price with Specification Online | IndiaShopps";
                            }
                        } elseif (isset($parent) && $parent == "care") {
                            # code...
                            if (isset($child) && !empty($child)) {
                                $value = "Compare Online " . ucfirst($cname) . " Price, Features with Latest Deals & Offers | IndiaShopps";
                            } else {
                                $value = "Buy " . ucfirst($cname) . " Online with Price Comparison | Lowest Price Store - IndiaShopps";
                            }
                        } elseif (isset($parent) && $parent == "lifestyle") {
                            # code...
                            if (isset($child) && !empty($child)) {
                                $value = "Compare Online " . ucfirst($cname) . " Price, Features with Latest Deals & Offers | IndiaShopps";
                            } else {
                                $value = "Compare Price " . ucfirst($cname) . " Online | Lowest Price Store - IndiaShopps";
                            }
                        } elseif (isset($parent) && $parent == "automotive") {
                            # code...
                            if (isset($child) && !empty($child)) {
                                $value = "Compare Online " . ucfirst($child) . " " . ucfirst($cname) . " Price With Features & Full Specification | IndiaShopps";
                            } else {
                                $value = "Buy & Compare " . ucfirst($cname) . " Essentials Price with Features & Full Specification Online | IndiaShopps";
                            }
                        } elseif (isset($parent) && $parent == "books") {
                            # code...
                            if (isset($child) && !empty($child)) {
                                $value = "Buy or Compare Online " . ucfirst($cname) . " Books Price with Latest Deals & Offers | IndiaShopps ";
                            } else {
                                $value = "Buy or Compare Price " . ucfirst($cname) . " Books Online | Best Price Only at IndiaShopps ";
                            }
                        } else {
                            $value = ucfirst($cname) . " Price List in India | Buy | Compare Online";
                        }
                    }
                }

                break;

            case "description";

                $cname = (isset($cname)) ? $cname : "";

                if (request()->route()->getName() == 'home_v2' || request()->route()->getName() == 'amp.home') {
                    $value = "IndiaShopps is one of best price comparison shopping platforms for mobiles, laptops, cameras, home decor & so on. Find best online prices for 1000s of products in India.";
                } else {
                    if (isset($brand) && !empty($brand)):
                        if (isset($parent) && $parent == "computers"):
                            if (strtolower($brand) == "dell"):
                                $value = "Compare Online Dell Laptop Prices and Specifications insight from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews at Indiashopps.";
                            elseif (strtolower($brand) == "hp"):
                                $value = "Compare Online HP Laptop Prices and Specifications insight from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews at Indiashopps.";
                            elseif (strtolower($brand) == "lenovo"):
                                $value = "Compare Online Lenovo Laptop Prices and Specifications insight from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews at Indiashopps.";
                            else:
                                $value = "IndiaShopps is the most reputed affiliate online shopping website which helps to buy, search, explore the quality & branded " . $brand . " " . $cname . " at most comparative prices";
                            endif;
                        elseif (isset($parent) && $parent == "mobile"):
                            if ((isset($cname)) && (strtolower($cname) == "mobiles")):
                                if (strtolower($brand) == "apple"):
                                    $value = "Compare Online Apple iPhone Prices and Specifications insight from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews at Indiashopps. Buy Now!";
                                elseif (strtolower($brand) == "micromax"):
                                    $value = "Compare Online Micromax Mobile Prices and Specifications insight from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews at Indiashopps.";
                                elseif (strtolower($brand) == "samsung"):
                                    $value = "Compare Online Samsung Smartphone & Mobiles Prices, Specifications & Feature insight from Flipkart, Snapdeal, Amazon and many more with latest offersat Indiashopps.";
                                elseif (strtolower($brand) == "htc"):
                                    $value = "Compare Online HTC Mobile Prices and Specifications insight from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews at Indiashopps.";
                                else:
                                    $value = "Mobiles latest price in India with technical specifications and detailed features. Compare Brands at IndiaShopps.";
                                endif;
                            elseif ((isset($cname)) && (strtolower($cname) == "tablets")):
                                if (strtolower($brand) == "apple"):
                                    $value = "Compare Online Apple Ipad Price at Indiashopps.com with technical specification & Features. We offer wide range of deals and coupons on top mobile brands.";
                                elseif (strtolower($brand) == "samsung"):
                                    $value = "Compare Online Samsung Tablet Prices and Specifications from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews at Indiashopps. Buy Now!";
                                else:
                                    $value = "Mobiles latest price in India with technical specifications and detailed features. Compare Brands at IndiaShopps.";
                                endif;
                            endif;
                        else:
                            $value = "IndiaShopps is the most reputed affiliate online shopping website which helps to buy, search, explore the quality & branded " . $brand . " " . $cname . " at most comparative prices";
                        endif;
                    else:
                        if (isset($parent) && ($parent == "men" || $parent == "women")):
                            if ($parent == "men" || $parent == "women"):
                                $value = "Shop or Compare Online " . $parent . " " . strtolower($cname) . " latest price in India with Exciting offers, Coupons and deals on Indiashopps. Compare Brands Now.";
                            else:
                                $value = "IndiaShopps is the most reputed affiliate online shopping website which helps to buy, search, explore the quality & branded " . $cname . " for " . $parent . " at most comparative prices";
                            endif;
                        elseif (isset($parent) && $parent == "electronics"):
                            if (isset($child) && !empty($child)):
                                if (strtoupper($cname) == "LED TV"):
                                    $value = "Compare Online 32 inch, 40 inch & more LED TV prices with features and Specification insight only at Indiashopps.com & buy from Flipkart, Snapdeal, Amazon & many more.";
                                else:
                                    $value = "Compare " . strtoupper($cname) . " with prices and Specification buy online from Flipkart, Snapdeal, Amazon. Buy Now!";
                                endif;
                            else:
                                $value = "Compare " . strtolower($cname) . " with prices and buy online from Flipkart, Snapdeal, Amazon. Latest " . strtolower($cname) . " price list with pictures, features & specification. Compare Now!";
                            endif;
                        elseif (isset($parent) && $parent == "appliances"):
                            if (isset($child) && !empty($child)):
                                $value = "Compare " . ucwords($cname) . " with price and Specification at Indiashopps. Buy Latest & Branded Energy saving " . ucwords($cname) . " at best price. Lowest Price Guaranteed, Shop Now!";
                            else:
                                $value = "Compare " . strtolower($cname) . " prices online at Indiashopps. Buy Microwave, Oven, Induction Cooktop, Gas Stove & many more. Lowest Price Guaranteed, Shop Now!";
                            endif;
                        elseif (isset($parent) && $parent == "beauty-health"):
                            if (isset($child) && !empty($child)):
                                $value = "Save Money & Time - Buy Best " . ucwords(str_replace('-', ' ', $child)) . " " . ucwords($cname) . " online with Price, Features comparison inside from Flipkart, Amazon & Snapdeal & many more including reviews and latest deal only at Indiashopps.";
                            else:
                                $value = "Shop " . strtolower($cname) . " online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside from your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.";
                            endif;
                        elseif (isset($parent) && $parent == "sports-fitness"):
                            if (isset($child) && !empty($child)):
                                $value = "Save Money & Time - Buy Best " . ucwords(str_replace('-', ' ', $child)) . " " . ucwords($cname) . " online with Price, full Specification comparison inside from Flipkart, Amazon & Snapdeal & many more including reviews and latest deal only at Indiashopps.";
                            else:
                                $value = "Purchase Smart & Save money at Indiashopps. Buy " . strtolower($cname) . " online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside from your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.";
                            endif;
                        elseif (isset($parent) && $parent == "home-decor"):
                            if (isset($child) && !empty($child)):
                                $value = "Browse Best " . ucwords($cname) . " online with price comparison inside from Flipkart, Amazon & Snapdeal, including reviews and latest deal only at Indiashopps. ✓ Lowest Price Guaranteed.";
                            else:
                                $value = "Save money with smart purchase option at Indiashopps, buy " . strtolower($cname) . " online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.";
                            endif;
                        elseif (isset($parent) && $parent == "mobile"):
                            if (isset($child) && empty($child)):
                                if (strtolower($cname) == "mobiles"):
                                    $value = "Find Latest price of Mobile Phones Online in India & Compare price, technical specifications & features only at Indiashopps! Get best deals, offer, Coupon code etc.";
                                else:
                                    $value = "" . ucfirst($cname) . " latest price in India with technical specifications and detailed features. Compare Brands at IndiaShopps.";
                                endif;
                            else:
                                if ($child == "headphones-headsets"):
                                    $value = "Compare " . ucfirst($cname) . " by Price, Features & Specifications at IndiaShopps.com. Get best deals & coupons on top brands!";
                                else:
                                    $value = "Compare " . ucfirst($parent) . " " . ucfirst($cname) . " by Price, Features & Specifications at IndiaShopps.com. Get best deals & coupons on top brands!";
                                endif;
                            endif;
                        elseif (isset($parent) && $parent == "computers"):
                            if (isset($child) && !empty($child)):
                                if (isset($cname) && strtolower($cname) == "wifi routers"):
                                    $value = "Compare Online Wifi Router Prices and Specifications at Indiashopps & buy from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews.";
                                elseif (isset($cname) && strtolower($cname) == "pen drives"):
                                    $value = "Compare Online 16GB, 32GB, 64GB Pen Drives Prices and Specifications only at Indiashopps & buy from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews.";
                                else:
                                    $value = "Save money & time with smart purchase option only at Indiashopps, Shop " . ucwords($cname) . " online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.";
                                endif;
                            else:
                                $value = "Compare Online " . strtolower($cname) . " Prices and Specifications from Flipkart, Snapdeal, Amazon and many more insight with latest offers, deals & reviews at Indiashopps.";
                            endif;
                        elseif (isset($parent) && $parent == "kids"):
                            if (isset($child) && !empty($child)):
                                $value = "Browse Best " . ucwords($cname) . " online with price comparison inside from Flipkart, Amazon & Snapdeal, including reviews and latest deal only at Indiashopps. ✓ Lowest Price Guaranteed.";
                            else:
                                $value = "Save money & time with smart purchase option only at Indiashopps, Shop or Compare " . strtolower($cname) . " online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.";
                            endif;
                        elseif (isset($parent) && $parent == "camera"):
                            if (isset($child) && !empty($child)):
                                if (strtolower($cname) == "digital slr cameras") :
                                    $value = "Compare DSLR Camera price in India Online. Browse full Specifications, feature & reviews insight from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews.";
                                else:
                                    $value = "Shop " . ucwords($cname) . " Online with Latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.";
                                endif;
                            else:
                                $value = "Compare " . strtolower($cname) . " with prices and buy online from Flipkart, Snapdeal, Amazon.  Latest " . strtolower($cname) . " price list with pictures, features & specification. Compare Now!";
                            endif;
                        elseif (isset($parent) && $parent == "care"):
                            if (isset($child) && !empty($child)):
                                $value = "Save Money & Time - Buy Best " . ucwords($cname) . " online with Price, Features comparison inside from Flipkart, Amazon & Snapdeal & many more including reviews and latest deal only at Indiashopps.";
                            else:
                                $value = "Purchase Smart & Save money at Indiashopps. Buy " . strtolower($cname) . " online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside from your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.";
                            endif;
                        elseif (isset($parent) && $parent == "lifestyle"):
                            if (isset($child) && !empty($child)):
                                $value = "Save Money & Time - Buy Best " . ucwords($cname) . " online with Price, Features comparison inside from Flipkart, Amazon & Snapdeal & many more including reviews and latest deal only at Indiashopps.";
                            else:
                                $value = "Purchase Smart & Save money at Indiashopps. Buy " . strtolower($cname) . " online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside from your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.";
                            endif;
                        elseif (isset($parent) && $parent == "automotive"):
                            if (isset($child) && !empty($child)):
                                $value = "Shop " . ucwords($child) . " " . ucwords($cname) . " online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.";
                            else:
                                $value = "Shop Best " . ucwords($cname) . " Essentials Online with Price, Features & full Specification Comparison inside from Flipkart, Amazon, Snapdeal & many more, including latest offers, deals & reviews only at Indiashopps.";
                            endif;
                        elseif (isset($parent) && $parent == "books"):
                            if (isset($child) && !empty($child)):
                                $value = "Browse " . ucwords($cname) . " Books with price comparison, reviews and latest deal at Indiashopps.";
                            else:
                                $value = "Save money with smart purchase option at Indiashopps, buy " . strtolower($cname) . " books online with <em>Price Trends</em>, <em>Price Comparisons</em> & <em>Latest Deal/offers</em> directly inside your favorite shopping website like Flipkart, Amazon, snapdeal & many more.";
                            endif;
                        else:
                            $value = "IndiaShopps is the most reputed affiliate online shopping website which helps to buy, search, explore the quality & branded " . $cname . " at most comparative prices";
                        endif;
                    endif;
                }
                break;

            case "keywords":

                if (request()->route()->getName() == 'home_v2' || request()->route()->getName() == 'amp.home') {
                    $value = "Mobile Price Online, Compare Laptop Price List, Books Price Online, Compare Electronics Items Online, Fashion Price Online, IndiaShopps";
                }

                break;

            default:

                $value = '';
                break;
        }

        return $value;
    }

    public function setMetaData($meta = '')
    {
        if (!is_array($meta)) {
            \Log::warning("Meta data did not process for ROUTE:: " . request()->route()->getName());
            return '';
        }

        $meta = (object)$meta;

        if (isset($meta->title)) {
            $this->setTitle($meta->title);
        }

        if (isset($meta->description)) {
            $this->setDescription($meta->description);
        }

        if (isset($meta->keywords)) {
            $this->setKeywords($meta->keywords);
        }

        if (isset($meta->keyword)) {
            $this->setKeywords($meta->keyword);
        }

        if (isset($meta->short_description)) {
            $this->setShortDescription($meta->short_description);
        }

        if (isset($meta->h1)) {
            $this->setHeading($meta->h1);
        }

        if (isset($meta->content)) {
            $this->setContent($meta->content);
        }

        return true;
    }

    public function dd()
    {
        dd($this);
    }

    public function listSnippetTitle($vars, $extra = '')
    {
        extract($vars);
     //   echo request()->route()->getName(); die();
        if (empty($extra) && isset($list_desc) && isset($list_desc->table_heading) && !empty($list_desc->table_heading)) {
            return $list_desc->table_heading;
        }

        if (empty($extra) && isset($brand_meta) && isset($brand_meta->table_heading) && !empty($brand_meta->table_heading)) {
            return $brand_meta->table_heading;
        }

        if (empty($extra) && isset($custom_page_meta) && isset($custom_page_meta['table_heading']) && !empty($custom_page_meta['table_heading'])) {
            return $custom_page_meta['table_heading'];
        }


        if (isset($c_name)) {
            $c_name = ucfirst($c_name);
        } else {
            $c_name = '';
        }

        $checkRoute = ["sub_category", "amp.sub_category"];

        if (!in_array(request()->route()->getName(), $checkRoute)){
            if (isset($brand) && !empty($brand)) {
                if (strtolower($brand) == "lg" || strtolower($brand) == "htc" || strtolower($brand) == "hp") {
                    $c_brand = strtoupper($brand);
                } else {
                    $c_brand = ucfirst($brand);
                }
            }
        }

        $snip_name = "";
        if (!in_array(request()->route()->getName(), $checkRoute)){
            if (isset($brand) && !empty($brand)) {
                $snip_name = $c_brand . " ";
            }
        }

        if (!isset($category)) {
            $category = Category::find($scat);
        }

        if (isset($parent) && in_array($parent, ['men', 'women', 'kids'])) {
            $snip_name .= ucfirst($parent) . " ";
        } elseif (isset($category) && in_array($category->group_name, ['men', 'women', 'kids'])) {
            $snip_name .= ucfirst($category->group_name) . " ";
        }

        if (isset($parent) && ($parent == "kids" && (isset($child) && ($child == "boy-clothing" || $child == "girl-clothing" || $child == "boys-footwear" || $child == "girls-footwear")))) {
            $snip_name .= ucfirst(str_replace("-clothing", "", (str_replace("-footwear", "", $child)))) . " ";
        }

        $snip_name .= $c_name;

        if (isset($h1)) {
            $snip_name = $h1;
        } else {
            if (!empty($extra)) {
                if (isset($category)) {
                    if ($category->id == Category::MOBILE) {
                        $snip_name = str_ireplace("Mobiles", "Mobile", $snip_name) . " Phones Models";
                    } elseif ($category->id == Category::LAPTOPS) {
                        $snip_name .= " Models";
                    } elseif (empty($parent) && in_array($category->group_name, ['men', 'women', 'kids'])) {
                        //$snip_name = $category->group_name . " " . $snip_name;
                    } elseif ($category->group_name == 'books') {
                        $snip_name = $snip_name . " Books List";
                    } else {
                        $snip_name .= " Models List";
                    }
                }
            } else {
                if (isset($book) && $book) {
                    $snip_name = $snip_name . " Books Price List on " . \Carbon\Carbon::now()->format('F, Y');
                } else {
                    $snip_name = $snip_name . " Price List on " . \Carbon\Carbon::now()->format('F, Y');
                }
            }
        }

        return $snip_name;

    }

    /**
     * Setup Short Description for All Pages
     *
     * @author Vishal Singh <vishal@manyainternational.com>
     * @param $product
     * @return bool
     *
     */
    public function setupShortDescription($product)
    {
        try {
            $short_key = false;

            if (isset($product->type) && (strtolower($product->type) == 'smartphone' || strtolower($product->type) == 'budget phone')) {

                try {
                    if (isComingSoon($product)) {
                        $this->processUpcomingMobileDescription($product);
                    } else {
                        $this->processMobileShortDescription($product);
                    }

                    return false;
                } catch (\Exception $e) {
                    if (request()->has('debug')) {
                        send_slack_alert($e->getMessage());
                    }
                }
            }
            if (isset($product->category) && $product->category == 'laptops') {
                try {
                    $this->processLaptopShortDescription($product);
                    return false;
                } catch (\Exception $e) {
                    if (request()->has('debug')) {
                        send_slack_alert($e->getMessage());
                    }
                }
            }
            if (array_key_exists($product->category, config('description.extended'))) {
                try {
                    if ($this->processRestDescription($product, 'description.extended.' . $product->category)) {
                        return false;
                    }
                } catch (\Exception $e) {
                    if (request()->has('debug')) {
                        send_slack_alert($e->getMessage());
                    }
                }
            }

            if (array_key_exists(strtolower($product->category), config('description.category'))) {
                $short_key = config('description.category.' . strtolower($product->category));
            }

            if (empty($short_key) && array_key_exists(strtolower($product->parent_category), config('description.category'))) {
                $short_key = config('description.category.' . strtolower($product->parent_category));
            }

            if (empty($short_key) && isset($product->grp) && array_key_exists(strtolower($product->grp), config('description.group'))) {
                $short_key = config('description.group.' . strtolower($product->grp));
            }

            if (empty($short_key) && isset($product->group) && array_key_exists(strtolower($product->group), config('description.group'))) {
                $short_key = config('description.group.' . strtolower($product->group));
            }

            if ($short_key === false) {
                return false;
            }

            $short_description = $this->processShortDescription($product, config('description.short.' . $short_key));

            $this->setShortDescription($short_description);

            return true;
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . $e->getTraceAsString());
            return false;
        }
    }

    private function processShortDescription($product, $short_description)
    {
        if (empty($product) || !is_object($product)) {
            return $short_description;
        }

        $search = [
            '{DATE}',
            '{YEAR}',
            '{BRAND}',
            '{MODEL}',
            '{PRICE}',
            '{CATEGORY}',
            '{GROUP}',
            '{ID}'
        ];
        $replace = [
            Carbon::now()->format('F, Y'),
            Carbon::now()->format('Y'),
            '',
            $product->name,
            number_format($product->saleprice),
            ucwords($product->category),
            ucwords($product->grp),
            $product->id,
        ];

        foreach ($search as $k => $s) {
            //$short_description = preg_replace('/\s\s+/', ' ', $short_description);
            $short_description = preg_replace('/' . $s . '/', $replace[$k], $short_description);
        }

        return $short_description;
    }

    public function getAllMetas()
    {
        $meta['title'] = $this->getTitle();
        $meta['h1'] = $this->getHeading();
        $meta['description'] = $this->getDescription();
        $meta['short_description'] = $this->getShortDescription();
        $meta['keywords'] = $this->getKeywords();
        $meta['content'] = $this->getContent();

        return $meta;
    }

    public function getStaticMeta($string, $brand = '', $category = '')
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

    public function processMobileShortDescription($product)
    {
        if (isset($product->type) && strtolower($product->type) == 'budget phone') {
            $short = config("description.extended.budget_mobiles");
        } elseif (in_array($product->brand, config("description.brands.mobiles"))) {
            $short = BrandDesc::whereUpcoming('0')->whereBrand($product->brand)->first();
            if (!is_null($short)) {
                $short = $short->toArray();
            } else {
                $short = config("description.extended.mobiles");
            }
        } else {
            $short = config("description.extended.mobiles");
        }

        $replace_var = (strtolower($product->type) == 'budget phone')?'budget_mobile':'replace';

        $extra = config("description.extended.mobiles");
        $content = $this->replaceVariables($short['text'], $product, $replace_var);
        $this->setShortDescription($content);
        $content = $this->replaceVariables($extra['excerpt'], $product, $replace_var);
        $this->setExcerpt($content);
    }

    public function processLaptopShortDescription($product)
    {
        if (array_key_exists($product->brand, config("description.brands.laptops"))) {
            $short = config("description.brands.laptops." . $product->brand);
        } else {
            $short = config("description.extended.laptops");
        }
        $content = $this->replaceVariables($short['text'], $product, $short['keys']);
        $this->setShortDescription($content);
        $content = $this->replaceVariables($short['excerpt'], $product, $short['keys']);
        $this->setExcerpt($content);
    }

    public function processUpcomingMobileDescription($product)
    {
        if (isset($product->type) && strtolower($product->type) == 'budget phone') {
            $short = config("description.extended.budget_upcoming");
        } elseif (in_array($product->brand, config("description.brands.mobiles"))) {
            $short = BrandDesc::whereUpcoming('1')->whereBrand($product->brand)->first();
            if (!is_null($short)) {
                $short = $short->toArray();
            } else {
                $short = config("description.extended.upcoming");
            }
        } else {
            $short = config("description.extended.upcoming");
        }

        $extra = config("description.extended.upcoming");
        $content = $this->replaceVariables($short['text'], $product, 'replace');
        $this->setShortDescription($content);
        $content = $this->replaceVariables($extra['excerpt'], $product, 'replace');
        $this->setExcerpt($content);
    }

    public function processRestDescription($product, $key)
    {
        $short = config($key);

        if (empty($short)) {
            return false;
        }

        $content = $this->replaceVariables($short['text'], $product, $short['keys']);
        $this->setShortDescription($content);
        $content = $this->replaceVariables($short['excerpt'], $product, $short['keys']);
        $this->setExcerpt($content);

        return true;
    }

    private function replaceVariables($content, $product, $keys)
    {
        if (isset($product->desc_json)) {
            $fields = json_decode($product->desc_json);
            $fields = (object)array_change_key_case((array)$fields, CASE_LOWER);
        }

        $all_keys = array_merge(config("description.extended." . $keys), config("description.extended.common"));
        foreach ($all_keys as $placeholder => $params) {
            $replace = '';

            if (is_array($params)) {
                if ($params['type'] == 'range') {
                    if ($params['field'] == "desc_json") {
                        $field = (int)$fields->{$params['options']['key']};
                    } else {
                        $field = $product->{$params['field']};
                    }

                    foreach ($params['values'] as $value => $text) {
                        if ($field <= (int)$value) {
                            break;
                        }
                    }
                    $replace = $text;
                } elseif ($params['type'] == 'multiple') {
                    if ($params['options']['search']) {
                        if (stripos($params['options']['search'], $params['options']['search']) !== false) {
                            $replace = collect($params['values'])->first();
                        }
                    } else {
                        if (isset($params['default'])) {
                            if (isset($fields->{$params['options']['key']})) {
                                $replace = $fields->{$params['options']['key']};
                            } else {
                                $replace = $params['default'];
                            }
                        } else {
                            $replace = $fields->{$params['options']['key']};
                        }
                    }
                } elseif ($params['type'] == 'either_one') {
                    if (isset($product->{$params['field']})) {
                        if (array_key_exists(strtolower($product->{$params['field']}), $params['values'])) {
                            $replace = $params['values'][strtolower($product->{$params['field']})];
                        } else {
                            $replace = $params['default'];
                        }
                    } else {
                        $replace = $params['default'];
                    }
                }
            } elseif (isset($product->{$params})) {
                $replace = $product->{$params};
            }

            if (is_numeric($replace)) {
                //$replace = number_format($replace);
            }

            if ($placeholder == '{VENDOR}') {
                $replace = strtoupper(config("vendor.name." . $replace));
            } elseif ($placeholder == '{DATE}') {
                $replace = Carbon::now()->format('F, Y');
            } elseif ($placeholder == '{COLOR}') {

                if (!empty($replace) && !in_array($replace, ['null', 'NULL'])) {
                    $replace = trim($replace, ']');
                    $replace = trim($replace, '[');
                    $colors = explode(":", $replace);

                    if (count($colors) > 0) {
                        if (count($colors) > 1) {
                            $colors[count($colors) - 1] = "and " . array_last($colors);
                        }

                        $replace = implode(", ", $colors);
                    } else {
                        $replace = 'Black, and White';
                    }
                } else {
                    $replace = 'Black, and White';
                }
            } elseif ($placeholder == '{PRICE}' && is_numeric($replace)) {
                $replace = number_format($replace);
            } elseif ($placeholder == '{BRAND}') {
                $replace = ucfirst($replace);
            }
            elseif ($placeholder == '{BATTERY}' && $keys=='budget_mobile') {
                $replace = $product->{$params}." mAh battery";
            }
            elseif($placeholder == '{LAUNCH_DATE}'){
                $replace = releaseDate($product);
            }

            $content = preg_replace('/' . $placeholder . '/', $replace, $content);
            $content = preg_replace('/\s\s+/', ' ', $content);
            $content = str_replace('M.Pixels', 'MP', $content);
            $content = str_replace('m.pixels', 'MP', $content);
        }

        return $content;
    }

    public function hasKey($key)
    {
        if (isset($this->{$key}) && !empty($this->{$key})) {
            return true;
        }
        return false;
    }

    public function couponSnippetTitle($vars)
    {
        extract($vars);

        if (isset($vendor_name) && !empty($vendor_name)) {
            return ucwords($vendor_name) . " Discount Coupons, Promo Codes, Offers & Deals List With Expiry Date";
        } elseif (isset($category) && !empty($category)) {
            return ucwords($category) . " Promo Codes, Coupons & Discount Offers With Expiry Date";
        }

        return "Best Promo Codes, Coupons & Offers For Today";
    }

    public function has($key)
    {
        if (isset($this->{$key}) && !empty($this->{$key})) {
            return true;
        }

        return false;
    }
}