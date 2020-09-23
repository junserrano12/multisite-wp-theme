require(['jquery_flexslider','jquery_bgcenterimage'],function(){
	jQuery(function(){
			_sliderdefault = jQuery('.slider-default');

			_sliderdefault.first().addClass('loading');
			jQuery('.loading li:last-child img').load(function(){
				_sliderdefault.removeClass('loading');					
			});

			/* activate flexslider */
			jQuery('.slider-default').flexslider({ 
				animation: "fade", 
				prevText: "", 
				nextText: "", 
				animationLoop: "true", 
				animationSpeed: 600, 
				slideshowSpeed: 7000,
				start: function( slider ){
						afterSliderLoad( jQuery('.fullscreen-slider .slider-default') );
						jQuery(window).load(function (){
							var slide_count = slider.count - 1;
							jQuery(slider).find('img.lazy:eq(0)').each(function(){
								src = jQuery(this).attr('data-src');
								if (typeof src !== typeof undefined && src !== false) {
									jQuery(this).attr('src', src).removeAttr('data-src');
								} 
							});
						});
					},
				before: function( slider ){
						afterSliderLoad( jQuery('.fullscreen-slider .slider-default') );
						var slides  = slider.slides,
						index      	= slider.animatingTo,
						_slide     	= jQuery(slides[index]),
						_img       	= _slide.find('img[data-src]'),
						current    	= index,
						nxt_slide  	= current + 1,
						prev_slide 	= current - 1;

						_slide.parentsUntil('li').find('img.lazy:eq(' + current + '), img.lazy:eq(' + prev_slide + '), img.lazy:eq(' + nxt_slide + ')').each(function() {
							var src = jQuery(this).attr('data-src');
							jQuery(this).attr('src', src).removeAttr('data-src');
						});	
					},
			});

			/* activate flexslider*/
			/* jQuery('.slider-thumb').flexslider({}); */
		 	/* slider-thumb */
			jQuery('.slider-thumb').flexslider({	
				animation: "fade", 
				controlNav: false, 
				animationLoop: "true", 
				slideshow: false, 
				prevText: "", 
				nextText: "", 
				sync: ".carousel-thumb",
				start: function( slider){
						afterSliderLoad( jQuery('.fullscreen-slider .slider-thumb') );
					},
				before: function( slider ){
						afterSliderLoad( jQuery('.fullscreen-slider .slider-thumb') );
					}
			});
				
			/*carousel-thumb*/
			jQuery('.carousel-thumb').flexslider({
				animation: "slide", 
				controlNav: false, 
				/*directionNav: true,*/
				animationLoop: false, 
				slideshow: false, 
				itemWidth: returnThumbnailSize(), 
				itemMargin: 5,
				prevText: "", 
				nextText: "", 
				asNavFor: '.slider-thumb'
			});

			/* resize image to full bg */
			function afterSliderLoad( id ){
				id.find('.slides li img').centerImage();
			}

			
			/*
			* return thumbnail size
			* return 150 or 40
			* default is 150
			*/
			function returnThumbnailSize(){
				var _size = 150;
				var _thumbnailSmall = jQuery('input[name="slider-new-thumbnail-small"]');
				var _thumbnailMedium = jQuery('input[name="slider-new-thumbnail-medium"]');
				var _thumbnailLarge = jQuery('input[name="slider-new-thumbnail-large"]');
				
				if( _thumbnailSmall.length ){
					_size = 40;
				} 

				if( _thumbnailMedium.length ){
					_size = 150;
				}

				if( _thumbnailLarge.length ){
					_size = 200;
				}

				return _size;
			}
		
			
			/* if bullet slider */
			var _bullet = jQuery('input[name="slider-new-bullet"]');
			
			if( _bullet.length ){

			}
			else{
				
				jQuery('ol.flex-control-paging').hide();
			
			}
		});
});