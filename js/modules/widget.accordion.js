jQuery(document).ready(function(){

	jQuery('.accordion-content').hide();
	
	_accordionWrapper = jQuery('.list-accordion');
	_accordionWrapper.find('.accordion-caption a').removeClass('active');
	
	jQuery.each( _accordionWrapper, function(){
		
		var _this = jQuery(this);
		
		if( _this.hasClass('showfirst') ){
			
			_this.find('.accordion-caption:first').find('a').addClass('active');
			_this.find('.accordion-content:first').show();
		}
	});
	
	jQuery(document).on('click', '.accordion-caption a', function(evt){
		evt.preventDefault();
		
		_this = jQuery(this);
		_container = _this.parents('.accordion-item').find('.accordion-content');
		
		_this.toggleClass('active');
		_container.slideToggle('fast');
	
	});

	/* Open first accordion */
	jQuery('.list-accordion').find('.accordion-caption:first').find('a').addClass('active');
	jQuery('.list-accordion').find('.accordion-content:first').show();

	
	/* Remove br tags */
	jQuery('.list-accordion > br, .list-accordion > p').remove();
	

});