<?php
if ( !function_exists( 'dwh_gallery_tab_shortcode' ) )
{
	function dwh_gallery_tab_shortcode( $atts )
	{
		ob_start();
		dwh_tabs( $atts, 'gallery' );
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}