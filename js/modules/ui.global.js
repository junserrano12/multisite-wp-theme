
var UI_Global = (function( JQ ){

	var ui_settings;
	
	JQ(document).ready(function(){
		
		init();
		
	});

	function init()
	{

		ui_settings = {

						'site_responsive_menu'				:  JQ("#rmenu"),
						'site_menu_ul'						:  JQ("#main-menu > ul"),
						'site_menu_submenu'					:  JQ(".sub-menu"),
						'site_menu_item_children'			:  JQ(".menu-item-has-children"),
						'site_body'							:  JQ('body'),
						'site_el_back_top_top_link'			:  '<a href="#" id="toTop" style="display:none;"></a>',
 						'site_back_top_top_link'			:  JQ('#toTop'),
 						'site_window'						:  JQ(window)

					   };

		bindUIEvents();

	}

	function bindUIEvents()
	{	
		/*Back to top append link */	
		ui_settings.site_body.append(ui_settings.site_el_back_top_top_link);

		/* Toggle go to top link on window scroll */	
		ui_settings.site_window.scroll(function() {

			if (JQ(this).scrollTop() > 250) {
				JQ('#toTop').fadeIn(300);
			} else {
				JQ('#toTop').fadeOut(300);
			}	
		});
		
		/* click toTop */
		JQ('#toTop').click(function(e){
			e.preventDefault();
			
			scrollposition = 0;
			scrollposition = scrollposition;
			JQ('html,body').animate({scrollTop: scrollposition}, 'slow');
			
		});
		

		/*responsive menu*/
		ui_settings.site_responsive_menu.click(function(e){
			ui_settings.site_menu_ul.toggleClass('visible-layer');
			e.preventDefault();
		});
		
		
		/* Quick Fix for images title and alt */
		JQ('body').find('img').each( function(){
			_this = JQ( this );
			var _alt = _this.attr('alt');
			var _title = _this.attr('title');
			
			if( !_alt ){
				_this.attr( 'alt', site_info.hotel_name +' in '+ site_info.hotel_location );
			}
			
			if( !_title ){
				_this.attr( 'title', site_info.hotel_name +' in '+ site_info.hotel_location );
			}
			
		});
		
		/*dropdownmenu*/
		ui_settings.site_menu_submenu.hide();
		ui_settings.site_menu_item_children.hover(function(e){
				jQuery(this).children('.sub-menu').show();
			}, 
			function(){
				ui_settings.site_menu_submenu.hide();
			}); 


	}

	return {

		'init' 						: init,
		'ui_settings' 				: ui_settings,
	 	'bindUIEvents' 				: bindUIEvents
	};


})( jQuery );
