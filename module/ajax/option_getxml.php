<?php

/* Get Site Options XML Data */
check_ajax_referer( 'option_getxml', 'nonce_sec' );

global $DWH_Options;
$xml = $DWH_Options->get_xml();

if( $xml )
{
	echo json_encode( array( 'response' => true , 'xml' => $xml ) );
}

die();

?>