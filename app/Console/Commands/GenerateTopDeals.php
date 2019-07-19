<?php

namespace indiashopps\Console\Commands;

use Illuminate\Console\Command;
use indiashopps\MobilePriceDiff;
use MongoDB\Client;
use MongoDB\Model\BSONArray;

class GenerateTopDeals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:comparative_deals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will automatically create the list of top products where deals are available..';

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
        $mongo   = new Client($this->getDsn(config('database.connections.mongodb')));
        $vendors = $mongo->wizard_panel->comp_vendor;
        $query   = [
            [
                '$group' => [
                    "_id"     => '$id',
                    'p_count' => ['$sum' => 1],
                    'max'     => ['$max' => '$saleprice'],
                    'min'     => ['$min' => '$saleprice'],
                ],
            ],
            ['$sort' => ['_id' => 1]],
            [
                '$match' => [
                    'p_count' => ['$gt' => 1],
                    'min'     => ['$gt' => 0],
                    'max'     => ['$gt' => 0],
                ],
            ]
        ];

        $group_data = collect($vendors->aggregate($query))->keyBy('_id');

        $this->info("Vendors Generated..!!");

        MobilePriceDiff::truncate();

        $processed = 0;

        foreach ($group_data->chunk(500) as $data) {
            $ids = [];

            foreach ($data as $pid => $row) {
                if ($row->max > $row->min && ($row->max - $row->min) > 5) {
                    $ids[] = $pid;
                }

            }

            $query = [
                [
                    '$match' => [
                        'id'          => ['$in' => $ids],
                        'track_stock' => 1,
                        'enabled'     => 1,
                    ],
                ],
                [
                    '$project' => [
                        'id'          => '$id',
                        'product_id'  => '$id',
                        'brand'       => '$brand',
                        'name'        => '$name',
                        'category_id' => '$category_id',
                        'category'    => '$category',
                        'image_url'   => '$image_url',
                        'product_url' => '$product_url',
                        'track_stock' => '$track_stock',
                        'saleprice'   => '$saleprice',
                        'vendor'      => '$vendor',
                        'rank'        => '$rank_points'
                    ],
                ],
            ];

            $products = collect($mongo->wizard_panel->comparative->aggregate($query));

            $processed += $products->count();
            try {
                $insert = $products->map(function ($product) use ($data) {
                    $product = (object)$product;

                    if ($product->vendor instanceof BSONArray) {
                        if (count($product->vendor->getArrayCopy()) == 1) {
                            $vendor = 0;
                        } else {
                            $vendor = 0;
                        }
                    } else {
                        $vendor = $product->vendor;
                    }

                    return [
                        'ref_id'      => 0,
                        'v_id'        => $vendor,
                        'product_id'  => $product->id,
                        'name'        => $product->name,
                        'category_id' => $product->category_id,
                        'image_url'   => $product->image_url,
                        'proURL'      => $product->product_url,
                        'min_price'   => $product->saleprice,
                        'max_price'   => $data->get($product->id)->max,
                        'rank'        => (isset($product->rank)) ? $product->rank : 0,
                        'difference'  => abs($data->get($product->id)->max - $data->get($product->id)->min),
                        'track_stock' => $product->track_stock
                    ];
                })->all();

                MobilePriceDiff::insert($insert);
            }
            catch (\Exception $e) {
                \Log::error("Deals Error:: " . $e->getMessage() . " :: " . $e->getTraceAsString());
            }

            unset($products, $insert, $ids);
        }

        send_slack_alert("Comparative Deals Generated.. :)");
    }

    function getDsn(array $config)
    {
        $hosts = is_array($config['host']) ? $config['host'] : [$config['host']];

        foreach ($hosts as &$host) {
            if (strpos($host, ':') === false && !empty($config['port'])) {
                $host = $host . ':' . $config['port'];
            }
        }

        return 'mongodb://' . $config['username'] . ':' . $config['password'] . '@' . $host . '/' . $config['database'] . '?authMechanism=SCRAM-SHA-1';
    }
}
