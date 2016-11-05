$(function(){

	// plugin pinto
	$(".plugin").pinto({
		itemWidth:415,
	    gapX:5,
	    gapY:30,
	});
	// end plugin pinto

	var hooks = $('.hooks');
	var hookWidth = hooks.outerWidth();
	var winWidth = $(window).outerWidth();
	if( winWidth > 767){
		$('.change').css({'left': '120px'});
		$('.hide-menu').click(function(){
			hooks.toggleClass('hides');
			if( hooks.hasClass('hides')){
				$('.hides').css({'left': -hookWidth});
				$('.change').css({'left':'0'});
			}else{
				hooks.css({'left': 0});
				var rowWidth = $('.change').outerWidth();
				$('.change').css({'left': '120px'});
			}
		});
	}
	else{
		hooks.css({'left': -304});
		hooks.addClass('hides');
		$('.change').css({'left': '0px'});
		$('.hide-menu').click(function(){
			hooks.toggleClass('hides');
			if( hooks.hasClass('hides')){
				$('.hides').css({'left': -hookWidth});
			}else{
				hooks.css({'left': 0});
			}
		});
	}

	$('.load-more').delegate('.load-btn', 'click', function(){
		$('.data').children().clone().appendTo('.plugin');
		$(".plugin").pinto({
			itemWidth:415,
		    gapX:5,
		    gapY:30,
		});
	});
});

$(window).resize(function(){
	$(function(){
		var hooks = $('.hooks');
		var winWidth = $(window).width();
		var hooksWidth = hooks.outerWidth();
		if( winWidth >767 ){
			$('.hides').css({'left': 0});
			$('.change').css({'left': '120px'});
			$('.hide-menu').click(function(){
				if( hooks.hasClass('hides')){
					$('.hides').css({'left': -304});
					$('.change').css({'left':'0'});
				}else{
					hooks.css({'left': 0});
					$('.change').css({'left': '120px'});
				}
			});
		}else{
			$('.hides').css({'left': -304});
			hooks.addClass('hides');
			$('.change').css({'left': '0px'});
		}
	});
});
