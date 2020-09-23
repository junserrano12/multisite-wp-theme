<script type="text/javascript">
	jQuery(function(){
		
		/*
		* Re-format Date for promo group datepicker fields after migration
		* only run if promo group is migrated
		* helpful during migration right after clicking migrate button
		*/
		if( jQuery('.form-promo-group input[name="migrated"]').length ){
		
			jQuery('.promo-group').find('input[class="datepicker"]').each(function(){
			
				_this = jQuery( this );
				_val = jQuery.trim( _this.val() );
				
				if( _val ){
					_this.val( jQuery.datepicker.formatDate( "dd-M-yy", new Date(_val) ) );
				}
				
			});
		}
		
		
		/* datepicker promocentric*/
		jQuery('.form-promo-group').on('focusin', 'input[class="datepicker"]', function(){
			var _this = jQuery(this);
		   
			_this.datepicker({
				dateFormat: 'dd-M-yy'
			});
		});
		
		/* create new promo group */
		jQuery('.create-new-promo-group').click(function(evt){
			evt.preventDefault();
			var _this = jQuery(this);
			var _ctr = jQuery('.promo-group').length;
			
			_this.before(_returnPromoGroup(_ctr));
			jQuery('#promo-group-'+_ctr).fadeIn('slow');
		});
		
		/* remove this group */
		jQuery('.form-promo-group').on('click','.remove-this-group',function(evt){
			evt.preventDefault();
			var _this = jQuery(this);
			_this.parent()
				.fadeOut('slow',
						 function(){ 
							 jQuery(this).remove();
						 }
					);
		});
		
		/* add image */
		jQuery('.form-promo-group').on('click', '.add-promo-image', function(evt){
			evt.preventDefault();
			var _this = jQuery(this);
			
			_wpUploadMediaPopup(_this);
		});
		
		
		function _returnPromoGroup(_ctr){
			var _str = '';
			
			_str += '<div id="promo-group-'+ _ctr +'" class="promo-group" style="display:block">';
			_str += '	<a class="remove-this-group" href="#">Remove</a>';
			_str += '	<div class="control-wrapper">';
			_str += '		<label for="promo-image-'+ _ctr +'"> Promo Image ID:</label>';
			_str += '		<input type="text" id="promo-image-'+ _ctr +'" name="promo-image[]" value="" />';
			_str += '		<div class="promo-image-holder">';
			_str += '		</div>';
			_str += '		<a class="add-promo-image button-primary" href="#">Add Image</a>';
			_str += '		<p class="description">Upload or insert promo image from media library.</p>';
			_str += '	</div>';
			_str += '	<div class="control-wrapper">';
			_str += '		<label for="promo-name-'+ _ctr +'"> Promo Name:</label> ';
			_str += '			<input type="text" id="promo-name-'+ _ctr +'" name="promo-name[]" value="" />';
			_str += '			<p class="description">What is your promo name?</p>';
			_str += '	</div>';
			_str += '	<div class="control-wrapper">';
			_str += '		<label for="promo-label-'+ _ctr +'"> Promo Offer Label:</label> ';
			_str += '			<input type="text" id="promo-label-'+ _ctr +'" name="promo-label[]" value="<span>Limited Time Offer</span>" />';
			_str += '			<p class="description">Display Promo Offer Label</p>';
			_str += '	</div>';
			_str += '	<div class="control-wrapper">';
			_str += '		<label for="promo-desc-'+ _ctr +'"> Promo Description:</label>';
			_str += '		<textarea row="4" col="4" id="promo-desc-'+ _ctr +'" name="promo-desc[]"></textarea>';
			_str += '		<p class="description">What is your promo description?</p>';
			_str += '	</div>';
			_str += '	<div class="control-wrapper">';
			_str += '		<label for="promo-rate-plan-id-'+ _ctr +'"> Rate Plan ID:</label>'; 
			_str += '		<input type="text" id="promo-rate-plan-id-'+ _ctr +'" name="promo-rate-plan-id[]" value="" />';
			_str += '		<p class="description">Input Promo Id</p>';
			_str += '	</div>';
			_str += '	<div class="control-wrapper">';
			_str += '		<label for="promo-stay-start-'+ _ctr +'">Stay Period Start Date:</label>';
			_str += '		<input type="text" id="promo-stay-start-'+ _ctr +'" name="promo-stay-start[]" class="datepicker" value="" />';
			_str += '		<p class="description">Stay Period Start Date (dd-M-YYYY)</p>';
			_str += '	</div>';
			_str += '	<div class="control-wrapper">';
			_str += '		<label for="promo-stay-end-'+ _ctr +'"> Stay Period End Date: </label>';
			_str += '		<input type="text" id="promo-stay-end-'+ _ctr +'" name="promo-stay-end[]" class="datepicker" value="" />';
			_str += '		<p class="description">Stay Period End Date (dd-M-YYYY)</p>';
			_str += '	</div>';
			_str += '	<div class="control-wrapper">';
			_str += '		<label for="promo-period-end-'+ _ctr +'"> Promo End Date: </label>';
			_str += '		<input type="text" id="promo-period-end-'+ _ctr +'" name="promo-period-end[]" class="datepicker" value="" />';
			_str += '		<p class="description">Promo End Date (dd-M-YYYY)</p>';
			_str += '	</div>';
			_str += '</div>';
			
			return _str;
		}
		
		
		
		function _returnImageMarkup(imgurl){
		
			imgurl = imgurl || '<?php echo get_template_directory_uri() ?>/images/default-noimage-150x150.jpg';
			
			return '<img src="'+ imgurl +'" alt="" width="100px" height="100px" />';
		}
		
		
		
		/*
		* function that handles wp media library popup
		*/
		function _wpUploadMediaPopup(_this){
			var _custom_uploader;
	 
			//If the uploader object has already been created, reopen the dialog
			if (_custom_uploader) {
				_custom_uploader.open();
				return;
			}
	 
			//Extend the wp.media object
			_custom_uploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				button: {
					text: 'Choose Image'
				},
				multiple: false
			});
	 
			//When a file is selected, grab the URL and set it as the text field's value
			_custom_uploader.on('select', function() {
				attachment = _custom_uploader.state().get('selection').first().toJSON();
				
				var _currentImgId = _this.prev().prev().val();
				var imgIds = '';
				
				if(_currentImgId){
					imgIds = _currentImgId +','+ attachment.id; 
				}
				else{
					imgIds = attachment.id;
				}

				_this
					.prev()
					.append(_returnImageMarkup(attachment.url))
					.prev()
					.val(imgIds);
					
			});
	 
			//Open the uploader dialog
			_custom_uploader.open();
		}
		
	});
</script>