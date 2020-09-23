require(['cookie_obj','jquery_colorbox'], function(){
	
	if( !is_mobile ){
		
		/* cookie object initialization */
		var _splashCookie = new Mycookie('splash_home');
		var _cookieVal = _splashCookie.readCookie();
		var _splashContainer = jQuery('#splash-container');
		var _splashClose = jQuery('.close-splash');
		/*console.log(_splashContainer.hasClass('show-only-once'));*/
		
		if(_splashContainer.hasClass('show-only-once')){
			if(!_cookieVal){
				/* console.log(_cookieVal); */
				jQuery.colorbox({inline:true, width:"auto", href:"#splash-container"});
				_splashCookie.createCookie('splash_home', 0);
			}
		}
		
		else{
			if(_splashContainer.length){
				jQuery.colorbox({inline:true, width:"auto", href:"#splash-container"});
				_splashCookie.deleteCookie();
			}
		}

		/* close splash */
		_splashClose.click(function(e){
			e.preventDefault();
			_splashClose.colorbox.close();
		});
		
	}
	
});