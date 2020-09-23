<?php
if ( !function_exists( 'dwh_fbshare_shortcode' ) )
{
	function dwh_fbshare_shortcode( $atts )
	{
		ob_start();
		dwh_facebook( $atts, 'fbshare' );
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}