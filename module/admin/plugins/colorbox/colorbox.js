
var UI_Colorbox = (function(JQ){

	var ui_settings;
	
	JQ(document).ready(function(){

		init();
	});

	function init()
	{
		ui_settings = {
						'el_colorbox' 			: JQ(".colorbox"),
						'el_colorbox_inline' 	: JQ(".colorbox-inline")
					  };


		bindUIEvents();

	}

	function bindUIEvents()
	{				
		/*colorbox*/
		ui_settings.el_colorbox.colorbox();
		ui_settings.el_colorbox_inline.colorbox({inline:true, fixed:true});	
	}

	return {

		'init' 						: init,
		'ui_settings' 				: ui_settings,
	 	'bindUIEvents' 				: bindUIEvents
	};

})(jQuery);






