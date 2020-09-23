<?php
if ( !function_exists( 'dwh_get_custom_content_shortcode' ) )
{
    function dwh_get_custom_content_shortcode( $atts )
    {
        $output = dwh_empty( dwh_get_data( $atts['key'] ) ) ? dwh_get_data( $atts['key'] ) : null;

        ob_start();
        echo $output;
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}