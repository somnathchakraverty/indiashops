<?php namespace indiashopps;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use indiashopps\Models\CategorySlider;

class Category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */

    const LAPTOPS       = 379;
    const TABLETS       = 352;
    const CAMERAS       = 471;
    const LED       = 446;
    const CAMERAS_SLR   = 472;
    const MOBILE        = 351;
    const HEADPHONES    = 370;
    const SPEAKERS      = 622;
    const MEMORY_CARDS  = 384;
    const SMART_WATCHES = 359;

    const GROUPS = [350, 378, 444];

    protected $table = 'gc_cat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['*'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get Category Parent
     *
     * @return Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')->select(['name', 'id', 'parent_id']);
    }

    public function parentImage()
    {
        return $this->hasOne(Slider::class, 'refer_id', 'id')->select(['image_url', 'refer_id', 'refer_url', 'alt']);
    }

    public function parentImages()
    {
        return $this->hasMany(Slider::class, 'refer_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function slider()
    {
        if (isMobile()) {
            $for = 2;
        } else {
            $for = 0;
        }

        return $this->hasMany(CategorySlider::class, 'cat_id', 'id')->whereFor($for);
    }

    public static function parentCategory($cat_id)
    {
        $cat = self::select(['id'])->whereId($cat_id)->with('parentImage')->whereParentId(0)->first();

        return $cat;
    }

    public function getProducts($isBook = false)
    {
        $cache_key = "category_products_" . $this->id;

        if (App::runningInConsole()) {
            Cache::forget($cache_key);
        }

        $products = Cache::remember($cache_key, 2000, function () use ($isBook) {
            if ($this->level < 2) {
                $child = Category::whereParentId($this->id)->get()->pluck('id');

                if ($child->count() > 0 && $child instanceof Collection) {
                    $childs      = $child->toArray();
                    $childs[]    = $this->id;
                    $childs      = implode(",", $childs);
                    $category_id = $childs;
                } else {
                    $category_id = $this->id;
                }
            } else {
                $category_id = $this->id;
            }

            try {

                $query = app('solr')->whereCategoryId($category_id)->take(15);

                if ($this->group_name == "books") {
                    $response = $query->getBooks();
                } else {
                    $response = $query->getSearch();
                }

                $response['products'] = $response['data'];

                return collect($response)->only(['products', 'filters']);
            }
            catch (\Exception $e) {
                \Log::error($e->getMessage());

                return collect([]);
            }
        });

        return $products;
    }

    public static function hasThirdLevel($category)
    {
        if (is_null($category) || !($category instanceof Category)) {
            return false;
        }

        try {
            $categories = Cache::remember("third_level_cat_null", 4400, function () {
                $categories = \DB::table(\DB::raw('`gc_cat` a'))
                                 ->select(['a.id'])
                                 ->leftJoin(\DB::raw('`gc_cat` b'), 'a.id', '=', 'b.parent_id')
                                 ->whereNull('b.parent_id')
                                 ->where('a.level', 1)
                                 ->get()
                                 ->keyBy('id');

                return $categories;
            });

            if ($categories instanceof Collection && !$categories->has($category->id) && $category->level == 1) {
                return false;
            }

            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }

    public static function hasSetCategory($product)
    {
        if (isset($product->category_id) && in_array($product->category_id, [
                self::MOBILE,
                self::LAPTOPS,
                self::CAMERAS,
                self::CAMERAS_SLR,
                self::LED
            ])
        ) {
            return true;
        }

        return false;
    }
}
