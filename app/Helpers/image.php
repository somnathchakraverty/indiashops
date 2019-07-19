<?php

function create_slug($string)
{
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', trim($string));
    $slug = strtolower($slug);
    $slug = str_replace("---", "-", $slug);
    $slug = str_replace("--", "-", $slug);
    $slug = trim($slug, "-");

    return $slug;
}

function cs($string)
{
    return create_slug($string);
}

function reverse_slug($string)
{
    $slug = str_replace('-', ' ', trim($string));
    $slug = str_replace("3 4", "3/4", $slug);
    $slug = str_replace("3-4", "3/4", $slug);
    $slug = strtolower($slug);

    return $slug;
}

function amp_desc_table_to_div($desc)
{
    $desc = preg_replace("/<\/table>/i", "", $desc);
    $desc = preg_replace("/<\/tr>/i", "", $desc);

    $desc = preg_replace('/<table.*?>/i', '', $desc);
    $desc = preg_replace('/<a.*?>/i', '', $desc);
    $desc = preg_replace('/<tr.*?>/i', '', $desc);
    $desc = preg_replace('/<th.*?>(.*?)<\/th>/i', '<div class="headdingname">$1</div>', $desc);
    $desc = preg_replace('/<td.*?>(.*?)<\/td>/i', '<li>$1</li>', $desc);
    $desc = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $desc);

    return $desc;
}

function removeInlineStyle($desc)
{
    $desc = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $desc);
    $desc = preg_replace('/(<[^>]+) onclick=".*?"/i', '$1', $desc);

    if (stripos($desc, 'indiashopps.com') == false) {
        $desc = preg_replace('/<a.*?>(.*?)<\/a>/i', '$1', $desc);
    }
    $desc = preg_replace('/style=[^>]*/', '', $desc);
    $desc = preg_replace('/<img(.*?)\/?>/', '<amp-img$1 layout="responsive"></amp-img>', $desc);

    return $desc;
}

function imageLazyLoad($html)
{
    $image = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
    $html  = preg_replace('/<img src/', "<img $image data-src", $html);

    return $html;
}

function removeInlineStyle1($desc)
{
    $desc = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $desc);
    $desc = preg_replace('/(<[^>]+) onclick=".*?"/i', '$1', $desc);

    return $desc;
}


function unslug($string)
{
    $string = preg_replace('/[-_]+/', ' ', trim($string));

    return ucwords($string);
}

function clear_url($url)
{
    if (config('app.seoEnable')) {
        $url = explode(config('app.seoURL'), $url);
        $url = $url[0];
    }

    return unslug($url);
}

function miniSpecs($specs, $count = 5)
{

    $specs = explode(";", $specs);
    $i     = 1;

    foreach ($specs as $spec) {
        if (!empty($spec)) {
            $s[] = $spec;
        }

        if ($count == $i) {
            break;
        } else {
            $i++;
        }
    }

    return $specs;
}

function miniSpecDetail($specs, $count = 5, $char = '')
{

    $specs  = explode(";", $specs);
    $return = "";
    $i      = 1;

    foreach ($specs as $spec) {
        if (!empty($spec)) {
            if (isMobile()) {
                $return .= '<li>' . $spec . '</li>';
            } else {
                $return .= '<li>' . $char . " " . $spec . '</li>';
            }
        }

        if ($count == $i) {
            break;
        } else {
            $i++;
        }
    }

    return $return;
}

function getMiniSpecV3($specs, $count = 5)
{

    $specs = array_filter(explode(";", $specs));

    for ($i = 0; $i <= $count; $i++) {
        if (isset($specs[$i])) {
            $new_spec[] = $specs[$i];
        }
    }
    if (isset($new_spec)) {
        return implode(" / ", $new_spec);
    }

    return '';
}

function solr_url($param = "")
{
    $com_url = env('SOLR_URL');

    if (!empty($com_url)) {
        return trim($com_url) . trim($param);
    } else {
        return env('SOLR_URL_DEV') . trim($param);
    }
}

function composer_url($param = "")
{
    $com_url = env('COMPOSER_URL');

    if (!empty($com_url)) {
        return trim($com_url) . trim($param);
    } else {
        return "http://ext.indiashopps.com/composer/site/2.3/" . trim($param);
    }
}

function isPricelist($cat)
{
    $pricelist_cat = [
        301,
        311,
        312,
        313,
        317,
        318,
        319,
        320,
        321,
        322,
        323,
        324,
        325,
        326,
        327,
        328,
        330,
        331,
        332,
        333,
        334,
        335,
        336,
        337,
        338,
        339,
        340,
        341,
        342,
        344,
        345,
        346,
        347,
        348,
        351,
        352,
        359,
        360,
        361,
        362,
        364,
        365,
        366,
        370,
        371,
        372,
        374,
        379,
        381,
        382,
        384,
        390,
        392,
        407,
        427,
        435,
        436,
        437,
        445,
        446,
        447,
        448,
        455,
        470,
        471,
        472,
        473,
        476,
        489,
        492,
        505,
        622,
        623,
        624,
        626,
        627,
        628,
        632,
        633,
        635,
        636,
        637,
        638,
        639,
        640
    ];
    if (in_array($cat, $pricelist_cat)) {
        return true;
    }

    return false;
}

function seoUrl($url)
{
    if (config('app.seoEnable')) {
        $url .= config('app.seoURL') . ".html";
    }

    return $url;
}

function getImage($img, $vendor, $size = false)
{
    switch ($vendor) {
        case 0:
            if (json_decode($img) != null) {
                $img = json_decode($img);
                $img = $img[0];
            }
            break;
        case 1:
            if (json_decode($img) != null) {
                $img = json_decode($img);
                $img = $img[0];
            }
            if (strpos($img, ',') || strpos($img, ';')) {
                if (strpos($img, ',')) {
                    $img = explode(",", $img);
                } else {
                    if (strpos($img, ';')) {
                        $img = explode(";", $img);
                    }
                }
                $img = $img[0];
            }
            $csize = explode("-", $img);
            $index = (sizeof($csize) - 2);
            // dd($index);
            $csize = @$csize[$index];
            if ($size && $size != $csize) {
                if (!strpos($img, $size) && strpos($img, $csize)) {
                    if ($size == 'L') {
                        $img = str_replace($csize, 'original', $img);
                    }
                    if ($size == 'M') {
                        $img = str_replace($csize, '400x400', $img);
                    }
                    if ($size == 'S') {
                        $img = str_replace($csize, '275x275', $img);
                    }
                    if ($size == 'XS') {
                        $img = str_replace($csize, '100x100', $img);
                    }
                    if ($size == 'XXS') {
                        $img = str_replace($csize, '75x75', $img);
                    }
                }
            }

            break;
        case 2:
            if (json_decode($img) != null) {
                $img = json_decode($img);
                $img = $img[0];
            }
            $img = str_replace("catalog_xs", "product2", $img);
            if ($size == 'L') {
                $img = str_replace("_xxs.", "_l.", $img);
            }
            break;
        case 3:
            if (json_decode($img) != null) {
                $img = json_decode($img);
                $img = $img[0];
            }
            if ($size == 'L') {
                $img = str_replace("._SL160_", "", $img);
                $img = str_replace("._SL425_", "", $img);
                $img = str_replace("._SS40_", "", $img);
            } else {
                if ($size == 'XS') {
                    $img = str_replace("._SL160_", "._SL75_", $img);
                    $img = str_replace("._SL425_", "._SL75_", $img);
                    $img = str_replace("._SS40_", "._SL75_", $img);
                }
            }
            break;
        case 23:
            if (json_decode($img) != null) {
                $img = json_decode($img);
                $img = $img[0];
            }
            if ($size == 'L') {
                $img = str_replace("bigthumb/", "zoom/", $img);
            } else {
                if ($size == 'M') {
                    $img = str_replace("bigthumb/", "438x531/", $img);
                }
            }
            break;
        case 16:
            if (json_decode($img) != null) {
                $img = json_decode($img);
                $img = $img[0];
            }
            if ($size == 'L') {
                $img = str_replace("166x194/", "", $img);
            }//else{
            //$img = str_replace("166x194/","",$img);
            //}
            break;
        case 21:
            if ($size == 'L') {
                $img = str_replace("-small", "-large", $img);
            }
            break;
        case 22:
            if (!is_file_exists($img)) {
                $img = str_replace("1_c", "2_c", $img);
            }
            break;
        case 35:
            if ($size == 'L') {
                $img = str_replace("210x", "410x", $img);
            } else {
                if (json_decode($img) != null) {
                    $img = json_decode($img);
                    $img = $img[0];
                }
            }
            break;
        case 54:
            if (json_decode($img) != null) {
                $img = json_decode($img);
                $img = $img[0];
            }
            if ($size == 'L') {
                $img = str_replace("97Wx144H", "1348Wx2000H", $img);
            } elseif ($size == 'M') {
                $img = str_replace("97Wx144H", "437Wx649H", $img);
            }

            break;

        default:
            if (json_decode($img) != null) {
                $img = json_decode($img);
                $img = $img[0];
            }
            break;
    }

    return $img;
}

