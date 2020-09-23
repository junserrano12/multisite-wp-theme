<?php
if ( !function_exists( 'dwh_main_banner_shortcode' ) )
{
	function dwh_main_banner_shortcode( $atts )
	{
		ob_start();
		dwh_main_banner( $atts );
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}