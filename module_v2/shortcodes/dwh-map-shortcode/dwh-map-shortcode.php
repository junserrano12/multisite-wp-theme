<?php
if ( !function_exists( 'dwh_map_shortcode' ) )
{
	function dwh_map_shortcode( $atts )
	{
		ob_start();
		dwh_google_maps( $atts );
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}