$(function(){
	$("#shownavi").bind("mousedown", function() {
		$("#navi").toggle();
	});
});

$(function(){
	$('.list-2 img').first().css('margin-left','0px');
	// $('.top-img span').first().css('margin-left','0px');
	// $('.top-img span').eq(2).css('margin','0px');
	// $('.top-img span').eq(3).css('margin-bottom','0px');
	$('.top-img span:even').css('margin-left','0px');
	$('.top-news ul li').last().css('border-bottom','none');
	$('footer').html('萧山网版权所有')
})