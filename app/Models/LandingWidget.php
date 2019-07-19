<?php

namespace indiashopps\Models;

use indiashopps\Category;
use Illuminate\Database\Eloquent\Model;

class LandingWidget extends Model
{
    protected $table = 'landing_widget';

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')->select(['name', 'id', 'parent_id']);
    }
}
