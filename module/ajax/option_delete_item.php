<?php

/* delete option set item  */

	global $DWH_Options;

	check_ajax_referer( 'option_delete_item', 'nonce_sec' );
	
		$option_set = trim($_POST['option_set']);
		$option_row = trim($_POST['option_row']);
		$response = array();

		/* construct new array for return as json */
		if( $DWH_Options->delete_option_set_item( $option_set, $option_row ) )
		{
			
			/* delete address */
			if( $option_set == 'dwh_hotels' ){
			
				$DWH_Options->delete_option_set_item( 'dwh_hotel_address', $option_row );
			}
			
			
			$response = array(
							'success' => 1,
							'msg' => 'Item deleted'
						);
		}
		else
		{
			$response = array(
							'success' => 0,
							'msg' => 'Error on delete item'
						);
		}

			
		echo json_encode( $response );
		
	die();

?>