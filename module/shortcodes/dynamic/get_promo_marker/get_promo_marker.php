<?php

function get_promo_marker( $atts ){
	
	global $DWH_Data;

	$data['atts'] = $atts;
	$data['dir'] = array('module/shortcodes/dynamic', __FUNCTION__ , 'views');
	$data['view'] = __FUNCTION__;	
	$DWH_Data->get_promo_marker( __FUNCTION__, $data );
}

?>