var http = require('http');
const querystring = require('querystring');
var composer_url = 'http://elastic-aws.indiashopps.com/composer/site/2.4/';

var showUsage = function(){
    console.log('Parameters Missing : Usage: "node amp_detail.js product_id={ID}"');
    process.exit(-1);
}

var price_range = function(min, max){
    var sections = 5;
    var number   = max;
    var divider  = 1000;
    var parts = [];

    parts[0] = min;

    if (max <= 1000) {
        divider = 100;
    }

    var part = number / sections;
    var last = 0;

    for (i = 1; i <= sections; i++) {
        number = ( parseInt( Math.ceil( parseInt( part / divider ) ) * divider)  * i);

        if (parseInt(number) > parseInt(min)) {
            parts[i] = number;
        }
    }

    return parts;
}

var productDetail = function( product_id, callback ){
    var url = composer_url + 'ext_prod_detail.php?_id='+product_id;

    request(url, 'product_detail', callback );
}

var productVendor = function( product_id, callback ){
    var url = composer_url+"vendor_list.php?id="+product_id

    request(url, 'product_vendors', callback );
}

var productCompare = function( product, callback ){

    var params = {};

    params['category_id'] 	= product.product_detail.category_id

    url = composer_url + "search.php?query="+JSON.stringify(params);

    request(url, 'compare', callback);
}

var deals_1 = function( product, result, callback ){

    deals(product, result, 0, 1, 'one', callback );
}

var deals_2 = function( product, result, callback ){

    deals(product, result, 1, 2, 'two', callback );
}

var deals_3 = function( product, result, callback ){

    deals(product, result, 2, 3, 'three', callback );
}

var deals_4 = function( product, result, callback ){

    deals(product, result, 3, 4, 'four', callback );
}

var deals_5 = function( product, result, callback ){

    deals(product, result, 4, 5, 'five', callback );
}

var deals = function( product, result, min, max, key, callback ){
    var filters = result.return_txt.aggregations;

    var min_price = filters.saleprice_min.value;
    var max_price = filters.saleprice_max.value;

    var parts = price_range(min_price, max_price)
    var params = {};

    params['saleprice_min'] = parts[min];
    params['saleprice_max'] = parts[max];
    params['category_id'] 	= product.product_detail.category_id;
    params['size'] = 10;

    json_response['deals_range'] = {};
    json_response['deals_range']['min'] = min_price;
    json_response['deals_range']['max'] = max_price;

    url = composer_url + "search.php?query="+JSON.stringify(params);
    request(url, 'deals_'+key, callback);

}

var productAccessories = function( product, callback ){
    var params = {};

    params['name'] = product.product_detail.name;
    params['size'] = 50;
    params['category_id'] 	= product.product_detail.category_id

    url = composer_url + "top_deals_acc.php?"+querystring.stringify(params);

    request(url, 'category_accessories', callback);
}

var getPriceRange = function(product, callback){
    var params = {};

    params['size'] = 1;
    params['category_id'] = product.product_detail.category_id;
    params['from'] = 0;

    url = composer_url + "search.php?query="+JSON.stringify(params);

    request(url, 'price_range', callback);
}

var request = function($url, $section, callback){

    http.get($url, (resp) => {
        var data = '';
    resp.on('data', (chunk) => {
        data += chunk
});

    resp.on('end', () => {
        var response = JSON.parse(data);
    json_response[$section] = response;

    if( typeof callback != "undefined" )
    {
        callback(null, response)
    }
});

}).on("error", (err) => {});
}

if( process.argv.length <= 2 )
{
    showUsage();
}
else
{
    var first = process.argv[2].split('=');

    if( first.length < 2 )
    {
        console.log("Invalid Product Argument Supplied.");
        showUsage();
    }
    else
    {
        var product_id = first[1];
    }


    var async = require("async");
    console.time("apistart");

    var json_response = {};

    async.parallel([

            function(main_callback){
                async.waterfall([
                        function(cb) {
                            productDetail(product_id, cb)
                        },
                        function(product, callback)
                        {
                            if( product.product_detail == null )
                            {
                                json_response.product_detail = false;
                                main_callback();
                                return false;
                            }

                            async.parallel([
                                    function(callback) {
                                        async.waterfall([
                                                function(cb) {
                                                    getPriceRange(product, cb)
                                                },
                                                function(result, callback)
                                                {
                                                    async.parallel([
                                                            function(cb_new) {
                                                                deals_1(product, result, cb_new)
                                                            },
                                                            function(cb_new) {
                                                                deals_2(product, result, cb_new)
                                                            },
                                                            function(cb_new) {
                                                                deals_3(product, result, cb_new)
                                                            },
                                                            function(cb_new) {
                                                                deals_4(product, result, cb_new)
                                                            },
                                                            function(cb_new) {
                                                                deals_5(product, result, cb_new)
                                                            },
                                                        ],
                                                        function(err,data) {
                                                            callback();
                                                        });
                                                }
                                            ],
                                            function(err,data) {
                                                main_callback();
                                            });
                                    },
                                    function(callback) {
                                        productAccessories(product, callback)
                                    },
                                    function(callback) {
                                        productCompare(product, callback)
                                    },
                                ],
                                function(err,data) {});
                        }
                    ],
                    function(err,data) {});
            },
            function(callback) {
                productVendor(product_id, callback);
            },
        ],
        function(err,data) {
            if( json_response.hasOwnProperty("price_range") )
            {
                delete json_response['price_range'];
            }

            // console.timeEnd("apistart");
            // console.log(Object.keys(json_response));

            console.log(JSON.stringify(json_response));
        });
}