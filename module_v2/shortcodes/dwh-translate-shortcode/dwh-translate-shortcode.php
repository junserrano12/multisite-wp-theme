<?php

if ( !function_exists( 'dwh_translate_shortcode' ) )
{
	function dwh_translate_shortcode( $atts )
	{
		ob_start();
		dwh_google_translate();
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
}