function getImageNew($img, $size = false)
{
    if (empty($img) && $size === false) {
        return asset("/assets/v3/images/image_loading.gif");
    }

    if (empty($img)) {
        return "https://www.indiashopps.com/assets/v1/images/imgNoImg.png";
    }

    if (is_array(json_decode($img)) && count(array_filter(json_decode($img))) == 0) {
        return "https://www.indiashopps.com/assets/v1/images/imgNoImg.png";
    }

    if (json_decode($img) != null) {
        $img = json_decode($img);
        $img = $img[0];
    }
    if (is_array($img)) {
        $img = $img[0];
    }

    if (empty($img)) {
        return "https://www.indiashopps.com/assets/v1/images/imgNoImg.png";
    }

    $domain = getDomain($img);

    if ($domain && $size) {
        switch (strtolower($domain)) {
            case 'fkcdn':
            case 'flipkart':
            case 'flixcart':
                if (strpos($img, ',') || strpos($img, ';')) {
                    if (strpos($img, ',')) {
                        $img = explode(",", $img);
                    } else {
                        if (strpos($img, ';')) {
                            $img = explode(";", $img);
                        }
                    }
                    $img = $img[0];
                }

                preg_match('/\/image\/(.?.?.?)\/(.?.?.?)\//', $img, $matches, PREG_OFFSET_CAPTURE, 0);

                if (isset($matches[0]) && isset($matches[0][1])) {
                    if ($size == 'L') {
                        $replace = '832/832/';
                    } elseif ($size == 'M') {
                        $replace = '230/230/';
                    } elseif ($size == 'S') {
                        $replace = '110/110/';
                    } elseif ($size == 'XS') {
                        $replace = '160/160/';
                    } elseif ($size == 'XXS') {
                        $replace = '75/75/';
                    } elseif ($size == 'CARD') {
                        $replace = '180/180/';
                    } elseif ($size == 'MOBILE') {
                        $replace = '120/120/';
                    }

                    $img = str_replace($matches[0][0], "/image/" . $replace, $img);
                }

                break;
            case 'jabong':
            case 'jassets':
                $img = str_replace("catalog_xs", "product2", $img);
                if ($size == 'L') {
                    $img = str_replace("_xxs.", "_l.", $img);
                }
                break;
                break;
            case 'amazon':
            case 'images-amazon':
            case 'ssl-images-amazon':
                $search  = '/._(.*)_/';
                $replace = '._SX220_';

                if ($size == 'L') {
                    $replace = '';
                } elseif ($size == 'M') {
                    $replace = '._SX220_';
                } elseif ($size == 'S') {
                    $replace = '._SL160_';
                } elseif ($size == 'XS') {
                    $replace = '._SL110_';
                } elseif ($size == 'XXS') {
                    $replace = '._SL75_';
                } elseif ($size == 'MOBILE') {
                    $replace = '._SL120_';
                }

                preg_match($search, $img, $match);

                if (isset($match[0]) && !empty($match[0])) {
                    $img = preg_replace($search, $replace, $img);
                } else {
                    $img = str_replace(".jpg", $replace . ".jpg", $img);
                    $img = str_replace(".png", $replace . ".png", $img);
                }

                break;

            case 'paytm':
                if ($size == 'M') {
                    $img = str_replace("0x1920", "323x575", $img);
                } elseif ($size == 'S') {
                    $img = str_replace("0x1920", "0x275", $img);
                } elseif ($size == 'XS') {
                    $img = str_replace("0x1920", "0x90", $img);
                } elseif ($size == 'MOBILE') {
                    $img = str_replace("0x1920", "0x120", $img);
                }

                break;
            case 'snapdeal':
                if ($size == 'L') {
                    $img = str_replace("166x194/", "", $img);
                }
                break;
            case 'myntassets':
                if ($size == 'L') {
                    $img = str_replace("w_240", "w_1080", $img);
                    $img = str_replace("w_180", "w_1080", $img);
                    $img = str_replace("h_240", "", $img);
                } else {
                    if ($size == 'M') {
                        $img = str_replace("w_240", "w_480", $img);
                        $img = str_replace("w_180", "w_480", $img);
                        $img = str_replace("h_240", "", $img);
                    } else {
                        if ($size == 'XS') {
                            $img = str_replace("w_240", "w_100", $img);
                        } elseif ($size == 'MOBILE') {
                            $img = str_replace("w_240", "w_120", $img);
                        }
                    }
                }
                break;
            case 'infibeam':
                if ($size == 'L') {
                    $img = str_replace("999x320x320", "999x400x400", $img);
                } else {
                    if ($size == 'M') {
                        $img = str_replace("999x320x320", "999x320x320", $img);
                    } else {
                        if ($size == 'S') {
                            $img = str_replace("999x320x320", "999x275x275", $img);
                        } else {
                            if ($size == 'XS') {
                                $img = str_replace("999x320x320", "999x100x100", $img);
                            } else {
                                if ($size == 'XXS') {
                                    $img = str_replace("999x320x320", "999x75x75", $img);
                                } elseif ($size == 'MOBILE') {
                                    $img = str_replace("999x320x320", "999x120x120", $img);
                                }
                            }
                        }
                    }
                }
                break;
            case '91-img':
            case 'indiatimes':
                if ($size == 'L') {
                    $img = str_replace("small", "large", $img);
                } else {
                    if ($size == 'M') {
                        $img = str_replace("large", "large", $img);
                    } else {
                        if ($size == 'S') {
                            $img = str_replace("large", "small", $img);
                        } else {
                            if ($size == 'XS') {
                                $img = str_replace("large", "small", $img);
                            } else {
                                if ($size == 'XXS') {
                                    $img = str_replace("large", "small", $img);
                                } elseif ($size == 'MOBILE') {
                                    $img = str_replace("large", "large", $img);
                                }
                            }
                        }
                    }
                }
                break;
            case 'tatacliq':
                preg_match_all('/.*\/images\/i2\/(.*)\//i', $img, $matches, PREG_SET_ORDER, 0);

                if (!isset($matches[0])) {
                    preg_match_all('/.*\/images\/(.*)\//i', $img, $matches, PREG_SET_ORDER, 0);
                }

                if ($size == "M") {
                    $replace = "252Wx374H";
                } elseif ($size == "XS" || $size == "XXS" || $size == 'S') {
                    $replace = "97Wx144H";
                } elseif ($size == "MOBILE") {
                    $replace = "252Wx374H";
                }

                if (isset($replace) && isset($matches[0]) && isset($matches[0][1])) {
                    $search = $matches[0][1];

                    try {
                        $img = preg_replace("/$search/i", $replace, $img);
                    }
                    catch (\Exception $e) {
                    }
                }

                break;

            case 'cloudfront':
                if ($size == 'L') {
                    $img = $img;
                } else {
                    if ($size == 'M') {
                        $img = str_replace("big", "medium", $img);
                    } else {
                        if ($size == 'S' || $size == 'XS' || $size == 'XXS') {
                            $img = str_replace("big", "small", $img);
                        } elseif ($size == 'MOBILE') {
                            $img = str_replace("big", "medium", $img);
                        }
                    }
                }
                break;

            case 'indiashopps':

                if (strpos($img, 'upcoming') !== false) {
                    if ($size == 'L') {
                        $img = $img;
                    } else {
                        if ($size == 'M') {
                            if (stripos($img, 'upcoming/small') === false && stripos($img, 'upcoming/medium') === false) {
                                $img = str_replace("upcoming", "upcoming/medium", $img);
                            } else {
                                $img = str_replace("small", "medium", $img);
                            }
                        } else {
                            if ($size == 'S' || $size == 'XS' || $size == 'XXS' && stripos($img, 'upcoming/small' && stripos($img, 'upcoming/medium') === false) === false) {
                                $img = str_replace("upcoming", "upcoming/small", $img);
                            } elseif ($size == 'MOBILE') {
                                $img = str_replace("upcoming", "upcoming/medium", $img);
                                $img = str_replace("small/medium", "medium", $img);
                            }
                        }
                    }

                    $img = str_replace("small/medium", "small", $img);
                    $img = str_replace("medium/medium", "medium", $img);
                    $img = str_replace("medium/medium", "medium", $img);
                    $img = str_replace("medium/small", "medium", $img);
                }
                break;

            case 'shopclues':

                preg_match_all('/detailed\/(.*)\//', $img, $matches, PREG_SET_ORDER, 0);

                if ($size == "M") {
                    $replace = "/200/200/";
                } elseif ($size == "XS" || $size == "XXS" || $size == 'S') {
                    $replace = "/50/50/";
                } elseif ($size == "MOBILE") {
                    $replace = "/160/160/";
                }

                if (isset($replace) && isset($matches[0][0])) {
                    $img = str_replace($matches[0][0], "thumbnails/" . $matches[0][1] . $replace, $img);
                }

                $img = preg_replace("/_/i", '', $img);

                break;

            case 'gadgets360cdn':
                $parts = explode("?", $img);

                $replace = (isset($parts[1])) ? "?" . $parts[1] : '';
                $img     = $parts[0];

                if ($size == "M") {
                    $replace = "?downsize=200:*&output-quality=70&output-format=jpg";
                } elseif ($size == "XS" || $size == "XXS" || $size == 'S') {
                    $replace = "?downsize=60:*&output-quality=60&output-format=jpg";
                } elseif ($size == "MOBILE") {
                    $replace = "?downsize=160:*&output-quality=70&output-format=jpg";
                }

                $img = $img . $replace;

                break;

            case 'sdlcdn':
                preg_match_all('/imgs\/.?\/.?\/(.?)\//i', $img, $matches, PREG_SET_ORDER, 0);

                if ($size == "M") {
                    $replace = "230X258_sharpened/";
                } elseif ($size == "XS" || $size == "XXS" || $size == 'S') {
                    $replace = "130x152/";
                } elseif ($size == "MOBILE") {
                    $replace = "130x152/";
                }

                if (isset($replace) && isset($matches[0][0])) {
                    $replace = $matches[0][0] . $replace;
                    try {
                        $img = preg_replace("/imgs\/.?\/.?\/(.?)\//i", $replace, $img);
                    }
                    catch (\Exception $e) {
                    }
                }

                break;
            case 'kraftly':

                preg_match_all('/w-.{3},h-.{3}/m', $img, $matches, PREG_SET_ORDER, 0);

                if (isset($matches[0]) && !empty($matches[0]) && isset($matches[0][0])) {
                    $search = $matches[0][0];

                    if ($size == 'M') {
                        $replace = 'w-200,h-200';
                    } elseif ($size == 'S') {
                        $replace = 'w-160,h-160';
                    } elseif ($size == 'XS') {
                        $replace = 'w-110,h-110';
                    } elseif ($size == 'XXS') {
                        $replace = 'w-75,h-75';
                    } elseif ($size == 'MOBILE') {
                        $replace = 'w-120,h-120';
                    }

                    if (isset($replace)) {
                        $img = str_replace($search, $replace, $img);
                    }
                }

                break;

            case 'voonik':
                $img = strtok($img, '?');

                if ($size == 'M') {
                    $width = '?sizes=200px';
                } elseif ($size == 'S') {
                    $width = '?sizes=160px';
                } elseif ($size == 'XS') {
                    $width = '?sizes=110px';
                } elseif ($size == 'XXS') {
                    $width = '?sizes=75px';
                } elseif ($size == 'MOBILE') {
                    $width = '?sizes=120px';
                }

                if (isset($width)) {
                    $img .= $width;
                }

                break;

            case 'craftsvilla':

                preg_match_all('/upload\/(.*)\/.?\/.?\//i', $img, $matches, PREG_SET_ORDER, 0);

                if (isset($matches[0]) && !empty($matches[0]) && isset($matches[0][1])) {
                    $search = $matches[0][1];

                    if ($size == 'M') {
                        $width = '220';
                    } elseif ($size == 'S') {
                        $width = '160';
                    } elseif ($size == 'XS') {
                        $width = '110';
                    } elseif ($size == 'XXS') {
                        $width = '75';
                    } elseif ($size == 'MOBILE') {
                        $width = '120';
                    }

                    if (isset($width)) {
                        $replace = "w_$width,c_scale,q_auto,f_auto";

                        $img = str_replace($search, $replace, $img);
                    }
                }

                break;

            case 'clovia':
                preg_match_all('/images\/images\/(.*)\/clovia/i', $img, $matches, PREG_SET_ORDER, 0);

                if (isset($matches[0]) && !empty($matches[0]) && isset($matches[0][1])) {
                    $search = $matches[0][1];

                    if ($size == 'M') {
                        $replace = '225x390';
                    } elseif ($size == 'S') {
                        $replace = '175x175';
                    } elseif ($size == 'XS') {
                        $replace = '86x86';
                    } elseif ($size == 'XXS') {
                        $replace = '86x86';
                    } elseif ($size == 'MOBILE') {
                        $replace = '175x175';
                    }

                    if (isset($replace)) {
                        $img = str_replace($search, $replace, $img);
                    }
                }
                break;

        }
    }

    if (stripos($img, "indiashopps") !== false) {
        return str_replace("http://", "https://", $img);
    }
    return $img;
}

