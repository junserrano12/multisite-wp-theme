<?php
if ( !function_exists( 'dwh_custom_menu_shortcode' ) )
{
    function dwh_custom_menu_shortcode( $atts )
    {
        $menu       = isset( $atts['menu'] ) ? $atts['menu'] : '';
        $menuclass  = isset( $atts['menuclass'] ) ? $atts['menuclass'].' menu' : 'menu';

        $args = array( 
                        'menu'              => $menu,
                        'container'         => 'div', 
                        'container_class'   => '', 
                        'container_id'      => '', 
                        'menu_class'        => $menuclass, 
                        'menu_id'           => '',
                        'echo'              => true, 
                        'fallback_cb'       => 'wp_page_menu', 
                        'before'            => '', 
                        'after'             => '', 
                        'link_before'       => '',
                        'link_after'        => '', 
                        'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s</ul>', 
                        'item_spacing'      => 'preserve',
                        'depth'             => 0, 
                        'walker'            => '', 
                        'theme_location'    => '' 
                    );

        ob_start();
        wp_nav_menu( $args );
        $html = ob_get_contents();
        ob_end_clean(); 

        return $html;  
    }
}