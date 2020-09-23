<?php

if ( !function_exists( 'dwh_accordions_shortcode' ) )
{
	function dwh_accordions_shortcode( $atts, $content = null )
	{
        global $DWH_wponetheme_util;
        $content = $DWH_wponetheme_util->load_shortcode_content( $content );

		ob_start();
		dwh_accordion( $atts, 'accordions', $content );
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
}