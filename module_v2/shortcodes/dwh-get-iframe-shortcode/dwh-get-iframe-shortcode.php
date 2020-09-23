<?php
if ( !function_exists( 'dwh_get_iframe_shortcode' ) )
{
	function dwh_get_iframe_shortcode( $atts )
	{
		ob_start();
		dwh_iframe( $atts );
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}
