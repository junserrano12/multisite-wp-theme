<?php
if ( !function_exists( 'dwh_fblike_shortcode' ) )
{
	function dwh_fblike_shortcode( $atts )
	{
		ob_start();
		dwh_facebook( $atts, 'fblike' );
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}