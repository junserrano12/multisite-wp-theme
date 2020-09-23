<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9]><html class="ie ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>	
<?php
global $DWH_Theme;
global $DWH_Options;
global $DWH_Customization;
global $post;


/* Get page and site info */
$page_info = array();
$site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites',0);
$page_info = $DWH_Options->get_option_set_data( 'dwh_pages' );

/* Get post or page theme */
$page_theme = $data['page_fields']['page_theme'];
$site_theme = $site_info->site_theme;


/* Get page theme config */
$page_config = $DWH_Theme->get_page_theme_config( $page_theme );

/* Paret site theme style */
$has_parent = false;

/* Get page info index based on a specific page theme */
foreach ( $page_info as $key => $page_detail ) {

	if( $page_detail['page_theme'] ==  $page_theme )
	{
		$page_info = $page_detail;
	}
}


if( isset( $page_config['parent'] ) )
{	
	if( $site_info->site_theme == $page_config['parent'] )
	{
		$has_parent = true;
	}
}

/* Include header Meta data */	
$DWH_Theme->header_meta_data();

/*Include header links*/
$DWH_Theme->header_links();

/* Load Global theme fonts */
$DWH_Theme->header_site_fonts();

/* Load Global theme style */
$DWH_Theme->header_site_styles();

/* Theme CSS Style(s)
/* ====================================== */

	if( $has_parent ) {
		/* Site  */
		$DWH_Theme->header_site_theme_add_style( $site_info , 'style-main' );
	}

	/* Page */
	$DWH_Theme->header_page_theme_add_style( $page_theme , 'main' );

/* ====================================== */


/*
* Theme Designer CSS 
/* ====================================== */
	if( $has_parent ) {
		/* Site */
		$style_param = array( 'theme' => $site_theme );
		$DWH_Theme->add_dynamic_css( 'site-theme-designer' , 'site_theme_designer', $style_param );
	}

	/* Page */
	$style_param = array( 'theme' => $page_theme );
	$DWH_Theme->add_dynamic_css( 'page-theme-designer' , 'page_theme_designer', $style_param );

/* ====================================== */


/*
* Settings - Theme CSS 
/* ====================================== */
	
	if( $has_parent ) {
		/* Site */
		$style_param = array( 'style_type' => 'site_css' );
		$DWH_Theme->add_dynamic_css( 'site-settings' , 'settings_site_css', $style_param );
	}

	/* Page */
	$style_param = array( 'style_type' => 'page_css' , 'theme' => $page_theme );
	$DWH_Theme->add_dynamic_css( 'page-settings' , 'settings_page_css', $style_param );

	/* Media queries */
	if( $has_parent ) {
		/* Site */
		$style_param = array( 'style_type' => 'site_mediaquery' );
		$DWH_Theme->add_dynamic_css( 'site-settings-mediaquery' , 'settings_site_mediaquery_css', $style_param );
	}

	/* Page */
	$style_param = array( 'style_type' => 'page_mediaquery' , 'theme' => $page_theme );
	$DWH_Theme->add_dynamic_css( 'page-settings-mediaquery' , 'settings_page_mediaquery_css', $style_param );

/* ====================================== */

/* Include global dynamic scripts */
$DWH_Theme->header_site_dynamic_scripts();

/* Include global theme scripts */
$DWH_Theme->header_site_scripts();

/* Include page theme scripts */
$DWH_Theme->header_page_theme_add_scripts( $page_theme );


/*
* Default wordpress head hook 
*
*/
wp_head();


?>
</head>