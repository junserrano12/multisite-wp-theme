<?php
/*
Function: Theme customizations
*/


/* Post Types Class */
if(file_exists(get_template_directory().'/module/core/class.customization.php'))
	require_once(get_template_directory().'/module/core/class.customization.php');

$DWH_Customization = new DWH_Customization();

if( is_admin() )
{
	$config_set_types = array( 'site' , 'page' );
	$DWH_Customization->init( $config_set_types );
}