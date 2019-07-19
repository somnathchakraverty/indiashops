<?php
namespace indiashopps\Support;

use Gregwar\Image\Image as GImage;
use indiashopps\Models\FacebookPost;

Class Image extends GImage
{
    public function orientation()
    {
        //@todo: Need to change this..one the code is live for AutoPost

        return 'height_rectangle';

        if ($this->getAdapter()->width() > $this->getAdapter()->height()) {
            return 'width_rectangle';
        } elseif ($this->getAdapter()->width() == $this->getAdapter()->height()) {
            return 'sqaure';
        } else {
            return 'height_rectangle';
        }
    }

    public function setup()
    {
        $this->setCacheDir(storage_path('framework/cache'));

        return $this;
    }

    public static function processImage($product)
    {
        if (stripos($product->image_url, "images.indiashopps.com") !== false) {
            $product_image = "https:" . getImageNew($product->image_url, "L");
        } else {
            $product_image = getImageNew($product->image_url, "L");
        }

        $product_img = self::open($product_image);
        $post_banner = collect(config('facebook.' . $product_img->orientation()))->random();
        $bs          = collect($post_banner['settings']);
        $ims         = $bs->get('image');
        /****Setting the Element According to the Banner Settings*/
        $product_img->scaleResize($ims['width'], $ims['height']);

        $image = self::open($post_banner['image']);
        $image->merge($product_img, $ims['left'], $ims['top'], $ims['width'], $ims['height']);

        /*Product Name && PRICE.. */
        $ns      = $bs->get('name');
        $ps      = $bs->get('price');
        $plength = strlen($product->name);

        if ($plength > 14 && $plength <= 17) {
            $ns['left'] -= 20;
        } elseif ($plength <= 10) {
            $ns['left'] += 70;
        } elseif ($plength > 17 && $plength < 22) {
            $ns['size'] -= 10;
            $ns['left'] -= 20;
        } elseif ($plength >= 22) {
            $ns['size'] -= 15;
            $ns['left'] -= 20;
        }

        $image->write(base_path('assets/v3/fonts/circular.ttf'), $product->name, $ns['left'], $ns['top'], $ns['size'], 0, $ns['color'], 'left');
        $image->write(base_path('assets/v3/fonts/circular.ttf'), "Rs " . number_format($product->saleprice), $ps['left'], $ps['top'], $ps['size'], 0, $ps['color'], 'left');
        $file_name = 'share_images/'.str_random(20) . ".png";
        $file_url  = url("storage/" . $file_name);
        $file_path = storage_path($file_name);

        $image->setup()->save($file_path);
        return $file_url;
    }
}