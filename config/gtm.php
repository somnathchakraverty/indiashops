<?php

return [
    'variables'         => [
        'product_detail_v2'          => [
            'product',
        ],
        'product_detail_non_book'    => [
            'product',
        ],
        'product_detail_non'         => [
            'product',
        ],
        'sub_category'               => [
            'total_products',
            'c_name',
            'category_id',
            'minPrice',
            'maxPrice',
        ],
        'product_list'               => [
            'total_products',
            'c_name',
            'category_id',
            'minPrice',
            'maxPrice',
        ],
        'brand_category_list_comp_1' => [
            'total_products',
            'c_name',
            'category_id',
            'minPrice',
            'maxPrice',
        ],
        'brand_category_list'        => [
            'total_products',
            'c_name',
            'category_id',
            'minPrice',
            'maxPrice',
        ],
        'custom_page_list'           => [
            'total_products',
            'c_name',
            'category_id',
            'minPrice',
            'maxPrice',
        ],
        'custom_page_list_v3'        => [
            'total_products',
            'c_name',
            'category_id',
            'minPrice',
            'maxPrice',
        ],
    ],
    'attribute_mapping' => [
        'product_detail_v2'          => 'detail',
        'product_detail_non_book'    => 'detail',
        'product_detail_non'         => 'detail',
        'sub_category'               => 'listing',
        'product_list'               => 'listing',
        'brand_category_list_comp_1' => 'listing',
        'brand_category_list'        => 'listing',
        'custom_page_list'           => 'listing',
        'custom_page_list_v3'        => 'listing',
    ],
    'attributes'        => [
        'detail'  => [
            "product_min_price_vendor" => "lp_vendor",
            "product_image"            => "image_url",
            "product_type"             => "product_type",
            "product_name"             => "name",
            "product_brand"            => "brand",
            "product_category"         => "category",
            "category_name"            => "category",
            "product_subcategory"      => "parent_category",
            "product_min_price"        => 'saleprice',
            "product_id"               => 'id',
            "product_total_vendors"    => 'vendor',
        ],
        'listing' => [
            'total_number_of_products' => 'total_products',
            'category_name'            => 'c_name',
            'category_id'              => 'category_id',
            'min_price_product'        => 'minPrice',
            'max_price_product'        => 'maxPrice',
        ],
        "common"  => [
            "device"    => (isMobile() ? "mobile" : "desktop"),
            "page_type" => "page_type",
        ],
        'all'     => [
            "product_min_price_vendor" => "",
            "product_image"            => "",
            "product_type"             => "",
            "product_brand"            => "",
            "product_category"         => "",
            "product_subcategory"      => "",
            "product_min_price"        => "",
            'total_number_of_products' => "",
            'category_name'            => "",
            'category_id'              => "",
            'min_price_product'        => "",
            'max_price_product'        => "",
            'category_id'              => "",
            "product_total_vendors"    => "",
            "product_name"             => "",
        ],
    ],
];