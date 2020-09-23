jQuery(function(){
	
	jQuery('.nivoSlider').nivoSlider({
			effect: 'boxRain',             
			slices: 15,
			boxCols: 8,
			boxRows: 8,
			animSpeed: 1500,
			pauseTime: 7000,
			startSlide: 0,
			directionNav: false,
			controlNav: false,
			controlNavThumbs: false,
			pauseOnHover: false,
			manualAdvance: false,
			prevText: '',
			nextText: '',
			randomStart: false
	});
		
});