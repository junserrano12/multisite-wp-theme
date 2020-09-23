jQuery(document).ready(function(){
	_main = jQuery('#main');
	
	jQuery('.bounce a').click( function( evt ){
		evt.preventDefault();
		_this = jQuery(this);
		
		jQuery('html, body').stop().animate({
			scrollTop: _main.offset().top
		}, 'slow' );
		
	});
	
});