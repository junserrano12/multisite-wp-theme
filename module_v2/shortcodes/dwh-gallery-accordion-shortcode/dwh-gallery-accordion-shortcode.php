<?php
if ( !function_exists( 'dwh_gallery_accordion_shortcode' ) )
{
	function dwh_gallery_accordion_shortcode( $atts )
	{
		ob_start();
		dwh_accordion( $atts, 'gallery' );
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}