/**test1**/
$(function(){
	scale();

	vitaminActive();
	
});

$(window).on('resize', function () {
      scale();
    });



function scale () {
	var ww = $(window).width(),
		wh = $(window).height(),
		el = $('.content-wrap');

	if (ww >1200) {
			var scaleh= wh / 1200;
				h1= $(window).height();
				w1= $(".header").width();
			el.css({
				'-webkit-transform': 'scale(' + scaleh + ')',
				'-moz-transform': 'scale(' + scaleh + ')',
				'-o-transform': 'scale(' + scaleh + ')',
				'-ms-transform': 'scale(' + scaleh + ')',
				'transform': 'scale(' + scaleh + ')',
			}).css({
				marginLeft: - ((1600 *scaleh)/2),
				left : 50 +"%" 
				}).parent().css({height: h1});
			var wc = el.width();
			$('.warning').css({
				'width': wc,
				'top': '86.3333%',
				'-webkit-transform': 'scale(' + scaleh + ')',
				'-moz-transform': 'scale(' + scaleh + ')',
				'-o-transform': 'scale(' + scaleh + ')',
				'-ms-transform': 'scale(' + scaleh + ')',
				'transform': 'scale(' + scaleh + ')',
			}).css({
				marginLeft: - ((1600)/2),
				left : 50 +"%" 
				});
		 }
		 else {
			var scale = ww / 1760;
			el.css({
				'-webkit-transform': 'scale(' + scale + ')',
				'-moz-transform': 'scale(' + scale + ')',
				'-o-transform': 'scale(' + scale + ')',
				'-ms-transform': 'scale(' + scale + ')',
				'transform': 'scale(' + scale + ')'
			}).css({left: '4.5%', marginLeft:0}).parent().css({height: 1200*scale+'px'});
			$('.warning').css({
				'width':'90%',
				'top': '89.3333%',
				'-webkit-transform': 'scale(1)',
				'-moz-transform': 'scale(1)',
				'-o-transform': 'scale(1)',
				'-ms-transform': 'scale(1)',
				'transform': 'scale(1)',
			}).css({left:'auto',margin:'0 auto'});
			 }
}

function vitaminActive () {

	var show = $('.vitamin-template .show');
	show.click(function(){
		$('.vitamin-template .show.active').removeClass('active');
		$('.vitamin-template .hidden.active').removeClass('active');
		$(this).addClass('active');
		$(this).next().addClass('active');
	});
}