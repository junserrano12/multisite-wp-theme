<?php

/* Gets page themes  */
check_ajax_referer( 'option_get_themes_page', 'nonce_sec' );

	global $DWH_Admin;
	$page_themes = $DWH_Admin->get_page_themes();
	if( !empty( $page_themes ) ) echo json_encode( $page_themes );
	
die();


?>