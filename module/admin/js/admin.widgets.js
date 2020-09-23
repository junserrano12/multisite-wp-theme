var admin_settings_widget,
    Admin_Widgets = (function( jQ ){

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


	function getDefaultSettings( widget_name , callback )
	{	
		if( widget_name )
		{
			jQ.ajax({

				 type : "post",
				 dataType : "json",
				 url : admin_ajax_url,
				 data : { 
							action       : nonces.widget_default_field_settings.naction, 
							nonce_sec    : nonces.widget_default_field_settings.nonce,
							widget_name  : widget_name
						},
				 success: callback 
				 
			});
		}
		
	}

	return {

			'init' 						: init,
			'admin_settings_widget' 	: admin_settings_widget,
		 	'bindUIEvents' 				: bindUIEvents,
		 	'getDefaultSettings'		: getDefaultSettings
		   };

})( jQuery );