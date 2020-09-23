<?php

/* Util Class */
$theme_class_dir = get_template_directory().'/module/core/class.util.php';
if(file_exists($theme_class_dir)) require_once( $theme_class_dir );
$DWH_Util = new DWH_Util();


/* Load mobile detect library */
$DWH_Util->load_library('Mobile_Detect');
$Mobile_Detect = new Mobile_Detect();


/* Load XML 2 Arry */
$DWH_Util->load_library('XML2Array');
$XML2Array = new XML2Array();


/* Detect user device */

if(!is_admin())
{	

	$user_Device = "";

	if( $Mobile_Detect->isMobile() )
	{
		$user_Device = 'mobile';
	}
	
	if( $Mobile_Detect->isTablet() )
	{
		$user_Device = 'tablet';
	}
	
	if( !$Mobile_Detect->isMobile() && !$Mobile_Detect->isTablet() )
	{
		$user_Device = 'desktop';
	}

	/* define contstant for user device */

	if( !defined('USER_DEVICE'))
	{
		DEFINE('USER_DEVICE',$user_Device);
	}

}
?>