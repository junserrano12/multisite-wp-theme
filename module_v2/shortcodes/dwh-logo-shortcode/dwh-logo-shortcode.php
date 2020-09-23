<?php
if ( !function_exists( 'dwh_logo_shortcode' ) )
{
	function dwh_logo_shortcode( $atts )
	{
		$attr = isset( $atts['attr'] ) ? $atts['attr'] : 'default';

		ob_start();
		dwh_logo( $attr, false );
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}