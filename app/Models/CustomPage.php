<?php namespace indiashopps\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use indiashopps\Category;

class CustomPage extends Model
{


    /**
     * Get Category info
     *
     * @return Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')->select([
            'id',
            'parent_id',
            'name',
            'group_name'
        ]);
    }

    public function getUrl()
    {
        return route('custom_page_list_v3', [cs($this->category->name), cs($this->slug)]);
    }

    public function scropeFeatured($query)
    {
        return $query->where('featured', '1');
    }

    public function scopeForMobiles($query)
    {
        return $query->whereCategoryId(Category::MOBILE);
    }

    public function scopeForFeaturedMobiles($query)
    {
        return $query->where('featured', '1')->whereCategoryId(Category::MOBILE);
    }
}
