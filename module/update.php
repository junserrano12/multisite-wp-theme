<?php

include(get_template_directory().'/module/core/class.theme.updater.php');

$onetheme_data = wp_get_theme( 'wp_one_theme' );
if ( $onetheme_data->exists() ) {
	$version 			    = $onetheme_data->get( 'Version' );
	$name 	 			    = $onetheme_data->get( 'Name' );
	$DWH_onetheme_updater 	= new DWH_onetheme_updater( 'wp_one_theme', $version );
}
?>