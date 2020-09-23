<?php

global $DWH_Options;

/* Theme Class */
$theme_class_dir = get_template_directory().'/module/core/class.theme.php';
if(file_exists($theme_class_dir)) require_once( $theme_class_dir );
$DWH_Theme = new DWH_Theme();

/* load ssl constant */
$DWH_Theme->is_ssl();

$site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites', 0 );

if( $site_info )
{
	$site_theme_name  = $site_info->site_theme;
	$dir = DWH_SITE_THEME_DIR .'/site/'. $site_theme_name .'/config.php';
	
	/* if template exists */
	if( file_exists( $dir )){
		$site_theme_config = include( $dir ); 
	}
	
	/* handler if not */
	else{
		$site_lists = $DWH_Theme->get_site_theme_list();
		$site_theme_name = array_shift( $site_lists );
		
		$dir = DWH_SITE_THEME_DIR .'/site/'. $site_theme_name .'/config.php';
		
		if( file_exists( $dir ) ){
			$site_theme_config = include( $dir );
			
			$option_values = (array) $site_info;
			$option_values['site_theme'] = $site_theme_name;

			/* update option */
			$DWH_Options->update_option_set_item( 'dwh_sites', 0, $option_values, 'update' );
		}
		
	}
  
  
	/*to prevent default pages of turning back once they had been deleted -- code start*/
	$optionPageName = 'theme_default_page' ;
	if ( get_option( $optionPageName ) !== false && get_option( $optionPageName ) != 0) { 
		/*The option already exists*/
		update_option( $optionPageName, 2 );
	} else { 
		/*The option hasn't been added yet*/
		if( get_option( $optionPageName ) !== false && get_option( $optionPageName ) == 0){
			update_option( $optionPageName, 1 );
		}else{
			add_option( $optionPageName, 1, null, 'no' );
		}			
	}
	/*-- code ends*/
   
	if( $site_theme_config && get_option( $optionPageName ) != 2 )
	{	
		/* add default pages */
		$DWH_Theme->load_default_pages( $site_theme_config );
	}

	if( $site_theme_config )
	{	
		/* add default menus */
		$DWH_Theme->load_default_menu( $site_theme_config );
	}
	
}

?>