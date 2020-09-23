<?php

global $DWH_Admin;

/* Get page theme configuration  */
check_ajax_referer( 'option_get_page_theme_config', 'nonce_sec' );

if( isset( $_POST['page_theme'] ))
{
	$page_theme = $_POST['page_theme'];
	$page_theme_config = $DWH_Admin->get_page_theme_config( $page_theme );
	$success = false;
	$data = array();

	if( !empty( $page_theme_config ))
	{	
		$data['page_theme_config'] = $page_theme_config;
		$success = true;
	}
	else
	{
		$success = false;
	}

	$response = array( 'success' => $success , 'data' => $data );
	echo json_encode( $response );

}

die();

?>