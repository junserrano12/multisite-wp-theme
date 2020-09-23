<script type="text/javascript">

jQuery(function(){
	
	/*
	* Re-format Date for flashdeal datepicker fields after migration
	* only run if flashdeal migrated metakey is yes
	* helpful during migration right after clicking migrate button
	*/
	if( jQuery('input[name="migrated"]').length ){
		
		_migrated = jQuery('input[name="migrated"]');
		var migrated = _migrated.val();
		
		if( migrated == 'yes' ){
			
			jQuery('input[class="date-picker"]').each(function(){
			
				_this = jQuery( this );
				_val = jQuery.trim( _this.val() );
				
				if( _val ){
					_this.val( jQuery.datepicker.formatDate( "dd-M-yy", new Date(_val) ) );
				}
			});
			
			/* make migrated value to no */
			_migrated.val('no');
		}
	
	}
	
	
	/* datepicker flashdeals */
	jQuery('.date-picker').datepicker({
			dateFormat: 'dd-M-yy'
	});
	
});

</script>