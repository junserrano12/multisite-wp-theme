<?php
if ( !function_exists( 'dwh_wponetheme_load_default_filters' ) )
{
	function dwh_wponetheme_load_default_filters()
	{
		/* remove gallery inline style backup if add_theme_support('html5', array('gallery')) is removed */
		add_filter( 'gallery_style', 'dwh_wponetheme_remove_gallery_style' );
		/* customize searchbar */
		add_filter( 'get_search_form', 'dwh_wponetheme_wp_search' );
		/*remove excerpt more*/
		add_filter( 'excerpt_more', 'dwh_wponetheme_excerpt_more' );
		/* limit excerpt */
		add_filter( 'excerpt_length', 'dwh_wponetheme_excerpt_length' );
		/* wrap images inside image container */
		add_filter( 'image_send_to_editor', 'dwh_wponetheme_wrap_image', 10, 8 );
		/* upload additional mimes types */
		add_filter( 'upload_mimes', 'dwh_wponetheme_mime_types', 1, 1 );
		/* add image size in menu list */
		add_filter( 'image_size_names_choose', 'dwh_wponetheme_display_custom_image_size', 11, 1 );

        /* modify the content hook */
		add_filter( 'the_content', 'dwh_wponetheme_modify_the_content', 20, 1 );

        /* insert rule to robots.txt */
        add_filter( 'robots_txt', 'dwh_wponetheme_insert_rules_in_robots', 10, 2 );

        /* rewrite rules for sitemap.xml */
        add_filter( 'generate_rewrite_rules', 'dwh_wponetheme_xml_feed_rewrite');
        add_filter( 'redirect_canonical', 'dwh_wponetheme_sitemap_no_trailing_slash' );

        /* add class to post_class function */
        add_filter( 'post_class', 'dwh_wponetheme_add_main_post_class' );

        /* add wp cron schedule */
        // add_filter( 'cron_schedules', 'dwh_wponetheme_custom_cron_schedule' );

        /* page title */
        add_filter( 'document_title_parts', 'dwh_wponetheme_modify_page_title' );
        add_filter( 'document_title_separator', 'dwh_wponetheme_title_separator' );
	}
}

/* modify page title */
if ( !function_exists( 'dwh_wponetheme_title_separator' ) )
{
    function dwh_wponetheme_title_separator( $sep ) {

        $sep = "|";

        return $sep;
    }
}

if ( !function_exists( 'dwh_wponetheme_modify_page_title' ) )
{
    function dwh_wponetheme_modify_page_title( $title )
    {
        $pagetitle = $title['title'];
        $tagline = get_bloginfo( 'description', 'display' );

        /* If page has meta page title */
        if ( ( is_page() || is_single() ) && dwh_empty( dwh_get_data( 'page_title_field' ) ) ) {
            $title = array( dwh_get_data( 'page_title_field' ) );
            $pagetitle = dwh_get_data( 'page_title_field' );
        }

        if ( ( is_page() || is_single() ) && dwh_empty( dwh_get_data( 'meta-title', 'onetheme_site_options' ) ) ) {
            $title = array();
            $tag = '';

            $parts = explode( ' ', dwh_get_data( 'meta-title', 'onetheme_site_options' ) );
            $count = array_keys( $parts );
            $last_key = end( $count );

            foreach ( $parts as $key => $part ) {
                $next_part = ( $key < $last_key ) ? $parts[$key + 1] : $parts[$key];

                switch ( $part ) {
                    case '$tagline':
                        $part = str_replace( '$tagline', $tagline, $part);
                        array_push( $title, $part );
                        break;
                    case '$title':
                        $part = str_replace( '$title', $pagetitle, $part);
                        array_push( $title, $part );
                        break;
                    default:
                        $tag .= ( $tag !== '' ) ? " ".$part : $part;
                        if ( $next_part == '$tagline' || $next_part == '$title' || $key == $last_key ) {
                            array_push( $title, $tag );
                            $tag = '';
                        }
                        break;
                }
            }

            if ( count( $title ) === 1 ) {
                array_push( $title, $tagline );
            }

        }
        return $title;
    }
}

if ( !function_exists( 'dwh_wponetheme_custom_cron_schedule' ) )
{
    function dwh_wponetheme_custom_cron_schedule( $schedules ) {
        $interval = dwh_empty( dwh_get_data( 'hotel-subdomain-interval', 'dwh_hotel_option' ) ) ? dwh_get_data( 'hotel-subdomain-interval', 'dwh_hotel_option' ) : 24;
        $interval = (int)$interval;
        $schedules['dwh_update_schedule'] = array(
            'interval' => 60*60*$interval,
            'display'  => __( 'Scheduled Update' ),
        );
        return $schedules;
    }
}

if ( !function_exists( 'dwh_wponetheme_add_main_post_class' ) )
{
    function dwh_wponetheme_add_main_post_class( $classes )
    {
        $classes[] = 'dwh-main';
        return $classes;
    }
}

