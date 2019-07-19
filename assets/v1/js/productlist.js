/**VARIABLES FOR PRODUCT LISTING**/
var loading = false;
var pre_top;
var page = 2;
var container 	= $("#product_wrapper");
var r_container = $("#right-container");
// var foo_offset	= $("#footer").offset();
var loading_img = "<div class='col-md-2 col-md-offset-5'><img id='loading_img' src='"+load_image+"' alt='Loading more products.....' style='display:none'/></div>";
var load_more 	= "<div class='col-md-4 col-md-offset-4'><a id='load_more' href='#' class='btn btn-danger form-control' style='display:block'>Load More</a></div>";
var no_more_prod= "<div class='col-md-12'><label class='btn btn-danger form-control' id='no_more_prod'>Thats All Folks !!!</label></div>";

$(document).ready(function(){

	r_container.append( loading_img );
	r_container.append( load_more );

	$("#load_more").click(function(){
		// This function gets the next page, when load more button is clicked
		$(this).hide();
		ListingPage.controller.getNextPage()
		return false;
	});

	/* Remove the ATTRIBUTEs which are not matching the search criteria*/
	$(".search_attr").keyup(function(){
		var brand 		= $(this).val();
		brand 			= ucfirst( brand, true );
		var parent_ul 	= $(this).parent().parent().parent();
		var matched 	= parent_ul.find(".checkbox .fix-slide-checkbox:not(:contains('"+brand+"'))");
		var total 	 	= parent_ul.find(".checkbox .fix-slide-checkbox:contains('"+brand+"')");
		var not_matched = parent_ul.find(".checkbox .fix-slide-checkbox");

		not_matched.each(function(){
			$(this).parent().show();
		});

		matched.each(function(){
			$(this).parent().hide();
		});
	});

	//For image lazy loading.. 
	$("img").lazyload({ 
	    effect: "fadeIn",
	    effectspeed: 900,
	}).removeClass("lazy");

	$(document).ajaxStop(function(){
	    $("img").lazyload({ 
	        effect: "fadeIn",
	        effectspeed: 900
	    }).removeClass("lazy");
	});

	/*** This function has click event for search page, and change URL once category is selected. ***/
	$(document).on("click",".search-category",function(){
		var cat_id = $(this).attr("id");
		var url = window.location.href;

		url = url.split("#")[0]
		url = url.split("&cat_id")[0];

		url = url+"&cat_id="+cat_id+window.location.hash;

		window.location.href = url;
	});
});

function update_products( products )
{
	$("#product_wrapper").append(products).hide().fadeIn();
}

function ucfirst(str,force)
{
	str = force ? str.toLowerCase() : str;
	return str.replace(/(\b)([a-zA-Z])/,
	       function(firstLetter){
	          return   firstLetter.toUpperCase();
	       });
}

function ucwords( str )
{
	str = str.replace("_"," ");
	str = str.replace("_"," ");
	str = str.replace(/\b[a-z]/g, function(letter) {
	    return letter.toUpperCase();
	});

	return str;
}

function clean( str )
{
	//Cleans the string.. 
	str = String(str)
	str = str.replace(/\s/g,"-");
	str = str.replace("&","");
	str = str.replace(".","");
	str = str.replace(".","");
	return str.replace("+","");
}

/***********************Product List Filter**************************/

