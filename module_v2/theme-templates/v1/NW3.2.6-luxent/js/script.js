jQuery(document).ready(function(){
	_main = jQuery('#main');
	_mainContainer = jQuery('#main-container');
	_mainWidth = _main.width();
	_main.append('<a href="#main" class="open" id="button-slide"> - </a>');
	_buttonSlide = jQuery('#button-slide');
	
	jQuery('body').delegate('#button-slide', 'click', function(e){
		e.preventDefault();
		if(_buttonSlide.hasClass('open')){
			_buttonSlide.removeClass('open').html('+');
			_main.animate({'right':'-'+_mainWidth+'px'}, 500, function(e){
			});
		}else{
			_buttonSlide.addClass('open').html('-');
			_main.animate({'right':'5%'}, 500, function(e){
			});
		}
	});

});