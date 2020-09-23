<?php


/* Activates a site theme */

	global $DWH_Options;
	global $DWH_Sidebar;

	check_ajax_referer( 'theme_activate_sidebars', 'nonce_sec' );
	
	/* Get site info */
	$site_info = $DWH_Options->get_dwh_site_option_field( 'dwh_sites',0);

	/* Theme name */
	$site_theme_name  = $site_info->site_theme;

	/* Theme configuration */
	$theme_template_config_path = DWH_SITE_THEME_DIR.'/site/'.$site_theme_name.'/config.php';
	$theme_template_config = include($theme_template_config_path);

	/* Autoload Widgets on the Theme template sidebars */
	$DWH_Sidebar->reset_sidebar_content();
	$DWH_Sidebar->register_sidebars();
	$DWH_Sidebar->add_widgets();

	/* Get sidebar options */
	$sidebar_options = get_dwh_option('sidebars_widgets');

	/* Update widget iteration for theme display */
	$widget_option = array( 1 => null, '_multiwidget' => 1 );

	foreach ($sidebar_options as $key => $value) {
		
		if(is_array($value))
		{
			foreach ($value as $key => $widget_item) {

				$widget_name  = explode('-', $widget_item);
				update_option('widget_'.$widget_name[0],$widget_option);

			}
		}

	}

	echo json_encode( array('success' => true, 'message' => 'Theme activated') );

	die();


?>



