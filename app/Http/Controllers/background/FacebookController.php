<?php

namespace indiashopps\Http\Controllers\background;

use Illuminate\Http\Request;
use indiashopps\Http\Controllers\Controller;
use indiashopps\Models\FacebookPost;
use indiashopps\Support\Image;

class FacebookController extends Controller
{
    public function productUpdate(Request $request)
    {
        if ($request->isMethod('POST') && $request->has('ids')) {
            if (!is_array($request->get('content'))) {
                return response()->json(['Invalid Request'], 400);
            }

            if (is_array($request->get('ids'))) {
                foreach ($request->get('ids') as $product_id) {
                    $product = FacebookPost::whereProductId($product_id)->first();

                    if (is_null($product)) {
                        $product             = new FacebookPost;
                        $product->product_id = $product_id;
                        $product->params     = json_encode($request->get('content'));
                        $product->save();
                    } else {
                        $product->params = json_encode($request->get('content'));
                    }
                }

                return response()->json(['Products Added... !!']);
            } else {
                return response()->json(['Invalid Request'], 400);
            }
        } else {
            return response()->json(['Invalid Request'], 400);
        }
    }

    public function getImage(Request $request, $post_id)
    {
        $post = FacebookPost::whereProductId($post_id)->first();
        if (is_null($post)) {
            return response(['error' => "Invalid Post, please contact Developer..!!"]);
        }
        
        $product = app('solr')->wherePid($post_id)->getProduct(true);
        $file    = Image::processImage($product->product_detail);

        if (!empty($file)) {
            return response(['image_url' => $file]);
        }

        return response(['error' => "Image cannot be processed, please contact Developer..!!"]);
    }

    public function getToken()
    {
        return response(['_token' => csrf_token()]);
    }
}
