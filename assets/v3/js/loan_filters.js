var loading=false;var pre_top;var page=2;var container=$("#product_wrapper");var r_container=$("#right-container");var loading_img="<div class='col-md-2 col-md-offset-5'><img id='loading_img' src='"+load_image+"' alt='Loading more products.....' style='display:none'/></div>";var load_more="<div class='col-md-4 col-md-offset-4'><a id='load_more' href='#' class='btn btn-danger form-control' style='display:block'>Load More</a></div>";var no_more_prod="<div class='col-md-12'><label class='btn btn-danger form-control' id='no_more_prod'>Thats All Folks !!!</label></div>";$(document).ready(function(){r_container.append(loading_img);r_container.append(load_more);$("#load_more").click(function(){$(this).hide();ListingPage.controller.getNextPage()
return false;});$(".search_attr").keyup(function(){var brand=$(this).val();brand=ucfirst(brand,true);var parent_ul=$(this).parent().parent().parent();var matched=parent_ul.find(".checkbox .fix-slide-checkbox:not(:contains('"+brand+"'))");var total=parent_ul.find(".checkbox .fix-slide-checkbox:contains('"+brand+"')");var not_matched=parent_ul.find(".checkbox .fix-slide-checkbox");not_matched.each(function(){$(this).parent().show();});matched.each(function(){$(this).parent().hide();});});$(document).on("click",".search-category",function(){var cat_id=$(this).attr("id");var url=window.location.href;url=url.split("#")[0]
url=url.split("&cat_id")[0];url=url+"&cat_id="+cat_id+window.location.hash;window.location.href=url;});});function update_products(products)
{$("#product_wrapper").append(products).hide().fadeIn();}
function ucfirst(str,force)
{str=force?str.toLowerCase():str;return str.replace(/(\b)([a-zA-Z])/,function(firstLetter){return firstLetter.toUpperCase();});}
function ucwords(str)
{str=str.replace("_"," ");str=str.replace("_"," ");str=str.replace(/\b[a-z]/g,function(letter){return letter.toUpperCase();});return str;}
function unslug(word)
{str=word.replace(/\-/g,' ');return ucwords(str);}
function clean(str)
{str=String(str)
str=str.replace(/\s/g,"-");str=str.replace("&","");str=str.replace(".","");str=str.replace(".","");return str.replace("+","");}
var ListingPage={model:{vars:{max_price:0,min_price:0,current_page:0,loading:false,loading:false,auto_load:true},ajax_url:"",hash:window.location.hash.replace("#",""),fields:{},manual_slide:false,ranges:['interest_rate','tenure','amount'],},view:{vars:{p_wrapper:$("#product_wrapper"),},renderProducts:function(products)
{if(products!="")
this.vars.p_wrapper.html(products).hide().fadeIn('slow');else
{var height=$("#wrapper1").height();var no_product="<div class='no-products col-md-12' style='min-height:"+height+"px'><h3>Sorry !!! No products found.. </h3></div>";this.vars.p_wrapper.html(no_product).hide().fadeIn('slow');}},renderFilter:function(facet){ListingPage.model.manual_slide=true;ListingPage.view.resetCheckboxes();if(typeof facet.filters_all!="undefined")
{$.each(facet.filters_all,function(attrib,value){try
{if(typeof value=="object")
{if(typeof value.buckets!="undefined")
{if($.inArray(attrib,facet.filter_applied)==-1)
{ListingPage.view.updateFilterCheckbox(attrib.toLowerCase(),value.buckets);}
else
{ListingPage.view.defaultFilterUpdate();}}
else
{if(attrib=="saleprice_min"&&$.inArray(attrib,facet.filter_applied)==-1)
{$("#price-range").slider({values:[value.value,ListingPage.model.vars.max_price]});}
else if(attrib=="saleprice_max"&&$.inArray(attrib,facet.filter_applied)==-1)
{$("#price-range").slider({values:[ListingPage.model.vars.min_price,value.value]});}}}}
catch(exp)
{console.log(exp)
console.log("filterApplied")}});}
else
{try
{$.each(facet,function(attrib,value){if(typeof value=="object")
{if(typeof value.buckets!="undefined")
{ListingPage.view.updateFilterCheckbox(attrib.toLowerCase(),value.buckets);}
else
{if(attrib=="saleprice_min")
{$("#price-range").slider({values:[ListingPage.model.vars.min_price,ListingPage.model.vars.max_price]});}
else if(attrib=="saleprice_max")
{$("#price-range").slider({values:[ListingPage.model.vars.min_price,ListingPage.model.vars.max_price]});}}}});}
catch(exp)
{console.log(exp);console.log("Without Filter")}}
ListingPage.model.manual_slide=false;$(".nano").nanoScroller({alwaysVisible:true});$(".nano1").nanoScroller({alwaysVisible:true,paneClass:'scrollPane'});},renderAppliedFilter:function(){fields=ListingPage.model.fields;var fltr_label={};var fltr_text="";var price=[];var ranges=['interest_rate','tenure','amount'];var rtext=['Percent','Years','Rupees'];$.each(fields,function(label,value){switch(label)
{case"features":if(value.length>0)
{fltr_label[label]="<div class='single-fltr'><span class='fltr-label'>Features: </span>";fltr_label[label]+="<div value='"+value+"' class='single-prop' name='features'><span class='fltr-name'>"+unslug(value)+"</span><span class='fltr-remove'>X</span></div>";fltr_label[label]+="</div>";}
break;case"bank":if(value.length>0)
{fltr_label[label]="<div class='single-fltr'><span class='fltr-label'>Bank: </span>";fltr_label[label]+="<div value='"+value+"' class='single-prop' name='Bank'><span class='fltr-name'>"+unslug(value)+"</span><span class='fltr-remove'>X</span></div>";fltr_label[label]+="</div>";}
break;default:if(!$.inArray(label,ranges))
{values=value.split(",");fltr_label[label]="<div class='single-fltr'><span class='fltr-label'>"+ucwords(label)+": </span>";$.each(values,function(i,val){fltr_label[label]+="<div value='"+val+"' class='single-prop' name='"+label+"'><span class='fltr-name'>"+unslug(val)+"</span><span class='fltr-remove'>X</span></div>";});fltr_label[label]+="</div>";}
else{price[label]=value;}
break;}});$.each(ranges,function(i,v){if(price[v+'_min']&&price[v+'_max'])
{fltr_label[v]="<div class='single-fltr'><span class='fltr-label'>"+ucwords(v)+": </span><div name='"+v+"' value='"+price[v+'_min']+"-"+price[v+'_max']+"' class='single-prop'><span class='fltr-name'>"+price[v+'_min']+" - "+price[v+'_max']+" (In "+rtext[i]+")</span><span class='fltr-remove'>X</span></div></div>";}});$.each(fltr_label,function(i,txt){fltr_text+=txt;})
if(fltr_text.length>0)
{fltr_text+="<div class='clear-all btn btn-danger' id='clear-all'>Clear All </div>";$("#appliedFilter").addClass("applied");}
else
{$("#appliedFilter").removeClass("applied");}
$("#appliedFilter").html(fltr_text).hide().fadeIn('slow');},addProducts:function(products){var html=$.parseHTML(products);var img_el=$("#loading_img");m=ListingPage.model.vars;if(products.indexOf("product-item")>-1)
{$("#product_wrapper").append(products).hide().fadeIn();m.loading=false;$(window).scroll();if(ListingPage.model.vars.current_page>=4)
{m.auto_load=false;$("#load_more").show();}else{m.auto_load=true;$("#load_more").hide();}}
else
{$("#no_more_prod").remove();r_container.append(no_more_prod);$("#load_more").hide();m.auto_load=false;}
img_el.hide();},resetCheckboxes:function(){$("input[type='checkbox']").each(function(){$(this).prop("disabled",false);});},updateFilterCheckbox:function(attr,values)
{$(".checkbox."+attr+" input[type='checkbox']").prop("disabled",true);$(".checkbox."+attr).find("b.count").html("[0]");$.each(values,function(key,v){try
{element=$("#chk"+clean(v.key));element.prop("disabled",false);element.parent().find("b.count").html("["+v.doc_count+"]")
element.closest(".checkbox."+attr).detach().prependTo($("#"+attr+" .panel-body"));}
catch(e)
{console.log(attr)}});},defaultFilterUpdate:function(){fields=ListingPage.model.fields;$.each(fields,function(attrib,val){values=val.split(",")
$.each(values,function(k,value){$("."+attrib+" #chk"+clean(value)).prop("checked",true);});});},},controller:{init:function(){this.setMaxMinPrice();this.registerEvents();this.setupFilterURL();this.initializePreFilter();this.functions.addOverlay();if(Object.keys(ListingPage.model.fields).length>0)
this.getProducts();else
ListingPage.view.resetCheckboxes();},initializePreFilter:function(){var hash=ListingPage.model.hash;ctrl=this;self=ListingPage;if(hash.length>0)
{var fields=hash.split("&");$.each(fields,function(e,field){var f=field.split("=");self.model.fields[f[0]]=ucfirst(decodeURIComponent(f[1]));});}},filterChanged:function(){ListingPage.model.vars.current_page=0;fields=this.getFilterFields();this.updateURLHash(fields);this.getProducts();},updateURLHash:function(fields){hash="";$.each(fields,function(key,val){if(hash=="")
{hash=key+"="+val;}
else
{hash+="&"+key+"="+val;}});window.location.hash=hash;},getURLHash:function(){fields=ListingPage.model.fields;hash="";$.each(fields,function(key,val){if(hash=="")
{hash=key+"="+val;}
else
{hash+="&"+key+"="+val;}});return hash;},getFilterFields:function(){fields=ListingPage.model.fields;fields={};$(".__filter_src__").each(function(i,el){key=$(this).attr("field");val="";vars=ListingPage.model.vars;if($(this).is(":checkbox")&&$(this).is(":checked"))
{val=$(el).val();}
else if($(this).is(":text")&&$(this).val().length>0)
{val=$(el).val();}
else if($(this).is("[type='number']"))
{val=$(el).val();}
if(val!=="")
{if(typeof fields[key]=="undefined")
{fields[key]=val}
else
{fields[key]+=","+val;}}});var ranges=['interest_rate','tenure','amount'];$.each(ranges,function(i,range){if(fields[range+'_max']==eval('price_range_'+i+'_max')&&fields[range+'_min']==eval('price_range_'+i+'_min'))
{delete fields[range+'_max'];delete fields[range+'_min'];}});ListingPage.model.fields=fields;return fields;},getNextPage:function(){m.loading=true;ListingPage.model.vars.current_page++;$("#loading_img").show()
this.setupFilterURL()
this.getProducts(true,function(products){ListingPage.view.addProducts(products);m.loading=false;});},getProducts:function(send,callback){if(typeof callback=="undefined")callback="";if(typeof send=="undefined")
{send=false;this.functions.overlay.show()}
that=this;filter_url=that.generateAjaxURL();if(that.localCache.exist(filter_url))
{try
{data=that.localCache.get(filter_url);if(send)
{if($.isFunction(callback))callback(data.products);}
else
{that.functions.overlay.hide()
that.renderViews(data);}}
catch(err)
{return false;}
that.functions.overlay.hide()}
else
{$.get(filter_url,function(data){try
{data=$.parseJSON(data);if(send)
{if($.isFunction(callback))callback(data.products);}
else
{that.functions.overlay.hide();that.renderViews(data);that.localCache.set(filter_url,data);}}
catch(err)
{console.log(err);return false;}});}},renderViews:function(data,callback){ListingPage.view.renderProducts(data.products);ListingPage.view.renderAppliedFilter();ListingPage.view.renderFilter(data.facet);if($.isFunction(callback))callback();},generateAjaxURL:function(){self=ListingPage;var params="";$.each(self.model.fields,function(key,value){params+="&"+key+"="+encodeURIComponent(value);});params+="&ajax=true&filter=true";if(self.model.ajax_url.indexOf("?")>-1)
{return self.model.ajax_url+params;}
else
{params=params.replace("&","?");return self.model.ajax_url+params;}},setupFilterURL:function(){w=window.location
page=ListingPage.model.vars.current_page;l=w.origin+w.pathname+w.search;ListingPage.model.ajax_url=l;},updateSortOptions:function(){var hash=ListingPage.controller.getURLHash();$("#product-list-cat-menu ul li a").each(function(i,v){var href=$(this).attr('href').split("#")[0];$(this).attr('href',href+"#"+hash);});},localCache:{data:{},remove:function(url){delete this.data[url];},exist:function(url){return this.data.hasOwnProperty(url)&&this.data[url]!==null;},get:function(url){return this.data[url];},set:function(url,cachedData,callback){this.remove(url);this.data[url]=cachedData;if($.isFunction(callback))callback(cachedData);}},registerEvents:function(){m=ListingPage.model;var sliders=['interest_rate','tenure','amount'];$(document).on("change",".__filter_src__",function(){var id=$(this).attr('id');var changed=false;$.each(sliders,function(i,v){if((id=='maxPrice'+v&&$(this).val()<eval('price_range_'+i+'_max'))||(id=='minPrice'+v&&$(this).val()>eval('price_range_'+i+'_min'))||!$(this).is("[type='number']"))
{ListingPage.model.vars.current_page=0;ListingPage.controller.setupFilterURL();changed=true;}
else
{if(id.indexOf('maxPrice')>-1)
{$(this).val(eval('price_range_'+i+'_max'));}
else
{$(this).val(eval('price_range_'+i+'_min'));}}});if(changed)
{ListingPage.controller.filterChanged();}});$.each(sliders,function(i,v){if(i!=2)
steps=0.05
else
steps=1000
$("#price-range"+i).slider({range:true,min:eval('price_range_'+i+'_min'),max:eval('price_range_'+i+'_max'),animate:"slow",values:[eval('price_range_'+i+'_min'),eval('price_range_'+i+'_max')],step:steps,change:function(event,ui){var sMinPrice=ui.values[0];var sMaxPrice=ui.values[1];if(!ListingPage.model.manual_slide)
{$("#minPrice"+i).val(sMinPrice);$("#maxPrice"+i).val(sMaxPrice);$("#minPrice"+i).change();}},slide:function(event,ui){var sMinPrice=ui.values[0];var sMaxPrice=ui.values[1];$("#minPrice"+i).val(sMinPrice);$("#maxPrice"+i).val(sMaxPrice);},start:function(event,ui){ListingPage.model.manual_slide=false;}});});$(document).on("click",".single-prop",function(){hasPrice=false;key=$.inArray($(this).attr("name"),ListingPage.model.ranges)
if(key>-1)
{hasPrice=true;}
else
{fields=$(this).attr("value").split(",");$.each(fields,function(i,field){var id="#chk"+clean(field);$(id).prop("checked",false);});}
if($(this).attr("name")=="query")
{$("#search").val("");}
if(hasPrice)
{$("#minPrice"+key).val(eval('price_range_'+key+'_min'));$("#maxPrice"+key).val(eval('price_range_'+key+'_max'));ListingPage.model.manual_slide=true;$("#price-range"+key).slider({values:[eval('price_range_'+key+'_min'),eval('price_range_'+key+'_max')]});ListingPage.model.manual_slide=false;}
ListingPage.model.vars.current_page=0;ListingPage.controller.setupFilterURL();ListingPage.model.manual_slide=true;ListingPage.controller.filterChanged()
ListingPage.model.manual_slide=false;});$(document).on("click","#clear-all",function(){$(".__filter_src__").each(function(){key=$(this).attr("field");if($(this).is(":checkbox")&&$(this).is(":checked"))
{$(this).prop("checked",false);}
else if($(this).is(":text")&&$(this).val().length>0)
{$(this).val("");}
else if($(this).is("[type='number']"))
{if($(this).attr("id").indexOf('minPrice')>-1)
{split=$(this).attr("id").split('minPrice');if(typeof split[1]!="undefined")
{$(this).val(eval('price_range_'+split[1]+'_min'));}}
if($(this).attr("id").indexOf('maxPrice')>-1)
{split=$(this).attr("id").split('maxPrice');if(typeof split[1]!="undefined")
{$(this).val(eval('price_range_'+split[1]+'_max'));ListingPage.model.manual_slide=true;$("#price-range"+split[1]).slider({values:[eval('price_range_'+split[1]+'_min'),eval('price_range_'+split[1]+'_max')]});ListingPage.model.manual_slide=false;}}}});ListingPage.model.vars.current_page=0;ListingPage.controller.filterChanged()});},setMaxMinPrice:function()
{},functions:{"addOverlay":function(){var overlay='<div class="overlay" id="overlay" style="display:none"><div class="loader center"><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div></div></div>';$('body').append(overlay);},'overlay':{'show':function(){$('html, body').animate({scrollTop:$("body").offset().top},800);$("#overlay").fadeIn();},'hide':function(){$("#overlay").fadeOut()},},},},}
$(document).ready(function(){ListingPage.controller.init();});function filterHtml(section,arr)
{var tpl='<div class="checkbox '+section+'">';tpl+='<label class="fix-slide-checkbox">';tpl+='<input type="checkbox" value="{KEY}" id="chk{CLEAN_KEY}" class="__filter_src__" field="'+section+'">'
tpl+='<span class="value">{UCKEY}&nbsp;</span>'
tpl+='<span class="count">[{DOC_COUNT}]</span>'
tpl+='</label></div>';var html="";$.each(arr,function(i,ar){sec_html=tpl;sec_html=sec_html.replace("{KEY}",ar.key);sec_html=sec_html.replace("{CLEAN_KEY}",clean(ar.key));sec_html=sec_html.replace("{UCKEY}",ucfirst(ar.key));sec_html=sec_html.replace("{DOC_COUNT}",ar.doc_count);html+=sec_html;});$("#"+section+"-wrapper .nano-content").html(html).hide().fadeIn();}
function sortNMerge(arr1,arr2,brand_arr)
{var keys=[];var result=[];j=0;$.each(brand_arr,function(i,val){result[j]=val;keys[j++]=val.key;});$.each(arr1,function(i,val){if($.inArray(val.key,keys)==-1)
{result[j]=val;keys[j++]=val.key;}
else
{key=$.inArray(val.key,keys)
result[key].doc_count=val.doc_count;}});$.each(arr2,function(i,val){if($.inArray(val.key,keys)==-1)
{val.doc_count=0;result[j++]=val;}})
return result;}
function decode(s)
{s.replace("&amp;","&");return s;}