function getDomain($url)
{

    $dom = parse_url($url);
    if (isset($dom['host'])) {
        $domain = str_replace(".com", "", $dom['host']);
        $domain = str_replace(".net", "", $domain);
        $domain = explode(".", $domain);

        if ($domain[(count($domain) - 1)] == 'com') {
            return $domain[(count($domain) - 2)];
        }
        return $domain[(count($domain) - 1)];
    }
    return false;
}

function is_file_exists($filePath)
{
    return is_file($filePath) && file_exists($filePath);
}

function truncate($str, $length = 10, $trailing = '...')
{
    $length -= mb_strlen($trailing);
    if (mb_strlen($str) > $length) {
        return mb_substr($str, 0, $length) . $trailing;
    } else {
        $res = $str;
    }

    return $res;
}

function clean($string)
{
    $string = str_replace('"', "", $string);
    $string = str_replace("'", "", $string);
    $string = str_replace(" ", "-", $string);
    $string = str_replace("---", "-", $string);

    return $string;
}

function cleanID($string)
{
    $find = [".", '"', '&', '+', "'", " ", "_"];
    $repl = ['', '', '', '', "", "-", "-"];

    $string = str_replace($find, $repl, $string);
    $string = str_replace($find, $repl, $string);

    return $string;
}

function ppLink(&$p, $brand)
{
    if ($p->grp !== $p->parent_category && !empty($p->parent_category)) {
        $url = seoUrl(url(create_slug($p->grp) . "/" . create_slug($p->parent_category) . "/" . create_slug($brand->key) . "--" . create_slug($p->category)));
    } else {
        $url = seoUrl(url(create_slug($p->grp) . "/" . create_slug($brand->key) . "--" . create_slug($p->category)));
    }

    return $url;
}

function canonical_url()
{
    $canonical_url = str_replace("/amp", "", (str_replace('/index.php', '', Request::URL())));
    if (strpos($canonical_url, '.html') !== false) {
        $canonical_url = explode(".html", $canonical_url);
        $canonical_url = $canonical_url[0] . ".html";
    }

    return $canonical_url;
}

function amp_url($product)
{
    if (isset($product->grp) && $product->grp == 'Books') {
        $route = route('amp_detail_books', [create_slug($product->name), $product->id, $product->vendor]);
    } elseif (hasVendorNonComp($product)) {
        $route = route('amp_detail_non_comp', [create_slug($product->name), $product->id, $product->vendor]);
    } else {
        $route = route('amp_detail_comp', [create_slug($product->name), $product->id]);
    }

    return $route;
}

function amp_canonical($product)
{
    if (hasVendorNonComp($product)) {
        if (stripos($product->grp, "books") !== false) {
            $route = route('product_detail_non_book', [cs($product->name), $product->id, $product->vendor]);
        } else {
            $route = route('product_detail_non', [
                cs($product->grp),
                cs($product->name),
                $product->id,
                $product->vendor
            ]);
        }
    } else {
        $route = route('product_detail_v2', [cs($product->name), $product->id]);
    }

    return $route;
}

function newUrl($path = "")
{
    $showDomain = false;
    $path       = str_replace("/index.php", "", $path);

    if ($showDomain) {
        return url($path);
    } else {
        if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == "localhost") {
            $base = "/indiashopps/";
        } else {
            $base = "/";
        }

        if (empty($path) || trim($path) == "/") {
            return $base;
        } else {
            if ($path[0] == "/") {
                return $path;
            } else {
                return $base . $path;
            }
        }
    }
}

function product_url_old($product, $book = false)
{
    if ($book) {
        $proURL = newUrl('product/' . create_slug($product->_source->name . " book") . "/" . $product->_id);
    } else {
        $proURL = newUrl('product/' . create_slug($product->_source->name) . "/" . $product->_id);
    }

    return $proURL;
}

function product_url_home_old($product, $book = false)
{
    if ($book) {
        $proURL = newUrl('product/' . create_slug($product->name . " book") . "/" . $product->_id);
    } else {
        $proURL = newUrl('product/' . create_slug($product->name) . "/" . $product->_id);
    }

    return $proURL;
}

function product_url_home($product, $book = false)
{
    if (hasVendorNonComp($product)) {
        if ($book) {
            $proURL = newUrl($product->grp . '/' . create_slug($product->name . " book") . "/" . $product->_id);
        } else {
            $proURL = newUrl($product->grp . '/' . create_slug($product->name) . config('app.detaiPageSlug') . $product->_id);
        }
    } else {
        $proURL = newUrl(create_slug($product->name) . config('app.detaiPageSlug') . $product->_id);
    }

    return $proURL;
}

function product_url($product, $book = false)
{
    if (isset($product->_source)) {
        if (hasVendorNonComp($product)) {
            if ($book || !isset($product->_source->grp)) {
                $proURL = url('books/' . create_slug($product->_source->name . config('app.detaiPageSlug')) . '-' . $product->_id);
            } else {
                $proURL = url(create_slug($product->_source->grp) . '/' . create_slug($product->_source->name) . config('app.detaiPageSlug') . $product->_id);
            }
        } else {
            $proURL = url(create_slug($product->_source->name) . config('app.detaiPageSlug') . $product->_id);
        }
    } else {
        if (hasVendorNonComp($product)) {
            if ($book || !isset($product->grp)) {
                $proURL = url('books/' . create_slug($product->name . config('app.detaiPageSlug')) . '-' . $product->id);
            } else {
                $proURL = url(create_slug($product->grp) . '/' . create_slug($product->name) . config('app.detaiPageSlug') . $product->id . "-" . $product->vendor);
            }
        } else {
            $proURL = url(create_slug($product->name) . config('app.detaiPageSlug') . $product->id);
        }
    }

    return $proURL;
}

function product_url_real($prod, $book = false)
{
    $product = clone $prod;

    if (isset($product->_source)) {
        $product = $product->_source;
    }

    $product->name = preg_replace("/\((.*)\)/", '', $product->name);
    return product_url($product, $book);
}

function hasVendorNonComp($product)
{
    if (isset($product->_source)) {
        $product = $product->_source;
    }

    if (isset($product->vendor) && !is_array($product->vendor) && $product->vendor != '0') {
        return true;
    } else {
        return false;
    }
}

function getIds($ids)
{
    $ids = explode(",", $ids);

    foreach ($ids as $id) {
        $array[] = trim($id, '"');
    }

    return $array;
}

function encrypt_ind($data)
{
    if (is_object($data) || is_array($data)) {
        return base64_encode(json_encode($data));
    }

    return base64_encode($data);
}

function getGroupName($cat_name)
{
    $cat_name = create_slug($cat_name);
    $db       = \DB::table('gc_cat AS a')->select(["a.group_name", 'a.id']);

    $row = $db->where(DB::raw(" create_slug(a.name) "), "like", $cat_name)->first();

    if (is_null($row)) {
        abort(404);
    } else {
        return $row;
    }
}

function getProductImageFolder(&$product, $relative_path = false)
{
    if ($relative_path) {
        return base_path() . "/images/v2/p/img/" . $product->category_id . "/" . implode("/", str_split($product->id)) . '/';
    } else {
        $cloud_url = env('CLOUDFRONT_URL', 'http://d29kfy3sc671h5.cloudfront.net/');

        return $cloud_url . $product->category_id . "/" . implode("/", str_split($product->id)) . '/';
    }
}

function productImage($product)
{
    $images = productImageArray($product);

    if (stripos($images[0], 'imgNoImg') === false) {
        return getProductImageFolder($product) . $images[0];
    } else {
        return $images[0];
    }
}

