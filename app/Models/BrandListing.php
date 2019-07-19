<?php

namespace indiashopps\Models;

use Illuminate\Database\Eloquent\Model;

class BrandListing extends Model
{
    protected $table = 'brand_listing';
    
    public function scopeForCategory($query, $category_id)
    {
        return $query->whereCategoryId($category_id);
    }
}
