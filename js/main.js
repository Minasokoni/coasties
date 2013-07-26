var win = $(window);

var grid = function(){
	var img = $('.grid').find('img');

	img.each(function(){
		var pl = $(this).parents('.grid').css('padding-left').replace('px',''),
		pt          = $(this).parents('.grid').css('padding-top').replace('px',''),
		overlay     = $(this).parents('.grid').find('.overlay'),
		width       = $(this).parents('.grid').width(),
		height      = $(this).parents('.grid').height();

		overlay.css({'width':width, 'height':height, 'margin-left':pl+'px', 'margin-top':pt+'px' });
	});
}

$(function(){

	// var container = document.querySelector('#container');
	// var pckry = new Packery( container, {
	//   // options
	//   itemSelector: '.grid',
	//   gutter: 10
	// });

	win.resize(function(){
		grid();
	});

});