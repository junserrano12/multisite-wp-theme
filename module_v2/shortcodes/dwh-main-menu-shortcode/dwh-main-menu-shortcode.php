<?php
if ( !function_exists( 'dwh_main_menu_shortcode' ) )
{
	function dwh_main_menu_shortcode( $atts )
	{
		ob_start();
		dwh_main_menu();
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}