if ( !function_exists( 'dwh_wponetheme_xml_feed_rewrite' ) )
{
    function dwh_wponetheme_xml_feed_rewrite( $wp_rewrite ) {

        $feed_rules = array(
            '.*sitemap.xml$' => 'index.php?feed=sitemap'
        );

        $wp_rewrite->rules = $feed_rules + $wp_rewrite->rules;
    }
}

if ( !function_exists( 'dwh_wponetheme_sitemap_no_trailing_slash' ) )
{
    function dwh_wponetheme_sitemap_no_trailing_slash( $redirect_url )
    {
        if ( is_feed() && strpos( $redirect_url, 'sitemap.xml/' ) !== FALSE )
            return;
        return $redirect_url;
    }
}

if ( !function_exists( 'dwh_wponetheme_insert_rules_in_robots' ) )
{
    function dwh_wponetheme_insert_rules_in_robots( $content, $is_public )
    {
        $rules   = dwh_get_data( 'robots', 'onetheme_site_options' );

        $robotscontent  = 'Sitemap:'.get_option('siteurl').'/sitemap.xml'."\n";
        $robotscontent .= $content;
        $robotscontent .= 'Disallow: /wp-includes/'."\n";
        $robotscontent .= 'Disallow: /wp-content/themes/wp_one_theme/fonts/*'."\n";
        $robotscontent .= 'Disallow: /hello-world/'."\n";
        $robotscontent .= 'Disallow: /dwh-sitemap-99/'."\n";
        $robotscontent .= ( $rules ) ? $rules : null;
        return $robotscontent;
    }
}

if ( !function_exists( 'dwh_wponetheme_remove_gallery_style' ) )
{
	function dwh_wponetheme_remove_gallery_style( $css )
	{

		return preg_replace( "!<style type='text/css'>(.*?)</style>!s", "", $css );

	}
}

if ( !function_exists( 'dwh_wponetheme_wp_search' ) )
{
	function dwh_wponetheme_wp_search( $form )
	{
	    $form  = '<form role="search" method="get" id="searchform" action="' . home_url('/') . '" >';
	    $form .= '	<label class="screen-reader-text" for="s">' . __( 'Search for:', 'wponetheme' ) . '</label>';
	    $form .= '	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr( 'Search the Site...', 'wponetheme' ).'" />';
	    $form .= '	<input type="submit" id="searchsubmit" value="'. esc_attr('Search') .'" />';
	    $form .= '</form>';
	    return $form;
	}
}

if ( !function_exists( 'dwh_wponetheme_excerpt_more' ) )
{
	function dwh_wponetheme_excerpt_more( $more )
	{
		return '';
	}
}

if ( !function_exists( 'dwh_wponetheme_excerpt_length' ) )
{
	function dwh_wponetheme_excerpt_length( $length )
	{
		return 70;
	}
}

if ( !function_exists( 'dwh_wponetheme_wrap_image' ) )
{
	function dwh_wponetheme_wrap_image( $html, $id )
	{
		if( is_admin() ) {

			$html = dwh_image_wrapper( $html, $id );

			return $html;
		}
	}
}

if ( !function_exists( 'dwh_wponetheme_display_custom_image_size' ) )
{
	function dwh_wponetheme_display_custom_image_size( $sizes )
	{
		$new_sizes = array();
		$added_sizes = get_intermediate_image_sizes();
		foreach( $added_sizes as $key => $value )
		{
			$new_sizes[$value] = $value;
		}
		$new_sizes = array_merge( $new_sizes, $sizes );
		return $new_sizes;
	}
}

if ( !function_exists( 'dwh_wponetheme_mime_types' ) )
{
	function dwh_wponetheme_mime_types( $mime_types )
	{

		$config_mimes = dwh_get_config('config.mimes', 'json');

		if( $config_mimes ) {
			foreach( $config_mimes as $mime ) {
				if( is_array( $mime ) ) {
					$mime = (object) $mime;
				}

				$type 	= isset( $mime->type ) ? $mime->type : false;
				$value	= isset( $mime->value ) ? $mime->value : false;

				if( $type && $value ) {
					$mime_types[$type] = $value;
				}
			}
		}

	    return $mime_types;
	}
}

if ( !function_exists( 'dwh_wponetheme_modify_the_content' ) )
{
	function dwh_wponetheme_modify_the_content( $content )
	{

		$content 		= force_balance_tags( $content );
		$pattern 		= array(
								'/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', /*remove ptags on images*/
								'#<p>\s*+(<br\s*/*>)?\s*</p>#i', /*remove empty p tags*/
                                '/\<p\>\s*+(\<br\s*\/*\>)?\s*\<\/p\>/', /*remove empty p tags*/
								'/<p>\s*(<a.*<\/a>)\s*<\/p>/iU', /*remove p tags on wrapping a tags*/
								'/^\<br\s*\/\>(\n|)/', /* remove first br */
								'/\<br\s*\/\>(\n|)$/' /* remove last br */
							);
		$replacement 	= array(
								'\1\2\3',
								'',
								'\1',
								'',
								''
							);

		$content 		= preg_replace( $pattern, $replacement, $content );

		return $content;
	}
}