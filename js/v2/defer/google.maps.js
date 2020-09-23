function Initgooglemap( lat, lng, container, id ) {
    this.lat = lat;
    this.lng = lng;
    this.container = container;

    /*create google map object for static map*/
    this.loadGoogleMap = function() {
        var myLatlng = new google.maps.LatLng( this.lat, this.lng );
        var map_canvas = document.getElementById( this.container );
        var map_options = {
            center: myLatlng,
            zoom: 16,
            scrollwheel : false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }

        var map = new google.maps.Map( map_canvas, map_options )
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: ""
        });
    };

    /*initialize static map*/
    this.showGoogleMap = function() {
        google.maps.event.addDomListener( window, 'load', this.loadGoogleMap() );
    };

    /*create google map object for dynamic map*/
    this.loadDynamicGoogleMap = function( zoom ) {
        this.zoom = zoom;
        var myLatlng = new google.maps.LatLng( this.lat, this.lng );
        var map_canvas = document.getElementById(id);

        var map_options = {
            center: myLatlng,
            zoom: this.zoom | 16,
            scrollwheel : false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(map_canvas, map_options)
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: ""
        });
    };
}

function loadGoogleMap(){
    if( jQuery('.dwh-map-container').length ){

        var _gmap = {};
        _mapObj = jQuery('.dwh-map-container');

        _mapObj.each(function(){
            _this = jQuery(this);
            _gmap = new Initgooglemap( _this.data('lat'), _this.data('lng'), _this.attr('id') );
            _gmap.showGoogleMap();
        });

    }

    jQuery('[id^=map-canvas-]').each(function(){

        var id = jQuery(this).attr('id');

        _dmap = new Initgooglemap( jQuery(this).data('lat'), jQuery(this).data('lng'), "", id );
        _dmap.loadDynamicGoogleMap( jQuery(this).attr('data-zoom') );

    });

    /* if get_map shortcode */
    if( jQuery('#map-canvas').length ){

        _mapCanvas = jQuery('#map-canvas');

        var _dmap = new Initgooglemap( _mapCanvas.data('lat'), _mapCanvas.data('lng'), "" );
        _dmap.loadDynamicGoogleMap( _mapCanvas.attr('data-zoom') );

    }
}

jQuery(document).ready(function(){

    settings.window.on( 'load', function() {
        loadGoogleMap();
    });

});