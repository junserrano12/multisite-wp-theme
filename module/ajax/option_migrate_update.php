<?php

	/* load and save site version wp option file data  */
	global $DWH_Options;

	check_ajax_referer( 'option_migrate_update', 'nonce_sec' );
	$migrate_ver_from = trim($_POST['migrate_ver_from']);
	$migrate_ver_to = trim($_POST['migrate_ver_to']);
	$response = array();
	
	$DWH_Options->migrate_option_settings( $migrate_ver_from , $migrate_ver_to ); 
	
	/* construct new array for return as json */
	$response = array(
					'success' => 1,
					'msg' => 'Site data migrated based on configuration.'
				);

	echo json_encode( $response );
		
	die();

?>