function allProductImages(&$product)
{
    $images = productImageArray($product);
    $return = [];

    foreach ($images as $image) {
        if (stripos($image, 'imgNoImg') === false) {
            $return[] = getProductImageFolder($product) . $image;
        } else {
            $return[] = $image;
        };
    }

    return $return;
}

function productImageArray(&$product)
{
    if (isset($product->image_url) && !empty($product->image_url)) {
        try {
            $images = json_decode($product->image_url);
        }
        catch (\Exception $E) {
            $images = $product->image_url;

            \Log::error("Product Image Array Error: " . $E->getMessage() . "\n <br/>" . $E->getTrace());
        }

        if (!is_array($images)) {
            return [$images];
        }

        return $images;
    } else {
        return ["//www.indiashopps.com/assets/v1/images/imgNoImg.png"];
    }
}

function elastic_search($param = "")
{
    return "http://elasticsearch.indiashopps.com/composer/site/2.3/" . trim($param);
}

function truncate_html($text, $length = 100, $options = [])
{
    $default = [
        'ending' => '...',
        'exact'  => true,
        'html'   => true
    ];
    $options = array_merge($default, $options);
    $html    = '';
    $ending  = '';
    $exact   = '';
    extract($options);

    if ($html) {
        if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            $text = preg_replace('#<a.*?>(.*?)</a>#i', '\1', $text);
            $text = preg_replace('/(<[^>]+) style="(.*?)"/i', '$1', $text);
            return $text;
        }
        $totalLength = mb_strlen(strip_tags($ending));
        $openTags    = [];
        $truncate    = '';

        preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
        foreach ($tags as $tag) {
            if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
                if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                    array_unshift($openTags, $tag[2]);
                } else {
                    if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                        $pos = array_search($closeTag[1], $openTags);
                        if ($pos !== false) {
                            array_splice($openTags, $pos, 1);
                        }
                    }
                }
            }
            $truncate .= $tag[1];

            $contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
            if ($contentLength + $totalLength > $length) {
                $left           = $length - $totalLength;
                $entitiesLength = 0;
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
                    foreach ($entities[0] as $entity) {
                        if ($entity[1] + 1 - $entitiesLength <= $left) {
                            $left--;
                            $entitiesLength += mb_strlen($entity[0]);
                        } else {
                            break;
                        }
                    }
                }

                $truncate .= mb_substr($tag[3], 0, $left + $entitiesLength);
                break;
            } else {
                $truncate .= $tag[3];
                $totalLength += $contentLength;
            }
            if ($totalLength >= $length) {
                break;
            }
        }
    } else {
        if (mb_strlen($text) <= $length) {
            $text = preg_replace('#<a.*?>(.*?)</a>#i', '\1', $text);
            $text = preg_replace('/(<[^>]+) style="(.*?)"/i', '$1', $text);

            return $text;
        } else {
            $truncate = mb_substr($text, 0, $length - mb_strlen($ending));
        }
    }
    if (!$exact) {
        $spacepos = mb_strrpos($truncate, ' ');
        if (isset($spacepos)) {
            if ($html) {
                $bits = mb_substr($truncate, $spacepos);
                preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                if (!empty($droppedTags)) {
                    foreach ($droppedTags as $closingTag) {
                        if (!in_array($closingTag[1], $openTags)) {
                            array_unshift($openTags, $closingTag[1]);
                        }
                    }
                }
            }
            $truncate = mb_substr($truncate, 0, $spacepos);
        }
    }
    $truncate .= $ending;

    if ($html) {
        foreach ($openTags as $tag) {
            $truncate .= '</' . $tag . '>';
        }
    }

    $truncate = preg_replace('#<a.*?>(.*?)</a>#i', '\1', $truncate);
    $truncate = preg_replace('/(<[^>]+) style="(.*?)"/i', '$1', $truncate);

    return $truncate;

}

function getUrl($parts = [], $postfix = '')
{
    $url = '';
    if (empty($parts)) {
        return '';
    } else {
        foreach ($parts as $part) {
            $url .= $part . '/';
        }

        return trim($url, "/") . $postfix;
    }
}

function imageSizeByCategory($cat_id)
{
    $medium_cats = [336, 352, 379];

    if (in_array($cat_id, $medium_cats)) {
        return "M";
    } else {
        return "S";
    }
}

function getQnA($pid)
{
    $url  = env('Q&A_LINK', 'http://webapi.indiashopps.com/check_file.php?path=ques/') . $pid . ".json";
    $json = file_get_contents($url);
    $qna  = [];
    try {
        $qna = json_decode($json);
    }
    catch (\Exception $e) {
    }

    return $qna;
}

function getMobileReviews($pid, $home = false, $vendor = '', $page = 2)
{
    $review_api = env('REVIEWS_LINK', 'http://webapi.indiashopps.com/api/');

    if (empty($vendor)) {
        if ($home) {
            $url = $review_api . "get-reviews/" . $pid . "/home";
        } else {
            $url = $review_api . "get-reviews/" . $pid;
        }
    } else {
        $url = $review_api . "get-review/" . $vendor . "/" . $pid . "/" . $page;
    }

    $json    = file_get_contents($url);
    $reviews = [];
    try {
        $reviews = json_decode($json);
    }
    catch (\Exception $e) {
    }

    return $reviews;
}

function isSearchPage()
{
    $route = \Request::route()->getName();

    if (in_array($route, ['search_new', 'search'])) {
        return true;
    } else {
        return false;
    }
}

function getJSONContent($file, $append = '_old')
{
    try {
        $data = json_decode(file_get_contents(config($file)));

        if (is_null($data)) {
            unset($data);
            throw new \Exception("JSON file corrupted.");
        }
    }
    catch (\Exception $e) {
        $data = json_decode(file_get_contents(config($file . $append)));
    }

    return $data;
}

function storageJson($path, $key = '')
{
    $json = \Storage::get($path);
    $json = getJSON($json);

    if ($json && is_object($json) && isset($json->{$key})) {
        return $json->{$key};
    } elseif ($json && is_array($json)) {
        return $json;
    } else {
        return $json;
    }
}

function getJSON($string)
{
    return is_string($string) && ($object = json_decode($string)) && (json_last_error() == JSON_ERROR_NONE) ? $object : false;
}

function getNotificationSettings($data)
{
    if (isset($data['pid'])) {
        $notify['id']   = $data['pid'];
        $notify['type'] = 'product';

        if (isset($data['data']) && isset($data['data']->product_detail)) {
            $notify['category_id'] = $data['data']->product_detail->category_id;
        }
    } elseif (isset($data['categories']) && isset($data['categories'][0])) {
        $notify['id']   = $data['categories'][0]->parent_id;
        $notify['type'] = 'category';
    } elseif (isset($data['category_id'])) {
        $notify['id']   = $data['category_id'];
        $notify['type'] = 'category';
    }

    if (isset($notify) && !empty($notify)) {
        echo "var show_notification = true;";
        echo "var notification_params = JSON.parse('" . json_encode($notify) . "')";
    }
}

function isDesktop()
{
    return ((new Jenssegers\Agent\Agent())->isDesktop()) ? true : false;
}

function isMobile()
{
    $a = (new Jenssegers\Agent\Agent());

    $return = ($a->isMobile() || $a->isPhone()) ? true : false;

    return $return;
}

function isAmpPage()
{
    if (!is_null(request()->route())) {
        if (stripos(request()->route()->getName(), 'amp.') !== false || stripos(request()
                ->route()
                ->getName(), 'amp_') !== false
        ) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function average($data, $key)
{
    $total = 0;
    $sum   = 0;

    foreach ($data as $d) {
        $sum += $d->$key;
        $total++;
    }

    return round(($sum / $total), 2);
}

function percent($sum, $count)
{
    $percent = ((float)$sum / (int)$count) * 100;
    $percent = ($percent > 0) ? $percent : 1;

    return round($percent);
}

function secureUrl($url, $force = false)
{
    if ($force) {
        $url = str_replace('http://', 'https://', $url);
    }

    return $url;
}

function secureAssets($path)
{
    $path = asset($path);

    if (isHomePage()) {
        $path = secureUrl($path);
    }

    return $path;
}

function isHomePage()
{
    $route = Request::route();

    if (isset($route) && $route instanceof \Illuminate\Routing\Route) {
        if ($route->getName() == 'home_v2') {
            return true;
        }
    }

    return false;
}

function product_image($image_url, $size = false)
{
    $image_url = getImageNew($image_url, $size);

    if (isHomePage()) {
        $image_url = secureUrl($image_url);
    }

    return $image_url;
}

function checkLink($url)
{
    if (!empty($url) && stripos($url, 'indiashopps.com') === false) {
        return 'rel="nofollow"';
    }

    return '';
}

function youTubePlayer($product_name, $youtube_url)
{
    if (isMobile()) {
        $height = '350px';
    } else {
        $height = '450px';
    }

    $html = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "<iframe src=\"//www.youtube.com/embed/$2\" allowfullscreen height='" . $height . "' width='100%' style='border: none;'></iframe>", $youtube_url);

    return $html;
}

function ampYouTubePlayer($youtube_url)
{
    $html = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "<amp-youtube data-videoid='$2' layout='responsive' width='480' height='270'></amp-youtube>", $youtube_url);

    return $html;
}

function canonical_url_list()
{
    $route      = \Request::route();
    $uri        = $route->uri();
    $parameters = $route->parameters();

    if (!is_null($route)) {
        $url = url($uri);

        if (isMobile()) {
            if (stripos($url, '-price-list-in-india') !== false) {
                $url = str_replace('-price-list-in-india', '', $url);
            }
        }

        foreach ($parameters as $parameter => $value) {
            if ($parameter != "page") {
                $url = str_replace("{" . $parameter . "}", $value, $url);
                $url = str_replace("{" . $parameter . "?}", $value, $url);
            }
        }

        $url = str_replace('-{page?}', '', $url);
        $url = str_replace('-{page}', '', $url);
        $url = str_replace('/{page}', '', $url);
        $url = str_replace('/{page?}', '', $url);
        $url = str_replace('-{vendor?}', '', $url);
    }

    if (isAmpPage()) {
        $url = str_replace($route->getPrefix(), "", $url);
    }

    if (isset($url)) {
        return '<link rel="canonical" href="' . str_replace('-{page?}', '', $url) . '" />';
    }

    return false;
}

