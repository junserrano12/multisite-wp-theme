<?php
function get_widget( $atts )
{	
	global $DWH_Data;

	if( $atts )
	{
		ob_start();
		$DWH_Data->get_widget( __FUNCTION__, $atts );
		$html = ob_get_contents();
		ob_end_clean();
		
		return $html;
	}

}
?>