<?php

namespace indiashopps\Console\Commands;

use Illuminate\Console\Command;
use indiashopps\Models\DealsCat;

class CouponJsonCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:coupon_json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genereate Coupons JSON for all the categories';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        self::getCoupons();

        $info = "Total Execution Time.. ::" . (microtime(true) - LARAVEL_START);
        $this->info(str_repeat('*', strlen($info) + 12));
        $this->info('*     ' . $info . '     *');
        $this->info(str_repeat('*', strlen($info) + 12));
    }

    public static function getCoupons()
    {
        $categories = DealsCat::select(['id', 'name'])->take(9)->where('name','NOT LIKE', 'others')->get();
        $solr       = app('solr');

        foreach ($categories as $category) {
            $coupons[cs($category->name)] = $solr->whereCatId($category->id)
                                                 ->getCouponList(true)->return_txt->hits->hits;
        }

        if (!empty(array_filter($coupons))) {
            \Storage::disk('local')->put("JSON/coupons_home.json", json_encode($coupons));
        }
    }
}
