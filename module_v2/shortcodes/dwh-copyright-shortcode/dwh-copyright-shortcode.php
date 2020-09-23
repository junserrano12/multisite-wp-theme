<?php

if ( !function_exists( 'dwh_copyright_shortcode' ) )
{
	function dwh_copyright_shortcode( $atts )
	{
		$content = isset( $atts['content'] ) ? $atts['content'] : null;

		ob_start();
		dwh_copyright( $content );
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
}