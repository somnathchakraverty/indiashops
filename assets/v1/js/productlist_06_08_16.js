var loading = false;
var pre_top;
var page = 2;
var container 	= $("#product_wrapper");
var r_container = $("#right-container");
// var foo_offset	= $("#footer").offset();
var loading_img = "<div class='col-md-2 col-md-offset-5'><img id='loading_img' src='"+load_image+"' alt='Loading more products.....' style='display:none'/></div>";
var load_more 	= "<div class='col-md-4 col-md-offset-4'><a id='load_more' href='#' class='btn btn-danger form-control' style='display:none'>Load More</a></div>";
var no_more_prod= "<div class='col-md-12'><label class='btn btn-danger form-control' id='no_more_prod'>Thats All Folks !!!</label></div>";

$(document).ready(function(){

	r_container.append( loading_img );
	r_container.append( load_more );

	$("#load_more").click(function(){

		ListingPage.controller.getNextPage()
		return false;
	});

	$("#search-brand").keyup(function(){
		var brand 		= $(this).val();
		brand 			= ucfirst( brand, true );
		var parent_ul 	= $(this).parent().parent().parent();
		var matched 	= parent_ul.find(".checkbox .fix-slide-checkbox:not(:contains('"+brand+"'))");
		var total 	 	= parent_ul.find(".checkbox .fix-slide-checkbox:contains('"+brand+"')");
		var not_matched = parent_ul.find(".checkbox .fix-slide-checkbox");

		not_matched.each(function(){
			$(this).parent().show();
		});

		if( total.length > 0 )
		{
			matched.each(function(){
				$(this).parent().hide();
			});
		}
	});

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

function clean( str )
{
	str = str.replace(/\s/g,"-");
	str = str.replace("&","");
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
		renderFilter : function( facet ){

			ListingPage.model.manual_slide = true;

			ListingPage.view.resetCheckboxes();
			if( typeof facet.filter_saleprice != "undefined" )
			{
				$("#sidebar").find("input[field='vendor']").prop("disabled",true).closest(".fix-slide-checkbox").find("span.count").html("[0]");

				var vendors = facet.filter_saleprice.vendor.buckets;

				$.each(vendors,function(i,v){
					$( "#chk"+v.key ).prop("disabled",false);
					$( "#chk"+v.key ).closest(".fix-slide-checkbox").find("span.count").html("["+v.doc_count+"]");
				});

				$("#sidebar").find("input[field='brand']").prop("disabled",true).closest(".fix-slide-checkbox").find("span.count").html("[0]");

				var brands = facet.filter_saleprice.brand.buckets;

				$.each(brands,function(i,b){
					$( "#chk"+b.key ).prop("disabled",false);
					$( "#chk"+b.key ).closest(".fix-slide-checkbox").find("span.count").html("["+b.doc_count+"]");
				});

			}
			else
			{
				
				if( typeof facet.filter_brand != "undefined" )
				{
					$("#sidebar").find("input[field='vendor']").prop("disabled",true).closest(".fix-slide-checkbox").find("span.count").html("[0]");

					var vendors = facet.filter_brand.vendor.buckets;
					var newVendor 	= sortNMerge( vendors, facet.vendor.buckets, facet.filter_brand.brand.buckets );

					var brand_arr = facet.filter_brand.brand.buckets;
					// filterHtml( "seller", newVendor );

					$.each(vendors,function(i,v){
						$( "#chk"+v.key+"[field='vendor']" ).prop("disabled",false);
						$( "#chk"+v.key ).closest(".fix-slide-checkbox").find("span.count").html("["+v.doc_count+"]");
					});

					var brands = facet.filter_brand.brand.buckets;

					$.each(brands,function(i,b){
						try
						{
							$( "#chk"+clean(b.key)+"[field='brand']" ).prop("disabled",false);
							$( "#chk"+decodeURIComponent(b.key) ).closest(".fix-slide-checkbox").find("span.count").html("["+b.doc_count+"]");
						}
						catch(e){}
					});

					$( "#price-range" ).slider({
					  values: [ facet.filter_brand.saleprice_min.value, facet.filter_brand.saleprice_max.value ]
					});
				}
				else
				{
					$("#sidebar").find("input[field='vendor']").prop("disabled",false);

					var vendors  	= facet.vendor.buckets;
					var brand_arr = [];
					// filterHtml( "seller", vendors );

					$.each(vendors,function(i,v){
						try
						{
							$( "#chk"+v.key+"[field='vendor']" ).closest(".fix-slide-checkbox").find("span.count").html("["+v.doc_count+"]");
						}catch(e){}
					});

					$( "#price-range" ).slider({
					  values: [ facet.saleprice_min.value, facet.saleprice_max.value ]
					});
				}

				if( typeof facet.filter_vendor != "undefined" )
				{
					$("#sidebar").find("input[field='brand']").prop("disabled",true).closest(".fix-slide-checkbox").find("span.count").html("[0]");

					var brands = facet.filter_vendor.brand.buckets;
					
					var newBrand = sortNMerge( brands, facet.brand.buckets, brand_arr );

					filterHtml( "brand", newBrand );

					$.each(brands,function(i,b){
						try
						{
							$( "#chk"+clean(HtmlDecode(b.key))+"[field='brand']" ).prop("disabled",false);
							$( "#chk"+decodeURIComponent(b.key) ).closest(".fix-slide-checkbox").find("span.count").html("["+b.doc_count+"]");
						}
						catch(e )
						{
							
						}
					});

					var vendors = facet.filter_vendor.vendor.buckets;

					$.each(vendors,function(i,v){
						try
						{
							$( "#chk"+clean(v.key) ).prop("disabled",false);
							$( "#chk"+clean(v.key) ).prop("checked",true);
						}
						catch(e ){}
					});
					$( "#price-range" ).slider({
					  values: [ facet.filter_vendor.saleprice_min.value, facet.filter_vendor.saleprice_max.value ]
					});
				}
				else
				{
					$("#sidebar").find("input[field='brand']").prop("disabled",false);

					var brands = facet.brand.buckets;

					filterHtml( "brand", brands );
					//console.log(facet)

					$.each(brands,function(i,b){
						try{
							$( "#chk"+clean(b.key)+"[field='brand']" ).closest(".fix-slide-checkbox").find("span.count").html("["+b.doc_count+"]");
						}catch(e){}
					});

					$( "#price-range" ).slider({
					  values: [ facet.saleprice_min.value, facet.saleprice_max.value ]
					});
				}
			}
			
			if( typeof facet.filter_brand !== "undefined" )
			{
				brands = facet.filter_brand.brand.buckets;

				$.each(brands,function(i,b){
					try
					{
						console.log($( "#chk"+clean(b.key) ));
						$( "#chk"+clean(b.key) ).prop("disabled",false);
						$( "#chk"+clean(b.key) ).prop("checked",true);
					}
					catch(e ){}
				});
			}

			if( typeof facet.filter_vendor !== "undefined" )
			{
				vendors = facet.filter_vendor.vendor.buckets;

				$.each(vendors,function(i,b){
					try
					{
						$( "#chk"+(b.key) ).prop("disabled",false);
						$( "#chk"+(b.key) ).prop("checked",true);
					}
					catch(e){}
				});
			}

			bindUniform();

			ListingPage.model.manual_slide = false;

			$(".nano").nanoScroller({ alwaysVisible: true });
			$(".nano1").nanoScroller({ alwaysVisible: true,paneClass: 'scrollPane'});
		},

		renderAppliedFilter : function(){

			fields = ListingPage.model.fields;

			var fltr_label = {};
			var fltr_text = "";
			var price = [];

			$.each( fields, function( label, value ){

				switch( label )
				{
					case "brand":

						brands 		= value.split(",");
						fltr_label[label] = "<div class='single-fltr'><span class='fltr-label'>Brand: </span>";

						$.each(brands, function(i,brand){
							fltr_label[label] += "<div value='"+brand+"' class='single-prop' name='brand'><span class='fltr-name'>"+ucfirst( brand, true )+"</span><span class='fltr-remove'>X</span></div>";
						});
						fltr_label[label] += "</div>";

						break;

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

		addProducts : function( products ){

			var html 	= $.parseHTML( products );
			var img_el 	= $("#loading_img");

			if( products.indexOf( "product-item" ) > -1 )
			{
				$("#product_wrapper").append(products).hide().fadeIn();

				m.loading = false;

				$(window).scroll();
				
				if( ListingPage.model.vars.current_page >= 4 )
				{
					m.auto_load = false;
					$("#load_more").show();
				}
			}
			else
			{
				$( "#no_more_prod" ).remove();
				r_container.append( no_more_prod );
				$("#load_more").hide();
				auto_load = false;
			}

			img_el.hide();
		},

		resetCheckboxes: function(){

			$("input[type='checkbox']").each(function(){

				$(this).prop("disabled",false);
				$(this).prop("checked",false);
			});

			bindUniform();
		},
	},
	controller: {

		init : function(){

			this.setMaxMinPrice();
			this.registerEvents();
			this.setupFilterURL();
			this.initializePreFilter();
			this.functions.addOverlay();

			if( Object.keys(ListingPage.model.fields).length > 0 )
				this.getProducts();
			else
				ListingPage.view.resetCheckboxes();

		},
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
		filterChanged : function(){

			ListingPage.model.vars.current_page = 0;
			ListingPage.model.vars.auto_load 	= true;

			fields = this.getFilterFields();
			this.updateURLHash( fields );
			this.getProducts();

		},
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

			if( fields.saleprice_max == vars.max_price && fields.saleprice_min == vars.min_price )
			{
				delete fields.saleprice_max;
				delete fields.saleprice_min;
			}

			ListingPage.model.fields = fields;
			return fields;
		},
		setupFilterFields: function(){


		},
		getNextPage : function(){


			m.loading = true;

			ListingPage.model.vars.current_page++;

			$("#loading_img").show()

			this.setupFilterURL()

			this.getProducts( true, function(products){

				ListingPage.view.addProducts( products );

				m.loading = false;
			});
		},
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
		renderViews : function( data, callback ){

			this.updateSortOptions();
			ListingPage.view.renderProducts( data.products );
			ListingPage.view.renderAppliedFilter();
			ListingPage.view.renderFilter( data.facet );


			if ( $.isFunction(callback) ) callback();
		},
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
		setupFilterURL : function(){
			w 		= window.location
			page 	= ListingPage.model.vars.current_page;
			l 		= w.origin+w.pathname+'/'+page+w.search;

			ListingPage.model.ajax_url = l;
		},
		updateSortOptions: function(){

			var hash = ListingPage.controller.getURLHash();
			
			$("#product-list-cat-menu ul li a").each(function(i,v){
				var href = $(this).attr('href').split("#")[0];
				$(this).attr('href', href+"#"+hash );
			});
		},

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

		registerEvents : function (){

			m = ListingPage.model;

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

			$( document ).on("click",".single-prop",function(){

				prices = $(this).attr("value").split("-");
				hasPrice = false;
				if( typeof prices[1] !== "undefined" )
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

				bindUniform();

				ListingPage.model.vars.current_page = 0;
				ListingPage.controller.filterChanged()
			});

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

			"addOverlay" : function(){

	        	var overlay = '<div class="overlay" id="overlay" style="display:none"><div class="loader center"><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div></div></div>';
	        	$('body').append(overlay);
	        },
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
