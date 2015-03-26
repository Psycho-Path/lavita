$(window).on('load', function () {
      intervals1();
    });

function intervals1 () {

	setTimeout(function(){
		var h1 = $('.women-health-template .heart-1 .wrap'),
		shadow = $('.women-health-template .heart-1 .wrap .shadow');
		shadow.css('opacity','1')
		h1.addClass('active');
		setTimeout(function(){
			h1.removeClass('active');
			shadow.css('opacity','0');
			setTimeout(function(){
				setInterval(function(){
					shadow.css('opacity','1')
					h1.addClass('active');
					
					setTimeout(function(){
						h1.removeClass('active');
						shadow.css('opacity','0')
					},1500);
				},21000);
			},1500);
		},1500);
	},1000);

	setTimeout(function(){
		var h2 = $('.women-health-template .heart-2 .wrap'),
		shadow = $('.women-health-template .heart-2 .wrap .shadow');
		shadow.css('opacity','1')
		h2.addClass('active');
		setTimeout(function(){
			h2.removeClass('active');
			shadow.css('opacity','0');
			setTimeout(function(){
				setInterval(function(){
					shadow.css('opacity','1')
					h2.addClass('active');
					
					setTimeout(function(){
						h2.removeClass('active');
						shadow.css('opacity','0')
					},1500);
				},21000);
			},1500);
		},1500);
	},4000);

	setTimeout(function(){
		var h3 = $('.women-health-template .heart-3 .wrap'),
		shadow = $('.women-health-template .heart-3 .wrap .shadow');
		shadow.css('opacity','1')
		h3.addClass('active');
		setTimeout(function(){
			h3.removeClass('active');
			shadow.css('opacity','0');
			setTimeout(function(){
				setInterval(function(){
					shadow.css('opacity','1')
					h3.addClass('active');
					
					setTimeout(function(){
						h3.removeClass('active');
						shadow.css('opacity','0')
					},1500);
				},21000);
			},1500);
		},1500);
	},7000);

	setTimeout(function(){
		var h4 = $('.women-health-template .heart-4 .wrap'),
		shadow = $('.women-health-template .heart-4 .wrap .shadow');
		shadow.css('opacity','1')
		h4.addClass('active');
		setTimeout(function(){
			h4.removeClass('active');
			shadow.css('opacity','0');
			setTimeout(function(){
				setInterval(function(){
					shadow.css('opacity','1')
					h4.addClass('active');
					
					setTimeout(function(){
						h4.removeClass('active');
						shadow.css('opacity','0')
					},1500);
				},21000);
			},1500);
		},1500);
	},10000);

	setTimeout(function(){
		var h5 = $('.women-health-template .heart-5 .wrap'),
		shadow = $('.women-health-template .heart-5 .wrap .shadow');
		shadow.css('opacity','1')
		h5.addClass('active');
		setTimeout(function(){
			h5.removeClass('active');
			shadow.css('opacity','0');
			setTimeout(function(){
				setInterval(function(){
					shadow.css('opacity','1')
					h5.addClass('active');
					
					setTimeout(function(){
						h5.removeClass('active');
						shadow.css('opacity','0')
					},1500);
				},21000);
			},1500);
		},1500);
	},13000);

	setTimeout(function(){
		var h6 = $('.women-health-template .heart-6 .wrap'),
		shadow = $('.women-health-template .heart-6 .wrap .shadow');
		shadow.css('opacity','1')
		h6.addClass('active');
		setTimeout(function(){
			h6.removeClass('active');
			shadow.css('opacity','0');
			setTimeout(function(){
				setInterval(function(){
					shadow.css('opacity','1')
					h6.addClass('active');
					
					setTimeout(function(){
						h6.removeClass('active');
						shadow.css('opacity','0')
					},1500);
				},21000);
			},1500);
		},1500);
	},16000);

	setTimeout(function(){
		var h7 = $('.women-health-template .heart-7 .wrap'),
		shadow = $('.women-health-template .heart-7 .wrap .shadow');
		shadow.css('opacity','1')
		h7.addClass('active');
		setTimeout(function(){
			h7.removeClass('active');
			shadow.css('opacity','0');
			setTimeout(function(){
				setInterval(function(){
					shadow.css('opacity','1')
					h7.addClass('active');
					
					setTimeout(function(){
						h7.removeClass('active');
						shadow.css('opacity','0')
					},1500);
				},21000);
			},1500);
		},1500);
	},19000);


}