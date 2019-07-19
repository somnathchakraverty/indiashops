
$(document).ready(function(){
	var x=document.documentElement.clientHeight;
	var y=$(".header").outerHeight();
	$("#parallax_wrapper").css("height",x-y+"px");
	$("#parallax_wrapper").css("left",50+"%");
	$(".scene_1").plaxify({"xRange":0,"yRange":0,"invert":true}),
	$(".scene_2").plaxify({"xRange":70,"yRange":30,"invert":false}),
	$(".scene_3").plaxify({"xRange":30,"yRange":10,"invert":true}),
	$.plax.enable();
});
