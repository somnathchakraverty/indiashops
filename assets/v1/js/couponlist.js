var loading = false;
var auto_load = true;
var pre_top;
var right_container = $("#right_container");

$(document).on("click","#load_more1",function(e){
	e.preventDefault();
	CouponListing.controller.getNextPage();
	return false;
});

var CouponListing = {

	"controller" : {

		"init" 	: function()
		{
			var that = this;

			$(document).on("change",".fltr__src",function(){
				that.filterChange();
			});

			$(document).on("click",".fltr__reset",function(){
				
				that.clearFieldByType( $(this) );
				return false; 
			});

			$(window).scroll(function(){
				
				var container 	= $(".all-category-bg");
				var scrolled 	= $(window).scrollTop() + $(window).height() / 2;
				var c_height 	= container.height() - $("#sticky-header").height();
				
				if( scrolled >  ( c_height ) && !loading && scrolled > pre_top && auto_load )
				{
					that.getNextPage();
				}
				// console.log( scrolled+":"+c_height+":"+auto_load+":"+pre_top );
				pre_top = scrolled;
			});

			$(document).on("click","#clear-all",function(){
				that.resetFields();
				$(".fltr__src").prop("checked",false);
				$("input[value='all']").prop("checked",true);
				that.setFilterHash();
				that.addClearButtons();
				that.updateAppliedFilter();
				that.refreshBoxes();
			});

			$(document).on("click",".single-prop",function(){
				var id = $(this).attr("data-groupname");

				$("input[value='"+id+"']").prop("checked",false);

				if( $("input[type='radio']:checked").length == 0 )
				{
					$("input[value='all']").prop("checked",true)
				}
				that.resetFields();
				that.checkFields();
				that.setFilterHash();
				that.addClearButtons();
				that.updateAppliedFilter();
				that.refreshBoxes();
			});

			$(document).ready(function(){
				that.addOverlay();
				that.addLoader();
				that.applyPreviousFilter( function(){

					that.filterChange();
				});
				
			});
		},

		"filterChange" 	: function()
		{
			this.resetFields();
			this.checkFields();
			this.setFilterHash();
			this.addClearButtons();
			this.updateAppliedFilter();
			this.resetFields();
		},

		"action" 	: {
			"add" 		: function( $type, $val )
			{
				CouponListing.model.fields[$type].push(create_slug($val) );
			},
			"addR" 		: function( $type, $val ) // Add all the value seperated by ","
			{
				$values = $val.split(":");
				$("input[name='"+$type+"']").prop("checked",false);

				$.each( $values, function( i, value ){
					// CouponListing.model.fields[$type].push( value );
					$("input[value='"+unslug(value)+"']").prop("checked",true);
				});

			},
			"remove" 	: function( $field, $type )
			{

			},
		},
		"resetFields" : function()
		{
			CouponListing.model.fields.type 	= [];
			CouponListing.model.fields.category = [];
			CouponListing.model.fields.vendor_name = [];
		},

		"checkFields" : function()
		{
			var that = this;

			$.each( $(".fltr__src"), function( i, el ){
				
				if( $(el).is(":checked") )
				{
					var type = $(el).attr('name');

					if( $(el).val() != "all" )
						that.action.add( type, $(el).val() );
				}
			});

			// console.log( CouponListing.model );
		},

		"setFilterHash" : function( $return )
		{
			var CL = CouponListing;
			var fields = "";

			if ( typeof $return === 'undefined' ) $return = false ;

			if( $return )
				seperator = ":"
			else
				seperator = ",";

			$.each( CL.model.fields, function( field, value ){
				// console.log(value);
				if( value.length > 0 )
				{
					if( fields.length > 0 )
					{
						fields += CouponListing.model.defaults.seperator+field+"="+CL.model.fields[field].join(seperator);
					}
					else
					{
						fields += field+"="+CL.model.fields[field].join(seperator);
					}
				}
			});

			if( fields.length > 0 )
			{
				window.location.hash = fields;	
			}
			else
			{
				window.location.hash = "filter"
			}

			if( $return )
				return fields;
			else
			{
				this.getFilterData( fields );
			}
			
		},
		"getNextPage" 	: function(){

			this.checkFields();

			var that 	= this;
			var page 	= CouponListing.model.defaults.page;
			var fields 	= this.setFilterHash(true);
			var url 	= window.location.href.split("#")[0];
			var query 	= fields.replace( CouponListing.model.defaults.seperator, "&");
				
			if( url.indexOf("?") > -1 )
			{
				url 	= url.replace("?","/"+page+"?");
				url 	= url+"&ajax=true&"+query;
			}
			else
			{
				url 	= url+"/"+page+"?ajax=true&"+query;
			}

			loading 	= true;
			// console.log(query);
			that.loader.show();
			$("#load_more1").fadeOut();

			$.ajax({
				url: url,
				cache: true,
				beforeSend: function () {

					if (that.localCache.exist(url))
					{
						var re = that.localCache.get( url );
						CouponListing.view.update( re.responseText );
						that.loader.hide();
						CouponListing.model.defaults.page += 1;
						return false;
					}

					return true;
				},
				complete: function (jqXHR, textStatus){
					that.localCache.set( url, jqXHR, false );
				}
			})
			.done( function( result ){

				CouponListing.view.update( result );
				that.loader.hide();
				CouponListing.model.defaults.page += 1;
			});
		},
		"getFilterData" 	: function( fields ){

			var that = this;
			that.overlay.show();

			var url 	= window.location.href.split("#")[0];
			var query 	= fields.replace( CouponListing.model.defaults.seperator, "&");

			if( url.indexOf("?") > -1 )
			{
				url 	= url+"&ajax=true&"+query;
			}
			else
			{
				url 	= url+"?ajax=true&"+query;
			}

			$.ajax({
				url: url,
				cache: true,
				beforeSend: function () {

					if (that.localCache.exist(url))
					{
						var re = that.localCache.get( url );
						CouponListing.view.render( re.responseText );
						that.overlay.hide();
						that.resetInfiniteLoader();
						return false;
					}

					return true;
				},
				complete: function (jqXHR, textStatus){
					that.localCache.set( url, jqXHR, false );
				}
			})
			.done( function( result ){

				CouponListing.view.render( result );
				that.resetInfiniteLoader();
				that.overlay.hide();
			});
		},
		'localCache' : {
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

		"resetInfiniteLoader"	: function(){

			CouponListing.model.defaults.page = 1;
			auto_load = true;
			$("#load_more1").fadeOut();
			$("#no_more").fadeOut();
		},
		updateAppliedFilter : function(){

			var fields = this.toParams( this.setFilterHash( true ) );
			// console.log(fields);
			var fltr_label = {};
			var fltr_text = "";
			var price = [];

			$.each( fields, function( label, value ){

				switch( label )
				{
					case "category":

						cats 		= value.split(":");
						fltr_label[label] = "<div class='single-fltr'><span class='fltr-label'>Category: </span>";

						$.each(cats, function(i,cat){
							fltr_label[label] += "<div data-groupname='"+cat+"' class='single-prop'><span class='fltr-name'>"+ucfirst( cat, true )+"</span><span class='fltr-remove'>X</span></div>";
						});
						fltr_label[label] += "</div>";

						break;

					case "vendor_name":

						cats 		= value.split(":");
						fltr_label[label] = "<div class='single-fltr'><span class='fltr-label'>Vendor: </span>";

						$.each(cats, function(i,cat){
							fltr_label[label] += "<div data-groupname='"+cat+"' class='single-prop'><span class='fltr-name'>"+ucfirst( cat, true )+"</span><span class='fltr-remove'>X</span></div>";
						});
						fltr_label[label] += "</div>";

						break;

					case "type":

						if( value.length > 0 )
						{
							fltr_label[label] = "<div class='single-fltr'><span class='fltr-label'>Offer Type: </span>";
							fltr_label[label] += "<div data-groupname='"+value+"' class='single-prop'><span class='fltr-name'>"+ucfirst( value, true )+"</span><span class='fltr-remove'>X</span></div>";
							fltr_label[label] += "</div>";
						}

						break;
				}

			});

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
		"toParams" : function (filterHash) {	//alert(883);
			// console.log( filterHash );
            var params = {},
                prop_strings = decodeURIComponent(filterHash).replace("#", "").split( CouponListing.model.defaults.seperator );

            if (prop_strings[0] !== "") {
                $.each(prop_strings, function (i, prop_string) {
                	if( prop_string.split("=")[1] != "all" )
                    	params[prop_string.split("=")[0]] = unslug( prop_string.split("=")[1] );
                });
                
                if ("property" in params) {
                    params.property = $.grep(params.property.split("|").sort(), function (e, i) {
                        return (e !== "");
                    });
                }
            }

            return params;
        },
		"applyPreviousFilter" : function( callback )
		{
			var hash = window.location.hash.replace("#","");
			var that = this;
			var type = hash.split( CouponListing.model.defaults.seperator );

			$.each( type, function( index, val ){

				value = val.split("=");
				that.action.addR( value[0], value[1] );
			});

			callback();

		},

		"addClearButtons" 	: function()
		{
			$.each( CouponListing.model.fields, function( field, value ){

				if( value.length > 0 )
				{
					$("#"+field).fadeIn();
				}
				else
				{
					$("#"+field).fadeOut();
				}
			});
		},
		"clearFieldByType" : function( el )
		{
			var id = el.attr("id");
			$("input[name='"+id+"']").prop("checked",false);

			this.resetFields();
			this.checkFields();
			this.setFilterHash();
			this.addClearButtons();
			this.updateAppliedFilter();
			this.refreshBoxes();

		},
		// This is used to update all the Check boxes, and radio buttons
		"refreshBoxes"	: function(){ 
			bindUniform()
		},
		"addLoader" : function(){

        	right_container.append( CouponListing.view.loading_img );
        	right_container.append( CouponListing.view.load_more );
        	right_container.append( CouponListing.view.no_more_prod );
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
        'loader' 	: {

        	'show'	: function(){

        		$("#loading_img").fadeIn();
        	},
        	'hide'	: function(){ $("#loading_img").fadeOut() },
        },
	},

	"model" 	 : {
		"defaults" : {

			"seperator" : "|",
			"page" : 1,
		},
		"fields":{
			
			"type" 		: [],
			"category" 	: [],
			"vendor_name": [],
		}
	},
	"view"		 : {

		"coupons" 	: $("#coupon-wrapper"),
		"counter" 	: $("#c_total"),
		loading_img : "<div class='col-md-2 col-md-offset-5'><img id='loading_img' src='"+load_image+"' alt='Loading more products.....' style='display:none'/></div>",
		load_more 	: "<div class='col-md-4 col-md-offset-4'><span id='load_more1' class='btn btn-danger form-control' style='display:none'>Load More</span></div>",
		no_more_prod: "<div class='col-md-12'><label id='no_more' class='btn btn-danger form-control' style='display:none'>Thats All Folks !!!</label></div>",

		"render" : function( $data )
		{
			try
			{
				result = $.parseJSON( $data );

				if( result.coupons.indexOf("coupon-list-panel") > -1 )
				{
					this.counter.html( result.total ).hide().fadeIn();
					this.coupons.html( result.coupons ).hide().fadeIn();
				}
				else
				{
					this.counter.html( "0" ).hide().fadeIn();
					var text = $("input[type='radio']:checked").val();

					if( text.length == 0 || text == "all" )
						text = "Coupons";

					this.coupons.html( "<h2> No "+ucfirst(text,true)+" found !!</h2>" ).hide().fadeIn();
				}
			}
			catch( err )
			{
				return false;
			}
			// console.log($data);
		},

		"update" : function( $data )
		{
			try
			{
				result = $.parseJSON( $data );

				if( result.coupons.indexOf("coupon-list-panel") > -1 )
				{
					// this.counter.html( this.counter.html() + result.total ).hide().fadeIn();
					if( CouponListing.model.defaults.page > 1 )
					{
						auto_load = false;
						$("#load_more1").fadeIn();
					}

					this.coupons.append( result.coupons ).fadeIn();
				}
				else
				{
					// this.counter.html( "0" ).hide().fadeIn();
					$("#no_more").show();
					auto_load = false;
				}

				loading 	= false;
			}
			catch( err )
			{
				return false;
			}
			// console.log($data);
		},
	},
}

$(document).ready(function(){
	CouponListing.controller.init();
});

function create_slug( str )
{
	// var re = new RegExp(/[^A-Za-z0-9-]/i, 'g');

	str = str.toLowerCase();
	str = str.replace(/\s/g , "-");
	str = encodeURIComponent( str );
	return str;
}

function unslug( str )
{
	// var re = new RegExp(/[^A-Za-z0-9-]/i, 'g');
	str = decodeURIComponent( str );
	str = str.toLowerCase();
	str = str.replace(/-/g , " ");

	return str;
}

function ucfirst(str,force)
{
	str = force ? str.toLowerCase() : str;
	return str.replace(/(\b)([a-zA-Z])/,
	       function(firstLetter){
	          return   firstLetter.toUpperCase();
	       });
}