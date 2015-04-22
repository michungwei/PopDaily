$(document).ready(function(){
	$(".accordion .tableheader:first").addClass("active");
	$(".accordion .tableheader").toggle(function(){
		$(this).next().slideUp("fast");
	},function(){
		$(this).next().slideDown("fast");
		$(this).siblings("tableheader").removeClass("active");
	});
	
	$(".btn-slide").click(function(){
		$("#panel").slideToggle("slow");
		$(this).toggleClass("active"); 
		return false; 
	});	
});