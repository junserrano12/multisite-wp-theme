<?php

function get_custom_content( $atts )
{
	global $DWH_Data;

	if( $atts )
	{
		
		ob_start();
		$DWH_Data->get_custom_content( __FUNCTION__, $atts );
		$html = ob_get_contents();
		ob_end_clean();
		
		return $html;
	}

}


?>
