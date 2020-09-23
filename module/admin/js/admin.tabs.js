var admin_settings_tabs,
    Admin_Tabs = (function( $ ){
	
	var tab_name = '';
	var settings_admin_tabs = '';

	
	$(document).ready(function(){
		init();
	});
		

	function init()
	{
		bindUIEvents();
	}

	function bindUIEvents()
	{
	}

	function newTab( tab_name , data )
	{
		
		if( tab_name )
		{
			
			/* Construct Tab Header */
			var el_tab = '<ul class="tab-menu '+ tab_name +'">';
			
				if( data ){
					
					el_tab += addHeaders( data.option_settings, 'tab_' );
					
				}

				el_tab += '</ul>';
				
				if( data ){
					
					el_tab += addContainer( data.option_settings, 'tab_' );
					
				}
				
			return el_tab;
			
		}	

		
	}

	function addHeaders( data, prefix )
	{
		if( data  )
		{	
		
			/* Construct Tab Header */
			var el_tab = '';
			var el_class = '';
			var ctr = 0;
			
			$.each( data , function( key , val ){
				
				el_class = ctr == 0 ? 'active' : '';
				el_tab += '<li>\
								<a class="'+ el_class +'" href="#'+ prefix + key +'">Edit '+ val['details']['title'] +'</a>\
							</li>';
				ctr++;
				
			});
			
			return el_tab;

		}

	}

	function addContainer( data, prefix )
	{
		if( data  )
		{	
			
			var el_container = '';
			var el_class = '';
			var ctr = 0;
			
			$.each( data , function( key , val ){
				
				/* prepare tab container */
				el_class = ctr == 0 ? ' show' : '';
				el_container += '<div id="'+ prefix + key +'" class="tab-container '+ el_class +'"></div>';
				
				ctr++;
			});

			return el_container;
		}						   

	}


	return {

			'init' 						: init,
			'settings_admin_tabs' 		: settings_admin_tabs,
			'bindUIEvents' 				: bindUIEvents,
			'newTab'					: newTab,
			'addHeaders'				: addHeaders,
			'addContainer'				: addContainer

			};

})( jQuery );