function checkBrandListingPageRedirect($route)
{

    if (empty($route->getParameter('category')) || empty($route->getParameter('id'))) {
        return redirect('home_v2');
    }

    $row = \DB::table('gc_cat')->select(['name'])->where('id', '=', $route->getParameter('id'))->first();

    if (stripos($route->getParameter('category'), $row->name) === false) {
        $parts = explode('-', $route->getParameter('category'));
        $group = $parts[0];
        unset($parts[0]);
        $category = implode('-', $parts);
        return redirect(route('brand_category_list', [$route->getParameter('brand'), $group, $category]), 301);
    }
}

function send_slack_alert($message, $channel = 'general')
{
    $ch   = curl_init("https://slack.com/api/chat.postMessage");
    $data = http_build_query([
        "token"    => env('SLACK_TOKEN'),
        "channel"  => $channel,
        "text"     => $message,
        "username" => "Indiashopps BOT",
    ]);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

function coupons_canonical_url()
{
    $route = Request::route();
    $route->forgetParameter('page');
    $route_name = $route->getName();

    return route($route_name, $route->parameters());
}

function show_loans_dropdown()
{
    $routes = [
        'home_v2',
        '_list',
        'sub_category',
        'product_list'
    ];

    if (!is_null(Request::route()) && in_array(Request::route()->getName(), $routes)) {
        return true;
    }

    return false;
}

function raw_content($path, $minify = false)
{
    if (file_exists($path)) {
        if ($minify) {
            $search = [
                '/\>[^\S ]+/s',
                '/[^\S ]+\</s',
                '/(\s)+/s',
                '/<!--(.|\s)*?-->/',
                '/\/\*\*(.*)\*\*\//',
                '/\\n/',
            ];

            $replace = [
                '>',
                '<',
                '\\1',
                '',
                '',
                '',
            ];

            $content = preg_replace($search, $replace, file_get_contents($path));
            return $content;
        } else {
            return file_get_contents($path);
        }
    }

    return '';
}

function ajaxFormFields($page)
{
    echo '<input type="hidden" name="_token" value="' . csrf_token() . '" />
                    <input type="hidden" name="page_section" value="' . $page . '" />
                    <input type="hidden" name="type" value="mobile_pages" />';
}

function isInvalidCaptcha($response)
{
    $verify_url = 'https://www.google.com/recaptcha/api/siteverify';

    $post['response'] = $response;
    $post['secret']   = env('CAPTCHA_SECRET', '6LfU1DUUAAAAAPaR_tYCJcc2cG9vwmi9weI_GS14');

    $client   = new \Guzzle\Http\Client();
    $response = $client->post($verify_url, [], $post)->send();
    $response = json_decode((string)$response->getBody());

    if ($response->success) {
        return false;
    } elseif (count($response->{'error-codes'}) > 0) {
        $message = 'Captcha Error:: ';

        foreach ($response->{'error-codes'} as $error) {
            $message .= unslug($error);
        }

        return $message;
    }
}

function get_file_url($file)
{
    $version_path = config('app.version_path');

    return "/" . $version_path . "/" . $file;
}

function getAjaxAttr($section = '', $carousel = true)
{
    if (empty($section)) {
        return '';
    } else {
        if ($carousel) {
            return 'class="ajax_load" data-carousel="yes" data-section="' . $section . '"';
        } else {
            return 'class="ajax_load" data-section="' . $section . '"';
        }
    }
}

function frontEndVersion()
{
    if (\Storage::has('indiashopps_version')) {
        $version = Storage::get('indiashopps_version');
    } else {
        $version = 10000;
    }

    return (int)$version;
}

function versionChanged()
{
    $cook_version = request()->cookie('front_version');
    $cook_version = str_replace('s:5:"',"",$cook_version);
    $cook_version = str_replace('";',"",$cook_version);
    if ($cook_version != frontEndVersion()) {
        return true;
    }
    return false;
}

function hasWidgets()
{
    if (class_exists("WidgetManager")) {
        return true;
    } else {
        return false;
    }
}

function enqueueWidget($component_name, $variables = [], $variable = '', $atf = false)
{
    if (hasWidgets()) {
        \WidgetManager::addComponent($component_name, $variables, $variable, $atf);
    }
}

function getAjaxWidget($component_name, $variables = [], $variable = '', $data = [])
{
    if (hasWidgets()) {
        return \WidgetManager::getAjaxComponent($component_name, $variables, $variable, $data);
    }
}

function renderWidget($component_name)
{
    return (hasWidgets()) ? \WidgetManager::getComponent($component_name) : '';
}

function getWidgetsFooterResources()
{
    return (hasWidgets()) ? \WidgetManager::getFooterResources() : '';
}

function getWidgetsAboveTheFoldResources()
{
    return (hasWidgets()) ? \WidgetManager::getAboveTheFoldResources() : '';
}

function replaceAll($search, $replace, $string)
{
    return preg_replace('/[' . $search . ']+/', $replace, trim($string));
}

function categoryLink($categories = [])
{
    if (!is_array($categories)) {
        return url('/');
    }

    foreach ($categories as $key => $cat) {

        if (stripos($cat, 'price-list-in-india') != false) {
            $cat = explode(config('app.seoURL'), $cat)[0];
        }

        $categories[$key] = create_slug($cat);

    }
    
    switch (count($categories)) {
        case 1:
            $route = (isAmpPage()) ? 'amp.category_list' : 'category_list';
            $link  = route($route, $categories);
            break;

        case 2:
            $route = (isAmpPage()) ? 'amp.sub_category' : 'sub_category';
            $link  = route($route, $categories) . config('app.seoURL') . ".html";
            break;

        case 3:
            $route = (isAmpPage()) ? 'amp.product_list' : 'product_list';
            $link  = route($route, $categories) . config('app.seoURL') . ".html";
            break;

        default:
            $link = url('/');
            break;
    }

    return $link;
}

function fromCamelCase($input)
{
    preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);

    $ret = $matches[0];
    foreach ($ret as &$match) {
        $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
    }
    return implode('_', $ret);
}

function range_html_old($min, $max)
{
    $sections = 5;
    $number   = $max;
    $divider  = 1000;

    if ($max <= 1000) {
        $divider = 100;
    }

    $part = $number / $sections;

    for ($i = 1; $i <= $sections; $i++) {
        $number = (((int)((int)$part / $divider) * $divider) * $i);

        if ((int)$number > (int)$min) {
            $parts[] = $number;
        }
    }
    $last = 0;
    $html = '';

    foreach ($parts as $key => $value) {
        if ($key == 0) {
            $html = '<input type="checkbox" id="c' . $key . '" name="cc">';
            $html .= '<label for="c' . $key . '"><span></span>Below Rs. ' . $value . ' <b>( 245 )</b></label>';
        } else {
            if ($max - $value >= $divider) {
                if ($key == (count($parts) - 1)) {
                    $html .= '<input type="checkbox" id="c' . $key . '" name="cc">';
                    $html .= '<label for="c' . $key . '"><span></span>Rs. ' . $value . ' and above <b>( 245 )</b></label>';
                } else {
                    $html .= '<input type="checkbox" id="c' . $key . '" name="cc">';
                    $html .= '<label for="c' . $key . '"><span></span>Rs ' . $last . ' - ' . $value . ' <b>( 245 )</b></label>';
                }
            } else {
                $html .= '<input type="checkbox" id="c' . $key . '" name="cc">';
                $html .= '<label for="c' . $key . '"><span></span>Rs. ' . $last . ' and above <b>( 245 )</b></label>';
            }
        }

        $last = $value;
    }

    return $html;
}

function range_html($ranges, $min, $max)
{
    $html = '';

    foreach ($ranges->buckets as $key => $range) {
        if ($range->doc_count > 0) {
            if (stripos($range->key, "*-") !== false) {
                $html = '<input type="radio" id="chk' . $min . "-" . $range->to . '" data-field="price_range" name="price_range" class="fltr__src" value="' . $range->key . '">';
                $html .= '<label for="chk' . $min . "-" . $range->to . '"><span></span>Below Rs. ' . $range->to . ' <b>( ' . $range->doc_count . ' )</b></label>';
            } elseif (stripos($range->key, "-*") !== false && $range->doc_count > 0) {
                $html .= '<input type="radio" id="chk' . $range->from . '-' . $max . '" data-field="price_range" name="price_range" class="fltr__src" value="' . $range->key . '">';
                $html .= '<label for="chk' . $range->from . '-' . $max . '"><span></span>Rs. ' . $range->from . ' and above <b>( ' . $range->doc_count . ' )</b></label>';
            } elseif ($range->doc_count > 0) {
                $html .= '<input type="radio" id="chk' . $range->from . '-' . $range->to . '" data-field="price_range" name="price_range" class="fltr__src" value="' . $range->key . '">';
                $html .= '<label for="chk' . $range->from . '-' . $range->to . '"><span></span>Rs ' . $range->from . ' - ' . $range->to . ' <b>( ' . $range->doc_count . ' )</b></label>';
            }
        }
    }

    return $html;
}

