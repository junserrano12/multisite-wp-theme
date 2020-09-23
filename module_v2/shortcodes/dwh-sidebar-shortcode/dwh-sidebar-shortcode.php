<?php
if ( !function_exists( 'dwh_sidebar_shortcode' ) )
{
	function dwh_sidebar_shortcode( $atts )
	{
		$sidebar         = isset( $atts['name'] ) && dwh_empty( $atts['name'] ) ? $atts['name'] : 'default';
		$container_id    = isset( $atts['container_id'] ) && dwh_empty( $atts['container_id'] ) ? ' id="'.$atts['container_id'].'"' : null;
		$container_class = isset( $atts['container_class'] ) && dwh_empty( $atts['container_class'] ) ? ' class="'.$atts['container_class'].'"' : null;
		$container       = isset( $atts['container'] ) && dwh_empty( $atts['container'] ) ? '<'.$atts['container'].$container_id.$container_class.'>' : null;
		$container_close = ( $container ) ? '</'.$container.'>' : null;

		ob_start();

		switch ( $sidebar ) {
			case 'default':
				get_sidebar();
				break;

			default:

				if ( is_active_sidebar( $sidebar ) ) {
					echo $container;
					dynamic_sidebar( $sidebar );
					echo $container_close;
				}
				break;
		}

		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
}