var ListingPage = 
{
	model: {

		vars : { max_price: 0, min_price: 0, current_page : 0, loading: false, loading: false, auto_load: true },
		ajax_url : "",
		hash : window.location.hash.replace("#",""),
		fields: {},
		manual_slide : false,
	},
	view : {

		vars: {
			p_wrapper : $( "#product_wrapper" ),

		},
		//Renders the product after the filter is changed.. 
		renderProducts : function( products )
		{
			if( products != "" )
				this.vars.p_wrapper.html(products).hide().fadeIn('slow');
			else
			{
				var height = $("#wrapper1").height();

				var no_product = "<div class='no-products col-md-12' style='min-height:"+height+"px'><h3>Sorry !!! No products found.. </h3></div>";
				this.vars.p_wrapper.html(no_product).hide().fadeIn('slow');
			}
		},
		//Changes the left filter value and attributes based on the filter selected.. 
		renderFilter : function( facet ){

			ListingPage.model.manual_slide = true;

			ListingPage.view.resetCheckboxes();

			if( typeof facet.filters_all != "undefined" )
			{
				/// This part is for when any filter is selected.. 
				$.each( facet.filters_all,function(attrib,value){
					try
					{
						if( typeof value == "object" )
						{
							//When attribute is object and has many attributes.
							if( typeof value.buckets != "undefined" )
							{
								if( $.inArray( attrib, facet.filter_applied ) == -1 )
								{
									//When filter is selected manually
									ListingPage.view.updateFilterCheckbox( attrib.toLowerCase(), value.buckets );
								}
								else
								{
									//This part renders the left side bar when the predefined filters.
									ListingPage.view.defaultFilterUpdate();
								}
							}
							else
							{
								//saleprice filters...
								if( attrib == "saleprice_min" && $.inArray( attrib, facet.filter_applied ) == -1 )
								{
									// $("#minPrice").val( value.value )
									$( "#price-range" ).slider({
									  values: [ value.value, ListingPage.model.vars.max_price ]
									});
								}
								else if( attrib == "saleprice_max" && $.inArray( attrib, facet.filter_applied ) == -1 )
								{
									$( "#price-range" ).slider({
									  values: [ ListingPage.model.vars.min_price, value.value ]
									});
								}
							}
						}
					}
					catch(exp)
					{
						//Exception
						console.log(exp)
						console.log("filterApplied")
					}
				});
			}
			// When no filter is selected.. 
			else
			{
				try
				{
					$.each( facet,function(attrib,value){
						if( typeof value == "object" )
						{
							if( typeof value.buckets != "undefined" )
							{
								ListingPage.view.updateFilterCheckbox( attrib.toLowerCase(), value.buckets );
							}
							else
							{
								//saleprice filters...
								if( attrib == "saleprice_min" )
								{
									// $("#minPrice").val( value.value )
									$( "#price-range" ).slider({
									  values: [ ListingPage.model.vars.min_price, ListingPage.model.vars.max_price ]
									});
								}
								else if( attrib == "saleprice_max" )
								{
									$( "#price-range" ).slider({
									  values: [ ListingPage.model.vars.min_price, ListingPage.model.vars.max_price ]
									});
								}
							}
						}
					});
				}
				catch(exp)
				{
					console.log( exp );
					console.log("Without Filter")
				}
			}

			bindUniform();

			ListingPage.model.manual_slide = false; // Variable is set to false, for stopping Price slider to stop
			$(".nano").nanoScroller({ alwaysVisible: true });
			$(".nano1").nanoScroller({ alwaysVisible: true,paneClass: 'scrollPane'});
		},

		/* Function for Applied filter, which shows all the filter applied above the product list*/
		renderAppliedFilter : function(){

			fields = ListingPage.model.fields;

			var fltr_label = {};
			var fltr_text = "";
			var price = [];

			$.each( fields, function( label, value ){

				switch( label )
				{

					case "query":

						if( value.length > 0 )
						{
							fltr_label[label] = "<div class='single-fltr'><span class='fltr-label'>Search: </span>";
							fltr_label[label] += "<div value='"+value+"' class='single-prop' name='query'><span class='fltr-name'>"+ucfirst( value, true )+"</span><span class='fltr-remove'>X</span></div>";
							fltr_label[label] += "</div>";
						}

						break;

					case "saleprice_max":

						price['saleprice_max'] = value;
						break;

					case "saleprice_min":

						price['saleprice_min'] = value;
						break;

					case "vendor":

						vendors		= value.split(",");
						fltr_label[label] = "<div class='single-fltr'><span class='fltr-label'>Vendor: </span>";

						$.each(vendors, function(i,vendor){
							fltr_label[label] += "<div value='"+vendor+"' name='vendor' class='single-prop'><span class='fltr-name'>"+ucfirst( alvendors.name[vendor], true )+"</span><span class='fltr-remove'>X</span></div>";
						});

						fltr_label[label] += "</div>";
						break;

					default:

						values 		= value.split(",");
						fltr_label[label] = "<div class='single-fltr'><span class='fltr-label'>"+ucwords( label )+": </span>";

						$.each(values, function(i,val){
							fltr_label[label] += "<div value='"+val+"' class='single-prop' name='"+label+"'><span class='fltr-name'>"+val+"</span><span class='fltr-remove'>X</span></div>";
						});
						fltr_label[label] += "</div>";

						break;
				}

			});

			if( price['saleprice_min'] && price['saleprice_max'] )
			{
				fltr_label['price'] = "<div class='single-fltr'><span class='fltr-label'>Price: </span><div name='price' value='"+price['saleprice_min']+"-"+price['saleprice_max']+"' class='single-prop'><span class='fltr-name'>"+price['saleprice_min']+"-"+price['saleprice_max']+"</span><span class='fltr-remove'>X</span></div></div>";
			}

			$.each(fltr_label, function(i,txt){
				fltr_text += txt;
			})
			
			if( fltr_text.length > 0 )
			{
				fltr_text += "<div class='clear-all btn btn-danger' id='clear-all'>Clear All </div>";
				$("#appliedFilter").addClass( "applied" );
			}
			else
			{
				$("#appliedFilter").removeClass( "applied" );
			}

			$("#appliedFilter").html( fltr_text ).hide().fadeIn('slow');
		},

		//Appends the next set of products to the product wrapper for INFINITE scroll..
		addProducts : function( products ){

			var html 	= $.parseHTML( products );
			var img_el 	= $("#loading_img");
			m = ListingPage.model.vars;

			if( products.indexOf( "product-item" ) > -1 )
			{
				$("#product_wrapper").append(products).hide().fadeIn();

				m.loading = false;

				$(window).scroll();
				
				if( ListingPage.model.vars.current_page >= 4 )
				{
					m.auto_load = false;
					$("#load_more").show();
				}else{
					m.auto_load = true;
					$("#load_more").hide();
				}
			}
			else
			{
				$( "#no_more_prod" ).remove();
				r_container.append( no_more_prod );
				$("#load_more").hide();
				m.auto_load = false;
			}

			img_el.hide();
		},

		//Reset all the checkbox in the left sidebar
		resetCheckboxes: function(){

			$("input[type='checkbox']").each(function(){

				$(this).prop("disabled",false);
				// $(this).prop("checked",false);
			});

			bindUniform();
		},
		//Update all the checkboxes in the LEFT SIDEBAR when the filter is applied.. 
		updateFilterCheckbox: function( attr, values )
		{
			$(".checkbox."+attr+" input[type='checkbox']").prop("disabled",true);
			$(".checkbox."+attr).find("span.count").html("[0]");

			$.each(values,function(key,v){

				try
				{
					$(".checkbox."+attr+" #chk"+clean(v.key)).prop("disabled",false);
					$(".checkbox."+attr+" #chk"+clean(v.key)).closest(".fix-slide-checkbox").find("span.count").html("["+v.doc_count+"]")
				}
				catch(e)
				{
					console.log(attr)
				}
			});
		},
		// Update the checkbox for the any PRE FILTER...
		defaultFilterUpdate: function(){

			fields = ListingPage.model.fields;

			$.each( fields, function(attrib,val){

				values = val.split(",")

				$.each(values,function(k,value){
					$("."+attrib+" #chk"+clean(value) ).prop("checked",true);
				});
			});
		},
	},
	/*****PRODUCTLIST CONTROLLER****/
	controller: {

		// Initializing the PRODUCT LIST JS file..
		init : function(){

			this.setMaxMinPrice(); // Sets Min, Max price in the product list
			this.registerEvents(); // Register all the events for product page, click, remove, change.
			this.setupFilterURL(); // Setup the Ajax URL if any prefilter is applied
			this.initializePreFilter(); // Prefilter...
			this.functions.addOverlay(); // Loading Overlay

			if( Object.keys(ListingPage.model.fields).length > 0 )
				this.getProducts();
			else
				ListingPage.view.resetCheckboxes();

		},
		// Prefilter check for the hash values from the URL to see whether any prefilter is applied.
		initializePreFilter: function(){

			var hash = ListingPage.model.hash;
			ctrl = this;
			self = ListingPage;

			if( hash.length > 0 )
			{
				var fields = hash.split("&");

				$.each(fields,function(e,field){
					var f = field.split("=");

					self.model.fields[f[0]] = ucfirst(decodeURIComponent( f[1] ));
				});
			}
		},
		//Fired once any event is occured for filter changes.. 
		filterChanged : function(){

			ListingPage.model.vars.current_page = 0;
			//ListingPage.model.vars.auto_load 	= true;

			fields = this.getFilterFields();
			this.updateURLHash( fields );
			this.getProducts();

		},
		//Changes the Browser URL with the HASH values
		updateURLHash : function( fields ){

			hash = "";

			$.each(fields,function(key,val){

				if( hash == "" )
				{
					hash = key+"="+val;
				}
				else
				{
					hash += "&"+key+"="+val;
				}
			});

			window.location.hash = hash;
		},
		//returns the Hashed value for all the applied filter fields..
		getURLHash : function(){

			fields = ListingPage.model.fields;
			hash = "";

			$.each(fields,function(key,val){

				if( hash == "" )
				{
					hash = key+"="+val;
				}
				else
				{
					hash += "&"+key+"="+val;
				}
			});

			return hash;
		},
		// Get the list of fields based on the checkbox selected in the left SIDEBAR
		getFilterFields: function(){

			fields = ListingPage.model.fields;
			fields = {};

			$(".fltr__src").each(function(i,el){

				key = $(this).attr( "field" );
				val = "";
				vars = ListingPage.model.vars;

				if( $(this).is(":checkbox") && $(this).is(":checked") )
				{
					val = $(el).val();
				}
				else if( $(this).is(":text") && $(this).val().length > 0 )
				{
					val = $(el).val();
				}
				else if( $(this).is("[type='number']") )
				{
					val = $(el).val();
				}
				
				if( val !== "" )
				{
					if( typeof fields[key] == "undefined" )
					{
						fields[key] = val
					}
					else
					{
						fields[key] += ","+val;
					}
				}
			});

			// If the price hasn't change remove it from the filter fields..
			if( fields.saleprice_max == vars.max_price && fields.saleprice_min == vars.min_price )
			{
				delete fields.saleprice_max;
				delete fields.saleprice_min;
			}

			ListingPage.model.fields = fields;
			return fields;
		},
		// Get the next page products..
		getNextPage : function(){


			m.loading = true;

			ListingPage.model.vars.current_page++;

			$("#loading_img").show()

			this.setupFilterURL()

			this.getProducts( true, function(products){

				//Callback function once the product are fetched from Solr
				ListingPage.view.addProducts( products );

				m.loading = false;
			});
		},
		//Getting the list of products using ajax, using the filtered fields.
		getProducts : function( send, callback ){

			if( typeof callback == "undefined" ) callback = "";

			if( typeof send == "undefined" )
			{
				send = false;
				this.functions.overlay.show()
			}

			that = this;

			filter_url = that.generateAjaxURL();

			if( that.localCache.exist( filter_url ) )
			{
				//Returns the CACHED products..for any filter.
				try
				{
					data = that.localCache.get( filter_url );

					if( send )
					{
						if ( $.isFunction(callback) ) callback(data.products);
					}
					else
					{
						that.functions.overlay.hide()
						that.renderViews( data );
					}
				}
				catch( err )
				{
					return false;
				}

				that.functions.overlay.hide()
			}
			else
			{
				//Ajax call to get product with the filter URL
				$.get( filter_url ,function(data){
					
					try
					{
						data = $.parseJSON( data );

						if( send )
						{
							if ( $.isFunction(callback) ) callback(data.products);
						}
						else
						{
							that.functions.overlay.hide();
							that.renderViews( data );
							that.localCache.set( filter_url, data );
						}
					}
					catch( err )
					{
						return false;
					}
				});
			}
		},

		//Generate Views the the AJAX responses. 
		renderViews : function( data, callback ){

			this.updateSortOptions();
			ListingPage.view.renderProducts( data.products );
			ListingPage.view.renderAppliedFilter();
			ListingPage.view.renderFilter( data.facet );


			if ( $.isFunction(callback) ) callback();
		},
		//Generate AJAX URL based on the Filter applied.. 
		generateAjaxURL: function(){

			self = ListingPage;
			var params = "";

			$.each(self.model.fields,function(key,value){

				params += "&"+key+"="+encodeURIComponent(value);
			});

			params += "&ajax=true&filter=true";

			if( self.model.ajax_url.indexOf("?") > -1 )
			{
				return self.model.ajax_url+params;
			}
			else
			{
				params = params.replace("&","?");
				return self.model.ajax_url+params;
			}
		},
		//Filter URL
		setupFilterURL : function(){
			w 		= window.location
			page 	= ListingPage.model.vars.current_page;
			l 		= w.origin+w.pathname+'/'+page+w.search;

			ListingPage.model.ajax_url = l;
		},
		// Updating the SORT BY options once any filter is applied.. 
		updateSortOptions: function(){

			var hash = ListingPage.controller.getURLHash();
			
			$("#product-list-cat-menu ul li a").each(function(i,v){
				var href = $(this).attr('href').split("#")[0];
				$(this).attr('href', href+"#"+hash );
			});
		},
		// Caching the applied filter for fast processing.. 
		localCache 	: 
			{
			    data: {},
			    remove: function (url) {
			        delete this.data[url];
			    },
			    exist: function (url) {
			        return this.data.hasOwnProperty(url) && this.data[url] !== null;
			    },
			    get: function (url) {
			        // console.log('Getting in cache for url' + url);
			        return this.data[url];
			    },
			    set: function (url, cachedData, callback) {
			        this.remove(url);
			        this.data[url] = cachedData;
			        if ($.isFunction(callback)) callback(cachedData);
			    }
			},
		// List of all the Events on Product Listing Page. 
		registerEvents : function (){

			m = ListingPage.model;

			//Any Filter input field change.
			$( document ).on("change",".fltr__src",function(){

				var id = $(this).attr('id');

				if( ( id == 'maxPrice' && $(this).val() <= pro_max ) || ( id == 'minPrice' && $(this).val() >= pro_min ) || !$(this).is("[type='number']") )
				{
					ListingPage.model.vars.current_page = 0;
					ListingPage.controller.setupFilterURL();
					ListingPage.controller.filterChanged();
				}
				else
				{
					if( id == 'maxPrice' )
					{
						$(this).val( pro_max );
					}
					else
					{
						$(this).val( pro_min );
					}
				}
			});

			//Price slider changes.. 
			$( "#price-range" ).slider({
			  range: true,
			  min: m.vars.min_price,
			  max: m.vars.max_price,
			  animate: "slow",
			  values: [ m.vars.min_price, m.vars.max_price ],
			  change: function( event, ui ) {
				  	var sMinPrice = ui.values[ 0 ];
				  	var sMaxPrice = ui.values[ 1 ];

				  	if( !ListingPage.model.manual_slide )
				  	{
				  		$("#minPrice").val(sMinPrice);
				  		$("#maxPrice").val(sMaxPrice);
				  		$("#minPrice").change();
				  	}
				},
				slide: function( event, ui ) {

				  	var sMinPrice = ui.values[ 0 ];
				  	var sMaxPrice = ui.values[ 1 ];
				  	$("#minPrice").val(sMinPrice);
					$("#maxPrice").val(sMaxPrice);
				},
				start: function( event, ui ) {
					ListingPage.model.manual_slide = false;
				}
			});
			// Removes the applied filter..
			$( document ).on("click",".single-prop",function(){

				hasPrice = false;
				if( $(this).attr("name") == "price" )
				{
					hasPrice = true;
				}
				else
				{
					var id = "#chk"+clean($(this).attr("value"));
					$(id).prop("checked",false);
				}

				if( $(this).attr("name") == "query" )
				{
					$("#search").val("");
				}
				
				if( hasPrice )
				{
					$("#minPrice").val( ListingPage.model.vars.min_price );
					$("#maxPrice").val( ListingPage.model.vars.max_price );
				}

				bindUniform();

				ListingPage.model.vars.current_page = 0;
				ListingPage.controller.setupFilterURL();
				ListingPage.model.manual_slide = true;
				ListingPage.controller.filterChanged()
				ListingPage.model.manual_slide = false;
			});

			//Clear all the filters..
			$(document).on("click","#clear-all",function(){

				$(".fltr__src").each(function(){

					key = $(this).attr("field");

					if( $(this).is(":checkbox") && $(this).is(":checked") )
					{
						$(this).prop("checked",false);
					}
					else if( $(this).is(":text") && $(this).val().length > 0 )
					{
						$(this).val("");
					}
					else if( $(this).is("[type='number']") )
					{
						if( key == "saleprice_min" )
						{
							$(this).val( ListingPage.model.vars.min_price );
						}

						if( key == "saleprice_max" )
						{
							$(this).val( ListingPage.model.vars.max_price );

							ListingPage.model.manual_slide = true;

							$( "#price-range" ).slider({
							  values: [ ListingPage.model.vars.min_price, ListingPage.model.vars.max_price ]
							});

							ListingPage.model.manual_slide = false;
						}
					}
				});

				bindUniform(); // Reset the checkbox on the left sidebar

				ListingPage.model.vars.current_page = 0;
				ListingPage.controller.filterChanged()
			});

			// INFINITE Scroll, and get the next page products.. 
			$(window).scroll(function(){

				m = ListingPage.model.vars;

				var scrolled 	= $(window).scrollTop() + $(window).height() / 2;
				var offset 		= container.offset();
				var c_height 	= container.height();
				var back_top 	= $(".back-top").height();
				
				if( scrolled >  ( c_height - back_top ) && !m.loading && scrolled > pre_top && m.auto_load )
				{
					m.loading = true;
					ListingPage.controller.getNextPage()
				}

				pre_top = scrolled;
			});
		},

		setMaxMinPrice : function()
		{
			ListingPage.model.vars.max_price = pro_max;
			ListingPage.model.vars.min_price = pro_min;
		},

		functions: {
			// Adds overlay to the document once any filter is applied or removed.. 
			"addOverlay" : function(){

	        	var overlay = '<div class="overlay" id="overlay" style="display:none"><div class="loader center"><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div></div></div>';
	        	$('body').append(overlay);
	        },
	        //Show and hide the Overlay for loading the filter.
	        'overlay' 	: {

	        	'show'	: function(){ 

	        		$('html, body').animate({
						scrollTop: $("body").offset().top
					}, 800);

	        		$("#overlay").fadeIn();
	        	},
	        	'hide'	: function(){ $("#overlay").fadeOut() },
	        },
		},
	},
}

