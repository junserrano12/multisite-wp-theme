<?php
/*
Function: Autoload admin settings files
*/

$menu_config = array();

/* Admin Class */
if(file_exists(get_template_directory().'/module/core/class.admin.php'))
{
	include(get_template_directory().'/module/core/class.admin.php');
}

/* include menu configuration */
if(file_exists(get_template_directory().'/config/config.menu.php'))
{
	$menu_config = include(get_template_directory().'/config/config.menu.php');
}

/* Get user role */
$user_role = strtolower( get_current_user_role() );
define('DWH_USER_ROLE', $user_role );

/* Load admin */
$DWH_Admin = new DWH_Admin();
/* load Settings*/
$DWH_Admin->load_settings( $menu_config );
/* Load admin scripts */
$DWH_Admin->load_scripts();
/* Load admin styles */
$DWH_Admin->load_styles();
/* Load default page settings content */
$DWH_Admin->autoload_new_page_themes();
/* Load User role caps block list */
$DWH_Admin->load_restrictions();