<?php

/* Import Site Options - XML */
check_ajax_referer( 'option_import', 'nonce_sec' );

global $DWH_Options;

$attachment_id = $_POST['attachment_id'];

if( $attachment_id!="")
{	
	$fullsize_path = get_attached_file( $attachment_id ); 
	$xml = file_get_contents( $fullsize_path );
	$DWH_Options->import_options( $xml );
	echo json_encode( array( 'success' => true , 'message' => 'Site Options imported' ) );
}

die();

?>