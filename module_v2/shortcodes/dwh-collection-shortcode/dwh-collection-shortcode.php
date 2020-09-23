<?php
if ( !function_exists( 'dwh_collection_shortcode' ) )
{
    function dwh_collection_shortcode( $atts, $content = null )
    {
        ob_start();
        dwh_collection( $atts, $content );
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}

if ( !function_exists( 'dwh_collection' ) )
{
    function dwh_collection( $atts, $content, $return = false )
    {
        global $DWH_wponetheme_collection;

        $DWH_wponetheme_collection->counter = $DWH_wponetheme_collection->counter + 1;

        $post_type      = isset( $atts['post_type'] ) ? $atts['post_type'] : "collection";
        $post_status    = isset( $atts['post_status'] ) ? $atts['post_status'] : "publish";
        $posts_per_page = isset( $atts['posts_per_page'] ) ? $atts['posts_per_page'] : -1;
        $order          = isset( $atts['order'] ) ? $atts['order'] : "DESC";
        $orderby        = isset( $atts['orderby'] ) ? $atts['orderby'] : "none";
        $taxonomy       = isset( $atts['taxonomy'] ) ? $atts['taxonomy'] : "group";
        $taxonomy_field = isset( $atts['taxonomy_field'] ) ? $atts['taxonomy_field'] : "slug";
        $taxonomy_terms = isset( $atts['taxonomy_terms'] ) ? array( $atts['taxonomy_terms'] ) : array();
        $class          = isset( $atts['class'] ) ? 'collection-container '.$atts['class'] : 'collection-container';
        $id             = isset( $atts['id'] ) ? $atts['id'] : 'dwh-collection-query-'.$DWH_wponetheme_collection->counter;
        $container      = isset( $atts['container'] ) ? $atts['container'] : 'div';

        $args = array(
                        "post_type"      => $post_type,
                        "post_status"    => $post_status,
                        "posts_per_page" => $posts_per_page,
                        "order"          => $order,
                        "orderby"        => $orderby,
                        "tax_query"      => array(
                                                    array(
                                                            'taxonomy' => $taxonomy,
                                                            'field'    => $taxonomy_field,
                                                            'terms'    => $taxonomy_terms
                                                         )
                                                 )
                     );


        $the_query = new WP_Query( $args );

        if ( $the_query->have_posts() ) {
            echo '<'.$container.' id="'.$id.'" class="'.$class.'">';
            while ( $the_query->have_posts() ) {
                $the_query->the_post();

                $html = $DWH_wponetheme_collection->load_shortcode_content( $content );
                $html = dwh_collection_views( $html );
                $html = dwh_modify_the_content( $html );
                $html = wp_make_content_images_responsive( $html );

                echo $html;

            }
            echo '</'.$container.'>';
            wp_reset_postdata();
        }

    }
}

if ( !function_exists( 'dwh_collection_views' ) )
{
    function dwh_collection_views( $content )
    {
        $pattern = array(
                        '/\[the_title\]/',
                        '/\[the_content\]/',
                        '/\[featured_image\]/',
                        '/\[date\]/'
                    );
        $replace = array(
                        dwh_collection_view_switch( 'the_title' ),
                        dwh_collection_view_switch( 'the_content' ),
                        dwh_collection_view_switch( 'featured_image' ),
                        dwh_collection_view_switch( 'date' )
                    );

        $content = preg_replace( $pattern, $replace, $content );

        return $content;
    }
}

if ( !function_exists( 'dwh_collection_view_switch' ) )
{
    function dwh_collection_view_switch( $type )
    {
        switch ( $type ) {
            case 'the_title':
                return get_the_title();
                break;
            case 'the_content':
                return get_the_content();
                break;
            case 'featured_image':
                return get_the_post_thumbnail();
                break;
            case 'date':
                return get_the_date();
                 break;
        }

    }
}