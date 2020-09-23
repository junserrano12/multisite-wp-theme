
var ua_promo_tracking = (function(JQ){

	var settings;
	
	JQ(document).ready(function(){
		init();
	});

	function init()
	{	
		settings = { };
		bindUIEvents();

	}

	function bindUIEvents() { 

		var _onclick = jQuery('.uaTracker').attr('data-tracker');
		var _onclick2 = jQuery('.uaTracker2').attr('data-tracker');
		var _bannerOnclick = jQuery('.uaPromoBannerSlide').attr('data-tracker');
		var _promoPageClickEvent = jQuery('.uaPromoPage').attr('data-tracker');
		if( _onclick != '' ){
			jQuery('.ua-tracker').attr('onclick',_onclick);
			jQuery('.ua-go-to-ibe-flexi').attr('onclick',_onclick);		
		}

		if( _onclick2 != '' ){
			jQuery('.ua-go-to-select-dates').attr('onclick',_onclick2);		
		}

		if( _bannerOnclick != '' ){
			jQuery('.ua-banner-slide-tracker').attr('onclick',_bannerOnclick);
		}	
		
		if(_promoPageClickEvent != ''){
			jQuery('.ua-go-to-showFlexible').attr('onclick',_promoPageClickEvent);
		}
	
	}

	return {

		'init' 						: init,
		'settings' 					: settings,
	 	'bindUIEvents' 				: bindUIEvents,
	};


})(jQuery);