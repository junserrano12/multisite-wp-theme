<?php

/*
* Slider Loader
*/

/* Slider Class */
if( file_exists( get_template_directory() .'/module/core/class.slider.php') )
	require_once( get_template_directory() .'/module/core/class.slider.php');

$DWH_Slider = new DWH_Slider();
$DWH_Slider->initialize( 'base' );	

?>