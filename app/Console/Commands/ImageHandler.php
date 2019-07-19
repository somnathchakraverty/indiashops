<?php namespace indiashopps\Console\Commands;

use Illuminate\Console\Command;
use indiashopps\Models\ProductImage;
use indiashopps\Http\Controllers\ImageController;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ImageHandler extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 's3:upload_images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command upload all the product Images to Amazon S3 Server';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    private $per_page = 200;

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
        $categories = [351, 21];
        $Handler = new ImageController();
        $searchAPI = "http://188.138.102.32:9200/shopping/_search?";
        $total_products = 0;
        $page = 1;
        $data['size'] = $this->per_page;

        /*Truncate Product Images Table*/
        //ProductImage::truncate();

        foreach ($categories as $category_id) {
            $data['q'] = "category_id:".$category_id;
            $has_more = true;

            do {
                $data['from'] = ($data['size'] * ($page - 1));
                $term = json_encode($data);
                $result = json_decode(file_get_contents($searchAPI.http_build_query($data)));

                unset($term);
                
                if (count($result->hits->hits) == 0) {
                    $has_more = false;
                } else {
                    foreach ($result->hits->hits as $product) {

                        $uploaded = $Handler->setProduct($product->_source)->saveProductImageToLocal();

                        if ($uploaded === false) {
                            \Log::error("Product Image Upload Error:: Product NOT Inititated");
                            $this->error("Product NOT Initiated");
                        }

                        $total_products++;
                    }
                }

                unset($return,$result);
                $page++;

                \Log::info("Products Processed for Category ID : $category_id ::".$total_products);

            } while ($has_more);
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['example', InputArgument::OPTIONAL, 'An example argument.'],
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
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }

}
