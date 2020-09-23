<?php
if ( !function_exists( 'dwh_gallery_grid_shortcode' ) )
{
	function dwh_gallery_grid_shortcode( $atts )
	{
		ob_start();
		dwh_gallery( $atts, 'grid' );
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}