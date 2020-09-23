require(['async!gmaps','google_map'], function(){
	
	/* if dwh_map shortcode */
	if( jQuery('.dwh-map-container').length ){
	
		var _gmap = {};
		_mapObj = jQuery('.dwh-map-container');
		
		_mapObj.each(function(){
			_gmap = new Initgooglemap( jQuery(this).attr('data-lat'), jQuery(this).attr('data-lng'), jQuery(this).attr('id') );
			_gmap.showGoogleMap();
		});
		
	}
	
	/* if get_map shortcode */
	if( jQuery('#map-canvas').length ){
		
		_mapCanvas = jQuery('#map-canvas');
		
		var _dmap = new Initgooglemap( _mapCanvas.attr('data-lat'), _mapCanvas.attr('data-lng'), "" );
		_dmap.loadDynamicGoogleMap( _mapCanvas.attr('data-zoom') );
	
	}
	
});