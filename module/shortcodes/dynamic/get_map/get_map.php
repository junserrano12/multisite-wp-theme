<?php

function get_map( $atts )
{
	
	global $DWH_Data;
	
	ob_start();
	$DWH_Data->get_map( __FUNCTION__, $atts );
	$html = ob_get_contents();
	ob_end_clean();
	
	return $html;

}
?>
