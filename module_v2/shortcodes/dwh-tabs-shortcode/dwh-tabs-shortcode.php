<?php

if ( !function_exists( 'dwh_tabs_shortcode' ) )
{
	function dwh_tabs_shortcode( $atts, $content = null )
	{

		ob_start();
		dwh_tabs( $atts, 'tabs', $content );
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
}