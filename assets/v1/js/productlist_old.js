var loading = false;
var pre_top;
var page = 2;
var container 	= $("#product_wrapper");
var r_container = $("#right-container");
var auto_load 	= true;
// var foo_offset	= $("#footer").offset();
var loading_img = "<div class='col-md-2 col-md-offset-5'><img id='loading_img' src='"+load_image+"' alt='Loading more products.....' style='display:none'/></div>";
var load_more 	= "<div class='col-md-4 col-md-offset-4'><a id='load_more' href='#' class='btn btn-danger form-control' style='display:none'>Load More</a></div>";
var no_more_prod= "<div class='col-md-12'><label class='btn btn-danger form-control'>Thats All Folks !!!</label></div>";

$(document).ready(function(){

	r_container.append( loading_img );
	r_container.append( load_more )

	$(window).scroll(function(){
		
		var scrolled 	= $(window).scrollTop() + $(window).height() / 2;
		var offset 		= container.offset();
		var c_height 	= container.height();
		var back_top 	= $(".back-top").height();
		
		if( scrolled >  ( c_height - back_top ) && !loading && scrolled > pre_top && auto_load )
		{
			ListingPage.filter.get_next_page()
		}

		pre_top = scrolled;
	});

	$("#load_more").click(function(){
		ListingPage.filter.get_next_page()
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
		// console.log(len);
		// console.log(parent_ul.find(".checkbox .checker").length);
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
	return str.replace(/\s/g,"-");
}

/***********************Product List Filter**************************/

var ListingPage = {
	'vars' :{
				'f_products': "",
				'r_products': "",
				'p_wrapper'	: "",
				'filter_url': "",
				'smin' 		: 0,
				'smax' 		: 0,
				'fields' 	: [],
				'qstring' 	: "",
				'isLoading' : false,
				"loading_img": img_url+"/v1/loading.gif",
				'a_fields'	: { 
								minp 	: "smin", 
								maxp 	: "smax",
								br 		: "brand",
								pr 		: "property",
								mins 	: "saleprice_min",
								maxs 	: "saleprice_max",
								pg 		: "page",
								qu		: "query",
								sr 		: "sort",
								sub 	: "subcategory",
								gr 		: "grp",
								ve 		: "vendor",
							}, // All fields matching based on field prefix
			},
	//"ajax_request",
	"filter" : { 
		vars : "",
		added: { mins : "", maxs : "" },
		init : function( p_wrapper, url ){

			this.vars = ListingPage.vars; // Point the reference to vars so that it can be accessed using `this` keyword
			this.vars.p_wrapper = p_wrapper; // product wrapper where the new data will be added
			this.setURL( url ); // Filter URL which will be used for AJAX requests
			this.initializeFilter();
			this.getFirstData(); // loading the product values based on hash values
			this.refreshHash();
			// this.add("value");
			// console.log( this );
		},

		initializeFilter : function(){

			var fltrObj = this;

			$("#right-container").css( 'min-height', $("#wrapper1").height() );

			$( "#price-range" ).slider({
			  range: true,
			  min: minPrice,
			  max: maxPrice,
			  animate: "slow",
			  values: [ minPrice, maxPrice ],
			  change: function( event, ui ) {
				  	var sMinPrice = ui.values[ 0 ];
				  	var sMaxPrice = ui.values[ 1 ];

				  	if( sMinPrice != $("#minPrice").val() || sMaxPrice != $("#maxPrice").val() )
				  	{
				  		$("#minPrice").val(sMinPrice);
					  	$("#maxPrice").val(sMaxPrice);
					  	$("#minPrice").change();
					  	$("#maxPrice").change();
				  	}
				},
				slide: function( event, ui ) {
				  	var sMinPrice = ui.values[ 0 ];
				  	var sMaxPrice = ui.values[ 1 ];

				  	// $("#minPrice").val(sMinPrice);
				  	// $("#maxPrice").val(sMaxPrice);
				}
			});

			$(document).on('change','.fltr__src', function(){
				var el = $(this);

				if( typeof $no_products ==='undefined' )
				{
					fltrObj.vars.isLoading = true;
					fltrObj.refreshValue( el );
					fltrObj.refreshHash();
					fltrObj.setQueryString();
					fltrObj.vars.f_products = fltrObj.getFilterData();
				}
			});

			$(document).on('click',"#clear-all",function(){
				fltrObj.clearFilter();
			});

			$(document).on('click',".single-prop",function(){
				fltrObj.removeFilterField( $(this) );
			});

			ListingPage.wishlist.init();
			fltrObj.addOverlay();
		},
		add: function( field ){

			if( !this.hasField( field ) )
			{
				this.vars.fields.push( field );
			}
			else
			{
				console.log("already has");
			}
		},
		remove : function( field ){

			if( this.hasField( field ) )
			{
				this.vars.fields.remove(field);
				return true;
			}
			else
			{
				return false;
				//console.log("doesn't exists");
			}

			// console.log(field);
		},

		refreshValue 	: function( el ){

			var val 	= el.attr("fltr--val");

			if( el.attr("type") == "text" )
			{
				var type 	= val.split("-");
				var newVal	= type[0]+"-"+el.val();

				// console.log(this.added.mins.length);

				if( type[0] == "mins" )
				{
					if( this.added.mins.length == 0 )
					{
						this.added.mins = newVal;
					}
					else if( el.val() < this.vars.smin )
					{
						el.val(this.vars.smin)
						return false;
					}
					else
					{
						this.remove( this.added.mins );
						this.added.mins = newVal;
					}
				}
				else if( type[0] == "maxs" )
				{
					if( this.added.maxs.length == 0 )
					{
						this.added.maxs = newVal;
					}
					else if( el.val() > this.vars.smax )
					{
						el.val(this.vars.smax)
						return false;
					}
					else
					{
						this.remove( this.added.maxs );
						this.added.maxs = newVal;
					}
				}
				else if( type[0] == "qu" )
				{
					var that = this;
					$.each( this.vars.fields, function( i, v ){

						val = v.split("-");

						if( val[0] == "qu" )
						{
							that.remove( v );
						}
					})
				}

				el.attr("fltr--val", newVal );
				this.add( newVal );

				return true;
			}
			else if( el.attr("type") == "checkbox" )
			{
				if( el.is(":checked") )
				{
					this.add( val );
				}
				else
				{
					this.remove(val);
				}
			}
		},

		getFirstData 	: function()
		{
			var fields 	= this.getURLHash();
			var len = $.map( fields, function(n, i) { return i; }).length; // check if filter is already applied
			// console.log(fields);
			if( len > 0 )
			{
				this.setFilterFields( fields );
				this.setQueryString();
				this.vars.f_products 	= this.getFilterData();
				this.setProducts( this.vars.f_products );
			}
			else
			{
				// this.updateLeftFilter();
			}

		},
		setFilterFields : function( fields ){
			var fltrObj = this;

			$.each( fields, function( i, value ){

				if( i == "brand" || i == "vendor" )
				{
					values = value.split(",");

					$.each( values, function( index, v ){

						var $field = getKey( fltrObj.vars.a_fields, i );

						fltrObj.add( $field+"-"+v );
					})
				}
				else
				{
					var $field = getKey( fltrObj.vars.a_fields, i );
				
					if( typeof value !== "object" )
					{
						fltrObj.add( $field+"-"+value );
					}
					else
					{
						$.each( value, function( index, v ){
							v = v.split("-");
							fltrObj.add( $field+"-"+v[1] );
						})
					}
				}
			});

			return true;
		},
		setQueryString 	: function(){
			
			this.vars.qstring = this.getURLParams();
			this.vars.qstring += this.getFieldHash()+"&ajax=true&autojs=true&filter=true";
		},
		setProducts 	: function( products ){

			this.vars.r_products = products;
		},
		getURLParams	: function(){

			
			if( window.location.href.indexOf("?") > -1 )
			{
				var params = window.location.href.split("?");

				if( params[1].indexOf("#") > -1 )
				{
					params[1] = params[1].split("#")[0];
				}
				return params[1]+"&";
			}
			else
			{
				return "";
			}
		},
		getFilterFields	: function(){

			var fields = this.vars.fields;
		},

		getFilterData	: function( fields ){

			if( typeof $no_products ==='undefined' )
			{
				if ( typeof fields ==='undefined' ) fields = "" ;
			
				this.vars.isLoading = true;
				this.overlay.show();

				$.get( this.vars.filter_url+"?"+this.vars.qstring ,function(data){
						// ListingPage.vars.p_wrapper.html( data );
						ListingPage.filter.updateProducts( data );
						// return data;
				});

				$.get( this.vars.filter_url+"?"+this.vars.qstring+"&isAggr=yes" ,function(data){
						// ListingPage.vars.p_wrapper.html( data );
						ListingPage.filter.updateProducts( data, true );
						// return data;
				});
			}
		},
		updateProducts 	: function ( data, leftFltr ){

			if ( typeof leftFltr ==='undefined' ) leftFltr = false ;

			try
			{
				result = $.parseJSON( data );

				var products 	= result.products;
				var facet		= result.facet;

				if( !leftFltr )
				{
					if( products.length > 0 )
					{
						this.vars.p_wrapper.html(products).hide().fadeIn('slow');
					}
					else
					{
						this.noProducts();
					}
				}

				if( leftFltr )
				{
					this.updateLeftFilter( facet );
				}

				this.overlay.hide();
				page = 2;
				auto_load = true;
				this.updateAppliedFilter();
				this.updateSortOptions();
				this.vars.isLoading = false;
				return products;
			}
			catch( err )
			{
				return false;
			}

		this.overlay.hide();

		},

		noProducts 	: function(){

			var height = $("#wrapper1").height();

			var no_product = "<div class='no-products col-md-12' style='min-height:"+height+"px'><h3>Sorry !!! No products found.. </h3></div>";
			this.vars.p_wrapper.html(no_product).hide().fadeIn('slow');
		},
		updateSortOptions: function(){

			var hash = this.getFieldHash();
			
			$("#product-list-cat-menu ul li a").each(function(i,v){
				var href = $(this).attr('href').split("#")[0];
				$(this).attr('href', href+"#"+hash );
			});
		},
		updateBrands	: function( facet ){

			var brands = "";
			var b_wrapper = $("#brand-wrapper");

			$("#brand-wrapper .fltr__src").prop('disabled',true).closest(".fix-slide-checkbox").find("span.count").html("[0]");

			$.each( facet.lbrand, function( i, brand ){

				var name = clean( brand.key );
				var el = $("#chk"+name );
				console.log(el);
				el.removeAttr( 'disabled' );
				el.closest(".fix-slide-checkbox").find("span.value").html( ucfirst(brand.key) );
				el.closest(".fix-slide-checkbox").find("span.count").html( "["+brand.doc_count+"]" );
			});

		},
		updateVendors	: function( facet ){

			var sellers = "";
			var s_wrapper = $("#seller-wrapper");

			$("#seller-wrapper .fltr__src").prop('disabled',true).closest(".fix-slide-checkbox").find("span.count").html("[0]");

			$.each( facet.sellers, function( i, seller ){

				var name = seller.key;
				var el = $("#chk"+name );
				el.prop('disabled',false);
				el.closest(".fix-slide-checkbox").find("span.value").html( alvendors.name[seller.key] );
				el.closest(".fix-slide-checkbox").find("span.count").html( "["+seller.doc_count+"]" );
			});

		},
		updateCategories: function( facet ){ return true; },
		updateLeftFilter: function( facet ){

			if ( typeof facet ==='undefined' ) facet = "" ;

			if( facet != "" && typeof facet.brand !=='undefined' )
			{
				if( facet.brand.length > 0 )
				{
					brands = facet.brand.split(",");
					// console.log(brands);
					
					$(".brand").find("input[type='checkbox']").prop("checked",false);
					$.each( brands, function( i, brand ){

						$("input[fltr--val='br-"+brand+"']").prop("checked",true);
						$("input[fltr--val='br-"+brand+"']").parent().addClass("checked");
					});
					bindUniform();

				}
				else
				{
					$(".brand").find("input[type='checkbox']").prop("checked",false);
				}

				bindUniform();
			}

			$(".seller").find("input[type='checkbox']").prop("checked",false);

			if( facet != "" && typeof facet.vendor_aggr.vendor.buckets !=='undefined' )
			{
				$(".seller").find("input[type='checkbox']").prop("checked",false);
				
				$.each( facet.vendor_aggr.vendor.buckets, function( i, seller ){

					$("input[fltr--val='ve-"+seller.key+"']").prop("checked",true);
					$("input[fltr--val='ve-"+seller.key+"']").parent().addClass("checked");
				});

				bindUniform();
			}

			bindUniform();
			
			var has_price = false;
			var fltrObj = this;

			$("#search").val("");

			$.each( this.vars.fields, function( i, val ){

				if( val.indexOf("mins-") > -1 || val.indexOf("maxs-") > -1 )
				{
					has_price = true;
				}

				if( val.indexOf("qu-") > -1  )
				{
					val = val.split("-");
					$("#search").val( val[1] );
				}
			});
			
			bindUniform();

			if( has_price )
			{
				var fields = fltrObj.getURLHash();
				
				// if( typeof fields.saleprice_min !== 'undefined' )
				// {
				// 	$("#minPrice").val( fields.saleprice_min );
				// 	$( "#price-range" ).slider( "option", "max", fields.saleprice_min );
				// }

				// if( typeof fields.saleprice_max !== 'undefined' )
				// {
				// 	$("#maxPrice").val( fields.saleprice_max );
				// 	$( "#price-range" ).slider( "option", "max", fields.saleprice_max );
				// }

				if( typeof fields.saleprice_min !== 'undefined' &&  typeof fields.saleprice_max !== 'undefined' )
				{
					$( "#price-range" ).slider({
					  values: [ fields.saleprice_min, fields.saleprice_max ]
					});
				}
			}
			else
			{

				if( typeof facet.maxPrice !== 'undefined' && typeof facet.minPrice !== 'undefined' )
				{
					$("#minPrice").val( facet.minPrice );
					$("#maxPrice").val( facet.maxPrice );

					$( "#price-range" ).slider( "option", "max", facet.maxPrice );
					$( "#price-range" ).slider( "option", "min", facet.minPrice );
				}
				else
				{
					$("#minPrice").val( this.vars.smin );
					$("#maxPrice").val( this.vars.smax );

					$( "#price-range" ).slider({
					  values: [ this.vars.smin, this.vars.smax ]
					});
				}
			}

			if( typeof fields.saleprice_min === 'undefined' &&  typeof fields.saleprice_max === 'undefined' )
			{
				if( typeof facet.maxPrice !== 'undefined' && typeof facet.minPrice !== 'undefined' )
				{
					$("#minPrice").val( facet.minPrice );
					$("#maxPrice").val( facet.maxPrice );
					$( "#price-range" ).slider( "option", "max", facet.maxPrice );
					$( "#price-range" ).slider( "option", "min", facet.minPrice );
				}
			}
			if( typeof facet.brand_aggr !== 'undefined' && typeof facet.brand_aggr !== 'undefined' )
			{
				// $("#minPrice").val( facet.brand_aggr.saleprice_min.value );
				// $("#maxPrice").val( facet.brand_aggr.saleprice_max.value );
				$( "#price-range" ).slider( "option", "max", facet.brand_aggr.saleprice_max.value );
				$( "#price-range" ).slider( "option", "min", facet.brand_aggr.saleprice_min.value );
			}

			if( typeof facet.vendor_aggr !== 'undefined' && typeof facet.vendor_aggr !== 'undefined' )
			{
				// $("#minPrice").val( facet.vendor_aggr.saleprice_min.value );
				// $("#maxPrice").val( facet.vendor_aggr.saleprice_max.value );
				$( "#price-range" ).slider( "option", "max", facet.vendor_aggr.saleprice_max.value );
				$( "#price-range" ).slider( "option", "min", facet.vendor_aggr.saleprice_min.value );
			}

			if( typeof facet.price_aggr !== 'undefined' && typeof facet.price_aggr !== 'undefined' )
			{
				// $("#minPrice").val( facet.price_aggr.saleprice_min.value );
				// $("#maxPrice").val( facet.price_aggr.saleprice_max.value );
				$( "#price-range" ).slider( "option", "max", facet.price_aggr.saleprice_max.value );
				$( "#price-range" ).slider( "option", "min", facet.price_aggr.saleprice_min.value );
			}
			
			this.updateBrands(facet);
			this.updateVendors(facet);
			this.updateCategories(facet);
			
			bindUniform();
		},
		updateFilter 	: function( facet ){

			if ( typeof facet ==='undefined' ) facet = "" ;

			var fltrObj = this;
			var lastObj;

			$(".fltr__src").each(function(){

				if( this.attr('type') == "checkbox" )
				{
					this.parent().removeClass('checked');
					this.prop( "checked", true );
					lastObj = this;
				}
			});

			$.each( this.vars.fields, function( i, val ){

				var el = ( "input[fltr--val='"+val+"']" );


				if( typeof el !== "undefined" )
				{
					if( el.attr('type') == "checkbox" )
					{
						el.parent().addClass('checked');
						el.prop( "checked", true );
					}
				}
				else
				{
					var option = val.split("-");

					if( option[0] == "mins" )
					{
						$("#maxPrice").val( option[1] );
						// $("#price-range").();
					}
					else if( option[0] == "maxs" )
					{
						$("#minPrice").val( option[1] );
					}
				}
			});

			// console.log( this.vars.fields );
			this.refreshFilter();
		},
		removeFilterField 	: function( prop ){

			var field = prop.attr('data-groupname');
			// console.log(field);
			if( !this.remove( field ) )
			{
				option = field.split("-");
				// console.log(option)
				if( option[0] == "price" )
				{
					this.remove( "mins-"+option[1] );
					this.remove( "maxs-"+option[2] );
				}
			}

			this.refreshFilter();
		},
		updateAppliedFilter : function(){

			var fields = this.getFieldHash(true);
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
							fltr_label[label] += "<div data-groupname='br-"+brand+"' class='single-prop'><span class='fltr-name'>"+ucfirst( brand, true )+"</span><span class='fltr-remove'>X</span></div>";
						});
						fltr_label[label] += "</div>";

						break;

					case "query":

						if( value.length > 0 )
						{
							fltr_label[label] = "<div class='single-fltr'><span class='fltr-label'>Search: </span>";
							fltr_label[label] += "<div data-groupname='qu-"+value+"' class='single-prop'><span class='fltr-name'>"+ucfirst( value, true )+"</span><span class='fltr-remove'>X</span></div>";
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
							fltr_label[label] += "<div data-groupname='ve-"+vendor+"' class='single-prop'><span class='fltr-name'>"+ucfirst( alvendors.name[vendor], true )+"</span><span class='fltr-remove'>X</span></div>";
						});

						fltr_label[label] += "</div>";
						break;
				}

			});

			if( price['saleprice_min'] && price['saleprice_max'] )
			{
				fltr_label['price'] = "<div class='single-fltr'><span class='fltr-label'>Price: </span><div data-groupname='price-"+price['saleprice_min']+"-"+price['saleprice_max']+"' class='single-prop'><span class='fltr-name'>"+price['saleprice_min']+"-"+price['saleprice_max']+"</span><span class='fltr-remove'>X</span></div></div>";
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

		getURLHash 		: function(){

			var fields = this.functions.toParams( window.location.hash );
			// console.log( $.param(fields) );return false;
			return fields;
		},

		setURL 			: function( url ){

			this.vars.filter_url = url;
		},

		refreshProducts	: function(){
			this.vars.p_wrapper.html( html )
		},

		refreshFilter 	: function(){

			this.refreshHash();
			this.setQueryString();
			this.getFilterData();
		},

		hasFilterData 	: function(){

		},

		hasField 		: function( value ){

			return this.vars.fields.indexOf(value) > -1
		},

		setMinMaxPrice : function( min, max ){

			ListingPage.vars.smin = min;
			ListingPage.vars.smax = max;
		},

		clearFilter 	: function(){

			this.vars.fields = [];
			this.refreshHash();
			this.setQueryString();
			this.getFilterData();
			// this.updateLeftFilter();
		},

		refreshHash 	: function(){

			var hash = this.getFieldHash();
			window.location.hash = hash;
		},

		getFieldHash 	: function( $array ){

			var fields 		= this.vars.fields;
			var params 		= {};
			var property 	= [];
			var brand 		= [];
			var fltrObj 	= this;
			var vendor 		= [];

			if (typeof $array ==='undefined' ) $array = false ;

			$.each( fields, function( i, val ){

				part = val.split("-");
				
				switch( fltrObj.vars.a_fields[part[0]] )
				{
				    case "saleprice_min":
				    	params.saleprice_min = part[1];
				        break;

				    case "saleprice_max":
				    	params.saleprice_max = part[1];
				        break;

				    case "property":
				        property.push( "brand-"+part[1] );
				        break;

				    case "brand":
				        brand.push( part[1] );
				        break;

				    case "page":
				        params.page = part[1];
				        break;

				    case "vendor":
				        vendor.push( part[1] );
				        break;

				    case "subcategory":
				        params.subcategory = part[1];
				        break;

				    case "query":
				        params.query = part[1];
				        break;

				    default:
				        
				} 
			});

			if( property.length > 0 )
			{
				params.property = property.join("|");
			}

			if( brand.length > 0 )
			{
				params.brand = brand.join(",");
			}

			if( vendor.length > 0 )
			{
				params.vendor = vendor.join(",");
			}

			if( typeof params.saleprice_max !== "undefined" && typeof params.saleprice_min !== "undefined" )
			{
				if( params.saleprice_min == fltrObj.vars.smin && params.saleprice_max == fltrObj.vars.smax )
				{
					delete params.saleprice_min;
					delete params.saleprice_max;
				}
			}
			else
			{
				if( typeof params.saleprice_max !== "undefined" && typeof params.saleprice_min === "undefined" )
				{
					params.saleprice_min = fltrObj.vars.smin
				}
				else if( typeof params.saleprice_max === "undefined" && typeof params.saleprice_min !== "undefined" )
				{
					params.saleprice_max = fltrObj.vars.smax
				}
				else if( typeof params.saleprice_max !== "undefined" && typeof params.saleprice_min !== "undefined" )
				{

				}
			}

			// console.log(typeof params.saleprice_min);
			// console.log(params);
			if( $array )
				return params;
			else
				return decodeURIComponent( $.param(params) );
		},

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

        get_next_page : function (){

			loading 	= true;
			var img_el 	= $("#loading_img");
			var clocation= window.location.href.split('?')[0];
			var qstring  = window.location.href.split('?')[1];
			var clocation= clocation.split('#')[0];
			var query 	= this.getFieldHash();

			if( query.length > 0 )
			{
				var url 	= clocation+"/"+page+"?ajax=true&autojs=true&sort="+sort_by+"&"+query+"&"+qstring;
			}
			else
			{
				var url 	= clocation+"/"+page+"?ajax=true&autojs=true&sort="+sort_by+"&"+qstring;
			}

			img_el.show();

			$("#load_more").hide();

			$.get(url,function(products){

				var html = $.parseHTML( products );
				// var total = html.find(".product-item").length;
				
				if( products.indexOf( "product-item" ) > -1 )
				{
					update_products( products ); loading = false;
					$(window).scroll(); page++;
					
					if( page >= 5 )
					{
						auto_load = false;
						$("#load_more").show();
					}
				}
				else
				{
					r_container.append( no_more_prod );
					auto_load = false;
				}

				img_el.hide();
			});
		},
		functions : {
			"toParams" : function (filterHash) {	//alert(883);
                var params = {},
                    prop_strings = decodeURIComponent(filterHash).replace("#", "").split("&");

                if (prop_strings[0] !== "") {
                    $.each(prop_strings, function (i, prop_string) {
                        params[prop_string.split("=")[0]] = prop_string.split("=")[1];
                    });
                    
                    if ("property" in params) {
                        params.property = $.grep(params.property.split("|").sort(), function (e, i) {
                            return (e !== "");
                        });
                    }
                    
                    if (params.minprice !== params.priceMin || params.maxprice !== params.priceMax) {
                        params.price = parseInt(params.minprice, 10) + ";" + parseInt(params.maxprice, 10);
                    }

                    delete params.minprice;
                    delete params.maxprice;
                }

                return params;
            },
		},

	},
	wishlist 	: {
		vars 	: { 'timeout' : false },
		init 	: function(){

			wishObj = this;

			$(document).on('click',".wishlist-icon",function(){
				
				ListingPage.filter.overlay.show();
				wishObj.checkWishlist( $(this) );
				ListingPage.filter.overlay.hide();
				return false;
			});

			this.updateProducts();
		},
		add 	: function( prod_id ){

			if( !this.inWishlist( prod_id ) )
			{
				cooks = this.getWCookie();
				cooks[prod_id] = prod_id;
				this.updateWishlist( cooks );
				return true;
			}
		},
		remove 	: function( prod_id ){

			if( this.inWishlist( prod_id ) )
			{
				cooks = this.getWCookie();
				delete cooks[prod_id];
				this.updateWishlist( cooks );
				return true;
			}
		},
		checkWishlist  : function( el ){

			var prod_id = el.attr('prod-id');

			if( el.hasClass( "wish-added" ) )
			{
				if( this.remove( prod_id ) )
				{
					this.sendWishlistRequest( prod_id, "remove",function(){

						el.removeClass( "wish-added" );
						ListingPage.wishlist.showMessage( "Product Removed from wishlist.. ", "danger" );
					});
				}
			}
			else
			{
				if( this.add( prod_id ) )
				{
					this.sendWishlistRequest( prod_id, "add", function(){
						el.addClass( "wish-added" ).attr('title', "Remove from Wishlist");
						ListingPage.wishlist.showMessage( "Product Added to wishlist.. " );
					} );
				}
			}
		},
		sendWishlistRequest : function( prod_id, action, callback ){

			url = "";
			callback();
		},
		updateWishlist : function( cooks ){
			setCookie( "indshp_cookie", JSON.stringify( cooks ), 1000 );
		},
		inWishlist: function( prod_id ){

			var cooks = this.getWCookie();

			if( cooks.hasOwnProperty( prod_id ) )
			{
				return true;
			}
			else
			{
				return false;
			}
		},

		getWCookie : function(){

			var cook = getCookie("indshp_cookie");

			if( cook.length > 0 )
			{
				try
				{
					cooks = $.parseJSON( cook );

					return cooks;
				}
				catch( err )
				{
					return {};
				}
			}
			else
			{
				return {};
			}
		},

		updateProducts : function(){

			cooks = this.getWCookie();

			$.each( cooks, function( i, val ){

				$('span[prod-id="'+i+'"]').addClass("wish-added").attr('title', "Remove from Wishlist");
			});
		},

		showMessage : function( msg, cls ){

			if ( typeof cls ==='undefined' ) cls = "success" ;

			if( this.vars.timeout !== false )
			{
				clearTimeout( this.vars.timeout )
				this.vars.timeout = false;
			}

			$("#message-div").attr( "class", "alert alert-"+cls );
			$("#message-div").html( msg );
			$("#message-div").fadeIn('slow');
			this.vars.interval = setTimeout(function(){$("#message-div").slideUp('slow')},4000);
		},
	},
}

$(document).ready(function(){
	ListingPage.filter.setMinMaxPrice( pro_min, pro_max );
	ListingPage.filter.init( product_wrapper, filter_url );
});

/***********************Adding remove element by value to Array prototype**************************/

Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};

function getKey( arr, value )
{
	var found = false;
	if( typeof arr === "object" )
	{
		$.each( arr, function( i, val ){
			
			if( val.trim() == value.trim() )
			{
				found = i;
				return true;
			}
		})

		if( found )
			return found;
	}

	return false;
}

$(document).ajaxStop(function(){
    ListingPage.wishlist.updateProducts();
});