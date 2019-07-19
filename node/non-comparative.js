var http = require('http');
const querystring = require('querystring');
var composer_url = 'http://elastic-aws.indiashopps.com/composer/site/2.4/';
var book = false;

var showUsage = function(){
	console.log('Parameters Missing : Usage: "node comparative.js product_id={ID}"');
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

	if( book )
	{
		url += "&isBook=true";
	}

	request(url, 'product_detail', callback );
}

var productVendorOne = function( product, callback ){
	var params = {}

	params['vendor'] 		= 3;
	params['category_id'] 	= product.product_detail.category_id
	params['size'] 			= 15;

	if( book )
	{
		var file = "books.php";
	}
	else
	{
		var file = "search.php";
	}

	url = composer_url + file + "?query="+JSON.stringify(params);
	request(url, 'by_vendor_one', callback);
}

var productVendorTwo = function( product, callback ){
	var params = {}

	params['vendor'] 		= 1;
	params['category_id'] 	= product.product_detail.category_id
	params['size'] 			= 15;

	if( book )
	{
		var file = "books.php";
	}
	else
	{
		var file = "search.php";
	}

	url = composer_url + file + "?query="+JSON.stringify(params);

	request(url, 'by_vendor_two', callback);
}

var productByBrand = function( product, callback ){
	var params = {}

	params['brand'] 		= product.product_detail.brand;
	params['category_id'] 	= product.product_detail.category_id
	params['size'] 			= 15;

	if( book )
	{
		var file = "books.php";
	}
	else
	{
		var file = "search.php";
	}

	url = composer_url + file + "?query="+JSON.stringify(params);

	request(url, 'by_brand', callback);
}

var deals = function( product, result, callback ){

	var filters = result.return_txt.aggregations;

	var min_price = filters.saleprice_min.value;
	var max_price = filters.saleprice_max.value;

	var parts = price_range(min_price, max_price)
	var params = {};


	params['saleprice_max'] = parts[1];
	params['saleprice_min'] = parts[0];
	params['size'] 			= 15;
	params['category_id'] 	= product.product_detail.category_id;

	json_response['deals_range'] = {};
	json_response['deals_range']['min'] = min_price;
	json_response['deals_range']['max'] = max_price;

	if( book )
	{
		var file = "books.php";
	}
	else
	{
		var file = "search.php";
	}

	url = composer_url + file + "?query="+JSON.stringify(params);

	request(url, 'deals', callback);

}

var getPriceRange = function(product, callback){
	var params = {};

	params['size'] = 1;
	params['category_id'] = product.product_detail.category_id;
	params['from'] = 0;

	if( book )
	{
		var file = "books.php";
	}
	else
	{
		var file = "search.php";
	}

	url = composer_url + file + "?query="+JSON.stringify(params);

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

	if( process.argv.length > 3 && process.argv[3] == "book" )
	{
		book = true;
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
													deals(product, result, callback)
												}
											],
											function(err,data) {
												main_callback();
											});
									},
									function(callback) {
										productVendorOne(product, callback)
									},
									function(callback) {
										productVendorTwo(product, callback)
									},
									function(callback) {
										productByBrand(product, callback)
									},
								],
								function(err,data) {});
						}
					],
					function(err,data) {});
			},
		],
		function(err,data) {
			if( json_response.hasOwnProperty("price_range") )
			{
				delete json_response['price_range'];
			}

			console.log(JSON.stringify(json_response));
			// console.timeEnd("apistart");
			// console.log(Object.keys(json_response));
		});
}