/*create google map object*/
function Initgooglemap(lat,lng,container){
	this.lat = lat;
	this.lng = lng;
	this.container = container;
	
	/*create google map object for static map*/
	this.loadGoogleMap = function(){
		var myLatlng = new google.maps.LatLng(this.lat,this.lng);
		var map_canvas = document.getElementById(this.container);
		var map_options = {
			center: myLatlng,
			zoom: 16,
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
	
	/*initialize static map*/
	this.showGoogleMap = function(){
		google.maps.event.addDomListener(window, 'load', this.loadGoogleMap());
	};
	
	/*create google map object for dynamic map*/
	this.loadDynamicGoogleMap = function(zoom){
		this.zoom = zoom;
		var myLatlng = new google.maps.LatLng(this.lat,this.lng);
		var map_canvas = document.getElementById("map-canvas");
		
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
	
	/*debug static map*/
	this.consoleGoogleMap = function(){
		console.log('Diplaying map properties below : \nLat: '+ this.lat +'\nLong : '+ this.lng +'\nContainer : '+ this.container);
	};
	
}
