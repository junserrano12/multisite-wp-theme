<?php

	/* Reset and Load default Option Settings  */

	global $DWH_Options, $DWH_Util;

	check_ajax_referer( 'option_load_defaults', 'nonce_sec' );
	
		$option_sets = array();

		/* Check if its a bulk reset */
		if( $_POST['data'] == '' && $_POST['type'] == 'bulk' )
		{
			$DWH_Options->reset_option_sets();
			$DWH_Options->load_default_settings();	
			update_option( 'theme_default_page', 0 );
			echo json_encode( array('success' => true, 'message' => 'Bulk Settings reset') );
		}
		else
		{
			foreach ( $_POST['data'] as $key => $option_set ) {
			
				extract( $option_set );
				
				if( isset( $field_name ) && isset( $field_value ) )
				{
					$option_set = $field_name;
					$option_val = $field_value;

					if( $option_val )
					{
						$option_sets[] = $option_set;
					}
				}
				
			}

		}
		

		if( !empty( $option_sets ) )
		{
			$DWH_Options->reset_option_sets( $option_sets );
			$DWH_Options->load_default_settings( $option_sets );
			
			echo json_encode( array('success' => true, 'message' => 'Option Setting reset') );
		}
		

	die();

?>