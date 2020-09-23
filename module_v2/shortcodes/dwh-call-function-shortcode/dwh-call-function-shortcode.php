<?php
if ( !function_exists( 'dwh_call_function_shortcode' ) )
{
	function dwh_call_function_shortcode( $atts )
	{
		global $DWH_wponetheme_config;

		$function_list	= dwh_get_config('config.call.function', 'json');
		$function_list  = (array)$function_list;
		$function_name	= isset( $atts['function'] ) ? $atts['function'] : '';

		unset( $atts['function'] );
		
		$attributes = dwh_rebuild_shortcode_parameter( $function_name, $atts );
		$atts       = count($attributes) > 0 ? $attributes : $atts;
		
		if ( in_array( $function_name, $function_list ) ) {
			ob_start();
			call_user_func_array( $function_name, $atts );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}
	}
}