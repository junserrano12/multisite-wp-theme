<?php
/*action hooks*/
add_action( 'admin_init', 'initialize_basetheme_admin_editor_support' );
add_action( 'init', 'initialize_basetheme_head_cleanup' );
add_action( 'init', 'initialize_basetheme_setup_pages' );
add_action( 'init', 'initialize_basetheme_custom_image_size' );
add_action( 'init', 'initialize_basetheme_support' );
add_action( 'init', 'initialize_basetheme_404_redirect' );
add_action( 'init', 'dwh_disableNewrelic' );
add_action( 'init', 'dwh_custom_scripts' );
add_action( 'init', 'dwh_ga_codes' );
add_action( 'wp', 'dwh_ob_output' );
add_action( 'wp', 'dwh_load_contact_form_7' );
add_action( 'wp_footer', 'dwh_load_script', 99 );
add_action( 'dwh_header_hook', 'dwh_template_header' );
add_action( 'dwh_footer_hook', 'dwh_template_footer' );
add_action( 'dwh_content_hook', 'dwh_template_content' );
add_action( 'dwh_content_header_hook', 'dwh_template_content_header' );
add_action( 'dwh_content_footer_hook', 'dwh_template_content_footer' );


if ( !function_exists('dwh_load_script') )
{
    function dwh_load_script()
    {
        global $DWH_Theme;

        $DWH_Theme->header_site_scripts();
    }
}

if ( !function_exists('dwh_load_promo_marker') )
{
    function dwh_load_promo_marker()
    {
        global $DWH_Options;

        /* Get links details */
        $promo_marker_info = (array) $DWH_Options->get_option_set_data( 'dwh_promo_marker' );
        $promo_marker_info = array_shift( $promo_marker_info );
    }
}

if ( !function_exists('dwh_template_header') )
{
    function dwh_template_header()
    {
        dwh_load_theme_section('header.php');
    }
}

if ( !function_exists('dwh_template_footer') )
{
    function dwh_template_footer()
    {
        dwh_load_theme_section('footer.php');
    }
}

if ( !function_exists('dwh_template_content') )
{
    function dwh_template_content()
    {
        ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <header class="post-entry-header">
                <h2><?php the_title(); ?></h2>
            </header>

            <?php if ( is_search() ) { ?>

            <div class="post-entry-content post-entry-summary">
                <?php the_excerpt(); ?>
            </div>

            <?php } else { ?>

            <div class="post-entry-content">
                <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'basetheme' ) ); ?>
                <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'basetheme' ), 'after' => '</div>' ) ); ?>
            </div>

            <?php } ?>

            <footer class="post-entry-footer">
                <?php edit_post_link( 'edit', '<span class="edit-link">', '</span>' ); ?>
            </footer>

        </div>
        <?php
    }
}

