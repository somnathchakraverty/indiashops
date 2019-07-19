<?php namespace indiashopps\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Storage;
use File;
use Exception;
use indiashopps\Models\ProductImage;

class ImageController extends Controller
{
    private $_product;

    public function __construct( $product = [] )
    {
        if( !empty($product) )
        {
            $this->_product = $product;
        }
    }

    public function index()
    {
        $image[] = "http://ecx.images-amazon.com/images/I/51KnISjikYL._AA160_.jpg";
        $image[] = "http://ecx.images-amazon.com/images/I/51jeLxhqZTL._AA160_.jpg";
        $image[] = "http://ecx.images-amazon.com/images/I/51CuozF3R0L._AA160_.jpg";
        $image[] = "http://ecx.images-amazon.com/images/I/519S76yaHbL._AA160_.jpg";
        $image[] = "http://ecx.images-amazon.com/images/I/41Bw-soZzUL._AA160_.jpg";
        $image[] = "http://ecx.images-amazon.com/images/I/41c1npb9gSL._AA160_.jpg";

        $this->saveImages($image);
    }

    protected function saveImages($images)
    {
        $widths = array(84, 150, 200, 250, 300);
        $base = base_path() . "/images/v1/resize/";

        if (!empty($images) && is_array($images)) {
            foreach ($images as $image) {
                foreach ($widths as $width) {
                    if (!file_exists($base . $width)) {
                        mkdir($base . $width, 0755);
                    }

                    $file = basename($image);
                    $img = \Image::make($image);

                    $img->resizeCanvas($width, $width);
                    $img->resize($width, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    $img->save($base . $width . "/" . $file, 70);
                }
            }
        }
    }

    public function setProduct( &$product )
    {
        $this->_product = $product;

        return $this;
    }

    public function saveProductImageToLocal()
    {
        if( !empty($this->_product) )
        {
            $directory = getProductImageFolder($this->_product, true);

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $images = [];

            if (is_array(json_decode($this->_product->image_url))) {
                foreach (json_decode($this->_product->image_url) as $key => $image) {
                    if (stripos($image, 'video') === false) {
                        try
                        {
                            $img = \Image::make($image);
                            $file = $this->_product->id . (($key == 0) ? '' : '-' . $key) . $this->imageExtension($img);

                            if (!File::exists($directory . $file))
                            {
                                $img->save($directory . $file, 70);
                            }

                            $images[] = getProductImageFolder($this->_product).$file;
                        }
                        catch (\Exception $E)
                        {
                            \Log::error("Image Not Returned :: $image ".$E->getMessage());
                        }
                    }

                }

                if(count($images) > 0)
                {
                    $product_image = new ProductImage;
                    $product_image->product_id = $this->_product->id;
                    $product_image->image_url = json_encode($images);
                    $product_image->save();
                }

            } else {
                try
                {
                    $img = \Image::make($this->_product->image_url);
                    $file = $this->_product->id;

                    $img->save($directory . $file, 70);

                    $images[] = getProductImageFolder($this->_product). $file;
                }
                catch (\Exception $E)
                {
                    \Log::error("Image Not Returned :: ".$this->_product->id."::".$E->getMessage());
                }

                if(count($images) > 0)
                {
                    $product_image = new ProductImage;
                    $product_image->product_id = $this->_product->id;
                    $product_image->image_url = json_encode($images);
                    $product_image->save();
                }

                return true;
            }
        }
        else
        {
            return false;
        }
    }

    public function imageExtension($image)
    {
        $mime = $image->mime();  //edited due to updated to 2.x

        if ($mime == 'image/jpeg')
            $extension = '.jpg';
        elseif ($mime == 'image/png')
            $extension = '.png';
        elseif ($mime == 'image/gif')
            $extension = '.gif';
        else
            $extension = '';

        return $extension;
    }

    public function initiateUpload()
    {
        $image[] = "http://ecx.images-amazon.com/images/I/51KnISjikYL._AA160_.jpg";
        $image[] = "http://ecx.images-amazon.com/images/I/51jeLxhqZTL._AA160_.jpg";
        $image[] = "http://ecx.images-amazon.com/images/I/51CuozF3R0L._AA160_.jpg";
        $image[] = "http://ecx.images-amazon.com/images/I/519S76yaHbL._AA160_.jpg";
        $image[] = "http://ecx.images-amazon.com/images/I/41Bw-soZzUL._AA160_.jpg";
        $image[] = "http://ecx.images-amazon.com/images/I/41c1npb9gSL._AA160_.jpg";

        foreach ($image as $img) {
            $this->uploadImageToS3($img);
        }
    }

    public function uploadImageToS3($image)
    {
        $base = base_path() . "/images/v2/amazon/";

        if (!file_exists($base)) {
            mkdir($base, 0755);
        }

        $file = basename($image);
        $img = \Image::make($image);

        $img->save($base . $file, 70);
        $s3 = Storage::disk('s3');

        $filePath = '/product-images/' . $file;

        $s3->put($filePath, file_get_contents($base . $file), 'public');
    }

}