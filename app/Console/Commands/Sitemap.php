<?php namespace indiashopps\Console\Commands;

use Illuminate\Console\Command;
use indiashopps\Category;
use indiashopps\Support\SolrClient\Facade\Solr;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use File;
use DB;

class Sitemap extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Category wise product sitemap for Comparative Products';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $file_index = 1;

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
        $name = $this->argument('name');

        if (is_null($name)) {
            $confirm = $this->ask('No Argument given !! Run the default sitemap (Y|N)..?');

            if ($confirm == "N" || is_null($confirm) || $confirm == "n") {
                $this->error("Command Aborted.!!!");
                exit;
            }
            $this->comment("\nCategory Sitemap in Progress!! \n");
            $this->categorySitemap();
            $this->comment("\nCategory Sitemap Finished!! \n");
        } elseif ($name == "brand") {
            $this->comment("\nBrand Sitemap in Progress!! \n");
            $this->brandSitemap();
            $this->comment("\nBrand Sitemap Finished!! \n");
        } elseif ($name == "discontinue") {
            $this->comment("\nDiscontinued Product Sitemap in Progress!! \n");
            $this->discontinueSitemap();
            $this->comment("\nDiscontinued Product Sitemap Finished!! \n");
        } elseif ($name == "detail") {
            if ($this->argument('category_id')) {
                $this->comment("\nComp PD Sitemap in Progress!! \n");
                $this->productDetail();
                $this->comment("\nComp PD Sitemap Finished!! \n");
            } else {
                $this->error("Category ID missing.. !!");
                exit;
            }
        } else {
            $this->error("Invalid Argument.. Arguments available {brand}");
            exit;
        }
    }

    private function productDetail()
    {
        $category_ids = $this->argument('category_id');
        $category_ids = explode(",", $category_ids);
        $solr         = Solr::getInstance();

        foreach ($category_ids as $category_id) {
            $category     = Category::find($category_id);
            $has_products = true;
            $page         = 0;
            $size         = 32;
            $urls         = '';

            $file_name = "sitemap/" . $category->group_name . "-products-" . cs($category->name) . ".xml";

            if (file_exists($file_name)) {
                $this->info($file_name . " SKIPPED");
                continue;
            }
            do {

                $query = $solr->whereCategoryId($category_id)->skip($page)->take($size);

                if ($category->group_name == 'books') {
                    $products = $query->getBooks(true);
                } else {
                    if ($this->input->getParameterOption('--type') == 'upcoming') {
                        $query = $query->whereAvailability('Coming Soon');
                    }

                    $products = $query->getSearch(true);
                }

                if (empty($products->return_txt->hits->hits)) {
                    $has_products = false;
                } else {
                    $page++;
                    foreach ($products->return_txt->hits->hits as $product) {
                        $product = $product->_source;
                        if ($product->grp == 'Books') {
                            $url = route('product_detail_non_book', [
                                cs($product->name),
                                $product->id,
                                $product->vendor
                            ]);
                        } else {
                            $url = route('product_detail_v2', [cs($product->name), $product->id]);
                        }

                        $url = str_replace("http://shops.com", "https://www.indiashopps.com", $url);
                        $urls .= '<url><loc>' . $url . '</loc><lastmod>' . date("Y-m-d") . '</lastmod><priority>0.8</priority></url>';
                    }

                    unset($products, $product, $url);
                }

                $this->info("Processed Products.. :" . $page * $size);
                if (($page * $size) >= 39700) {
                    break;
                }
            } while ($has_products);

            $xml = $this->generateProductXml($urls);

            if (!empty($xml)) {
                file_put_contents($file_name, $xml);
                unset($urls, $xml);
            }
        }
    }

    private function brandSitemap()
    {
        $categories = config('vendor.comparitive_category');
        $full_brand = config('vendor.all_brand_category');
        $limit      = 0;
        $url        = '';

        if (!File::exists('sitemap')) {
            File::makeDirectory('sitemap');
        }

        foreach ($categories as $category_id) {

            $category   = Category::select(['name'])->whereId($category_id)->first();
            $priority   = 0.8;
            $file_index = 1;

            if (in_array($category_id, $full_brand)) {
                $url1 = composer_url("cat_agg.php?category_id=" . $category_id);
            } else {
                $url1 = composer_url("cat_agg.php?size=4&category_id=" . $category_id);
            }

            $result = file_get_contents($url1);
            $result = json_decode($result);

            foreach ($result->return_txt->aggregations->brand->buckets as $brand) {

                $proURL = route('brand_category_list_comp', [
                    create_slug($brand->key),
                    create_slug($category->name),
                    $category_id
                ]);
                $url .= '<url><loc>' . $proURL . '</loc><lastmod>' . date("Y-m-d") . '</lastmod><priority>' . $priority . '</priority></url>';
                $limit++;
            }

            if ($limit >= 40000) {
                file_put_contents("sitemap/brand-comparative-sitemap-" . $file_index . ".xml", $this->generateProductXml($url));
                $url = "";
                $file_index++;
            }
        }

        $xml = $this->generateProductXml($url);

        if (!empty($xml)) {
            file_put_contents("sitemap/brand-comparative-sitemap-" . $file_index . ".xml", $xml);
        }

        $this->comment("Total Sitemap Created: " . $file_index);
    }

    private function categorySitemap()
    {
        $categories = config('vendor.comparitive_category');

        if (!File::exists('sitemap')) {
            File::makeDirectory('sitemap');
        }

        foreach ($categories as $category_id) {
            $category   = Category::select('name')->whereId($category_id)->first();
            $priority   = 0.8;
            $url        = '';
            $from       = 0;
            $limit      = 0;
            $file_index = 1;

            do {
                $url1   = "http://209.126.127.240:9200/shopping/_search?q=track_stock:1%20vendor:0%20category_id:" . $category_id . "&size=500&from=" . $from . "&default_operator=AND";
                $result = file_get_contents($url1);
                $result = json_decode($result);

                foreach ($result->hits->hits as $pro) {
                    $pro    = $pro->_source;
                    $proURL = route('product_detail_v2', [create_slug($pro->name), $pro->id]);
                    $url .= '<url><loc>' . $proURL . '</loc><lastmod>' . date("Y-m-d") . '</lastmod><priority>' . $priority . '</priority></url>';
                }

                $products = count($result->hits->hits);
                $from += $products;
                $limit = $from;

                if ($limit >= 40000) {
                    file_put_contents("sitemap/product-sitemap-" . create_slug($category->name) . "-" . $file_index . ".xml", $this->generateProductXml($url));
                    $url = "";
                    $file_index++;
                }

            } while ($products > 0);

            $xml = $this->generateProductXml($url);

            if (!empty($xml)) {
                file_put_contents("sitemap/product-sitemap-" . create_slug($category->name) . "-" . $file_index . ".xml", $xml);
            }
        }
    }

    private function discontinueSitemap()
    {
        if (!File::exists('sitemap')) {
            File::makeDirectory('sitemap');
        }

        $sql[] = ' gc_products_flipkart_discontinued';
        $sql[] = ' gc_products_jms where enabled=0';
        $sql[] = ' gc_products_others where enabled=0';
        $sql[] = ' gc_products_amazon where enabled=0';

        $file_index = 1;

        foreach ($sql as $table_index => $query) {

            $url = '';

            DB::connection('panel32')->table(DB::raw($query))->chunk(40000, function ($rows) use ($url) {

                foreach ($rows as $pro) {
                    $proURL = route('product_detail_non', [
                        create_slug($pro->group_name),
                        create_slug($pro->name),
                        $pro->id,
                        $pro->vendor
                    ]);
                    $proURL = str_replace("indiashopps.yourshoppingwizard.com", "www.indiashopps.com", $proURL);
                    $url .= '<url><loc>' . $proURL . '</loc><lastmod>' . date("Y-m-d") . '</lastmod><priority>0.8</priority></url>';
                }

                file_put_contents("sitemap/discontinued-products-" . $this->file_index++ . ".xml", $this->generateProductXml($url));
                $url = '';
            });

            $this->comment("\nTable " . ($table_index) . " DONE..!! \n");
        }

        $this->comment("\nTotal Files Created " . ($this->file_index - 1) . "!! \n");
    }

    private function generateProductXml($urls)
    {
        if (empty($urls)) {
            return '';
        }

        $url = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $url .= $urls;
        $url .= "</urlset>";

        return $url;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::OPTIONAL, 'Sitemap option, if not given, it will generate category sitemap'],
            ['category_id', InputArgument::OPTIONAL, 'Category ID'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['--type', InputArgument::OPTIONAL, InputOption::VALUE_REQUIRED ]
        ];
    }

}
