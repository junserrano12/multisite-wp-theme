<?php

	/* get slider fields config  */

	global $DWH_Slider;

	check_ajax_referer( 'slider_get_fields_config', 'nonce_sec' );
	
		$slideritems = array();
	
		if( isset( $_POST['mode'] ) ){
			
			$slideritems = $DWH_Slider->get_slider_config( 'all' );
		
		}

		/* construct new array for return as json */
		$slider_arr = array(
							'slider_items' => $slideritems
						);
		
		echo json_encode(  $slider_arr );

	die();

?>