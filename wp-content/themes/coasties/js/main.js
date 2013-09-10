
////////////////////////////////////////////////////////////////////////// Slider

var slider = slider || ( function ( container, nav) {

	var $this = this;
	
	this.container = container;
	this.nav = nav;


	this.img = this.container.find('img');
	this.ww = window.outerWidth - 15;
	this.numofimg = this.img.length;

	this.current = 0;

	container.find('li').width(this.ww);

	slider.prototype.transition = function( coords, size ){
		this.container.stop(true, true).animate({'margin-left': coords || -(this.current * this.ww) });
	};

	slider.prototype.setCurrent = function( direction ){
		var position = this.current;

		position += ( ~~( direction === 'next') || -1);
		this.current = (position < 0) ? this.numofimg - 1 : position % this.numofimg;

		container.find('li').removeClass('active');
		container.find('li').eq(this.current).addClass('active');

		return position;
	};

	slider.prototype.resize = function(){
		var size = window.outerWidth - 15;
		return size;
	};

	$(window).resize(function(){
		container.css({'margin-left': -($this.current * $this.resize())});
		container.find('li').width($this.resize());
	});


});


////////////////////////////////////////////////////////////////////////// JQuery init

$(function(){

	slider = new slider($('body.home #slider > ul'), $('a.nav'));

	slider.nav.on('click', function(){
		slider.setCurrent($(this).data('direction'));
		slider.transition();
		return false;
	});


/**
 * pdp slider
 */
	$('#product-img-slider').flexslider({
		animation: "slide",
		controlNav: "thumbnails"
	});

/**
 * Go to checkout button 
 */

$('.checkout-button').on('click', function(){
	$('form.shipping_calculator').submit();
});

/**
 * Listing filter
 */

$('nav#subnav li a').on('click', function(){
	var cat = $(this).attr('href');
	$('nav#subnav li a').removeClass('active');
	$(this).addClass('active');
	if(cat != '#all'){
		$('.cat:visible').slideUp(function(){
			$(cat).slideDown();
		});
	}else{
		$('.cat').slideDown();
	}
	return false;
});


	$('#guide-btn, #guide a.close').on('click', function(){
		$('#guide').slideToggle(300);
		return false;
	});

	$('#guide section div:first').show();

	$('#guide nav a').on('click', function(){
		var tab = $(this).attr('href');
		$('#guide section div:visible').fadeOut(function(){
			$(tab).fadeIn();
		});
		$('#guide nav a').removeClass('active');
		$(this).addClass('active');
		return false;
	});


});