$(document).ready(function(){

	//Initializing the Product List JS filter functionality..
	ListingPage.controller.init();
});

function filterHtml( section, arr )
{
	var tpl = '<div class="checkbox '+section+'">';
	tpl +=		'<label class="fix-slide-checkbox">';
	tpl +=			'<input type="checkbox" value="{KEY}" id="chk{CLEAN_KEY}" class="fltr__src" field="'+section+'">'
	tpl +=			'<span class="value">{UCKEY}&nbsp;</span>'
	tpl +=			'<span class="count">[{DOC_COUNT}]</span>'
	tpl +=		'</label></div>';

	var html = "";

	$.each( arr, function(i,ar){
		
		sec_html = tpl;
		sec_html = sec_html.replace("{KEY}",ar.key);
		sec_html = sec_html.replace("{CLEAN_KEY}",clean(ar.key));
		sec_html = sec_html.replace("{UCKEY}",ucfirst(ar.key));
		sec_html = sec_html.replace("{DOC_COUNT}",ar.doc_count);

		html 	+= sec_html;
	});
	
	$( "#"+section+"-wrapper .nano-content" ).html(html).hide().fadeIn();
	// $(".nano").nanoScroller({ alwaysVisible: true });
}

function sortNMerge( arr1, arr2, brand_arr )
{
	var keys = [];
	var result = []; j = 0;

	$.each(brand_arr, function(i,val){

		result[j] = val;
		keys[j++] = val.key;
	});

	$.each(arr1, function(i,val){

		if( $.inArray( val.key, keys ) == -1 )
		{
			result[j] = val;
			keys[j++] = val.key;
		}
		else
		{
			key = $.inArray( val.key, keys )
			result[key].doc_count = val.doc_count;
		}
	});

	$.each(arr2,function(i,val){

		if( $.inArray( val.key, keys ) == -1 )
		{
			val.doc_count = 0;
			result[j++] = val;
		}
	})

	// result.sort(function(a, b) {
	//     return b.doc_count - a.doc_count;
	// })

	return result;
}
function decode(s)
{
  s.replace("&amp;","&");
  return s;
}
