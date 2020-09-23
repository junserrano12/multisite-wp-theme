jQuery(document).ready(function(){
	var _isTracker = jQuery('#ua-istanaTracker').attr('data-value');
	if(_isTracker != ''){		
		jQuery('.istana-plugin-excerpt a').attr('onclick',_isTracker);
	}	
});