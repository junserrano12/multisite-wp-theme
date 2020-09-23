jQuery(document).ready(function(){
	

	_tabParent = jQuery('.tab-container-shortcode');
	_tabMenu = _tabParent.find('.tab-menu');
	_tabContainer = _tabParent.find('.tab-container');
	
	var _active = '';
	var _show = '';
	var _ctr = 0;
	
	_tabContainer.each(function(){
		
		_this = jQuery(this);
		_active = _ctr == 0 ? "active" : "";
		_show = _ctr == 0 ? "show" : "";
		
		_tabMenu.append('<li><a class="'+ _active +'" href="#tab-container-id-'+ _ctr +'">'+ _this.attr('data-title') +'</a></li>');
		_this.attr('id', 'tab-container-id-'+ _ctr ).addClass(_show);
		
		_ctr++;
	});

	
	/* Remove br tags */
	jQuery('.tabs > br, .tabs > p').remove();
	jQuery('.tab > br, .tab > p').remove();

	/* activate tab menu */
	jQuery(document).on('click', '.tab-menu a', function(e){
		e.preventDefault();
		
		_this = jQuery(this);
		_tabParent = _this.parent().parent()
		_wrapperContainer = _this.parents('.tab-menu').parent();
		
		/* remove class active to all tab li */
		_tabParent.find('li a').removeClass('active');
		
		/* add class active to current tab li */
		_this.addClass('active');
		
		/* remove class show to all tab containers */
		_wrapperContainer.find('.tab-container').removeClass('show');
		
		/* add class show to active tab container */
		_wrapperContainer.find( _this.attr('href') ).addClass('show');
		
	});

	
});