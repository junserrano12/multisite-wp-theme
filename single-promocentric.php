<?php
global $post;
global $DWH_Options;
global $DWH_Theme;
global $DWH_CustomFields;
global $DWH_Admin;

/* Get theme post types */
$post_types                   = $DWH_PostTypes->get_post_types();
/* Get Post Data*/
$post_data                    = get_post_meta( $post->ID );
/* Get Page settings info */
$page_settings_info           = $DWH_Options->get_dwh_site_option_set_by_field_name( 'dwh_pages' , 'page_type' , get_post_type() );
$hotel_info                   = $DWH_Options->get_dwh_site_option_field( 'dwh_hotels',0 );
/* Get post info */
$page_fields                  = $DWH_CustomFields->get_fields( 'post-types' , get_post_type() );
/* Get Page themes collection */
$page_theme_arr               = $DWH_Admin->get_page_themes();
/* get page theme */
$page_theme                   = $page_fields['page_theme'];
$is_page_theme_on_collections = false;

foreach ($page_theme_arr as $key => $value) {
    if ( $page_theme == $key )
        $is_page_theme_on_collections = true;
}

/* Check if the theme is not in the active page themes collection */
if ( $is_page_theme_on_collections == false ) {
    foreach ($page_theme_arr as $key => $page_theme_info ) {
        if( $page_theme_info['category'] == get_post_type() ) {

            $page_theme = $key;
            $page_fields['page_theme'] = $page_theme;

            /* update page theme */
            update_post_meta( $post->ID, 'page_theme', $page_theme );
            continue;
        }
    }
}

/* Prepare page data */
$page_info = array( 'page_fields' => $page_fields, 'hotel_info'  => $hotel_info );

/* Load post Theme */
$DWH_Theme->get_page_theme_part( $page_theme, 'header', $page_info );
$DWH_Theme->get_page_theme_part( $page_theme, 'main', $page_info );
$DWH_Theme->get_page_theme_part( $page_theme, 'footer', '' );

?>