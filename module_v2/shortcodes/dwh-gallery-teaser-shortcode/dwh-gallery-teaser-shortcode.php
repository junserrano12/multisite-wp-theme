<?php
if ( !function_exists( 'dwh_gallery_teaser_shortcode' ) )
{
	function dwh_gallery_teaser_shortcode( $atts )
	{

		ob_start();
		dwh_gallery_teaser( $atts, 'teaser');
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}
