<?php

/* Gets site themes  */
check_ajax_referer( 'option_get_themes_site', 'nonce_sec' );

	global $DWH_Admin;
	$site_themes = $DWH_Admin->get_site_themes();
	if( !empty( $site_themes ) ) echo json_encode( $site_themes );
	
die();


?>