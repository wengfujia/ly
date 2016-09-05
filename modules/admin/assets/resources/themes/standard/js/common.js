var ray = $(window);
//左边栏自动fixed
ray.scroll(function(){
	var scrollHeight = ray.scrollTop() + $('#header').outerHeight();
	var screenHeight  = ray.height();
	var sideHeight = $('#navSide').height();
	if(sideHeight > screenHeight){
		if(scrollHeight + screenHeight > sideHeight){
			$('#navSide').css({
				'position':'fixed',
				'top': -(sideHeight - screenHeight),
				'left':0
			});
		}else{
			$('#navSide').css({
				'position':'static'
			});
		}	
	}else{
		if(ray.scrollTop() > $('#header').outerHeight()){
			$('#navSide').css({
				'position':'fixed',
				'top':0,
				'left':0
			});
		}else{
			$('#navSide').css({
				'position':'static'
			});
		}
	}
});
	

window.onload = function(){
	ray.trigger('scroll');
//	navInside();
};

ray.resize(function() {
	ray.trigger('scroll');
});