function price_range($min, $max)
{
    if (empty($min) || empty($max)) {
        return false;
    }

    $sections = 5;
    $number   = $max;
    $divider  = 1000;

    if ($max <= 1000) {
        $divider = 100;
    }

    $part = $number / $sections;
    $last = 0;

    for ($i = 1; $i <= $sections; $i++) {
        $number = (((int)ceil((int)$part / $divider) * $divider) * $i);

        if ((int)$number > (int)$min) {
            $parts[] = $number;
        }
    }
    $tabs = [];

    $keys = ['one', 'two', 'three', 'four', 'five', 'six'];

    foreach ($parts as $key => $value) {
        if ($key == 0) {
            $tabs[$keys[$key]] = 'Below &#8377; ' . number_format($value);

            $ranges[] = $min . "-" . $value;
        } else {
            if ($max - $value >= $divider) {
                if ($key == (count($parts) - 1)) {
                    $tabs[$keys[$key]] = '&#8377; ' . number_format($value) . " and Above";
                    $ranges[]          = $value . "-" . $max;
                } else {
                    $tabs[$keys[$key]] = '&#8377; ' . number_format($last) . " - &#8377; " . number_format($value);
                    $ranges[]          = $last . "-" . $value;
                }
            } else {
                $tabs[$keys[$key]] = '&#8377; ' . number_format($last) . " and Above";
                $ranges[]          = $last . "-" . $max;
            }
        }

        $last = $value;
    }

    return ['tabs' => $tabs, 'price_range' => $ranges];
}

function getCategoryUrl(\indiashopps\Category $category)
{
    if (isset($category->parent)) {
        if (empty($category->parent->parent_id)) {
            $url = categoryLink([$category->parent->name, $category->name]);
        } else {
            $url = categoryLink([$category->parent->parent->name, $category->parent->name, $category->name]);
        }
    } else {
        $url = categoryLink([$category->name]);
    }

    return $url;
}

function getCouponImage($img, $size = 'S')
{
    if (stripos($img, "small-card") !== false) {
        switch ($size) {
            case 'L':
            case 'big':
            case 'BIG':
                $img = str_replace('small-card', 'large', $img);
                break;

            default:
                break;
        }
    }

    return $img;
}

function brandProductList($brand, \indiashopps\Category $cat)
{
    if (isAmpPage()) {
        if (in_array($cat->group_name, config('listing.brand.groups'))) {
            return route('amp.brands.listing', [cs($cat->group_name), cs($brand), cs($cat->name)]);
        }

        return route('amp.brand_category_list', [
            cs($brand),
            cs($cat->group_name),
            cs($cat->name)
        ]);
    }

    if (in_array(strtolower($cat->group_name), config('listing.brand.groups'))) {
        return route('brands.listing', [cs($cat->group_name), cs($brand), cs($cat->name)]);
    }

    return route('brand_category_list', [
        cs($brand),
        cs($cat->group_name),
        cs($cat->name)
    ]);
}

function getStructuredDataJson($vars)
{
    $structured_data = '';

    $route = request()->route();

    if (isset($route) && !is_null($route)) {
        switch ($route->getName()) {
            case 'home_v2';
                $structured_data .= '<script type="application/ld+json"> { "@context": "http://schema.org", "@type": "WebSite", "name": "IndiaShopps", "alternateName": "IndiaShopps", "url": "https://www.indiashopps.com/", "potentialAction": { "@type": "SearchAction", "target": "https://www.indiashopps.com/search/0/{searchTerms}", "query-input": "required name=searchTerms" } } </script>';
                $structured_data .= '<script type="application/ld+json"> { "@context": "http://schema.org", "@type": "Organization", "url": "https://www.indiashopps.com", "sameAs": [ "https://www.facebook.com/indiashopps", "https://plus.google.com/+indiashopps/", "https://www.linkedin.com/company/indiashopps/", "https://twitter.com/indiashopps", "https://www.youtube.com/channel/UC2FUadoNGd6LfZZEuhnRCAg" ], "logo": "https://www.indiashopps.com/assets/v3/images/logo.png" } </script>';
                break;

            case 'sub_category':
            case 'category_list':
            case 'product_list':
            case 'brands.listing':
            case 'amp.sub_category':
            case 'amp.category_list':
            case 'amp.product_list':
            case 'amp.brands.listing':
            case 'brand_category_list_comp':
            case 'brand_category_list_comp_1':
                $webpage = [
                    '@context'    => 'http://schema.org',
                    '@type'       => 'WebPage',
                    'description' => app('seo')->getDescription(),
                    'url'         => \Request::url(),
                    'publisher'   => [
                        '@type' => 'Organization',
                        'name'  => 'IndiaShopps.com',
                        'logo'  => asset('images/v1/indiashopps_logo-final.png'),
                    ],
                    'name'        => app('seo')->getHeading(),
                ];

                $structured_data .= '<script type="application/ld+json">' . json_encode($webpage) . '</script>';

                if (\Breadcrumbs::generate()->count() > 0) {
                    $json = [
                        '@context'        => 'http://schema.org',
                        '@type'           => 'BreadcrumbList',
                        'itemListElement' => [],
                    ];

                    $i = 1;

                    foreach (Breadcrumbs::generate() as $breadcrumb) {
                        $json['itemListElement'][] = [
                            '@type'    => 'ListItem',
                            'position' => $i++,
                            'item'     => [
                                '@type' => 'WebPage',
                                '@id'   => url($breadcrumb->url),
                                'name'  => $breadcrumb->title,
                                'url'   => url($breadcrumb->url)
                            ],
                        ];
                    }

                    $structured_data .= '<script type="application/ld+json">' . json_encode($json) . '</script>';
                    if (session()->has('second_category_bread')) {
                        session()->forget('second_category_bread');
                    }
                }

                break;

            case 'product_detail_non':
            case 'product_detail':
            case 'product_detail_v2':
            case 'amp_detail_comp':
            case 'amp_detail_books':

                if (isset($vars['main_product']) && !is_null($vars['main_product'])) {
                    $product = $vars['main_product'];

                    if (isset($product->_source)) {
                        $product = $product->_source;
                    }

                    if (isset($product->image_url)) {
                        $img = getImageNew($product->image_url);;
                    }

                    $description = app('seo')->getDescription();

                    $sellers = '';

                    if (is_array($product->vendor) && count($product->vendor) > 0) {
                        $sellers = '"seller": [';

                        foreach ($product->vendor as $v) {
                            $sellers .= '{';
                            $sellers .= '"@type": "Organization",';
                            $sellers .= '"name": "' . config('vendor.name.' . $v) . '",';
                            $sellers .= '"url": "' . config('vendor.url.' . $v) . '",';
                            $sellers .= '"logo": "' . config('vendor.vend_logo.' . $v) . '"';
                            $sellers .= '},';
                        }
                        $sellers = ", " . trim($sellers, ",");

                        $sellers .= "]";
                    }

                    if ($product->track_stock == 1) {
                        $availability = 'https://schema.org/InStock';
                    } else {
                        $availability = 'https://schema.org/OutOfStock';
                    }

                    if (!empty($product->color) && !in_array($product->color, ['null', 'NULL'])) {
                        if (is_array($product->color)) {
                            $colors = $product->color;
                        } else {
                            $colors = trim($product->color, ']');
                            $colors = trim($colors, '[');
                            $colors = explode(":", $colors);
                        }

                        if (count($colors) > 0) {
                            if (count($colors) > 1) {
                                $colors[count($colors) - 1] = "and " . array_last($colors);
                            }

                            $colors = implode(", ", $colors);
                        } else {
                            $colors = 'Black, and White';
                        }
                    } else {
                        $colors = 'Black, and White';
                    }

                    $highPrice = (!empty($product->price)) ? $product->price : $product->saleprice;

                    if (hasKey($product, 'rating', 'rating_count')) {
                        $rating = '"aggregateRating": {
                                            "@type": "AggregateRating",
                                            "ratingValue": "' . $product->rating . '",
                                            "reviewCount": "' . $product->rating_count . '",
                                            "bestRating" : "5"
                                          },';
                    } else {
                        $rating = '';
                    }

                    if (isComingSoon($product)) {
                        $structured_data .= '<script type="application/ld+json">
                                        {
                                          "@context": "http://schema.org/",
                                          "@type": "Product",
                                          ' . $rating . '
                                          "name": "' . $product->name . '",
                                          "image": "' . $img . '",
                                          "description": "' . $description . '",
                                          "category" : "' . ucwords($product->category) . '",
                                          "color" : "' . $colors . '",
                                          "brand": {
                                            "@type": "Brand",
                                            "name": "' . ucwords($product->brand) . '"
                                          },
                                          "offers": {
                                            "@type": "AggregateOffer",
                                            "priceCurrency" : "INR",
                                            "lowPrice": "' . round($product->saleprice) . '",
                                            "highPrice": "' . round($product->saleprice) . '",
                                            "availability":"https://schema.org/PreOrder",
                                            "itemCondition":"https://schema.org/NewCondition"
                                            }
                                          }
                                        </script>';
                    } else {
                        $structured_data .= '<script type="application/ld+json">
                                {
                                  "@context": "http://schema.org/",
                                  "@type": "Product",
                                  "name": "' . $product->name . '",
                                  "image": "' . $img . '",
                                  "description": "' . $description . '",
                                  "category" : "' . ucwords($product->category) . '",
                                  "color" : "' . $colors . '",
                                  "brand": {
                                            "@type": "Brand",
                                            "name": "' . ucwords($product->brand) . '"
                                          },
                                  ' . $rating . '
                                  "offers": {
                                    "@type": "AggregateOffer",
                                    "priceCurrency" : "INR",
                                    "lowPrice": "' . round($product->saleprice) . '",
                                    "highPrice": "' . $highPrice . '",
                                    "offerCount": "' . count($product->vendor) . '",
                                    "availability":"' . $availability . '",
                                    "itemCondition":"https://schema.org/NewCondition"
                                    }
                                  }
                          </script>';
                    }
                }

            default:
                break;
        }
    }

    return $structured_data;
}

function getCouponsCats()
{
    $cats = \Illuminate\Support\Facades\Cache::remember('coupons_cats', 36000000, function () {
        return \indiashopps\Models\DealsCat::all()->toArray();
    });

    return $cats;
}

