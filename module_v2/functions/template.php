<?php
/* LOAD TEMPLATES CONTENTS */
if ( !function_exists( 'dwh_get_template_section' ) )
{
    function dwh_get_template_section( $section )
    {
        global $DWH_wponetheme_util;

        $theme_section  = ( $section === 'header' ) ? 'header_layout' : 'footer_layout';
        $theme_template = dwh_get_data( 'theme-layout', 'onetheme_customizer_options' );
        $content        = $theme_template[$theme_section];

        echo $DWH_wponetheme_util->load_shortcode_content( $content );

    }
}

if ( !function_exists( 'dwh_template_header' ) )
{
    function dwh_template_header()
    {
        dwh_load_theme_section('header.php');
    }
}

if ( !function_exists( 'dwh_template_footer' ) )
{
    function dwh_template_footer()
    {
        dwh_load_theme_section('footer.php');
    }
}

if ( !function_exists( 'dwh_template_content' ) )
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
                <?php the_content(); ?>
                <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'wponetheme' ), 'after' => '</div>' ) ); ?>
            </div>

            <?php } ?>

            <footer class="post-entry-footer">
                <?php edit_post_link( 'edit', '<span class="edit-link">', '</span>' ); ?>
            </footer>

        </div>
        <?php
    }
}

if ( !function_exists( 'dwh_template_content_header' ) )
{
    function dwh_template_content_header()
    {
        global $post;

        $output         = '';
        $alttitle       = '';
        $meta           = '';
        $displayh1      = false;
        $displayaddress = false;

        if( is_search() ) {

            if ( have_posts() ) {
               $title = 'Search Results for: <span>'.get_search_query().'</span>';
            } else {
               $title = 'Nothing Found';
            }

        } else if( is_archive() ) {

            if ( is_day() ) {
                $title = 'Dayily Archives: '.get_the_date();
            } elseif ( is_month() ) {
                $title = 'Yearly Archives: '.get_the_date( 'F Y' );
            } elseif ( is_year() ) {
                $title = 'Yearly Archives: '.get_the_date( 'Y' );
            } else {
                $title = 'Archives';
            }

            if ( category_description() ) {
                $meta = '<div class="archive-meta">'.category_description().'</div>'."\n";
            }

        } else if( is_404() ) {

            $title = '404 page';

        } else if( is_author() ) {

            $title = get_the_author();

        } else if( is_category() ) {

            $title = single_cat_title( '', false );

        } else {

            $hoteltype      = dwh_get_data( 'type', 'onetheme_hotel_options' );
            $hotelinfo      = ( $hoteltype == 'single' ) ? dwh_get_data( 'hotel-single' , 'onetheme_hotel_options' ) : null;
            $hotelname      = dwh_empty( $hotelinfo['hotel_name'] ) && isset( $hotelinfo['hotel_name'] ) ? $hotelinfo['hotel_name'] : get_the_title();

            $alttitle       = dwh_empty( dwh_get_data( 'title_field' ) ) ? dwh_get_data( 'title_field' ) : null;
            $displayh1      = dwh_empty( dwh_get_data( 'h1_display_flag' ) ) ? dwh_get_data( 'h1_display_flag' ) : false;
            $displayaddress = dwh_empty( dwh_get_data( 'address_field' ) ) ? dwh_get_data( 'address_field' ) : false;

            if ( is_front_page() ) {
                $title = dwh_empty( $alttitle ) ? $alttitle : $hotelname;
            } else {
                $title = dwh_empty( $alttitle ) ? $alttitle : $hotelname.' - '.get_the_title();
            }

        }

        if ( !$displayh1 ) {
            $output .= '<div class="entry-header">'."\n";
            $output .= '    <h1 class="entry-title">'.$title.'</h1>'."\n";
            $output .= ( $displayaddress ) ? dwh_address( 'inline', true )."\n" : '';
            $output .= $meta;
            $output .= '</div>'."\n";
        }

        echo $output;
    }
}

if ( !function_exists( 'dwh_template_content_footer' ) )
{
    function dwh_template_content_footer()
    {
        global $post;

        $hidectalink    = dwh_empty( dwh_get_data( 'cta_display_flag' ) ) ? dwh_get_data( 'cta_display_flag' ) : false;
        $ctalabel       = dwh_get_data( 'cta-label', 'onetheme_customizer_options' );
        $ctalinklabel   = isset( $ctalabel['cta_link'] ) && dwh_empty( $ctalabel['cta_link'] ) ? $ctalabel['cta_link'] : 'Check Availabilty and Prices';
        $output         = '';

        if ( !$hidectalink ) {
            $output .= '<div class="entry-footer">'."\n";
            $output .= '    <a class="ctalink cta-link" href="'.dwh_cta_link( 'ctalink' ).'">'.$ctalinklabel.'</a>'."\n";
            $output .= '</div>'."\n";
        }

        echo $output;
    }
}
