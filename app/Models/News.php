<?php

namespace indiashopps\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public static function getProductNews($product)
    {
        if (is_object($product) && isset($product->name)) {
            if (isComparativeProduct($product)) {
                $product_id = $product->id;
            } else {
                $product_id = $product->id . "-" . $product->vendor;
            }

            return self::query()->where('product_id', $product_id)->take(3)->orderBy('created_at', 'DESC')->get();
        }

        return [];
    }
}
