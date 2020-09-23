<?php

if ( !function_exists( 'dwh_address_shortcode' ) )
{
	function dwh_address_shortcode( $atts )
	{

		$type = isset( $atts['type'] ) ? $atts['type']  : 'inline';

		ob_start();
		dwh_address( $type );
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
}