function setUpGlobals(&$variable)
{
    if (!is_null(request()->route())) {
        $route = request()->route()->getName();

        if ($vars = config('gtm.variables.' . $route)) {
            $variables = [];
            foreach ($vars as $var) {
                if (isset($variable[$var])) {
                    $variables[$var] = $variable[$var];
                }
            }

            app('config')->set('gtm.page_variables', $variables);
        } else {
            app('config')->set('gtm.page_variables', ['is_mobile' => isMobile()]);
        }

        $detail_routes = [
            'product_detail_v2',
            'product_detail_non_book',
            'product_detail_non',
            'amp_detail_comp',
            'amp_detail_non_comp',
            'amp_detail_books'
        ];

        if (in_array($route, $detail_routes)) {
            app('config')->set('is_detail_page', true);
        }
    }
}

/**
 * @return String
 */
function getHeadTagContent()
{
    if (class_exists("GTM")) {
        \GTM::processPageInformation();
        $content = getTagContent('html.content.head');

        return $content;
    } else {
        return '';
    }
}

function getBodyTagContent()
{
    if (class_exists("GTM")) {
        $content = getTagContent('html.content.body');

        return $content;
    } else {
        return '';
    }
}

function pageType(&$route)
{
    if (is_null($route)) {
        return 'discontinued_page';
    }

    $routes = [
        'home_v2'                    => "home_page",
        "aboutus_v2"                 => 'about_us',
        'register_v2'                => 'registration_page',
        'login_v2'                   => 'login_page',
        'category_page_v2'           => 'coupon_category_page',
        'coupons_v2'                 => 'coupons_home_page',
        'vendor_page_v2'             => 'coupons_vendor_page',
        'product_detail_v2'          => 'product_detail_page_comparative',
        'product_detail_non'         => 'product_detail_page_non_comparative',
        'myaccount'                  => 'user_accounts_page',
        'most-compared'              => 'most_compared_mobiles_page',
        'compare-mobiles'            => 'product_compare_page',
        'amp_detail_non_comp'        => 'product_detail_non_comp_amp',
        'amp_detail_comp'            => 'product_detail_comp_amp',
        'smartphone'                 => 'listing_page_mobile_smartphones',
        'dual_sim'                   => 'listing_page_mobile_dual_sim',
        'android_phones'             => 'listing_page_mobile_android_phones',
        'windows_phones'             => 'listing_page_mobile_windows_phones',
        'listing'                    => 'listing_page_category_group_wise',
        'list_of_category'           => 'listing_page_category_keywords',
        'bbphones'                   => 'listing_page_brand_wise_mobile',
        'bbetphones'                 => 'listing_page_mobile_between_price',
        'bestphones'                 => 'listing_page_mobile_under_price',
        'brand_category_list_comp_1' => 'listing_page_brand_and_category_comp',
        'brand_category_list'        => 'listing_page_brand_and_category_non_comp',
        'sub_category'               => 'listing_page_second_level_category',
        'product_list'               => 'listing_page_third_level_category',
        'custom_page_list'           => 'listing_page_custom_page',
        'custom_page_list_v3'        => 'listing_page_custom_page',
        'trending'                   => 'hot_trending_products',
        'all-cat'                    => 'all_category_list',
        'category_list'              => 'category_list_first_level',
    ];

    switch ($route) {
        case array_key_exists($route, $routes):
            $type = $routes[$route];
            break;

        default:
            $type = $route;
            break;
    }

    return $type;
}


/**
 * @return String
 */
function getFooterContent()
{
    if (class_exists("GTM")) {
        $content = getTagContent('html.content.footer');

        return $content;
    } else {
        return '';
    }
}

function getTagContent($key)
{
    $html     = '';
    $contents = config($key);

    if (!empty($contents) && is_array($contents)) {
        foreach ($contents as $content) {
            $html .= $content;
        }

    }
    return $html;
}

function isComparativeProduct($product)
{
    if (!empty($product) && is_object($product)) {
        if (isset($product->vendor)) {
            $vendor = $product->vendor;
        } else {
            $vendor = false;
        }

        if (isset($vendor) && (is_array($vendor) || empty($vendor))) {
            return true;
        }

        return false;
    }
}

function hasExitPopup($vars)
{
    $routes = env('POPUP_ROUTES', []);
    $html   = "";

    if (!is_array($routes)) {
        try {
            $routes = array_filter(explode(",", $routes));
        }
        catch (\Exception $e) {
            $routes = [];
        }
    }

    if (!is_null(request()->route())) {
        $route = request()->route()->getName();

        if (in_array($route, $routes)) {

            if ($route == 'home_v2' && auth()->check()) {
                $html = '';
            } else {
                $html .= "<script>var isExitPopupPage = true; var page = '" . $route . "';";
                if (isset($vars['prod']) && !empty($vars['prod']) && $route != "category_list") {
                    $html .= "var product ='" . $vars['prod'] . "'";
                }
                $html .= "</script>";
            }
        }
    }

    return $html;
}

function is_collection($var)
{
    if ($var instanceof \Illuminate\Support\Collection) {
        return true;
    }

    return false;
}

function isComingSoon($product)
{
    if (isset($product->availability) && $product->availability == 'Coming Soon') {
        return true;
    }


    return false;
}

function getAmpPageCss($css_file = '')
{
    if (isAmpPage()) {
        if (isDiscontinued()) {
            return file_get_contents(resource_path("views/v3/amp_detail_comp.css"));
        }

        if (!empty($css_file)) {
            $route = "amp/css/" . $css_file;
        } else {
            $route = request()->route()->getName();
        }

        $file = str_replace("amp.", "amp/css/", $route);
        $file = resource_path("views/v3/" . $file . ".css");

        return file_get_contents($file);
    }
}

function isDiscontinued()
{
    if (config('amp_page', false) === true) {
        return true;
    } else {
        return false;
    }
}

function ampStar($rating)
{
    $rating = ($rating > 5) ? 5 : $rating;
    $full   = floor($rating);
    $stars  = str_repeat('<div class="greycolor"><span class="fullstar"></span></div>', $full);

    if ($full < 5) {
        if ($full != $rating) {
            $stars .= '<div class="greycolor"><span class="halfstar"></span></div>';

            if (abs(4 - $full) > 0) {
                $stars .= str_repeat('<div class="greycolor"><span class="emptystar"></span></div>', abs(4 - $full));
            }
        } else {
            if (abs(5 - $full) > 0) {
                $stars .= str_repeat('<div class="greycolor"><span class="emptystar"></span></div>', abs(5 - $full));
            }
        }
    }

    return $stars;
}

function ampListingCanonical()
{
    $routes = ['product_list', 'sub_category','brands.listing'];
    $route  = request()->route();

    if (in_array(request()->route()->getName(), $routes)) {
        $name   = "amp." . $route->getName();
        $params = $route->parametersWithoutNulls();

        if((request()->route()->getName()=='brands.listing') && isDesktopPage()){
            return '<link rel="amphtml" href="' . route($name, $params) . '"/>';
        }
        else if((request()->route()->getName()=='brands.listing') && isMobile()){
            return '';
        }
        else{
            return '<link rel="amphtml" href="' . route($name, $params) . '.html"/>';
        }
    } else {
        return '';
    }
}

function isDesktopPage()
{
    return (!isAmpPage() && !isMobile());
}

function getFileContent($files = [])
{
    if (!empty($files) && is_array($files)) {
        $content = \Illuminate\Support\Facades\Cache::remember('header_css', 2880, function () use ($files) {
            $content = '';

            foreach ($files as $file) {
                if (file_exists($file)) {
                    $content .= file_get_contents($file);
                }
            }

            return $content;
        });

        return $content;
    }
}

function isValidLink($link)
{
    if (isset($link) && !empty($link) && filter_var($link, FILTER_VALIDATE_URL)) {
        return true;
    } else {
        return false;
    }
}

function getRange($ranges)
{
    $response = [];
    $last_key = collect($ranges)->keys()->last();

    foreach ($ranges as $key => $range) {
        if ($key == 0) {
            $response[] = "Below &#8377; " . number_format($range->max);
        } elseif ($last_key == $key) {
            $response[] = "Above &#8377; " . number_format($range->min);
        } else {
            $response[] = "&#8377; " . number_format($range->min) . " - &#8377; " . number_format($range->max);
        }
    }

    return $response;
}

function proUrl($url, $force_https = false)
{
    if ($force_https && stripos($url, 'linksredirect') !== false) {
        return str_replace("http://", "https://", $url);
    }

    return $url;
}

function getJsFile()
{
    switch (request()->route()->getName()) {
        case 'product_detail_v2':
        case 'product_detail_non':
        case 'product_detail_non_book':
            $file = "detail.js";
            break;

        case 'android_phones':
        case 'windows_phones':
        case 'listing':
        case 'list_of_category':
        case 'bbphones':
        case 'bbetphones':
        case 'bestphones':
        case 'brand_category_list_comp_1':
        case 'brand_category_list':
        case 'sub_category':
        case 'product_list':
        case 'custom_page_list':
        case 'custom_page_list_v3':
        case 'search_new':
        case 'upcoming_mobiles':
        case 'list_of_men_women':
        case 'brands.listing':
            $file = "listing.js";
            break;

        case 'category_page_v2':
        case 'coupons_v2':
        case 'vendor_page_v2':
        case 'coupon_search':
            $file = "coupons.js";
            break;

        default:
            $file = "bottom.js";
            break;
    }

    if (isMobile()) {
        try {
            $file = mix('build/mobile/js/' . $file);
        }
        catch (\Exception $e) {
            $file = '/backup/build/mobile/js/' . $file;
        }
    } else {
        try {
            $file = mix('build/js/' . $file);
        }
        catch (\Exception $e) {
            $file = '/backup/build/js/' . $file;
        }
    }

    return $file;
}

function getCssFile()
{
    $file = "app.css";

    if (isMobile()) {
        try {
            $css_file = mix('build/mobile/css/' . $file);
        }
        catch (\Exception $e) {
            $css_file = '/backup/build/mobile/css/' . $file;
        }
    } else {
        try {
            $css_file = mix('build/css/' . $file);
        }
        catch (\Exception $e) {
            $css_file = '/backup/build/css/' . $file;
        }
    }

    return $css_file;
}

