<?php

namespace indiashopps\Console\Commands;

use Illuminate\Console\Command;
use indiashopps\Category;

class CategoryProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:category_products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Cache for first Level Category Products';

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
        $categories = Category::whereLevel(1)->get();

        foreach ($categories as $category) {
            if ($category->group_name == "books") {
                $category->getProducts(true);
            } else {
                $category->getProducts();
            }
        }
    }
}
