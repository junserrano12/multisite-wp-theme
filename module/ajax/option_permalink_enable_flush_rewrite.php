<?php

/* Enables Flush rewrite on admin loaded  */

check_ajax_referer( 'option_permalink_enable_flush_rewrite', 'nonce_sec' );

	global $DWH_Util;


	$flush_rewrite_info = get_dwh_option('dwh_option_permalink_flush');
	
	if( !empty( $flush_rewrite_info ) )
	{
		$enable_flag = $_POST['enable_permalink_flush_rewrite'];

		if( $DWH_Util->enable_flush_rewrite( $enable_flag ) )
		{
			echo json_encode( array( 'success' => true ) );
		}
	}


die();



?>