function checkDomainCondition()
{
    return env('APP_ENV') == 'production' && env('DISABLE_COOKIELESS', false) === false;
}

function assetsDomain($file)
{
    if (checkDomainCondition()) {
        $assets_domain = 'https://assets.indiashopps.com';
        $file          = $assets_domain . $file;
    } else {
        $file = asset($file);
    }

    return $file;
}

function headerCss()
{
    $content = file_get_contents(base_path('resources/views') . '/v3/common/header.css');

    if (checkDomainCondition()) {
        $content = preg_replace("/\/assets\//", "https://assets.indiashopps.com/assets/", $content);
    }

    $font = '@font-face{font-family:\'CircularSpotifyText\';src:url(/assets/v3/css/CircularSpotifyText-Light.eot);src:url(/assets/v3/css/CircularSpotifyText-Light.eot?#iefix) format("embedded-opentype"),url(/assets/v3/css/CircularSpotifyText-Light.woff) format("woff"),url(/assets/v3/css/CircularSpotifyText-Light.ttf) format("truetype");font-weight:300;font-style:normal}';

    return $font . $content;
}

function changeEnv($data = [])
{
    if (count($data) > 0) {

        $env = file_get_contents(app()->environmentFilePath());
        $env = preg_split('/\s+/', $env);;

        foreach ((array)$data as $key => $value) {
            foreach ($env as $env_key => $env_value) {
                $entry = explode("=", $env_value, 2);

                if ($entry[0] == $key) {
                    $env[$env_key] = $key . "=" . $value;
                } else {
                    $env[$env_key] = $env_value;
                }
            }
        }

        $env = implode("\n", $env);

        file_put_contents(base_path() . '/.env', $env);

        return true;
    } else {
        return false;
    }
}

function processListingHeading($vars)
{
    if ($vars['category_id'] == '351') {
        if (isset($vars['brand'])) {
            return "Best " . ucwords($vars['brand']) . " Mobile Phones Products (" . \Carbon\Carbon::now()
                                                                                                   ->format('Y') . ")";
        } else {
            return 'Best Mobile Phones Products (' . \Carbon\Carbon::now()->format('Y') . ')';
        }
    }

    if ($vars['book']) {
        return 'Best ' . ucwords($vars['c_name']) . ' Books List (' . \Carbon\Carbon::now()->format('Y') . ')';
    }

    if (isset($vars['brand'])) {
        return 'Best ' . ucwords($vars['brand']) . ' ' . ucwords($vars['c_name']) . ' Products (' . \Carbon\Carbon::now()
                                                                                                                  ->format('Y') . ')';
    }

    return 'Best ' . ucwords($vars['c_name']) . ' Products (' . \Carbon\Carbon::now()->format('Y') . ')';
}

function getSnippetField(&$vars, $product = null)
{
    try {
        if (isset($vars['brand_page']) || isset($vars['brand_listing_page'])) {
            $key  = 'meta.list.snippet.brand.' . $vars['category_id'];
            $data = config($key);

            if ($data && isset($data['name']) && $data['key']) {
                if (!is_null($product)) {
                    return (isset($product->{$data['key']})) ? ucwords($product->{$data['key']}) : 'NA';
                } else {
                    return $data['name'];
                }
            }
        } else {
            $key  = 'meta.list.snippet.' . $vars['category_id'];
            $data = config($key);
            if ($data && isset($data['name']) && $data['key']) {
                if (!is_null($product)) {
                    $return = (isset($product->{$data['key']})) ? ucwords($product->{$data['key']}) : 'NA';
                    if (strlen($return) <= 3) {
                        $return = strtoupper($return);
                    }

                    return $return;
                } else {
                    return $data['name'];
                }
            }
        }
    }
    catch (\Exception $e) {
        if (request()->has('debug')) {
            \Log::error($e->getTraceAsString());
        }

        return false;
    }

    return false;
}

/**
 * Checks whether Product has any vendor reviews.
 * @param $vendors
 * @param bool $mutiple
 * @return bool
 */
function hasReviews(&$vendors, $mutiple = true)
{
    $has = false;

    if ($mutiple) {
        foreach ($vendors as $v) {
            if (isset($v->review_link) && !empty($v->review_link)) {
                $has = true;
                break;
            }
        }
    } else {
        if (isset($vendors->review_link) && !empty($vendors->review_link)) {
            $has = true;
        }
    }
    if ($has) {
        return true;
    } else {
        return false;
    }
}

function addAttributesToProductName($product)
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
            if ($product->category_id == \indiashopps\Category::LAPTOPS) {
                $product->name .= ' - ' . implode(" + ", $attributes);
            } else {
                $product->name .= ' ( ' . implode(" + ", $attributes) . ' )';
            }
        }
    }

    return $product->name;
}

function shouldNotIndex($product)
{
    if (isset($product->_source)) {
        $product = $product->_source;
    }

    if (is_string($product->vendor) && !is_array($product->vendor)) {
        $pid    = $product->id . "-" . $product->vendor;
        $groups = ['books', 'home & decor'];

        if (in_array(strtolower($product->grp), $groups)) {

            if (in_array($pid, ['951560-3', '970392-1', '345-3', '19589939-3'])) {
                return false;
            } else {
                return true;
            }
        }
    }

    if (in_array($product->id, ['10164227', '10165098', '10157268'])) {
        return false;
    }

    if (in_array($product->category_id, config('noindex_category'))) {
        return true;
    }

    return false;
}

function changeFkUrl($product)
{
    if (stripos($product->product_url, 'dl.flipkart.com/dl/') !== false) {
        $product->product_url = str_replace('dl.flipkart.com/dl', 'www.flipkart.com', $product->product_url);
    }

    return $product;
}

function productAffLink($p, $ref_id = 0)
{
    if (isset($p->_source)) {
        $p = $p->_source;
    }
    if (isComparativeProduct($p)) {
        if (!empty($ref_id)) {
            return route('product_redirect_comp', [$p->id, $ref_id]);
        } else {
            return $p->product_url;
        }
    }
    return route('product_redirect_non_comp', [$p->id, $p->vendor]);
}

function userHasAccess($permission)
{
    return \Illuminate\Support\Facades\Gate::allows('has-access', $permission);
}

function getSavingAmount($product, $vendors = false)
{
    if ($vendors && collect($vendors)->count() > 1) {
        $vendors = collect($vendors);
        $vendors = $vendors->reject(function ($vendor) {
            return $vendor->_source->track_stock != 1;
        });

        if (!is_null($vendors->last())) {
            return $vendors->last()->_source->saleprice - $vendors->first()->_source->saleprice;
        }

        return 0;

    } elseif ($product->price > 0 && $product->price > $product->saleprice) {
        return $product->price - $product->saleprice;
    }
    return 0;
}

function getCashbackText($vendor_id, $default = true)
{
    $text = getVendorSettings();

    if (isset($text[$vendor_id]) && !empty($text[$vendor_id]['cashback_rate'])) {
        return $text[$vendor_id]['cashback_rate'];
    }

    if ($default) {
        return 'No Cashback';
    }

    return false;
}

function getVendorSettings()
{
    $text = \Illuminate\Support\Facades\Cache::remember('cashback_rate_vendor', 1440, function () {
        $text = \indiashopps\Models\Cashback\VendorSetting::select(['vendor_id', 'cashback_rate'])
                                                          ->where('cashback_enabled', 'Y')
                                                          ->get();

        $text = $text->keyBy('vendor_id')->toArray();

        return $text;
    });

    return $text;
}

function getUserEmail()
{
    return (auth()->check()) ? auth()->user()->email : '';
}

function carbon($date, $output_format = 'd-m-Y', $input_format = false)
{
    if ($input_format !== false) {
        return \Carbon\Carbon::createFromFormat($input_format, $date)->format($output_format);
    }

    try {
        return \Carbon\Carbon::parse($date)->format($output_format);
    }
    catch (\Exception $e) {
        \Log::error("Incorrect Date format function CARBON : " . $e->getTraceAsString());
        return '';
    }
}

function hasKey($var, ...$args)
{
    $has = false;

    foreach ($args as $a) {
        if (isset($var->{$a}) && !empty($var->{$a})) {
            $has = true;
        } else {
            $has = false;
            break;
        }
    }

    return $has;
}

function hasOneUpcomingProduct($products)
{
    $has = false;

    foreach ($products as $product) {
        if (isset($product['details']) && isComingSoon($product['details'])) {
            $has = true;
        }
    }

    return $has;
}

function getSchemaType()
{
    if (config('is_detail_page', false) !== false) {
        return 'http://schema.org/Product';
    }

    return 'http://schema.org/WebPage';
}

function checkSpecification($product)
{
    if (!empty($product)) {
        if (isset($product->specification) && !empty($product->specification)) {
           return true;
        } else {
            return false;
        }
    }
        return false;
}


function homeSliderData($index, $type = 'text')
{
    $links = config('home_slider_links');
   // dd($links);
    if ($links) {
        if (isset($links[$type])) {
            if ($index === 'all') {
                return $links[$type];
            } elseif (isset($links[$type][$index])) {
                return $links[$type][$index];
            }
        }
    }

    return false;
}

function isAddToCompare($product)
{
    $arrGroup =['men','women','Kids'];
    if (!empty($product) && is_object($product)) {
        if (in_array($product->grp,$arrGroup)) {
           return false;
        } else {
            return true;
        }
        return true;
    }
}

function releaseDate($product){
    if(isset($product->release_date)) {
        $cur_date= strtotime(date('Y-m-d'));
        $date = date_create($product->release_date);
        $release_date = date_format($date, "jS F Y");
        if($cur_date > strtotime(date_format($date, "jS F Y")) ){
            $Date = date('Y-m-d');
            return date('jS F Y', strtotime($Date. ' + 3 days'));
        }
        return $release_date;
    }else{
        return false;
    }
}