if ( !function_exists('dwh_template_content_header') )
{
    function dwh_template_content_header()
    {
        global $DWH_Options;
        global $DWH_Data;
        global $post;

        /* Check if page address is enable in post data */
        $is_address_enabled = '';
        if( $post ) $is_address_enabled = get_post_meta( $post->ID , 'address_field' , true );

        if( is_search() ) {

            if ( have_posts() ) { ?>
                <h1 class="entry-title"><?php printf( __( 'Search Results for: %s', 'basetheme' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
            <?php } else { ?>
                <h1><?php _e( 'Nothing Found', 'basetheme' ); ?></h1>
            <?php }

        } else if( is_archive() ) {

            ?><h1 class="entry-title">
            <?php if ( is_day() ) {
                printf( __( 'Daily Archives: %s', 'basetheme' ), get_the_date() );
            } elseif ( is_month() ) {
                printf( __( 'Monthly Archives: %s', 'basetheme' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'basetheme' ) ) );
            } elseif ( is_year() ) {
                printf( __( 'Yearly Archives: %s', 'basetheme' ), get_the_date( _x( 'Y', 'yearly archives date format', 'basetheme' ) ) );
            } else {
                _e( 'Archives', 'basetheme' );
            } ?>
            </h1><?php

        } else if( is_404() ) {

            ?><h1 class="entry-title">404 Page</h1><?php

        } else if( is_author() ) {

            ?><h1 class="entry-title"><?php the_author(); ?></h1><?php

        } else if( is_category() ) {

            ?><h1 class="entry-title"><?php echo single_cat_title( '', false ); ?></h1><?php

        } else if( is_single() ) {

            $hotel_info         = $DWH_Options->get_dwh_site_option_field('dwh_hotels',0);
            $hotelpref          = $hotel_info->hotel_name;
            $alttitle           = get_post_meta( $post->ID, 'title_field', true );
            $address_field      = get_post_meta( $post->ID, 'address_field', true );
            $h1_display_flag    = get_post_meta( $post->ID, 'h1_display_flag', true );
            $title = ($alttitle != '' || $alttitle != null ) ? $alttitle : $hotelpref . ' - ' . get_the_title();

            if(!$h1_display_flag) { ?>
                <h1 class="entry-title"><?php echo $title; ?></h1>
            <?php }

            if( $is_address_enabled == true ) {
                if ( $address_field ) {
                    $DWH_Data->get_hotel_address('inline', false , '');
                }
            }

        } else {

            $hotel_info         = $DWH_Options->get_dwh_site_option_field('dwh_hotels',0);
            $hotelpref          = $hotel_info->hotel_name;
            $alttitle           = (have_posts()) ? get_post_meta( $post->ID, 'title_field', true ) : null;
            $address_field      = (have_posts()) ? get_post_meta( $post->ID, 'address_field', true ) : null;
            $h1_display_flag    = (have_posts()) ? get_post_meta( $post->ID, 'h1_display_flag', true ) : null;

            if( is_home() OR is_front_page() ){
                $title = ($alttitle != '' || $alttitle != null ) ? $alttitle : $hotelpref;
            }
            else{
                $title = ($alttitle != '' || $alttitle != null ) ? $alttitle : $hotelpref . ' - ' . get_the_title();
            }

            if( !$h1_display_flag ) { ?>
                <h1 class="entry-title"><?php echo $title; ?></h1>
            <?php }

            if( $is_address_enabled == true ) {
                if ( $address_field ) {
                    $DWH_Data->get_hotel_address('inline', false , '');
                }
            }

        }
    }
}

if ( !function_exists('dwh_template_content_footer') )
{
    function dwh_template_content_footer()
    {
        global $post;
        global $DWH_Options;
        global $DWH_Theme;
        global $DWH_Data;

        /* Get hotel info */
        $hotel_info = $DWH_Options->get_dwh_site_option_field( 'dwh_hotels',0);

        /* Get site info */
        $cta_info = $DWH_Options->get_dwh_site_option_field( 'dwh_cta',0);
        $cta_footer_link_label = isset( $cta_info->cta_footer_link ) && $cta_info->cta_footer_link!='' ?  $cta_info->cta_footer_link : 'Check Availability and Prices';

        $site_theme_config = $DWH_Theme->get_site_theme_config();
        $site_theme_category = strtolower($site_theme_config['details']['category']);
        $link_url_config_dir = get_template_directory() . '/module/cta/config.php';

        if( file_exists( $link_url_config_dir ))
        {
            $link_url_config = include( $link_url_config_dir );
            $link_url_config = $link_url_config[$site_theme_category]['button'];
            $data['hotel_info'] = $hotel_info;
            $data['link_url_config'] = $link_url_config;
            $ga_track_event_click = $DWH_Data->get_ga_track_event( $site_theme_category,'default','cta-link', true , $data );
            $ga_track_event_link_push = $DWH_Data->get_ga_track_event( $site_theme_category,'link','cta-link', true , $data );
            $link_url = $link_url_config['base_url'].$hotel_info->hotel_id . '/';
            if(isset($link_url_config['param1'])) $link_url .= $link_url_config['param1'];

            /* if universal analytics */
            $google_analytics_info  = $DWH_Options->get_dwh_site_option_field('dwh_api_google_analytics',0);
            $gtm_flag = isset( $google_analytics_info->tag_manager_flag ) ? $google_analytics_info->tag_manager_flag : 0;
            $ga_onclick_event = $gtm_flag == 0 ? 'onclick="'. $ga_track_event_click . $ga_track_event_link_push .'"' : '';

            $fullURL = $_SERVER['HTTP_HOST'];

            if(strpos($fullURL,'istana-kl') > 0){
                $link_url = str_replace('reservations', 'reservations2', $link_url);
            }

        }

        if ( !$post == NULL ) {
            $disablectalink = get_post_meta( $post->ID, 'cta_display_flag', true ) ? true : false;
            if ( !$disablectalink ) {
                ?>
                <a class="ctalink" <?php echo $ga_onclick_event; ?> href="<?php echo $link_url;?>">
                    <?php echo $cta_footer_link_label;?>
                </a>
                <?php
            }
        }
    }
}

if ( !function_exists('dwh_ga_codes') )
{
    function dwh_ga_codes()
    {

        add_action( 'wp_head', function() {
            $data['dir']  = array('module/collections','views','scripts');
            $data['view'] = 'universalanalytics';
            load_view( $data );
        });

        add_action( 'dwh_body_hook', function() {
            global $uniAnalyticCodes;

            echo '<div id="fb-root"></div>';

            if ( $uniAnalyticCodes ) {
                echo '<span class="hide uaPromoBannerSlide" data-tracker="ga(\'send\', \'event\', \'promo-click\', \'go-to-showFlexible\', \'promo-banner-slide\');" ></span>';
                echo '<span class="hide uaPromoPage" data-tracker="ga(\'send\', \'event\', \'promo-click\', \'go-to-showFlexible\', \'promo-page\');" ></span>';
            }

            $data['dir']  = array('module/collections','views','scripts');
            $data['view'] = 'googletagmanager';
            load_view( $data );

            $data['dir']  = array('module/collections','views','scripts');
            $data['view'] = 'fbtab';
            load_view( $data );
        });

        add_action( 'wp_footer', function() {
            /* google remarketing */
            $data['dir']  = array('module/collections','views','scripts');
            $data['view'] = 'googleremarketing';
            load_view( $data );
        });
    }
}

if ( !function_exists('dwh_custom_scripts') )
{
    function dwh_custom_scripts()
    {
        global $DWH_Theme;
        global $DWH_Options;
        global $custom_scripts;

        /* get custom Scripts */
        $custom_scripts = $DWH_Options->get_option_set_data( 'dwh_custom_scripts' );

        add_action( 'wp_head', function() use ( $DWH_Theme, $custom_scripts ){
            $DWH_Theme->siteCustomScript( $custom_scripts, 'inside head tag' );
        });

        add_action( 'dwh_body_hook', function() use ( $DWH_Theme, $custom_scripts ){
            $DWH_Theme->siteCustomScript( $custom_scripts, 'below opening body tag' );
        });

        add_action( 'wp_footer', function() use ( $DWH_Theme, $custom_scripts ){
            $DWH_Theme->siteCustomScript( $custom_scripts, 'above closing body tag' );
        });
    }
}

/* ob start */
if ( ! function_exists('dwh_ob_output') )
{
    function dwh_ob_output()
    {
        ob_start('fix_links');
    }
}

/*disable new relic*/
if ( ! function_exists('dwh_disableNewrelic') )
{
    function dwh_disableNewrelic()
    {
        if (extension_loaded('newrelic')) {
            newrelic_disable_autorum( true );
        }
    }
}

if ( !function_exists('dwh_load_contact_form_7') )
{
    function dwh_load_contact_form_7()
    {
        global $post;
        if( is_a( $post, 'WP_Post' ) && !has_shortcode( $post->post_content, 'contact-form-7') ) {
            dwh_remove_js_css_cf7();
        }
    }
}

if ( !function_exists('initialize_basetheme_admin_editor_support') )
{
    function initialize_basetheme_admin_editor_support()
    {
        add_theme_support('editor_style');
        add_editor_style( get_template_directory_uri() .'/module/admin/css/bootstrap.min.css' );
        add_editor_style( get_template_directory_uri() . '/module/admin/css/editor-style.css' );
    }
}

if ( !function_exists('initialize_basetheme_404_redirect') )
{
    function initialize_basetheme_404_redirect()
    {
        if(is_404()){
            header("Refresh: 3; url='".home_url()."'");
        }
    }
}

if ( !function_exists('initialize_basetheme_support'))
{
    function initialize_basetheme_support()
    {
        add_post_type_support( 'page', 'excerpt' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'custom-header' );
    }
}

/*CLEAN UP HEADER META AND LINK DATA*/
if ( !function_exists('initialize_basetheme_head_cleanup') )
{
    function initialize_basetheme_head_cleanup()
    {

        remove_action('wp_head', 'feed_links_extra', 3 );
        remove_action('wp_head', 'feed_links', 2 );
        remove_action('wp_head', 'rsd_link' );
        remove_action('wp_head', 'wlwmanifest_link' );
        remove_action('wp_head', 'index_rel_link' );
        remove_action('wp_head', 'parent_post_rel_link', 10, 0 );
        remove_action('wp_head', 'start_post_rel_link', 10, 0 );
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
        remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );
        remove_action('wp_head', 'rel_canonical' );
        remove_action('wp_head', 'wp_generator' );

        // REMOVE WP EMOJI
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
    }
}

/*AUTO GENERATE PAGES AND DELETE DEFAULT WORDPRESS POST AND PAGE*/
if ( !function_exists('initialize_basetheme_setup_pages') )
{
    function initialize_basetheme_setup_pages()
    {

        $wp_default_pages = array( 'Sample Page','Hello World!');

        if( $wp_default_pages )
        {
            foreach ($wp_default_pages as $default_page_title) {

                if( $default_page_title )
                {
                    if (get_page_by_title( $default_page_title , 'OBJECT', 'page') ){
                        $page = get_page_by_title( $default_page_title );
                        wp_delete_post($page->ID, true);
                    }

                }
            }
        }
    }
}

/*CUSTOM IMAGE SIZE*/
if ( !function_exists('initialize_basetheme_custom_image_size') )
{
    function initialize_basetheme_custom_image_size()
    {
        add_image_size( 'small-thumbnail-image', 40, 40, true );
        add_image_size( 'medium-thumbnail-image', 180, 100, true );
        add_image_size( 'large-thumbnail-image', 300, 200, true );
        add_image_size( 'large-colorbox-image', 800, 800 );
    }
}
