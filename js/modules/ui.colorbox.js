var UI_Colorbox = (function(JQ){

	var ui_settings;
	
	JQ(document).ready(function(){
		require(['jquery_colorbox'],function(){
			init();
		});
		
		
	});

	function init()
	{

		ui_settings = {
						'el_colorbox' 				: JQ(".colorbox"),
						'el_colorbox_inline' 		: JQ(".colorbox-inline"),
						'el_colorbox_inline_img' 	: JQ(".colorbox-inline-img")
					  };


		bindUIEvents();

	}

	function bindUIEvents()
	{			
			_varhasimageonly = false;
					
			ui_settings.el_colorbox_inline.each(function(){
				_boxid = JQ(this).attr('href');

				if(JQ(_boxid).children().size() < 2 && JQ(_boxid).has('img')){
					_varhasimageonly = true;	
				} else {
					_varhasimageonly = false;
				}

				if(!_varhasimageonly && _boxid !== '#bpgmodal'){
					if(!JQ(_boxid).hasClass('content')){
						JQ(_boxid).addClass('content').css({'max-width':'800px', 'width':'auto'});
						JQ(_boxid).find('img').wrap('<div class="image-container"></div>');
					} else {
						JQ(_boxid).find('img').wrap('<div class="image-container"></div>');
					}
				} else {
					JQ(_boxid).find('img').css({'width':'100%'});
				}
			});

			/*colorbox*/
			ui_settings.el_colorbox.colorbox({ maxWidth:'80%'});	
			ui_settings.el_colorbox_inline.colorbox({ inline:true, maxWidth:'80%' });
			ui_settings.el_colorbox_inline_img.colorbox({inline:true});
		
	}

	return {
		'init' 						: init,
		'ui_settings' 				: ui_settings,
	 	'bindUIEvents' 				: bindUIEvents
	};


})(jQuery);






