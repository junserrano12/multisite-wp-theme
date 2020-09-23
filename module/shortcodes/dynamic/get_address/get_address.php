<?php
function get_address($atts)
{
	global $DWH_Data;

	if( $atts )
	{
		$address_type = isset( $atts['address_type'] ) ? $atts['address_type'] : 'inline';
		ob_start();
		$DWH_Data->get_hotel_address( $address_type , true );
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

}
?>