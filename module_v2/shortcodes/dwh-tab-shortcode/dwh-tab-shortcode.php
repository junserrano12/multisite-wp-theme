<?php

if ( !function_exists( 'dwh_tab_shortcode' ) )
{
	function dwh_tab_shortcode( $atts, $content = null )
	{

		ob_start();
		dwh_tabs( $atts, 'tab', $content );
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
}