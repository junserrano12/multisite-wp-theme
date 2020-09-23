<?php
if ( !function_exists( 'dwh_scroll_shortcode' ) )
{
	function dwh_scroll_shortcode( $atts )
	{
		ob_start();
		dwh_scroll_to( $atts );
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}