<?php
	extract( $data );
	
	$cta_set = $cta_settings['cta_set'];
	$cta_type = strtoupper( $cta_settings['cta_type'] );
	$cta_promo_code = $cta_settings['cta_promo_code'];
	
	if( isset( $cta_settings_fields[ $cta_type ][ $cta_set ][ 'settings' ][ 'cta_promo_code' ] ) ){
		if( $cta_promo_code ){
?>
			<div class="control-wrapper cta-calendar-container">
				<span class="calendar-label">Promo Code:</span>
				<div class="calendar-input">
					<input gtbfieldid="6" class="text_reserve" id="promo_code" name="promo_code" value="" type="text" autocomplete="off" >
				</div>
			</div>
<?php
		}
	}
?>