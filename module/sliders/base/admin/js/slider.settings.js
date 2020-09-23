/* slider object */
var _sliderObj = {
	
	/*
	* set value to hidden field
	* @param _this: is the radio object
	*/
	setHiddenValue: function( _this ){

						var _val = _this.val();
						_this.parents('.control-wrapper').parent().find('input[type="hidden"]').val(_val);
						
	},
	
	/*
	* refresh accordion object
	* @param _accordionWrapper: should be jQuery selector object
	*/
	refreshAccordion: function( _accordionWrapper ){
		
						_accordionWrapper
							.find('.radio-wrapper')
							.each( function(index){

								var _this = jQuery(this);
								_this.find('input[type="radio"]').attr('name', 'item-radio-'+ index);
							
							});
	},
	
	/*
	* setup accordion object
	* @param _accordionWrapper: should be jQuery selector object
	*/
	setupAccordionObject: function ( _accordionWrapper, _mode ){
		
							var _mode = _mode || 'default';
							
							if( _mode == 'default' ){
								
								/* remove span icon */
								_accordionWrapper.find('span.ui-icon').remove();
								
								/* setup accordion */
								_accordionWrapper
									.find('.accordion-wrapper')
									.removeClass("ui-accordion").addClass("ui-accordion")
									.find("h4")
									.removeClass("ui-accordion-header ui-state-default").addClass("ui-accordion-header ui-state-default")
									.prepend('<span class="ui-icon ui-icon-plus"></span>')
									.next()
									.removeClass("ui-accordion-content").addClass("ui-accordion-content")
									.hide();
							}
							
							else if( _mode == 'last' ){
								
								/* setup accordion */
								_accordionWrapper
									.find('.accordion-wrapper')
									.eq(-1)
									.removeClass("ui-accordion").addClass("ui-accordion")
									.find("h4")
									.removeClass("ui-accordion-header ui-state-default").addClass("ui-accordion-header ui-state-default")
									.prepend('<span class="ui-icon ui-icon-plus"></span>')
									.next()
									.removeClass("ui-accordion-content").addClass("ui-accordion-content")
									.hide();
							}

	},
	
	/*
	* fire accordion object
	* one time fire only
	*/
	fireAccordionObject: function( _accordionWrapper ){

							/* fire accordion */
							_accordionWrapper.on('click','h4.accordion-head',function(evt){
								evt.preventDefault();
								var _this = jQuery(this);
								
								_this
									.toggleClass("ui-accordion-header-active ui-state-active ui-state-default")
									.find("> .ui-icon")
									.toggleClass("ui-icon-plus ui-icon-minus")
									.end()
									.next()
									.toggleClass("ui-accordion-content-active")
									.slideToggle(500);
									
								return false;
							});

	},
	
	/*
	* handles wp media library popup
	* @param _this: objects
	*/
	wpUploadMediaPopup: function( _this, _mode ){
	
							var _custom_uploader;
					 
							/* If the uploader object has already been created, reopen the dialog */
							if (_custom_uploader) {
								_custom_uploader.open();
								return;
							}
					 
							/* Extend the wp.media object */
							_custom_uploader = wp.media.frames.file_frame = wp.media({
								title: 'Choose Image',
								button: {
									text: 'Choose Image'
								},
								multiple: false
							});
					 
							/* When a file is selected, grab the ID and set it as the text field's value */
							_custom_uploader.on('select', function() {
								attachment = _custom_uploader.state().get('selection').first().toJSON();
								
								/* imageid */
								if( _mode == 'imageid' ){
									
									_this
									.prev()
									.find('img')
									.attr('src', attachment.url)
									.parent()
									.prev()
									.find('input')
									.val(attachment.id);
								
								}
								
								/* imageurl */
								else if( _mode == 'imageurl' ){
								
									_textarea = _this.next();
									var textareacontent = _textarea.val();
									var caretpos = _textarea.prop('selectionStart');
									
									_textarea.val( textareacontent.substr(0, caretpos) + attachment.url + textareacontent.substr(caretpos));
									
								}
									
							});
					 
							/* Open the uploader dialog */
							_custom_uploader.open();
	},
	
	/*
	* handles wp editor tinyMCE
	* @param ctr: counter
	*/
	fireWpEditor: function( ctr ){
					
					tinyMCE.init({
						selector: 'textarea#image_desc_editor_'+ ctr
					});

	},
	
	/*
	* handles datepicker
	* @param _accordionWrapper: should be jQuery selector object
	*/
	fireDatePicker: function( _accordionWrapper ){
		
						/* datepicker */
						_accordionWrapper.find('.datepicker').datepicker({
								dateFormat: 'dd-M-yy',
								changeMonth: true,
								changeYear: true,
								minDate: -366,
								onSelect: function(date){
											_this = $(this);
											var currentDate = $.datepicker.formatDate( "dd-M-yy", new Date() );
											var selectedDate = _this.val();
											_parent = _this.parents('.accordion-wrapper');
											
											if(  new Date(selectedDate).getTime() < new Date(currentDate).getTime() ){
												_parent.removeClass('item-expired').addClass('item-expired');
											}
											else{
												_parent.removeClass('item-expired');
											}
										}
						});
	},
	
	/*
	* return slider config
	*/
	getSliderFieldConfig: function( mode, slider_data, naction, nonce_sec, callback ){
											
						jQuery.ajax({

							 type : "post",
							 dataType : "json",
							 url : admin_ajax_url,
							 data : { 
										action       : naction, 
										nonce_sec    : nonce_sec,
										mode 		 : mode,
										slider_data  : slider_data
									},
							 success: callback 

						});

	},
	
	/* 
	* slider prealoader
	*/
	enablePreloader: function( thisButton, mode, message ){
		
						mode = mode || '';
						message = message || '';
						
						/* show preloader */
						if( mode ){
							thisButton.hide().after( message );
						}
						/* hide preloader */
						else{
							thisButton.fadeIn().next().remove();
						}
		
	},
	
	/*
	* init this
	* @param _accordionWrapper: accepts mark-up object
	*/
	init: function( _accordionWrapper  ){
			
			/* initialize accordion */
			this.setupAccordionObject( _accordionWrapper, '' );
			this.fireAccordionObject( _accordionWrapper );
			
			/* fire sortable */
			_accordionWrapper
				.sortable({
						axis: "y",
						handle: "h4",
						placeholder: "ui-state-highlight",
						stop: function( event, ui ) {
						  /* IE doesn't register the blur when sorting
						  so trigger focusout handlers to remove .ui-state-focus */
						  ui.item.children( "h4" ).triggerHandler( "focusout" );

						}
					});
			
			
			/* check data type for slider */
			var _dataType = jQuery('input[name="slider-data-type"]');
			
			if( _dataType.val() == 'option' ){
				
				_dataType.parents('.widget-inside')
					.css({
							'width':'200%',
							'position':'relative',
							'z-index':'9999'
						});
						
						
				/* hide slider-mode type when on widget */
				jQuery('select[name^="slider-mode"]').parent().hide();
				
			}
			
			
			/* fire datepicker */
			this.fireDatePicker( _accordionWrapper );

	}
	
};