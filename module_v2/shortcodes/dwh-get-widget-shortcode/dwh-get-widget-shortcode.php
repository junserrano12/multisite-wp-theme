<?php
if ( !function_exists( 'dwh_get_widget_shortcode' ) )
{
	function dwh_get_widget_shortcode( $atts )
	{
		ob_start();
		dwh_widget( $atts );
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}
