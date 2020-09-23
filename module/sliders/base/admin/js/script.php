<script type="text/javascript">
	
	var slider_nonces             				= [];
	slider_nonces['slider_get_fields_config']	= { 'naction' : 'slider_get_fields_config' , 'nonce' : '<?php echo wp_create_nonce("slider_get_fields_config");?>' };
	
	
	jQuery(document).ready(function(){
	
		/* selectors */
		var _accordionWrapper = jQuery(document).find( '.form-header-slider' );
		
		/* initialize accordion */
		_sliderObj.init( _accordionWrapper );
		
		
			/* add image url to textarea */
			jQuery(document).on('click', '.button-add-uploaded-media-item', function(evt){
				evt.preventDefault();
				var _this = jQuery(this);
				
				_sliderObj.wpUploadMediaPopup( _this, 'imageurl' );
			});
			
			
			/* add image */
			jQuery(document).on('click', '.add-slider-item-image', function(evt){
				evt.preventDefault();
				var _this = jQuery(this);
				
				_sliderObj.wpUploadMediaPopup( _this, 'imageid' );
			});
			
			
			/* 
			* slider auto populate name to accordion header
			* @name slider-item-title  
			* keyup() event
			*/
			jQuery(document).on('keyup', '.control-wrapper input[name^="slider-item-title"]', function(){
			
				var _this = jQuery(this);
				var _val = jQuery.trim(_this.val());
				_val = _val || 'Slider Item';
				
				_this
					.parents('.slider-item-wrapper')
					.prev()
					.find('span.slider-item-title')
					.text( _val );
				
			});
			
			
			/* remove this slider row */
			jQuery(document).on('click', '.remove-slider-item', function(evt){
				evt.preventDefault();
				var _this = jQuery(this);
				
				_this.parents('.accordion-wrapper')
					.fadeOut('slow',
							 function(){ 
								
								/* remove this object */
								jQuery(this).remove();
								
								/* run refresh */
								_sliderObj.refreshAccordion(_accordionWrapper);
								
							 }
						);
			});
			
			
			/* 
			* slider item type trigger
			* @name slider-item-type  
			* change() event
			* switches: slider, map, iframe
			*/
			jQuery(document).on('change', '.with-radio input[type="radio"]', function(){
				
				var _this = jQuery(this);
				var _val = jQuery.trim(_this.val());
				var _fieldWrapper = _this.parents('.slider-item-wrapper').find('.slide-fields-wrapper');
				
				_this.attr('checked','checked');
				
				/* set value to hidden field from radio */
				_sliderObj.setHiddenValue( _this );
				
				
				if( _val == 'slider'){
					
					_fieldWrapper
						.filter(':eq(1), :eq(2)')
						.fadeOut(function(){
							_fieldWrapper.eq(0).fadeIn();
						});
				}
				
				else if( _val == 'map'){
					
					_fieldWrapper
						.filter(':eq(0), :eq(2)')
							.fadeOut(function(){
								_fieldWrapper.eq(1).fadeIn();
							});
				}
				
				else if(_val == 'iframe'){
					
					_fieldWrapper
						.filter(':eq(0), :eq(1)')
						.fadeOut(function(){
							_fieldWrapper.eq(2).fadeIn();
						});
				}

			});
			
			
			/* create new slider row */
			jQuery(document).on('click', '.create-new-slider-row', function(evt){
				
				evt.preventDefault();
				
				_thisButton = jQuery(this);
				var _wrapper = _accordionWrapper;
				var _ctr = _wrapper.find('.slider-group').length;
				
				/* add preloader */
				_sliderObj.enablePreloader( _thisButton, 1, '<div style="display:inline-block; margin-left:15px; margin-top: 6px">loading...</div>' );
				
				/* if option slider */
				if( _thisButton.attr('data-mode') == 'dwh_slider' ){
					_popupfields = $('.popup-edit').find('.options-popupmodal-fields');
					_wrapper = _popupfields.find( '.form-header-slider' );
				}
				
				
				/* get slider config */
				_sliderObj.getSliderFieldConfig( 'slider', '', slider_nonces.slider_get_fields_config.naction, slider_nonces.slider_get_fields_config.nonce, 
						
													function( response ){

														var _slidermarkup = '';
														_slidermarkup = Slider_Item.addItem( response.slider_items, '', _ctr );
														_wrapper.append( _slidermarkup );
														
														/* fire wp editor */
														/* _sliderObj.fireWpEditor( _ctr ); */
														
														/* fire datepicker */
														_sliderObj.fireDatePicker( _wrapper );
														
														/* fire accordion */
														_sliderObj.setupAccordionObject( _wrapper, 'last' );
														
														/* hide preloader */
														_sliderObj.enablePreloader( _thisButton );
														
													}
												);
												
			});
			

			/* 
			* Add widget-updated callback for widget slider
			*/
			jQuery(document).on('widget-updated', function(e, widget){
				
				/*
				* do your awesome stuff here
				* "widget" represents jQuery object of the affected widget's DOM element
				* re-initialize accordion object
				*/
				_sliderObj.init( widget.find( '.form-header-slider' ) );
				
			});

		
	});
	
/* End of Header Slider Script */
</script>